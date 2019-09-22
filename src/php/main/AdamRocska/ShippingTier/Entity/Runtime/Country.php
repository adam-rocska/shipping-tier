<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country as CountryEntity;

/**
 * Represents a runtime instance of a Country entity.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class Country implements CountryEntity
{

    /**
     * The ISO code of the represented country object.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $isoCode;

    /**
     * The human readable representation of the represented country's name.
     * This value may be localized.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $label;

    /**
     * Country constructor.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param string $label   The human readable representation of the
     *                        represented country's name.
     *                        This value may be localized.
     * @param string $isoCode The ISO code of the represented country object.
     */
    public function __construct(string $isoCode, string $label)
    {
        $this->isoCode = $isoCode;
        $this->label   = $label;
    }

    /**
     * Utility method for the mass creation of Country objects from a provided
     * map.
     *
     * @param array $map Keys are considered to be ISO Codes. Values are
     *                   considered to be labels.
     *
     * @return Country[]
     * @example example/php/AdamRocska/ShippingTier/Entity/Runtime/country-creation-from-map.php
     *
     */
    public static function createFromMap(array $map): iterable
    {
        $countries = [];
        foreach ($map as $isoCode => $label) {
            $countries[] = new Country($isoCode, $label);
        }
        return $countries;
    }

    /**
     * Returns the ISO Code of the country the object represents.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

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
    public function getLabel(): string
    {
        return $this->label;
    }

}
