<?php


namespace AdamRocska\ShippingTier\Entity;


/**
 * Represents a shipping method.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface ShippingMethod
{
    /**
     * Returns a human friendly / human readable label identifying the shipping
     * method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getLabel(): string;

    /**
     * Returns a computer program intended identifier identifying the shipping
     * method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Returns the list of `ShippingMethodBranch`es belonging to this shipping
     * method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return ShippingMethodBranch[]
     */
    public function getBranches(): iterable;

    /**
     * Returns the `Carrier` to which the current `ShippingMethod` belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Carrier
     */
    public function getCarrier(): Carrier;
}