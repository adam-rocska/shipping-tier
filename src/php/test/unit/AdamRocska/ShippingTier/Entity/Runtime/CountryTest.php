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

    public function testEquals_throwsExceptionIfIsntCountryEntity(): void
    {
        $country       = new Country("test", "test");
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
        $equalObject = $this->createMockComparableCoutnry($archetypeIso);
        /** @var MockObject|Equatable|CountryEntity $unequalObject */
        $unequalObject = $this->createMockComparableCoutnry("not matching iso");

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

    private function createMockComparableCoutnry(string $iso): MockObject
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
