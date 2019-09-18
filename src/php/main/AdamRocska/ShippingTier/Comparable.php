<?php


namespace AdamRocska\ShippingTier;


use AdamRocska\ShippingTier\Comparable\Exception\UncomparableType;

/**
 * Represents a comparable object.
 * By design it doesn't include the Equatable API.
 *
 * @package AdamRocska\ShippingTier
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 * @see     Equatable
 */
interface Comparable
{

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
    public function greaterThan(Comparable $comparable): bool;

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
    public function smallerThan(Comparable $comparable): bool;

}