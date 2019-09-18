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

    public function testConstructorInjectedFields(): void
    {
        $stubCountries  = [
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class),
            $this->createMock(Country::class)
        ];
        $shippingMethod = new ShippingMethod(
            $this->stubDoorToDoorTransitTime,
            $stubCountries
        );
        $this->assertSame(
            $this->stubDoorToDoorTransitTime,
            $shippingMethod->getDoorToDoorTransitTime(),
            "Door to door transit time reference should be returned as is."
        );
        foreach ($shippingMethod->getCountries() as $countryIndex => $country) {
            $this->assertSame(
                $stubCountries[$countryIndex],
                $country,
                "Expected to have the same stub country at index $countryIndex"
            );
        }
    }

    public function testCarrierBinding(): void
    {
        $shippingMethod = new ShippingMethod(
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

    protected function setUp()
    {
        parent::setUp();
        $this->stubDoorToDoorTransitTime = $this->createMock(
            DoorToDoorTransitTime::class
        );
    }
}
