<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Carrier;
use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\Tier;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShippingMethodTest extends TestCase
{

    /**
     * @var MockObject|DoorToDoorTransitTime
     */
    private $stubDoorToDoorTransitTime;
    /**
     * @var (Country|MockObject)[]
     */
    private $stubCountries;

    public function testConstructorInjectedFields(): void
    {

        $shippingMethod = new ShippingMethod(
            "test label",
            "test identifier",
            $this->stubDoorToDoorTransitTime,
            $this->stubCountries
        );
        $this->assertSame(
            $this->stubDoorToDoorTransitTime,
            $shippingMethod->getDoorToDoorTransitTime(),
            "Door to door transit time reference should be returned as is."
        );
        foreach ($shippingMethod->getCountries() as $countryIndex => $country) {
            $this->assertSame(
                $this->stubCountries[$countryIndex],
                $country,
                "Expected to have the same stub country at index $countryIndex"
            );
        }
        $this->assertEquals(
            "test label",
            $shippingMethod->getLabel(),
            "Label should be returned as is."
        );
        $this->assertEquals(
            "test identifier",
            $shippingMethod->getIdentifier(),
            "Identifier should be returned as is."
        );
    }

    public function testCarrierBinding(): void
    {
        $shippingMethod = new ShippingMethod(
            "test",
            "test",
            $this->stubDoorToDoorTransitTime,
            []
        );
        $this->assertFalse(
            $shippingMethod->hasCarrier(),
            "After instantiation it shouldn't have a carrier."
        );
        /** @var MockObject|Carrier $stubCarrier */
        $stubCarrier = $this->createMock(Carrier::class);
        $shippingMethod->setCarrier($stubCarrier);
        $this->assertTrue(
            $shippingMethod->hasCarrier(),
            "After runtime injection it should have a carrier."
        );
        $this->assertSame(
            $stubCarrier,
            $shippingMethod->getCarrier(),
            "Returned bound carrier should be the same as the one injected lazily"
        );
    }

    public function testTierBinding(): void
    {
        $shippingMethod = new ShippingMethod(
            "test",
            "test",
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
            "After runtime injection it should have a carrier."
        );
        $this->assertSame(
            $stubTier,
            $shippingMethod->getTier(),
            "Returned bound carrier should be the same as the one injected lazily"
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
        $shippingMethod = new ShippingMethod(
            "test",
            "test",
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
