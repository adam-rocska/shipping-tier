<?php


namespace AdamRocska\ShippingTier\Entity;


/**
 * Represents a country entity considered by the tiering mechanism.
 *
 * @package AdamRocska\ShippingTier\Entity
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface Country
{

    /**
     * Returns the ISO Code of the country the object represents.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIsoCode(): string;

    /**
     * Returns the human readable representation of the country's name the
     * object represents.
     * This value may be localized.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getLabel(): string;
}
