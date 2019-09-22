<?php


namespace AdamRocska\ShippingTier\Entity;


/**
 * Represents an object that can consume the injection of
 * `ShippingMethodBranch` entities as its dependency after instantiation.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface LazyShippingMethodBranchListInjection
{

    /**
     * Adds the provided shipping method branch to the instance.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param ShippingMethodBranch $branch
     */
    public function addShippingMethodBranch(ShippingMethodBranch $branch): void;

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
    public function setShippingMethodBranches(iterable $branches): void;
}
