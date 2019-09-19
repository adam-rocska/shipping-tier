<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\LazyCarrierInjectionAware;
use AdamRocska\ShippingTier\Entity\ShippingMethod;
use PHPUnit\Framework\MockObject\Matcher\InvokedCount as InvokedCountMatcher;
use PHPUnit\Framework\MockObject\MockObject;
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

    public function testConstructorSetsSelfInLazyShippingMethods(): void
    {
        $mixedShippingMethods = [
            $this->createMock(ShippingMethod::class),
            $this->createMockCarrierAwareShippingMethod(),
            $this->createMockCarrierAwareShippingMethod(),
            $this->createMockCarrierAwareShippingMethod(),
            $this->createMock(ShippingMethod::class),
            $this->createMockCarrierAwareShippingMethod(),
            $this->createMock(ShippingMethod::class),
            $this->createMock(ShippingMethod::class),
            $this->createMockCarrierAwareShippingMethod(),
            $this->createMock(ShippingMethod::class),
            $this->createMockCarrierAwareShippingMethod()
        ];
        /** @var InvokedCountMatcher[] $invocationMatchers */
        $invocationMatchers = [];

        /** @var MockObject|ShippingMethod|LazyCarrierInjectionAware $shippingMethod */
        foreach ($mixedShippingMethods as $shippingMethod) {
            if (!($shippingMethod instanceof LazyCarrierInjectionAware)) {
                continue;
            }
            $once = $this->once();
            $shippingMethod
                ->expects($once)
                ->method("setCarrier");
            $invocationMatchers[] = $once;
        }

        $expectedShippingMethod = new Carrier(
            "test",
            "test",
            $mixedShippingMethods
        );

        foreach ($invocationMatchers as $invocationMatcher) {
            // we need this assertion here, as mocks are being validated after
            // test execution, while we need this information during test
            // execution for a spy-like behavior.
            $invocations = $invocationMatcher->getInvocations();
            $this->assertEquals(
                1,
                count($invocations),
                "setShippingMethod should have been called exactly once."
            );
            $invocation = $invocations[0];
            list($actualShippingMethod) = $invocation->getParameters();
            $this->assertSame(
                $expectedShippingMethod,
                $actualShippingMethod,
                "The shipping method should inject itself into the lazy shipping method shippingMethod."
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

    /**
     * @return MockObject|ShippingMethod|LazyCarrierInjectionAware
     */
    private function createMockCarrierAwareShippingMethod(): ShippingMethod
    {
        return $this->createMock([
                                     ShippingMethod::class,
                                     LazyCarrierInjectionAware::class
                                 ]);
    }

}
