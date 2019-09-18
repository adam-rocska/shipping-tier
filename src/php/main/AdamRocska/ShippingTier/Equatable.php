<?php


namespace AdamRocska\ShippingTier;


use AdamRocska\ShippingTier\Equatable\Exception\UnequatableType;

/**
 * Represents an object that can be checked for equality with another object.
 *
 * @package AdamRocska\ShippingTier
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface Equatable
{

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
    public function equals(Equatable $equatable): bool;
}