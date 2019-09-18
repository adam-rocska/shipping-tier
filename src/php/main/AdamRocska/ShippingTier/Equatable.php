<?php


namespace AdamRocska\ShippingTier;


interface Equatable
{

    /**
     * @param Equatable $equatable
     *
     * @return bool
     * @throws
     */
    public function equals(Equatable $equatable): bool;
}