<?php


namespace AdamRocska\ShippingTier\Entity;


use AdamRocska\ShippingTier\Entity\Carrier\Exception\NoShippingMethod;

/**
 * Represents a shipping carrier.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface Carrier
{

    /**
     * Returns a human friendly / human readable label identifying the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getLabel(): string;

    /**
     * Returns a computer program intended identifier identifying the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Returns the list of individual shipping methods provided by the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return ShippingMethod[]
     */
    public function getShippingMethods(): iterable;

    /**
     * Returns a shipping method who's identifier matches the given one.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param string $identifier
     *
     * @return ShippingMethod
     * @throws NoShippingMethod Throws a `NoShippingMethod` when no shipping
     *                          method was matched against the received
     *                          identifier.
     */
    public function getShippingMethodByIdentifier(string $identifier
    ): ShippingMethod;
}
