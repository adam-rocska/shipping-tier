<?php
/**
 * Copyright 2019 Adam Rocska
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Carrier;
use AdamRocska\ShippingTier\Entity\LazyShippingMethodInjectionAware;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch;
use PHPUnit\Framework\MockObject\Matcher\InvokedCount as InvokedCountMatcher;
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

    public function testConstructorSetsSelfInLazyShippingMethodBranches(): void
    {
        $mixedShippingMethodBranches = [
            $this->createMock(ShippingMethodBranch::class),
            $this->createMockShippingMethodAwareBranch(),
            $this->createMockShippingMethodAwareBranch(),
            $this->createMockShippingMethodAwareBranch(),
            $this->createMock(ShippingMethodBranch::class),
            $this->createMockShippingMethodAwareBranch(),
            $this->createMock(ShippingMethodBranch::class),
            $this->createMock(ShippingMethodBranch::class),
            $this->createMockShippingMethodAwareBranch(),
            $this->createMock(ShippingMethodBranch::class),
            $this->createMockShippingMethodAwareBranch()
        ];
        /** @var InvokedCountMatcher[] $invocationMatchers */
        $invocationMatchers = [];

        /** @var MockObject|ShippingMethodBranch|LazyShippingMethodInjectionAware $branch */
        foreach ($mixedShippingMethodBranches as $branch) {
            if (!($branch instanceof LazyShippingMethodInjectionAware)) {
                continue;
            }
            $once = $this->once();
            $branch
                ->expects($once)
                ->method("setShippingMethod");
            $invocationMatchers[] = $once;
        }

        $expectedShippingMethod = new ShippingMethod(
            "test",
            "test",
            $mixedShippingMethodBranches
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
                "The shipping method should inject itself into the lazy shipping method branch."
            );
        }
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

    /**
     * @return MockObject|ShippingMethodBranch|LazyShippingMethodInjectionAware
     */
    private function createMockShippingMethodAwareBranch(): ShippingMethodBranch
    {
        return $this->createMock([
                                     ShippingMethodBranch::class,
                                     LazyShippingMethodInjectionAware::class
                                 ]);
    }

}
