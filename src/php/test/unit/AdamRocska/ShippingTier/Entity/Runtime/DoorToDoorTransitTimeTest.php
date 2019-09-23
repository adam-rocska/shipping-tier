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

use AdamRocska\ShippingTier\Entity\Runtime\DoorToDoorTransitTime\Exception\InvalidBoundaries;
use PHPUnit\Framework\TestCase;

class DoorToDoorTransitTimeTest extends TestCase
{

    public function transitTimePairs(): iterable
    {
        return [
            [8, 15],
            [8, 10],
            [10, 16],
            [8, 15],
            [5, 8],
            [8, 12]
        ];
    }

    /**
     * @param int $minimumDays
     * @param int $maximumDays
     *
     * @dataProvider transitTimePairs
     */
    public function testConstructorValidatesInput(
        int $minimumDays,
        int $maximumDays
    ): void {
        try {
            new DoorToDoorTransitTime($maximumDays, $minimumDays);
            $this->fail("Should have thrown exception.");
        } catch (InvalidBoundaries $exception) {
            $expectedMessage = "Maximum days greater than minimum days.";
            $expectedMessage .= "Values received : ";
            $expectedMessage .= "\$maximumDays=" . $minimumDays;
            $expectedMessage .= "\$minimumDays=" . $maximumDays;
            $this->assertEquals(
                $expectedMessage,
                $exception->getMessage(),
                "Exception message should be self explanatory."
            );
        }
    }

    /**
     * @param int $minimumDays
     * @param int $maximumDays
     *
     * @dataProvider transitTimePairs
     * @throws InvalidBoundaries
     */
    public function testPrimitiveGetters(
        int $minimumDays,
        int $maximumDays
    ): void {
        $doorToDoorTransitTime = new DoorToDoorTransitTime(
            $minimumDays,
            $maximumDays
        );
        $this->assertEquals(
            $minimumDays,
            $doorToDoorTransitTime->getMinimumDays(),
            "Expected to return minimum days untouched."
        );
        $this->assertEquals(
            $maximumDays,
            $doorToDoorTransitTime->getMaximumDays(),
            "Expected to return maximum days untouched."
        );
    }

}
