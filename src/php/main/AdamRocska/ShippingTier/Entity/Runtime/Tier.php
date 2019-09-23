<?php
/**
 * Copyright 2019 Adam Rocska
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
 * @package AdamRocska\ShippingTier
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
     * @param string $identifier The machine identifier of the tier.
     * @param string $label      The human comprehensible label of the tier.
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
     * Compares the received `DoorToDoorTransitTime` against the received
     * "best" / fastest `DoorToDoorTransitTime`, and tells whether the new one
     * is considered to be faster, than the current best.
     * The decision logic finds the one, that's most likely to arrive sooner.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param DoorToDoorTransitTime $current The `DoorToDoorTransitTime` of a
     *                                       competing shipping method branch.
     * @param DoorToDoorTransitTime $best    The `DoorToDoorTransitTime` of the
     *                                       shipping method branch considered
     *                                       as the fastest at the time of
     *                                       comparison.
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
     * Asserts, that the current tier object has shipping method branches bound.
     *
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

}
