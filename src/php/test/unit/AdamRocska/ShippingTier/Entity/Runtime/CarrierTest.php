<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\ShippingMethod;
use PHPUnit\Framework\TestCase;

class CarrierTest extends TestCase
{

    public function fields(): iterable
    {
        return [
            ["test", "test label", $this->createStubShippingMethods(0)],
            ["DHL", "DHL", $this->createStubShippingMethods(0)],
            ["FEDEX", "FeEx", $this->createStubShippingMethods(0)],
            ["test", "test label", $this->createStubShippingMethods(5)],
            ["DHL", "DHL", $this->createStubShippingMethods(5)],
            ["FEDEX", "FeEx", $this->createStubShippingMethods(5)],
            ["test", "test label", $this->createStubShippingMethods(10)],
            ["DHL", "DHL", $this->createStubShippingMethods(10)],
            ["FEDEX", "FeEx", $this->createStubShippingMethods(10)]
        ];
    }

    /**
     * @param string   $label
     * @param string   $identifier
     * @param iterable $shippingMethods
     *
     * @dataProvider fields
     */
    public function testPrimitiveGetters(
        string $label,
        string $identifier,
        iterable $shippingMethods
    ): void {
        $carrier = new Carrier($label, $identifier, $shippingMethods);
        $this->assertEquals(
            $label,
            $carrier->getLabel(),
            "Label should be returned unchanged."
        );
        $this->assertEquals(
            $identifier,
            $carrier->getIdentifier(),
            "Identifier should be returned unchanged."
        );
        $boundShippingMethods = $carrier->getShippingMethods();
        foreach ($shippingMethods as $shippingMethodIndex => $expectedShippingMethod) {
            $this->assertSame(
                $expectedShippingMethod,
                $boundShippingMethods[$shippingMethodIndex],
                "Shipping method at index $shippingMethodIndex should be the same as provided."
            );
        }
    }

    private function createStubShippingMethods(
        int $numberOfShippingMethods
    ): iterable {
        $stubShippingMethods = [];
        while ($numberOfShippingMethods-- >= 0) {
            $stubShippingMethods[] = $this->createMock(ShippingMethod::class);
        }
        return $stubShippingMethods;
    }

}
