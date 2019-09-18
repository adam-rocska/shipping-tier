<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country as CountryEntity;
use AdamRocska\ShippingTier\Equatable;

class Country implements CountryEntity, Equatable
{

    /**
     * @var string
     */
    private $isoCode;

    /**
     * @var string
     */
    private $label;

    /**
     * Country constructor.
     *
     * @param string $isoCode
     * @param string $label
     */
    public function __construct(string $isoCode, string $label)
    {
        $this->isoCode = $isoCode;
        $this->label   = $label;
    }

    /**
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    public function equals(Equatable $equatable): bool
    {
        assert($equatable instanceof self);
    }
}