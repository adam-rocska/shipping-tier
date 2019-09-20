<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country;
use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime;
use AdamRocska\ShippingTier\Entity\LazyShippingMethodBranchListInjection;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch;
use AdamRocska\ShippingTier\Entity\Tier as TierEntity;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchesBound;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchForCountry;

class Tier implements TierEntity, LazyShippingMethodBranchListInjection
{

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $label;

    /**
     * @var ShippingMethodBranch[]
     */
    private $shippingMethodBranches;

    /**
     * Tier constructor.
     *
     * @param string $identifier
     * @param string $label
     */
    public function __construct(string $identifier, string $label)
    {
        $this->identifier             = $identifier;
        $this->label                  = $label;
        $this->shippingMethodBranches = [];
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
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
    ): ShippingMethodBranch {
        if (count($this->shippingMethodBranches) === 0) {
            throw new NoShippingMethodBranchesBound("There are no shipping method branches bound to this tier.");
        }

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

        if (is_null($bestBranch)) {
            $exceptionMessage = "No shipping method found for country "
                                . $country->getLabel()
                                . " of ISO code "
                                . $country->getIsoCode()
                                . ".";
            throw new NoShippingMethodBranchForCountry($exceptionMessage);
        }
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
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param DoorToDoorTransitTime $best
     *
     * @param DoorToDoorTransitTime $current
     *
     * @return bool
     */
    private function isCurrentTimeFasterThanBest(
        DoorToDoorTransitTime $current,
        DoorToDoorTransitTime $best
    ): bool {
        // @TODO
    }
}