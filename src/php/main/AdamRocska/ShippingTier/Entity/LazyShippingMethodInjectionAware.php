<?php


namespace AdamRocska\ShippingTier\Entity;


/**
 * Represents an object that can consume the injection of a `ShippingMethod`
 * entity as its dependency after instantiation.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface LazyShippingMethodInjectionAware
{

    /**
     * Injects the provided `ShippingMethod`.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param ShippingMethod $shippingMethod
     */
    public function setShippingMethod(ShippingMethod $shippingMethod): void;

    /**
     * Tells whether the current instance has a `ShippingMethod` injected.
     * _HINT : For its dependents it's useful for catch-able, or debug
     * assertions._
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function hasShippingMethod(): bool;
}
