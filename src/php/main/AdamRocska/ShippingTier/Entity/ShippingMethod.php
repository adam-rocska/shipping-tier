<?php


namespace AdamRocska\ShippingTier\Entity;


interface ShippingMethod
{
    public function getDoorToDoorTransitTime(): DoorToDoorTransitTime;

    public function getTier(): Tier;

    /**
     * @return Country[]
     */
    public function getCountries(): iterable;

    public function getCarrier(): Carrier;
}