<?php

namespace AdamRocska\ShippingTier\Utility\DateInterval;

use DateInterval;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NativeWrapperTest extends TestCase
{

    const INTERVAL_FORMAT_FOR_TESTING = "Y=%yM=%MD=%DH=%HI=%IS=%SF=%FR=%R";

    public function intervalSpecs(): iterable
    {
        return [
            ["P2Y4DT6H8M"],
            ["P2Y4DT6H2M"],
            ["P2Y5DT6H8M"],
            ["P2Y5DT6H2M"],
            ["P2Y4DT1H8M"],
            ["P2Y4DT1H2M"],
            ["P2Y5DT1H8M"],
            ["P2Y5DT1H2M"]
        ];
    }

    public function nativeDateIntervals(): iterable
    {
        $nativeDateIntervals = [];
        foreach ($this->intervalSpecs() as $intervalSpec) {
            $nativeDateIntervals[] = [new DateInterval($intervalSpec[0])];
        }
        foreach ($this->intervalSpecs() as $intervalSpec) {
            $nativeDateIntervals[] = [
                $this->asNegative(
                    new DateInterval($intervalSpec[0])
                )
            ];
        }

        return $nativeDateIntervals;
    }

    /**
     * @param DateInterval $nativeDateInterval
     *
     * @dataProvider nativeDateIntervals
     */
    public function testPrimitiveGetters(DateInterval $nativeDateInterval): void
    {
        $nativeWrapper = new NativeWrapper($nativeDateInterval);
        $this->assertEquals(
            $nativeDateInterval->y,
            $nativeWrapper->getYears(),
            "Wrapped years should match."
        );
        $this->assertEquals(
            $nativeDateInterval->m,
            $nativeWrapper->getMonths(),
            "Wrapped months should match."
        );
        $this->assertEquals(
            $nativeDateInterval->d,
            $nativeWrapper->getDays(),
            "Wrapped days should match."
        );
        $this->assertEquals(
            $nativeDateInterval->h,
            $nativeWrapper->getHours(),
            "Wrapped hours should match."
        );
        $this->assertEquals(
            $nativeDateInterval->i,
            $nativeWrapper->getMinutes(),
            "Wrapped minutes should match."
        );
        $this->assertEquals(
            $nativeDateInterval->s,
            $nativeWrapper->getSeconds(),
            "Wrapped seconds should match."
        );
        $this->assertEquals(
            $nativeDateInterval->f,
            $nativeWrapper->getMicroseconds(),
            "Wrapped microseconds should match."
        );

        if ($nativeDateInterval->invert === 1) {
            $this->assertTrue(
                $nativeWrapper->isBackwardInTime(),
                "Should point backward in time."
            );
            $this->assertFalse(
                $nativeWrapper->isForwardInTime(),
                "Shouldn't point forward in time."
            );
        } else {
            $this->assertTrue(
                $nativeWrapper->isForwardInTime(),
                "Shouldn't point backward in time."
            );
            $this->assertFalse(
                $nativeWrapper->isBackwardInTime(),
                "Should point forward in time."
            );
        }
    }

    /**
     * @param DateInterval $native
     *
     * @dataProvider nativeDateIntervals
     * @throws Exception\CorruptIntervalSpec
     */
    public function testAsNativeDateInterval(DateInterval $native): void
    {
        $nativeWrapper = new NativeWrapper($native);
        $dateInterval  = $nativeWrapper->asNativeDateInterval();
        $this->assertNotSame(
            $dateInterval,
            $native,
            "As Native conversion shouldn't return the same instance, to avoid unintended side-effects."
        );
        $this->assertEquals(
            $native->format(self::INTERVAL_FORMAT_FOR_TESTING),
            $dateInterval->format(self::INTERVAL_FORMAT_FOR_TESTING),
            "Conceptually the date intervals should be equal."
        );
    }

    /**
     * @param DateInterval $original
     *
     * @dataProvider nativeDateIntervals
     */
    public function testIgnoresOriginSideEffect(DateInterval $original): void
    {
        $nativeWrapper       = new NativeWrapper($original);
        $wasOriginalInverted = ($original->invert === 1);

        $original->y      = 1234;
        $original->m      = 1234;
        $original->d      = 1234;
        $original->h      = 1234;
        $original->i      = 1234;
        $original->s      = 1234;
        $original->f      = 123.456;
        $original->invert = $original->invert === 1 ? 0 : 1;

        $this->assertNotEquals(
            $original->y,
            $nativeWrapper->getYears(),
            "Should return the original years."
        );
        $this->assertNotEquals(
            $original->m,
            $nativeWrapper->getMonths(),
            "Should return the original months."
        );
        $this->assertNotEquals(
            $original->d,
            $nativeWrapper->getDays(),
            "Should return the original days."
        );
        $this->assertNotEquals(
            $original->h,
            $nativeWrapper->getHours(),
            "Should return the original hours."
        );
        $this->assertNotEquals(
            $original->i,
            $nativeWrapper->getMinutes(),
            "Should return the original minutes."
        );
        $this->assertNotEquals(
            $original->s,
            $nativeWrapper->getSeconds(),
            "Should return the original seconds."
        );
        $this->assertNotEquals(
            $original->f,
            $nativeWrapper->getMicroseconds(),
            "Should return the original microseconds."
        );

        if ($wasOriginalInverted) {
            $this->assertTrue(
                $nativeWrapper->isBackwardInTime(),
                "Should point backward in time."
            );
            $this->assertFalse(
                $nativeWrapper->isForwardInTime(),
                "Shouldn't point forward in time."
            );
        } else {
            $this->assertTrue(
                $nativeWrapper->isForwardInTime(),
                "Shouldn't point backward in time."
            );
            $this->assertFalse(
                $nativeWrapper->isBackwardInTime(),
                "Should point forward in time."
            );
        }
    }

    public function testConstructor_wrapsException(): void
    {
        /** @var MockObject|DateInterval $mockNativeDateInterval */
        $mockNativeDateInterval = $this->createMock(DateInterval::class);
        $mockNativeDateInterval
            ->method("format")
            ->willReturn("INVALID SPEC");

        try {
            $nativeWrapper = new NativeWrapper($mockNativeDateInterval);
            $this->fail("Should have thrown an exception.");
        } catch (Exception\CorruptIntervalSpec $exception) {
            $this->assertEquals(
                "Native date interval construction failed.",
                $exception->getMessage(),
                "Exception message should be descriptive."
            );
            $this->assertNotNull(
                $exception->getPrevious(),
                "Previous exception message should be bound."
            );
        }
    }

    /**
     * @param string $intervalSpec
     *
     * @dataProvider intervalSpecs
     * @throws Exception\CorruptIntervalSpec
     */
    public function testCreateFromIntervalSpec(string $intervalSpec): void
    {
        $nativeWrapper = NativeWrapper::createFromIntervalSpec($intervalSpec);

        $expectedInterval = new DateInterval($intervalSpec);
        $actualInterval   = $nativeWrapper->asNativeDateInterval();

        $this->assertEquals(
            $expectedInterval->format(static::INTERVAL_FORMAT_FOR_TESTING),
            $actualInterval->format(static::INTERVAL_FORMAT_FOR_TESTING),
            "Should create the right instance out of the interval spec."
        );

    }

    public function testCreateFromIntervalSpec_exceptionWrapping(): void
    {
        try {
            NativeWrapper::createFromIntervalSpec("INVALID SPEC");
            $this->fail("Should have thrown an exception.");
        } catch (Exception\CorruptIntervalSpec $exception) {
            $this->assertEquals(
                "Native date interval construction failed.",
                $exception->getMessage(),
                "Exception message should be descriptive."
            );
            $this->assertNotNull(
                $exception->getPrevious(),
                "Previous exception message should be bound."
            );
        }
    }


    private function asNegative(DateInterval $dateInterval): DateInterval
    {
        $dateInterval->invert = 1;
        return $dateInterval;
    }

}
