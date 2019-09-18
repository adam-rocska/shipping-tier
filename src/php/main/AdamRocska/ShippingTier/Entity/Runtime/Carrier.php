<?php


namespace AdamRocska\ShippingTier\Entity\Runtime;


use AdamRocska\ShippingTier\Entity\Carrier as CarrierEntity;
use AdamRocska\ShippingTier\Entity\ShippingMethod;

/**
 * Represents a shipping carrier during runtime.
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class Carrier implements CarrierEntity
{

    /**
     * A human friendly / human readable label identifying the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $label;

    /**
     * A computer program intended identifier identifying the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $identifier;

    /**
     * The list of individual shipping methods provided by the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var ShippingMethod[]
     */
    private $shippingMethods;

    /**
     * Carrier constructor.
     *
     * @param string           $label           A human friendly / human
     *                                          readable label identifying the
     *                                          carrier.
     * @param string           $identifier      A computer program intended
     *                                          identifier identifying the
     *                                          carrier.
     * @param ShippingMethod[] $shippingMethods The list of individual shipping
     *                                          methods provided by the
     *                                          carrier.
     */
    public function __construct(
        string $label,
        string $identifier,
        iterable $shippingMethods
    ) {
        $this->label           = $label;
        $this->identifier      = $identifier;
        $this->shippingMethods = $shippingMethods;
    }

    /**
     * Returns a human friendly / human readable label identifying the carrier.
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
     * Returns a computer program intended identifier identifying the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Returns the list of individual shipping methods provided by the carrier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return ShippingMethod[]
     */
    public function getShippingMethods(): array
    {
        return $this->shippingMethods;
    }


}