<?php


namespace AdamRocska\ShippingTier\Entity\Tier\Exception;


use AdamRocska\ShippingTier\Entity\Tier\Exception;

/**
 * Represents an exception case, when a given country has no shipping method
 * entity matched to it.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class NoShippingMethodBranchForCountry extends Exception
{

}
