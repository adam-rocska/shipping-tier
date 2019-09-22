<?php


namespace AdamRocska\ShippingTier\Entity;


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
     * Returns the minimum necessary transit time in days.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMinimumDays(): int;

    /**
     * Returns the maximum necessary transit time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMaximumDays(): int;
}
