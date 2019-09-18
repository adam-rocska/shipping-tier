<?php


namespace AdamRocska\ShippingTier\Utility;


use DateInterval as NativeDateInterval;

/**
 * Represents an interval of time.
 *
 * The intention is a more comfortable API for a date interval concept.
 * Inspired by Php's native DateInterval interface.
 *
 * @package AdamRocska\ShippingTier\Utility
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 * @see     https://www.php.net/manual/en/class.dateinterval.php
 */
interface DateInterval
{
    /**
     * Returns the number of years in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getYears(): int;

    /**
     * Returns the number of months in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMonths(): int;

    /**
     * Returns the number of hours in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getHours(): int;

    /**
     * Returns the number of minutes in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMinutes(): int;

    /**
     * Returns the number of seconds in the interval.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getSeconds(): int;

    /**
     * Returns the number of microseconds in the interval.
     * Can be fractional.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return float
     */
    public function getMicroseconds(): float;

    /**
     * Tells whether the date interval is forward pointing in time.
     * In other words, if the start point is now, it points ahead in time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function isForwardInTime(): bool;

    /**
     * Tells whether the date interval is backward pointing in time.
     * In other words, if the start point is now, it points back in time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function isBackwardInTime(): bool;

    /**
     * Returns the native `DateInterval` representation of the current object.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return NativeDateInterval
     */
    public function asNativeDateInterval(): NativeDateInterval;
}