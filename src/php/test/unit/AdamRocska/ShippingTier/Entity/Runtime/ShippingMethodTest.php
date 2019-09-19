<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Carrier;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShippingMethodTest extends TestCase
{
    /**
     * @var (MockObject|ShippingMethodBranch)[]
     */
    private $stubShippingMethodBranches;

    public function testCarrierBinding(): void
    {
        $shippingMethod = new ShippingMethod(
            "test",
            "test",
            $this->stubShippingMethodBranches
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

    public function testConstructorInjectedFields(): void
    {
        $shippingMethod = new ShippingMethod(
            "test label",
            "test identifier",
            $this->stubShippingMethodBranches
        );
        foreach ($shippingMethod->getBranches() as $branchIndex => $branch) {
            $this->assertSame(
                $this->stubShippingMethodBranches[$branchIndex],
                $branch,
                "Expected to have the same stub branch at index $branchIndex"
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

    protected function setUp()
    {
        parent::setUp();
        $this->stubShippingMethodBranches = [
            $this->createMock(ShippingMethodBranch::class),
            $this->createMock(ShippingMethodBranch::class),
            $this->createMock(ShippingMethodBranch::class),
            $this->createMock(ShippingMethodBranch::class),
            $this->createMock(ShippingMethodBranch::class)
        ];
    }


}
