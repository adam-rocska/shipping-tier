<?php

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
