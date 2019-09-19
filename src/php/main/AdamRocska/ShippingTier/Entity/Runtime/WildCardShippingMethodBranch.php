<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\LazyShippingMethodInjectionAware;
use AdamRocska\ShippingTier\Entity\LazyTierInjectionAware;
use AdamRocska\ShippingTier\Entity\ShippingMethod;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch as ShippingMethodBranchEntity;
use AdamRocska\ShippingTier\Entity\Tier;

/**
 * Represents a wildcard shipping method branch.
 * It matches as true for all hasCountry calls.
 * Used to represent an "all other countries" in a shipping method.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class WildCardShippingMethodBranch implements ShippingMethodBranchEntity,
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
     * WildCardShippingMethodBranch constructor.
     *
     * @param DoorToDoorTransitTime $doorToDoorTransitTime The
     *                                                     `DoorToDoorTransitionTime`
     *                                                     of the current
     *                                                     shipping method
     *                                                     brach.
     */
    public function __construct(DoorToDoorTransitTime $doorToDoorTransitTime)
    {
        $this->doorToDoorTransitTime = $doorToDoorTransitTime;
    }


    /**
     * Returns the `DoorToDoorTransitionTime` of the current shipping method
     * branch.
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
     * Injects the provided `Tier`.
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
     * Returns an empty list of countries, since this is a wildcard shipping
     * method branch. It doesn't encapsulate specific countries.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Country[]
     */
    public function getCountries(): iterable
    {
        return [];
    }

    /**
     * Always returns true, to fulfill its wildcard matcher role.
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
        return true;
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
    public function hasTier(): bool
    {
        return !is_null($this->tier);
    }
}