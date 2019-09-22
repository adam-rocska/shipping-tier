<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\LazyShippingMethodBranchListInjection;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch;
use AdamRocska\ShippingTier\Entity\Tier as TierEntity;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchesBound;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchForCountry;

/**
 * Represents a set of shipping method branches sorted in the same tier /
 * category.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class Tier implements TierEntity, LazyShippingMethodBranchListInjection
{

    /**
     * The machine identifier of the tier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $identifier;

    /**
     * The human comprehensible label of the tier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $label;

    /**
     * The set of shipping method branches encapsulated by this tier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var ShippingMethodBranch[]
     */
    private $shippingMethodBranches;

    /**
     * Tier constructor.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param string $label
     * @param string $identifier
     */
    public function __construct(string $identifier, string $label)
    {
        $this->identifier             = $identifier;
        $this->label                  = $label;
        $this->shippingMethodBranches = [];
    }

    /**
     * Returns the machine identifier of the tier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Returns the human comprehensible label of the tier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Returns the fastest shipping method branch within the tier, that
     * contains the provided country.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Country $country
     *
     * @return ShippingMethodBranch
     * @throws NoShippingMethodBranchesBound Throws a
     *                                      `NoShippingMethodBranchesBound`
     *                                      exception when there are no
     *                                      shipping method branches bound to
     *                                      the tier at all.
     * @throws NoShippingMethodBranchForCountry Throws a
     *                                          `NoShippingMethodBranchForCountry`
     *                                          exception when there is no
     *                                          shipping method branch found
     *                                          for the provided country.
     */
    public function getFastestShippingMethodBranchForCountry(
        Country $country
    ): ShippingMethodBranch {
        $this->assertHasShippingMethodBranches();

        $bestBranch = null;
        foreach ($this->shippingMethodBranches as $currentBranch) {
            if (!$currentBranch->hasCountry($country)) {
                continue;
            }
            if (is_null($bestBranch)) {
                $bestBranch = $currentBranch;
                continue;
            }

            $currentTime = $currentBranch->getDoorToDoorTransitTime();
            $bestTime    = $bestBranch->getDoorToDoorTransitTime();

            if ($this->isCurrentTimeFasterThanBest($currentTime, $bestTime)) {
                $bestBranch = $currentBranch;
            }
        }

        $this->assertShippingMethodFoundForCountry($country, $bestBranch);
        return $bestBranch;
    }

    /**
     * Adds the provided shipping method branch to the instance.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param ShippingMethodBranch $branch
     */
    public function addShippingMethodBranch(ShippingMethodBranch $branch): void
    {
        $this->shippingMethodBranches[] = $branch;
    }

    /**
     * Sets the provided shipping method branches.
     * It overrides the existing set of shipping methods bound to this instance.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param iterable $branches
     */
    public function setShippingMethodBranches(iterable $branches): void
    {
        $this->shippingMethodBranches = $branches;
    }

    /**
     * Compares the received `DoorToDoorTransitTime` against the received
     * "best" / fastest `DoorToDoorTransitTime`, and tells whether the new one
     * is considered to be faster, than the current best.
     * The decision logic finds the one, that's most likely to arrive sooner.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param DoorToDoorTransitTime $best
     * @param DoorToDoorTransitTime $current
     *
     * @return bool
     */
    private function isCurrentTimeFasterThanBest(
        DoorToDoorTransitTime $current,
        DoorToDoorTransitTime $best
    ): bool {
        $r = $best->getMaximumDays() - $best->getMinimumDays();
        $t = $best->getMinimumDays() - $current->getMinimumDays();
        $s = $current->getMaximumDays() - $best->getMaximumDays();

        $minAngle = atan2($t, $r) * (180 / M_PI);
        $maxAngle = atan2($s, $r) * (180 / M_PI);

        return ($minAngle > 0) && ($maxAngle < $minAngle);
    }

    /**
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @throws NoShippingMethodBranchesBound
     */
    private function assertHasShippingMethodBranches(): void
    {
        if (count($this->shippingMethodBranches) === 0) {
            throw new NoShippingMethodBranchesBound("There are no shipping method branches bound to this tier.");
        }
    }

    /**
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param ShippingMethodBranch|null $bestBranch
     * @param Country                   $country
     *
     * @throws NoShippingMethodBranchForCountry
     */
    private function assertShippingMethodFoundForCountry(
        Country $country,
        ?ShippingMethodBranch $bestBranch
    ): void {
        if (is_null($bestBranch)) {
            $exceptionMessage = "No shipping method found for country "
                                . $country->getLabel()
                                . " of ISO code "
                                . $country->getIsoCode()
                                . ".";
            throw new NoShippingMethodBranchForCountry($exceptionMessage);
        }
    }

}
