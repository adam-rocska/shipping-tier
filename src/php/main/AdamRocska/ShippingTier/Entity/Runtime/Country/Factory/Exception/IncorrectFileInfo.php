<?php


namespace AdamRocska\ShippingTier\Entity\Runtime\Country\Factory\Exception;


use AdamRocska\ShippingTier\Entity\Runtime\Country\Factory\Exception;

/**
 * Represents an exception related to the FileInfo object with which the
 * factory could work.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime\Country\Factory\Exception
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class IncorrectFileInfo extends Exception
{
    const NOT_FILE                  = 0b00000001;
    const NOT_READABLE              = 0b00000010;
    const UNEXPECTED_FILE_EXTENSION = 0b00000100;
}