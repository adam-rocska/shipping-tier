<?php
/**
 * Copyright 2019 Adam Rocska
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace AdamRocska\ShippingTier\Entity\Runtime;

use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{

    public function isoCodes(): iterable
    {
        return [
            ["HU"],
            ["DE"],
            ["US"]
        ];
    }

    public function labels(): iterable
    {
        return [
            ["Hungary"],
            ["Germany"],
            ["United States"]
        ];
    }

    /**
     * @param string $isoCode
     *
     * @dataProvider isoCodes
     */
    public function testGetIsoCode(string $isoCode): void
    {
        $country = new Country($isoCode, "test");
        $this->assertEquals(
            $isoCode,
            $country->getIsoCode(),
            "Object should return the instantiated iso code untouched."
        );
    }

    /**
     * @param string $label
     *
     * @dataProvider labels
     */
    public function testGetLabel(string $label): void
    {
        $country = new Country("test", $label);
        $this->assertEquals(
            $label,
            $country->getLabel(),
            "Object should return the instantiated label untouched."
        );
    }

    public function testCreateFromMap(): void
    {
        $countryMap            = [
            "HU" => "Hungary",
            "DE" => "Germany",
            "US" => "United States"
        ];
        $countries             = Country::createFromMap($countryMap);
        $isoListInCountiesList = [];

        foreach ($countries as $country) {
            $isoListInCountiesList[] = $country->getIsoCode();
            $this->assertArrayHasKey(
                $country->getIsoCode(),
                $countryMap,
                "Received ISO code should exist in the original map."
            );
            $this->assertEquals(
                $countryMap[$country->getIsoCode()],
                $country->getLabel(),
                "Country's related label should match."
            );
        }
        $this->assertEquals(
            count($countryMap),
            count($isoListInCountiesList),
            "Should have the same amount of ISO codes as originally defined."
        );

        $isoListInCountryMap = array_keys($countryMap);
        sort($isoListInCountryMap);
        sort($isoListInCountiesList);

        $this->assertEquals(
            $isoListInCountryMap,
            $isoListInCountiesList,
            "Should have the exact same ISO codes represented as provided."
        );
    }

}
