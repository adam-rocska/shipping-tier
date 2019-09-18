<?php


namespace AdamRocska\ShippingTier\Entity;


use AdamRocska\ShippingTier\Utility\DateInterval;

/**
 * Represents a door-to-door transit estimate.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface DoorToDoorTransitTime
{
    /**
     * Returns the minimum necessary transit time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return DateInterval
     */
    public function getAtLeast(): DateInterval;

    /**
     * Returns the maximum necessary transit time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return DateInterval
     */
    public function getAtMost(): DateInterval;
}