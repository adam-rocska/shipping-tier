<?php


namespace AdamRocska\ShippingTier\Entity;


/**
 * Represents an object that can consume the injection of a `Tier` entity as
 * its dependency after instantiation.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface LazyTierInjectionAware
{
    /**
     * Injects the provided `Tier`.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Tier $tier
     */
    public function setTier(Tier $tier): void;

    /**
     * Tells whether the current instance has a `Tier` injected.
     * _HINT : For its dependents it's useful for catch-able, or debug
     * assertions._
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function hasTier(): bool;
}
