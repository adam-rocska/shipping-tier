<?php


namespace AdamRocska\ShippingTier\Entity;


interface ShippingMethodBranch
{
    /**
     * Returns the `DoorToDoorTransitionTime` of the current shipping method
     * branch.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return DoorToDoorTransitTime
     */
    public function getDoorToDoorTransitTime(): DoorToDoorTransitTime;

    /**
     * Returns the `Tier` to which this shipping method branch belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Tier
     */
    public function getTier(): Tier;

    /**
     * Returns the list of countries handled by the current shipping method
     * branch.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Country[]
     */
    public function getCountries(): iterable;

    /**
     * Tells whether the queried country is handled by the current shipping
     * method branch.
     * Comparison is done based on the encapsulated countries' and the provided
     * country's ISO codes.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Country $country
     *
     * @return bool
     */
    public function hasCountry(Country $country): bool;

    /**
     * Returns the shipping method to which this shipping method branch belongs
     * to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return ShippingMethod
     */
    public function getShippingMethod(): ShippingMethod;
}
