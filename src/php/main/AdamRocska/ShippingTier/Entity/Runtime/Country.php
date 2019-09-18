<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Country as CountryEntity;
use AdamRocska\ShippingTier\Equatable;
use AdamRocska\ShippingTier\Equatable\Exception\UnequatableType;

/**
 * Represents a runtime instance of a Country entity.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class Country implements CountryEntity, Equatable
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

    /**
     * Performs an equality check on the received equatable object.
     * Returns true if the ISO code of the current instance matches that of the
     * received one.
     * Returns false if it doesn't.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Equatable|CountryEntity $equatable The equatable `CountryEntity`
     *                                           to check for equality.
     *
     * @return bool
     * @throws UnequatableType Throws an `UnequatableType` if the received
     *                         equatable doesn't implement `CountryEntity`.
     */
    public function equals(Equatable $equatable): bool
    {
        if (!($equatable instanceof CountryEntity)) {
            $exceptionMessage = "Expected a/an "
                                . CountryEntity::class
                                . " entity implementation. Got a/n"
                                . get_class($equatable)
                                . " instance.";
            throw new UnequatableType($exceptionMessage);
        }

        return $equatable->getIsoCode() === $this->getIsoCode();
    }


}