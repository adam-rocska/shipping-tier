<?php
/**
 * Copyright 2019 Adam Rocska
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\LazyShippingMethodInjectionAware;
use AdamRocska\ShippingTier\Entity\LazyTierInjectionAware;
use AdamRocska\ShippingTier\Entity\ShippingMethod;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch as ShippingMethodBranchEntity;
use AdamRocska\ShippingTier\Entity\Tier;

/**
 * Represents a branch of a shipping method.
 * A branch is a cluster of countries with a common door to door transit times,
 * and belonging to a common tier.
 *
 * @package AdamRocska\ShippingTier
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class ShippingMethodBranch implements ShippingMethodBranchEntity,
                                      LazyTierInjectionAware,
                                      LazyShippingMethodInjectionAware
{
    /**
     * The current shipping method branch's door to door transition time for its
     * encapsulated countries.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var DoorToDoorTransitTime
     */
    private $doorToDoorTransitTime;


    /**
     * The list of countries encapsulated by this shipping method branch.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var Country[]
     */
    private $countries;

    /**
     * The tier to which this shipping method branch belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var Tier
     */
    private $tier;

    /**
     * The shipping method to which this shipping method branch belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var ShippingMethod
     */
    private $shippingMethod;

    /**
     * ShippingMethodBranch constructor.
     *
     * @param DoorToDoorTransitTime $doorToDoorTransitTime The
     *                                                     `DoorToDoorTransitionTime`
     *                                                     of the current
     *                                                     shipping method
     *                                                     branch.
     * @param Country[]             $countries             The list of
     *                                                     countries handled by
     *                                                     the current shipping
     *                                                     method branch.
     */
    public function __construct(
        DoorToDoorTransitTime $doorToDoorTransitTime,
        iterable $countries
    ) {
        $this->doorToDoorTransitTime = $doorToDoorTransitTime;
        $this->countries             = $countries;
    }

    /**
     * Returns the current shipping method branch's door to door transition
     * time for its encapsulated countries.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return DoorToDoorTransitTime
     */
    public function getDoorToDoorTransitTime(): DoorToDoorTransitTime
    {
        return $this->doorToDoorTransitTime;
    }

    /**
     * Returns the `Tier` to which this shipping method branch belongs to.
     * `Tier`s are lazily injected into this instance, therefore in order to
     * avoid runtime type related failures, make sure to test / assert /
     * validate a tier's presence via `hasTier`.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Tier
     */
    public function getTier(): Tier
    {
        return $this->tier;
    }

    /**
     * Sets the tier to which this shipping method branch belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Tier $tier
     */
    public function setTier(Tier $tier): void
    {
        $this->tier = $tier;
    }

    /**
     * Returns the list of countries encapsulated by this shipping method
     * branch.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Country[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    /**
     * Tells whether the encapsulated list of countries contains the received
     * country. It does equality comparison based on the encapsulated ISO Code.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Country $country
     *
     * @return bool
     */
    public function hasCountry(Country $country): bool
    {
        $queriedIsoCode = $country->getIsoCode();
        foreach ($this->countries as $encapsulatedCountry) {
            if ($encapsulatedCountry->getIsoCode() === $queriedIsoCode) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the shipping method to which this shipping method branch belongs
     * to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return ShippingMethod
     */
    public function getShippingMethod(): ShippingMethod
    {
        return $this->shippingMethod;
    }

    /**
     * Tells whether the current instance has a `Tier` injected into it.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return bool
     */
    public function hasTier(): bool
    {
        return !is_null($this->tier);
    }

    /**
     * Injects the provided `ShippingMethod`.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param ShippingMethod $shippingMethod
     */
    public function setShippingMethod(ShippingMethod $shippingMethod): void
    {
        $this->shippingMethod = $shippingMethod;
    }

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
    public function hasShippingMethod(): bool
    {
        return !is_null($this->shippingMethod);
    }

}
