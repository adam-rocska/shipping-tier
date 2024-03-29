<?php
/**
 * Copyright 2019 Adam Rocska
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Carrier\Exception\NoShippingMethod;
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

    public function testGetShippingMethodByIdentifier_throwsExceptionIfNoMethodsBound(
    ): void
    {
        $carrier = new Carrier("test", "test", []);
        try {
            $testIdentifier = "test identifier";
            $carrier->getShippingMethodByIdentifier($testIdentifier);
            $this->fail("Expected to throw exception.");
        } catch (NoShippingMethod $exception) {
            $this->assertEquals(
                "No shipping method found by identifier \"$testIdentifier\"",
                $exception->getMessage(),
                "Expected an expressive exception message."
            );
        }
    }

    public function testGetShippingMethodByIdentifier_throwsExceptionIfNotfound(
    ): void
    {
        $carrier = new Carrier("test", "test", [
            $this->createMockCarrierAwareShippingMethod("test"),
            $this->createMockCarrierAwareShippingMethod("test method")
        ]);
        try {
            $testIdentifier = "test identifier";
            $carrier->getShippingMethodByIdentifier($testIdentifier);
            $this->fail("Expected to throw exception.");
        } catch (NoShippingMethod $exception) {
            $this->assertEquals(
                "No shipping method found by identifier \"$testIdentifier\"",
                $exception->getMessage(),
                "Expected an expressive exception message."
            );
        }
    }

    /**
     * @throws NoShippingMethod
     */
    public function testGetShippingMethodByIdentifier(): void
    {
        $testIdentifier = "test identifier";

        $stub = $this->createMockCarrierAwareShippingMethod($testIdentifier);

        $carrier = new Carrier("test", "test", [
            $this->createMockCarrierAwareShippingMethod("test"),
            $this->createMockCarrierAwareShippingMethod("test method"),
            $stub
        ]);
        $this->assertSame(
            $stub,
            $carrier->getShippingMethodByIdentifier($testIdentifier),
            "Expected to return the shipping method who's identifier is \"$testIdentifier\""
        );
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
     * @param string $identifier
     *
     * @return MockObject|ShippingMethod|LazyCarrierInjectionAware
     */
    private function createMockCarrierAwareShippingMethod(
        string $identifier = ""
    ): ShippingMethod {
        $mockShippingMethod = $this->createMock([
                                                    ShippingMethod::class,
                                                    LazyCarrierInjectionAware::class
                                                ]);
        $mockShippingMethod
            ->method("getIdentifier")
            ->willReturn($identifier);
        return $mockShippingMethod;
    }

}
