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

namespace AdamRocska\ShippingTier\Entity;


use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchesBound;
use AdamRocska\ShippingTier\Entity\Tier\Exception\NoShippingMethodBranchForCountry;

/**
 * Represents a set of shipping method branches sorted in the same tier /
 * category.
 *
 * @package AdamRocska\ShippingTier
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
interface Tier
{

    /**
     * Returns the tier's human readable label.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getLabel(): string;

    /**
     * Returns the tier's machine readable identifier.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Returns the shipping method branch for the given country which is of the
     * fastest possible door-to-door transit time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param Country $country
     *
     * @return ShippingMethodBranch
     * @throws NoShippingMethodBranchForCountry Throws a
     *                                          `NoShippingMethodBranchForCountry`
     *                                          exception when there is no
     *                                          shipping method branch found
     *                                          for the provided country.
     * @throws NoShippingMethodBranchesBound Throws a
     *                                      `NoShippingMethodBranchesBound`
     *                                      exception when there are no
     *                                      shipping method branches bound to
     *                                      the tier at all.
     */
    public function getFastestShippingMethodBranchForCountry(
        Country $country
    ): ShippingMethodBranch;
}
