<?php


namespace AdamRocska\ShippingTier\Entity;


use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchesBound;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchForCountry;

interface Tier
{

    /**
     * Returns the tier's human readable label.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getLabel(): string;

    /**
     * Returns the tier's machine readable identifier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Returns the shipping method branch for the given country which is of the
     * fastest possible door-to-door transit time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Country $country
     *
     * @return ShippingMethodBranch
     * @throws NoShippingMethodBranchForCountry Throws a
     *                                          `NoShippingMethodBranchForCountry`
     *                                          exception when there is no
     *                                          shipping method branch found
     *                                          for the provided country.
     * @throws NoShippingMethodBranchesBound Throws a
     *                                      `NoShippingMethodBranchesBound`
     *                                      exception when there are no
     *                                      shipping method branches bound to
     *                                      the tier at all.
     */
    public function getFastestShippingMethodBranchForCountry(
        Country $country
    ): ShippingMethodBranch;
}