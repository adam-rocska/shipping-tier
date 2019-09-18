<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime as DoorToDoorTransitTimeEntity;
use AdamRocska\ShippingTier\Entity\Runtime\DoorToDoorTransitTime\Exception\InvalidBoundaries;

class DoorToDoorTransitTime implements DoorToDoorTransitTimeEntity
{

    /**
     * @var int
     */
    private $minimumDays;

    /**
     * @var int
     */
    private $maximumDays;

    /**
     * DoorToDoorTransitTime constructor.
     *
     * @param int $minimumDays
     * @param int $maximumDays
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