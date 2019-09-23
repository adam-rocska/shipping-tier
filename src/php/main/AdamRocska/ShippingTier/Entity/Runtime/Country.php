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


use AdamRocska\ShippingTier\Entity\Country as CountryEntity;

/**
 * Represents a runtime instance of a Country entity.
 *
 * @package AdamRocska\ShippingTier
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
     * @param string $isoCode The ISO code of the represented country object.
     * @param string $label   The human readable representation of the
     *                        represented country's name.
     *                        This value may be localized.
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
