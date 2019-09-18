<?php


namespace AdamRocska\ShippingTier\Entity;


interface Country
{
    public function getIsoCode(): string;

    public function getLabel(): string;
}