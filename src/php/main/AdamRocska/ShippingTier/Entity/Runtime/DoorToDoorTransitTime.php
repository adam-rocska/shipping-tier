<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime as DoorToDoorTransitTimeEntity;
use AdamRocska\ShippingTier\Entity\Runtime\DoorToDoorTransitTime\Exception\InvalidBoundaries;

/**
 * Represents a simple runtime `DoorToDoorTransitTime` entity implementation.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class DoorToDoorTransitTime implements DoorToDoorTransitTimeEntity
{

    /**
     * The minimum amount of days it takes for a shipment to arrive door to
     * door.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var int
     */
    private $minimumDays;

    /**
     * The maximum amount of days it takes for a shipment to arrive door to
     * door.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var int
     */
    private $maximumDays;

    /**
     * DoorToDoorTransitTime constructor.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param int $minimumDays The minimum amount of days it takes for a
     *                         shipment to arrive door to door.
     * @param int $maximumDays The maximum amount of days it takes for a
     *                         shipment to arrive door to door.
     *
     * @throws InvalidBoundaries
     */
    public function __construct(int $minimumDays, int $maximumDays)
    {
        if ($maximumDays < $minimumDays) {
            $message = "Maximum days greater than minimum days.";
            $message .= "Values received : ";
            $message .= "\$maximumDays=" . $maximumDays;
            $message .= "\$minimumDays=" . $minimumDays;
            throw new InvalidBoundaries($message);
        }
        $this->minimumDays = $minimumDays;
        $this->maximumDays = $maximumDays;
    }

    /**
     * Returns the minimum necessary transit time in days.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMinimumDays(): int
    {
        return $this->minimumDays;
    }

    /**
     * Returns the maximum necessary transit time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMaximumDays(): int
    {
        return $this->maximumDays;
    }

}
