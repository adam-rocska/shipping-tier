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


use AdamRocska\ShippingTier\Entity\Carrier;
use AdamRocska\ShippingTier\Entity\LazyCarrierInjectionAware;
use AdamRocska\ShippingTier\Entity\LazyShippingMethodInjectionAware;
use AdamRocska\ShippingTier\Entity\ShippingMethod as ShippingMethodEntity;
use AdamRocska\ShippingTier\Entity\ShippingMethodBranch;

/**
 * Represents a runtime `ShippingMethod` entity.
 *
 * @package AdamRocska\ShippingTier
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class ShippingMethod implements ShippingMethodEntity, LazyCarrierInjectionAware
{

    /**
     * The carrier to which this shipping method belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var Carrier
     */
    private $carrier;

    /**
     * a human friendly / human readable label identifying the shipping
     * method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $label;

    /**
     * Returns a computer program intended identifier identifying the shipping
     * method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var string
     */
    private $identifier;

    /**
     * The list of shipping method branches encapsulated by the current
     * shipping method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var ShippingMethodBranch[]
     */
    private $branches;

    /**
     * ShippingMethod constructor.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param string                 $label                A human friendly /
     *                                                     human readable label
     *                                                     identifying the
     *                                                     shipping method.
     * @param string                 $identifier           A computer program
     *                                                     intended identifier
     *                                                     identifying the
     *                                                     shipping method.
     * @param ShippingMethodBranch[] $branches             A list of shipping
     *                                                     method branches
     *                                                     encapsulated by the
     *                                                     current shipping
     *                                                     method.
     */
    public function __construct(
        string $label,
        string $identifier,
        iterable $branches
    ) {
        $this->label      = $label;
        $this->identifier = $identifier;
        $this->branches   = $branches;

        foreach ($this->branches as $branch) {
            if ($branch instanceof LazyShippingMethodInjectionAware) {
                $branch->setShippingMethod($this);
            }
        }
    }

    /**
     * Returns the `Carrier` to which this shipping method belongs to.
     * `Carrier`s are lazily injected into this instance, therefore in order to
     * avoid runtime type related failures, make sure to test / assert /
     * validate a tier's presence via `hasCarrier`.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return Carrier
     */
    public function getCarrier(): Carrier
    {
        return $this->carrier;
    }

    /**
     * Sets the carrier to which this shipping method belongs to.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Carrier $carrier
     */
    public function setCarrier(Carrier $carrier): void
    {
        $this->carrier = $carrier;
    }

    /**
     * Returns a human friendly / human readable label identifying the shipping
     * method.
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
     * Returns a computer program intended identifier identifying the shipping
     * method.
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
     * Returns the list of `ShippingMethodBranch`es belonging to this shipping
     * method.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return ShippingMethodBranch[]
     */
    public function getBranches(): iterable
    {
        return $this->branches;
    }

    /**
     * Tells whether the current instance has a `Carrier` injected into it.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @return bool
     */
    public function hasCarrier(): bool
    {
        return !is_null($this->carrier);
    }
}
