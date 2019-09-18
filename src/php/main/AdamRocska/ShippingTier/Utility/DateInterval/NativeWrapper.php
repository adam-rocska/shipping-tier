<?php


namespace AdamRocska\ShippingTier\Utility\DateInterval;


use AdamRocska\ShippingTier\Utility\DateInterval;
use AdamRocska\ShippingTier\Utility\DateInterval\Exception\CorruptIntervalSpec;
use DateInterval as NativeDateInterval;

/**
 * Wraps a native `DateInterval` object, and represents it as an internal
 * `DateInterval`
 *
 * @package AdamRocska\ShippingTier\Utility\DateInterval
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class NativeWrapper implements DateInterval
{
    // weeks can be handled as input but not as format output.
    const INTERVAL_FORMAT_FOR_COPYING = "P"    // "period marker"
                                        . "%yY" // year
                                        . "%mM" // months
                                        . "%dD" // days
                                        . "T"   // "time marker"
                                        . "%hH" // hours
                                        . "%iM" // minutes
                                        . "%sS"; // seconds;

    /**
     * The `DateInterval` instance being wrapped.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var NativeDateInterval
     */
    private $nativeDateInterval;

    /**
     * Copies the provided `NativeDateInterval` instance for representation to
     * avoid unexpected side-effects.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param NativeDateInterval $nativeDateInterval The native date interval
     *                                               instance to wrap.
     *
     * @throws CorruptIntervalSpec Throws a `CorruptIntervalSpec` if
     *                             `NativeDateTime` copying / instantiation has
     *                             failed.
     */
    public function __construct(NativeDateInterval $nativeDateInterval)
    {
        $this->nativeDateInterval = $this->copyNativeDateInterval(
            $nativeDateInterval
        );
    }

    /**
     * Creates a NativeWrapper instance for a `NativeDateInterval` representing
     * the provided interval spec.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param string $spec The interval spec to construct a wrapper for.
     *
     * @return NativeWrapper
     * @throws CorruptIntervalSpec Throws a `CorruptIntervalSpec` if the
     *                             received interval spec can't be processed by
     *                             the native `DateInterval` constructor.
     * @see     https://www.php.net/manual/en/dateinterval.construct.php for
     *          interval_spec description.
     *
     */
    public static function createFromIntervalSpec(string $spec): NativeWrapper
    {
        try {
            return new NativeWrapper(new NativeDateInterval($spec));
        } catch (\Exception $exception) {
            throw new CorruptIntervalSpec(
                "Native date interval construction failed.",
                0,
                $exception
            );
        }
    }

    /**
     * Returns the number of years in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getYears(): int
    {
        return $this->nativeDateInterval->y;
    }

    /**
     * Returns the number of months in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMonths(): int
    {
        return $this->nativeDateInterval->m;
    }

    /**
     * Returns the number of hours in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getHours(): int
    {
        return $this->nativeDateInterval->h;
    }

    /**
     * Returns the number of minutes in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->nativeDateInterval->i;
    }

    /**
     * Returns the number of seconds in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getSeconds(): int
    {
        return $this->nativeDateInterval->s;
    }

    /**
     * Returns the number of microseconds in the interval.
     * Can be fractional.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return float
     */
    public function getMicroseconds(): float
    {
        return $this->nativeDateInterval->f;
    }

    /**
     * Tells whether the date interval is forward pointing in time.
     * In other words, if the start point is now, it points ahead in time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function isForwardInTime(): bool
    {
        return $this->nativeDateInterval->invert === 0;
    }

    /**
     * Tells whether the date interval is backward pointing in time.
     * In other words, if the start point is now, it points back in time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function isBackwardInTime(): bool
    {
        return $this->nativeDateInterval->invert === 1;
    }

    /**
     * Returns the native `DateInterval` representation of the current object.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return NativeDateInterval
     * @throws CorruptIntervalSpec Throws a `CorruptIntervalSpec` in case the
     *                             constructor of the `NativeDateInterval`
     *                             throws an exception.
     */
    public function asNativeDateInterval(): NativeDateInterval
    {
        return $this->copyNativeDateInterval($this->nativeDateInterval);
    }

    /**
     * Returns the number of days in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getDays(): int
    {
        return $this->nativeDateInterval->d;
    }

    /**
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param NativeDateInterval $interval
     *
     * @return NativeDateInterval
     * @throws CorruptIntervalSpec
     */
    private function copyNativeDateInterval(
        NativeDateInterval $interval
    ): NativeDateInterval {
        try {
            $intervalCopy         = new NativeDateInterval(
                $interval->format(static::INTERVAL_FORMAT_FOR_COPYING)
            );
            $intervalCopy->invert = $interval->invert;
            return $intervalCopy;
        } catch (\Exception $exception) {
            throw new CorruptIntervalSpec(
                "Native date interval construction failed.",
                0,
                $exception
            );
        }
    }
}