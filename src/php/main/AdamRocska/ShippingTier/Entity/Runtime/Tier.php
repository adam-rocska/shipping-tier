<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\ShippingMethod;
use AdamRocska\ShippingTier\Entity\Tier as TierEntity;

class Tier implements TierEntity
{
    /**
     * @var ShippingMethod[]
     */
    private $shippingMethods;


    /**
     * Tier constructor.
     *
     * @param ShippingMethod[] $shippingMethods
     */
    public function __construct(iterable $shippingMethods)
    {
        $this->shippingMethods = $shippingMethods;
    }

    public function getFastestShippingMethodForCountry(
        Country $country
    ): ShippingMethod {
        foreach ($this->shippingMethods as $shippingMethod) {
            $shippingMethod->hasCountry();
        }
    }
}