<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\ShippingMethod;
use AdamRocska\ShippingTier\Entity\Tier;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class WildCardShippingMethodBranchTest extends TestCase
{
    /**
     * @var MockObject|DoorToDoorTransitTime
     */
    private $stubDoorToDoorTransitTime;

    public function testPrimitiveGetters(): void
    {
        $wildCardShippingMethodBranch = new WildCardShippingMethodBranch(
            $this->stubDoorToDoorTransitTime
        );
        $this->assertSame(
            $this->stubDoorToDoorTransitTime,
            $wildCardShippingMethodBranch->getDoorToDoorTransitTime(),
            "Should return injected door to door transit time reference."
        );
    }

    public function testTierBinding(): void
    {
        $shippingMethod = new WildCardShippingMethodBranch(
            $this->stubDoorToDoorTransitTime
        );
        $this->assertFalse(
            $shippingMethod->hasTier(),
            "After instantiation it shouldn't have a tier."
        );
        /** @var MockObject|Tier $stubTier */
        $stubTier = $this->createMock(Tier::class);
        $shippingMethod->setTier($stubTier);
        $this->assertTrue(
            $shippingMethod->hasTier(),
            "After runtime injection it should have a tier."
        );
        $this->assertSame(
            $stubTier,
            $shippingMethod->getTier(),
            "Returned bound tier should be the same as the one injected lazily"
        );
    }

    public function testShippingMethodBinding(): void
    {
        $wildcardShippingMethodBranch = new WildCardShippingMethodBranch(
            $this->stubDoorToDoorTransitTime
        );
        $this->assertFalse(
            $wildcardShippingMethodBranch->hasShippingMethod(),
            "After instantiation it shouldn't have a shipping method."
        );
        /** @var MockObject|ShippingMethod $stubShippingMethod */
        $stubShippingMethod = $this->createMock(ShippingMethod::class);
        $wildcardShippingMethodBranch->setShippingMethod($stubShippingMethod);
        $this->assertTrue(
            $wildcardShippingMethodBranch->hasShippingMethod(),
            "After runtime injection it should have a shipping method."
        );
        $this->assertSame(
            $stubShippingMethod,
            $wildcardShippingMethodBranch->getShippingMethod(),
            "Returned bound shipping method should be the same as the one injected lazily."
        );
    }

    public function testGetCountries(): void
    {
        $wildcardShippingMethodBranch = new WildCardShippingMethodBranch(
            $this->stubDoorToDoorTransitTime
        );
        $this->assertEquals(
            [],
            $wildcardShippingMethodBranch->getCountries(),
            "Wildcard shipping method should return an empty list of countries."
        );
    }

    public function testHasCountry(): void
    {
        $wildcardShippingMethodBranch = new WildCardShippingMethodBranch(
            $this->stubDoorToDoorTransitTime
        );

        $countriesToMatch = [
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class)
        ];

        foreach ($countriesToMatch as $countryIndex => $countryToMatch) {
            $this->assertTrue(
                $wildcardShippingMethodBranch->hasCountry($countryToMatch),
                "Should have matched country index $countryIndex, as it should match any given countries."
            );
        }
    }

    protected function setUp()
    {
        parent::setUp();
        $this->stubDoorToDoorTransitTime = $this->createMock(
            DoorToDoorTransitTime::class
        );
    }

}
