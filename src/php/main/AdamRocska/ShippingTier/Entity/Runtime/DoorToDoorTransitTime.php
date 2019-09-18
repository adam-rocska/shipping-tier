<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Comparable;
use AdamRocska\ShippingTier\Comparable\Exception\UncomparableType;
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
     * Compares the received object with the current one.
     * Can be interpreted as `>` or as `$myObject > $thatObject`, where
     * `$myObject->greaterThan($thatObject)` is called.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Comparable $comparable
     *
     * @return bool
     * @throws UncomparableType Throws an `UncomparableType` exception if the
     *                          received input can't be compared against the
     *                          current object.
     */
    public function greaterThan(Comparable $comparable): bool
    {
        // TODO: Implement greaterThan() method.
    }

    /**
     * Compares the received object with the current one.
     * Can be interpreted as `<` or as `$myObject < $thatObject`, where
     * `$myObject->smallerThan($thatObject)` is called.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Comparable $comparable
     *
     * @return bool
     * @throws UncomparableType Throws an `UncomparableType` exception if the
     *                          received input can't be compared against the
     *                          current object.
     */
    public function smallerThan(Comparable $comparable): bool
    {
        // TODO: Implement smallerThan() method.
    }

    /**
     * Performs an equality check between the current object, and the received
     * object. It is up to the objects' implementations to decide how the
     * equality logic works.
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
        $message = "Object to check equality against is not a/an";
        $message .= DoorToDoorTransitTimeEntity::class;
        $message .= " implementation";
        throw new UnequatableType($message);
    }
}