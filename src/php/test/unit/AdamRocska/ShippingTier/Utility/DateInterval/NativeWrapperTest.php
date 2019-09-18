<?php

namespace AdamRocska\ShippingTier\Utility\DateInterval;

use DateInterval;
use PHPUnit\Framework\TestCase;

class NativeWrapperTest extends TestCase
{

    public function nativeDateIntervals(): iterable
    {
        return [
            [new DateInterval('P2Y4DT6H8M')],
            [new DateInterval('P2Y4DT6H2M')],
            [new DateInterval('P2Y5DT6H8M')],
            [new DateInterval('P2Y5DT6H2M')],
            [new DateInterval('P2Y4DT1H8M')],
            [new DateInterval('P2Y4DT1H2M')],
            [new DateInterval('P2Y5DT1H8M')],
            [new DateInterval('P2Y5DT1H2M')],
            [$this->asNegative(new DateInterval('P2Y4DT6H8M'))],
            [$this->asNegative(new DateInterval('P2Y4DT6H2M'))],
            [$this->asNegative(new DateInterval('P2Y5DT6H8M'))],
            [$this->asNegative(new DateInterval('P2Y5DT6H2M'))],
            [$this->asNegative(new DateInterval('P2Y4DT1H8M'))],
            [$this->asNegative(new DateInterval('P2Y4DT1H2M'))],
            [$this->asNegative(new DateInterval('P2Y5DT1H8M'))],
            [$this->asNegative(new DateInterval('P2Y5DT1H2M'))]
        ];
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
            $native->format("Y=%yM=%MD=%DH=%HI=%IS=%SF=%FR=%R"),
            $dateInterval->format("Y=%yM=%MD=%DH=%HI=%IS=%SF=%FR=%R"),
            "Conceptually the date intervals should be equal."
        );
    }

    private function asNegative(DateInterval $dateInterval): DateInterval
    {
        $dateInterval->invert = 1;
        return $dateInterval;
    }

}
