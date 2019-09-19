<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\ShippingMethod;
use AdamRocska\ShippingTier\Entity\Tier;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShippingMethodBranchTest extends TestCase
{

    /**
     * @var MockObject|DoorToDoorTransitTime
     */
    private $stubDoorToDoorTransitTime;
    /**
     * @var (Country|MockObject)[]
     */
    private $stubCountries;

    public function testPrimitiveGetters(): void
    {
        $shippingMethodBranch = new ShippingMethodBranch(
            $this->stubDoorToDoorTransitTime,
            $this->stubCountries
        );
        $this->assertSame(
            $this->stubDoorToDoorTransitTime,
            $shippingMethodBranch->getDoorToDoorTransitTime(),
            "Door to door transit time should be the same reference as bound."
        );
        foreach ($shippingMethodBranch->getCountries() as $countryIndex => $country) {
            $this->assertSame(
                $this->stubCountries[$countryIndex],
                $country,
                "Country bound at index $countryIndex should be the same at the same location in the stub list."
            );
        }
    }


    public function testTierBinding(): void
    {
        $shippingMethod = new ShippingMethodBranch(
            $this->stubDoorToDoorTransitTime,
            []
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
        $shippingMethodBranch = new ShippingMethodBranch(
            $this->stubDoorToDoorTransitTime,
            []
        );
        $this->assertFalse(
            $shippingMethodBranch->hasShippingMethod(),
            "After instantiation it shouldn't have a shipping method."
        );
        /** @var MockObject|ShippingMethod $stubShippingMethod */
        $stubShippingMethod = $this->createMock(ShippingMethod::class);
        $shippingMethodBranch->setShippingMethod($stubShippingMethod);
        $this->assertTrue(
            $shippingMethodBranch->hasShippingMethod(),
            "After runtime injection it should have a shipping method."
        );
        $this->assertSame(
            $stubShippingMethod,
            $shippingMethodBranch->getShippingMethod(),
            "Returned bound shipping method should be the same as the one injected lazily."
        );
    }


    public function countryCodes(): iterable
    {
        return [
            [["HU", "DE"]],
            [["HU", "DE", "AU"]],
            [["HU", "DE", "AU", "IT"]],
            [["HU", "DE", "AU", "IT", "US"]]
        ];
    }

    /**
     * @param iterable $supportedCountryCodes
     *
     * @dataProvider countryCodes
     */
    public function testHasCountry(iterable $supportedCountryCodes): void
    {
        $countries = [];
        foreach ($supportedCountryCodes as $supportedCountryCode) {
            $countries[] = $this->createMockCountry($supportedCountryCode);
        }
        $shippingMethod = new ShippingMethodBranch(
            $this->stubDoorToDoorTransitTime,
            $countries
        );
        foreach ($supportedCountryCodes as $supportedCountryCode) {
            // note, that we intentionally create a new instance. We want to
            // assure, that it works on data level, and not on instance level.
            $countryToQuery = $this->createMockCountry($supportedCountryCode);
            $this->assertTrue(
                $shippingMethod->hasCountry($countryToQuery),
                "Should return true for a country object of iso $supportedCountryCode."
            );
        }
        $nonExistantCountry = $this->createMockCountry("DOESNT EXIST");
        $this->assertFalse(
            $shippingMethod->hasCountry($nonExistantCountry),
            "Should return false for a country object that wasn't injected."
        );
    }

    protected function setUp()
    {
        parent::setUp();
        $this->stubDoorToDoorTransitTime = $this->createMock(
            DoorToDoorTransitTime::class
        );
        $this->stubCountries             = [
            $this->createMockCountry("HU"),
            $this->createMockCountry("DE"),
            $this->createMockCountry("AU"),
            $this->createMockCountry("IT"),
            $this->createMockCountry("US")
        ];
    }

    private function createMockCountry(string $isoCode): Country
    {
        /** @var MockObject|Country $mockObject */
        $mockObject = $this->createMock(Country::class);
        $mockObject->method("getIsoCode")->willReturn($isoCode);
        return $mockObject;
    }
}
