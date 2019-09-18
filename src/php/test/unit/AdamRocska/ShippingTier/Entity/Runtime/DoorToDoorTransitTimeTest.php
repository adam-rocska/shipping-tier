<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime as DoorToDoorTransitTimeEntity;
use AdamRocska\ShippingTier\Entity\Runtime\DoorToDoorTransitTime\Exception\InvalidBoundaries;
use AdamRocska\ShippingTier\Equatable;
use PHPUnit\Framework\MockObject\MockObject;
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

    /**
     * @throws InvalidBoundaries
     */
    public function testEquals_shouldAssertInputType(): void
    {
        /** @var MockObject|Equatable $equatableImplementation */
        $equatableImplementation = $this->createMock(Equatable::class);
        $doorToDoorTransitTime   = new DoorToDoorTransitTime(1, 2);

        try {
            $doorToDoorTransitTime->equals($equatableImplementation);
            $this->fail("Should have thrown an exception.");
        } catch (Equatable\Exception\UnequatableType $exception) {
            $expectedMessage = "Object to check equality against is not a/an";
            $expectedMessage .= DoorToDoorTransitTimeEntity::class;
            $expectedMessage .= " implementation";
            $this->assertEquals(
                $expectedMessage,
                $exception->getMessage(),
                "Exception message should be self explanatory."
            );
        }
    }


}
