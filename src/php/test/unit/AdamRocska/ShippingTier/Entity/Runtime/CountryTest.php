<?php

namespace AdamRocska\ShippingTier\Entity\Runtime;

use AdamRocska\ShippingTier\Entity\Country as CountryEntity;
use AdamRocska\ShippingTier\Equatable;
use AdamRocska\ShippingTier\Equatable\Exception\UnequatableType;
use PHPUnit\Framework\MockObject\MockObject;
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

    public function testEquals_throwsExceptionIfIsNotCountryEntity(): void
    {
        $country = new Country("test", "test");
        /** @var MockObject|Equatable $mockEquatable */
        $mockEquatable = $this->createMock(Equatable::class);

        try {
            $country->equals($mockEquatable);
            $this->fail("Expected equality check to throw exception.");
        } catch (UnequatableType $exception) {
            $this->assertInstanceOf(
                UnequatableType::class,
                $exception,
                "Expected to throw an exception of type "
                . UnequatableType::class
            );
            $expectedExceptionMessage = "Expected a/an "
                                        . CountryEntity::class
                                        . " entity implementation. Got a/n"
                                        . get_class($mockEquatable)
                                        . " instance.";
            $this->assertEquals(
                $expectedExceptionMessage,
                $exception->getMessage(),
                "Expected a descriptive exception message."
            );
        }
    }

    /**
     * @throws UnequatableType
     */
    public function testEquals_happyPath(): void
    {
        $archetypeIso = "test";
        $archetype    = new Country($archetypeIso, "stub label");

        /** @var MockObject|Equatable|CountryEntity $equalObject */
        $equalObject = $this->createMockComparableCountry($archetypeIso);
        /** @var MockObject|Equatable|CountryEntity $unequalObject */
        $unequalObject = $this->createMockComparableCountry("not matching iso");

        $this->assertTrue(
            $archetype->equals($archetype),
            "Archetype object should equal itself."
        );

        $this->assertTrue(
            $archetype->equals($equalObject),
            "Archetype should equal another object of same iso code."
        );

        $this->assertFalse(
            $archetype->equals($unequalObject),
            "Archetype shouldn't equal another object of different iso code"
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

    private function createMockComparableCountry(string $iso): MockObject
    {
        $mockObject = $this->createMock([
                                            Equatable::class,
                                            CountryEntity::class
                                        ]);
        $mockObject
            ->method("getIsoCode")
            ->willReturn($iso);

        return $mockObject;
    }


}
