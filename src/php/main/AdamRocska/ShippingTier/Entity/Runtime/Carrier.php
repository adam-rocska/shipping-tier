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


use AdamRocska\ShippingTier\Entity\Carrier as CarrierEntity;
use AdamRocska\ShippingTier\Entity\Carrier\Exception\NoShippingMethod;
use AdamRocska\ShippingTier\Entity\LazyCarrierInjectionAware;
use AdamRocska\ShippingTier\Entity\ShippingMethod;

/**
 * Represents a shipping carrier during runtime.
 *
 * @package AdamRocska\ShippingTier
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

        foreach ($this->shippingMethods as $shippingMethod) {
            if ($shippingMethod instanceof LazyCarrierInjectionAware) {
                $shippingMethod->setCarrier($this);
            }
        }
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

    /**
     * Returns a shipping method who's identifier matches the given one.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param string $identifier
     *
     * @return ShippingMethod
     * @throws NoShippingMethod Throws a `NoShippingMethod` when no shipping
     *                          method was matched against the received
     *                          identifier.
     */
    public function getShippingMethodByIdentifier(string $identifier
    ): ShippingMethod {
        foreach ($this->shippingMethods as $shippingMethod) {
            if ($shippingMethod->getIdentifier() === $identifier) {
                return $shippingMethod;
            }
        }
        $exceptionMessage = "No shipping method found by identifier \"";
        $exceptionMessage .= $identifier;
        $exceptionMessage .= "\"";
        throw new NoShippingMethod($exceptionMessage);
    }

}
