<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime as DoorToDoorTransitTimeEntity;
use AdamRocska\ShippingTier\Entity\Runtime\DoorToDoorTransitTime\Exception\InvalidBoundaries;
use AdamRocska\ShippingTier\Equatable;
use AdamRocska\ShippingTier\Equatable\Exception\UnequatableType;

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
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var int
     */
    private $minimumDays;

    /**
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
     * @param int $maximumDays The minimum amount of days it takes for a
     *                         shipment to arrive door to door.
     * @param int $minimumDays The maximum amount of days it takes for a
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

    /**
     * Performs an equality check between the current object, and the received
     * object. It is up to the objects' implementations to decide how the
     * equality logic works.
     *
     * Two `DoorToDoorTransitTime` objects are considered equal if, and only if
     * both their minimum and their maximum days are equal.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Equatable $equatable
     *
     * @return bool Returns `true` if the current object is considered to be
     *              equal with the received object. Returns `false` if the
     *              current object is not considered to be equal with the
     *              received object.
     * @throws UnequatableType Throws an `UnequatableType` exception if the
     *                         equality can not be performed due to a type
     *                         mismatch. This exception is used to tackle PHP's
     *                         current covariance & contra-variance concepts.
     */
    public function equals(Equatable $equatable): bool
    {
        if (!($equatable instanceof DoorToDoorTransitTimeEntity)) {
            $message = "Object to check equality against is not a/an ";
            $message .= DoorToDoorTransitTimeEntity::class;
            $message .= " implementation.";
            throw new UnequatableType($message);
        }
        return ($equatable->getMinimumDays() === $this->getMinimumDays())
               && ($equatable->getMaximumDays() === $this->getMaximumDays());
    }
}