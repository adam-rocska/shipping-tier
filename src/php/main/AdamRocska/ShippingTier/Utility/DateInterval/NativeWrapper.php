<?php


namespace AdamRocska\ShippingTier\Utility\DateInterval;


use AdamRocska\ShippingTier\Utility\DateInterval;
use DateInterval as NativeDateInterval;

class NativeWrapper implements DateInterval
{

    /**
     * @var NativeDateInterval
     */
    private $nativeDateInterval;

    /**
     * NativeWrapper constructor.
     *
     * @param NativeDateInterval $nativeDateInterval
     */
    public function __construct(NativeDateInterval $nativeDateInterval)
    {
        $this->nativeDateInterval = $nativeDateInterval;
    }

    public static function createFromIntervalSpec(string $spec): NativeWrapper
    {
        return new NativeWrapper(new NativeDateInterval($spec));
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
     */
    public function asNativeDateInterval(): NativeDateInterval
    {
        // weeks can be handled as input but not as format output.
        $format       = "P";    // "period marker"
        $format       .= "%yY"; // year
        $format       .= "%mM"; // months
        $format       .= "%dD"; // days
        $format       .= "T";   // "time marker"
        $format       .= "%hH"; // hours
        $format       .= "%iM"; // minutes
        $format       .= "%sS"; // seconds
        $dateInterval = new NativeDateInterval(
            $this->nativeDateInterval->format($format)
        );
        if ($this->isBackwardInTime()) {
            $dateInterval->invert = 1;
        }
        return $dateInterval;
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
}