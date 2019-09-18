<?php


namespace AdamRocska\ShippingTier\Utility\DateInterval\Exception;


use AdamRocska\ShippingTier\Utility\DateInterval\Exception;

/**
 * Represents an exception which occurs when corrupt / malformed / invalid
 * interval spec parameters are fed into the native `DateInterval`'s
 * constructor.
 *
 * @package AdamRocska\ShippingTier\Utility\DateInterval\Exception
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 * @see     https://www.php.net/manual/en/dateinterval.construct.php
 */
class CorruptIntervalSpec extends Exception
{

}