<?php


namespace AdamRocska\ShippingTier\Entity;


interface Tier
{
    public function getFastestShippingMethodForCountry(
        Country $country
    ): ShippingMethod;
}