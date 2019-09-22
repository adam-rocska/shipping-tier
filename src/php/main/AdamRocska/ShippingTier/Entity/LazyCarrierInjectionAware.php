<?php


namespace AdamRocska\ShippingTier\Entity;


/**
 * Represents an object that can consume the injection of a `Carrier` entity as
 * its dependency after instantiation.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface LazyCarrierInjectionAware
{

    /**
     * Injects the provided `Carrier`
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Carrier $carrier
     */
    public function setCarrier(Carrier $carrier): void;

    /**
     * Tells whether the current instance has a `Carrier` injected.
     * _HINT : For its dependents it's useful for catch-able, or debug
     * assertions._
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function hasCarrier(): bool;
}
