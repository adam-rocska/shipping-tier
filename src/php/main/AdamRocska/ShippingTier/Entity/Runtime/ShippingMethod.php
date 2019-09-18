<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Carrier;
use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\LazyCarrierInjectionAware;
use AdamRocska\ShippingTier\Entity\LazyTierInjectionAware;
use AdamRocska\ShippingTier\Entity\ShippingMethod as ShippingMethodEntity;
use AdamRocska\ShippingTier\Entity\Tier;

/**
 * Represents a runtime `ShippingMethod` entity.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class ShippingMethod implements ShippingMethodEntity, LazyCarrierInjectionAware,
                                LazyTierInjectionAware
{

    /**
     * The current shipping method's door to door transition time for its
     * encapsulated countries.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var DoorToDoorTransitTime
     */
    private $doorToDoorTransitTime;

    /**
     * The tier to which this shipping method belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var Tier
     */
    private $tier;

    /**
     * The list of countries encapsulated by this shipping method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var Country[]
     */
    private $countries;

    /**
     * The carrier to which this shipping method belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var Carrier
     */
    private $carrier;

    /**
     * ShippingMethod constructor.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Country[]             $countries
     * @param DoorToDoorTransitTime $doorToDoorTransitTime
     */
    public function __construct(
        DoorToDoorTransitTime $doorToDoorTransitTime,
        iterable $countries
    ) {
        $this->doorToDoorTransitTime = $doorToDoorTransitTime;
        $this->countries             = $countries;
    }

    /**
     * Returns the current shipping method's door to door transition time for
     * its encapsulated countries.
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
     * Returns the `Tier` to which this shipping method belongs to.
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
     * Sets the tier to which this shipping method belongs to.
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
     * Returns the list of countries encapsulated by this shipping method.
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
     * Returns the `Carrier` to which this shipping method belongs to.
     * `Carrier`s are lazily injected into this instance, therefore in order to
     * avoid runtime type related failures, make sure to test / assert /
     * validate a tier's presence via `hasCarrier`.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Carrier
     */
    public function getCarrier(): Carrier
    {
        return $this->carrier;
    }

    /**
     * Sets the carrier to which this shipping method belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Carrier $carrier
     */
    public function setCarrier(Carrier $carrier): void
    {
        $this->carrier = $carrier;
    }

    /**
     * Tells whether the current instance has a `Carrier` injected into it.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @return bool
     */
    public function hasCarrier(): bool
    {
        return !is_null($this->carrier);
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


}