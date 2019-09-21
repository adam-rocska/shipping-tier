<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\Runtime\TierTest\TestFixture;
use AdamRocska\ShippingTier\Entity\Runtime\TierTest\TestFixtures;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchesBound;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchForCountry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TierTest extends TestCase
{

    /**
     * @var MockObject|Country
     */
    private $stubCountry;

    public function testPrimitiveGetters(): void
    {
        $identifier = "test identifier";
        $label      = "test label";
        $tier       = new Tier($identifier, $label);
        $this->assertEquals(
            $identifier,
            $tier->getIdentifier(),
            "Identifier should be returned untouched."
        );
        $this->assertEquals(
            $label,
            $tier->getLabel(),
            "Label should be returned untouched."
        );
    }

    /**
     * @throws NoShippingMethodBranchForCountry
     */
    public function testGetFastestShippingMethodBranchForCountry_noBranchesBound(
    ): void
    {
        $tier = new Tier("test", "test");

        try {
            $tier->getFastestShippingMethodBranchForCountry($this->stubCountry);
            $this->fail("Expected to throw exception");
        } catch (NoShippingMethodBranchesBound $exception) {
            $this->assertEquals(
                "There are no shipping method branches bound to this tier.",
                $exception->getMessage(),
                "Exception message should be descriptive."
            );
        }
    }

    public function queriedCountries(): iterable
    {
        return [
            // label, ISO code
            ["Hungary", "HU"],
            ["Germany", "DE"],
            ["Austria", "AT"]
        ];
    }

    /**
     * @param string $countryLabel
     * @param string $countryISOCode
     *
     * @throws NoShippingMethodBranchesBound
     * @dataProvider queriedCountries
     */
    public function testGetFastestShippingMethodBranchForCountry_noShippingMethodBranchMatched(
        string $countryLabel,
        string $countryISOCode
    ): void {
        $stubShippingMethodBranches         = [];
        $numberOfStubShippingMethodBranches = 10;

        $this->stubCountry = $this->createMock(Country::class);
        $this->stubCountry
            ->expects($this->once())
            ->method("getLabel")
            ->willReturn($countryLabel);
        $this->stubCountry
            ->expects($this->once())
            ->method("getIsoCode")
            ->willReturn($countryISOCode);
        while ($numberOfStubShippingMethodBranches--) {
            $mockBranch = $this->createMock(ShippingMethodBranch::class);
            $mockBranch
                ->expects($this->once())
                ->method("hasCountry")
                ->with($this->stubCountry)
                ->willReturn(false);
            $stubShippingMethodBranches[] = $mockBranch;
        }
        $tier = new Tier("test", "test");
        $tier->setShippingMethodBranches($stubShippingMethodBranches);
        try {
            $tier->getFastestShippingMethodBranchForCountry($this->stubCountry);
            $this->fail("Expected to throw exception");
        } catch (NoShippingMethodBranchForCountry $exception) {
            $expectedMessage = "No shipping method found for country "
                               . $countryLabel
                               . " of ISO code "
                               . $countryISOCode
                               . ".";
            $this->assertEquals(
                $expectedMessage,
                $exception->getMessage(),
                "Expected to have a descriptive exception message."
            );
        }
    }

    /**
     * @throws NoShippingMethodBranchForCountry
     * @throws NoShippingMethodBranchesBound
     */
    public function testGetFastestShippingMethodBranchForCountry_returnsBranchIfOnlyOneMatched(
    ): void
    {
        $tier                               = new Tier("test", "test");
        $numberOfStubShippingMethodBranches = 10;
        /** @var MockObject|ShippingMethodBranch $branchToMatch */
        $branchToMatch = null;
        while ($numberOfStubShippingMethodBranches--) {
            /** @var MockObject|ShippingMethodBranch $mockBranch */
            $mockBranch         =
                $this->createMock(ShippingMethodBranch::class);
            $isLastTestedBranch = $numberOfStubShippingMethodBranches === 0;
            $mockBranch
                ->expects($this->once())
                ->method("hasCountry")
                ->with($this->stubCountry)
                ->willReturn($isLastTestedBranch);
            $mockBranch
                ->expects($this->never())
                ->method("getDoorToDoorTransitTime");
            if ($isLastTestedBranch) {
                $branchToMatch = $mockBranch;
            }
            $tier->addShippingMethodBranch($mockBranch);
        }
        $branch =
            $tier->getFastestShippingMethodBranchForCountry($this->stubCountry);
        $this->assertSame(
            $branchToMatch,
            $branch,
            "If only one branch matches, it should be returned, without bothering with door to door transit time."
        );
    }

    /**
     * @return iterable
     */
    public function shippingMethodBranchesForMatching(): iterable
    {
        $testData     = [];
        $testFixtures = TestFixtures::getInstance();
        foreach ($testFixtures->getTestFixtures() as $label => $testFixture) {
            $testData[$label] = [$testFixture];
        }
        return $testData;
    }

    /**
     * @dataProvider shippingMethodBranchesForMatching
     *
     * @param TestFixture $testFixture
     *
     * @throws NoShippingMethodBranchForCountry
     * @throws NoShippingMethodBranchesBound
     */
    public function testGetFastestShippingMethodBranchForCountry_returnsBestMatch(
        TestFixture $testFixture
    ): void {
        /** @var ShippingMethodBranch[]|MockObject[] $mockBranches */
        /** @var MockObject|ShippingMethodBranch $expectedBranch */
        list($mockBranches, $expectedBranch) = $this->createBranchesForMatching(
            $testFixture->getCsvRecords(),
            $testFixture->getWinnerRecordIndex()
        );

        $tier = new Tier("test", "test");
        $tier->setShippingMethodBranches($mockBranches);
        $actualBranch = $tier->getFastestShippingMethodBranchForCountry(
            $this->stubCountry
        );

        $assertionMessage = "Expected fastest transit time\n";
        $assertionMessage .= "Minimum days : ";
        $assertionMessage .= (string)$expectedBranch
            ->getDoorToDoorTransitTime()
            ->getMinimumDays();
        $assertionMessage .= "\n";
        $assertionMessage .= "Maximum days : ";
        $assertionMessage .= (string)$expectedBranch
            ->getDoorToDoorTransitTime()
            ->getMaximumDays();
        $assertionMessage .= "\n";
        $assertionMessage .= "Actual fastest transit time\n";
        $assertionMessage .= "Minimum days : ";
        $assertionMessage .= (string)$actualBranch
            ->getDoorToDoorTransitTime()
            ->getMinimumDays();
        $assertionMessage .= "\n";
        $assertionMessage .= "Maximum days : ";
        $assertionMessage .= (string)$actualBranch
            ->getDoorToDoorTransitTime()
            ->getMaximumDays();
        $assertionMessage .= "\n";
        $assertionMessage .= "Read the following test spec for details : ";
        $assertionMessage .= $testFixture->getDescriptionPath();

        $this->assertSame($expectedBranch, $actualBranch, $assertionMessage);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->stubCountry = $this->createMock(Country::class);
    }

    /**
     * @param iterable $mockBranchProperties An iterable of arrays, where the
     *                                       arrays are used as tuples of
     *                                       `list($hasCountry, $minTransit,
     *                                       $maxTransit)`
     * @param int      $expectedMatchIndex
     *
     * @return iterable
     */
    private function createBranchesForMatching(
        iterable $mockBranchProperties,
        int $expectedMatchIndex
    ): iterable {
        $mockBranches = [];

        foreach ($mockBranchProperties as $index => $mockBranchProperty) {
            list($hasCountry, $minTransit, $maxTransit) = $mockBranchProperty;
            $mockBranch = $this->createMockBranch(
                $hasCountry,
                $minTransit,
                $maxTransit
            );

            $mockBranches[] = $mockBranch;
            if ($index === $expectedMatchIndex) {
                $expectedMatch = $mockBranch;
            }
        }

        assert(!is_null($expectedMatch), "There was no branch to mock as matched at index $expectedMatchIndex");

        return [$mockBranches, $expectedMatch];
    }

    /**
     * @param bool $hasCountry
     * @param int  $minimumTransit
     * @param int  $maximumTransit
     *
     * @return MockObject|ShippingMethodBranch
     */
    private function createMockBranch(
        bool $hasCountry = false,
        int $minimumTransit = null,
        int $maximumTransit = null
    ): ShippingMethodBranch {
        /** @var MockObject|ShippingMethodBranch $mockBranch */
        $mockBranch = $this->createMock(ShippingMethodBranch::class);
        $mockBranch
            ->expects($this->atLeastOnce())
            ->method("hasCountry")
            ->with($this->stubCountry)
            ->willReturn($hasCountry);

        if (!$hasCountry) {
            return $mockBranch;
        }

        $transitTime = $this->createMock(DoorToDoorTransitTime::class);
        $transitTime
            ->expects($this->atLeastOnce())
            ->method("getMinimumDays")
            ->willReturn($minimumTransit);
        $transitTime
            ->expects($this->atLeastOnce())
            ->method("getMaximumDays")
            ->willReturn($maximumTransit);
        $mockBranch
            ->expects($this->atLeastOnce())
            ->method("getDoorToDoorTransitTime")
            ->willReturn($transitTime);

        return $mockBranch;
    }
}
