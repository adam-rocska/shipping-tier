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


use AdamRocska\ShippingTier\Entity\DoorToDoorTransitTime as DoorToDoorTransitTimeEntity;
use AdamRocska\ShippingTier\Entity\Runtime\DoorToDoorTransitTime\Exception\InvalidBoundaries;

/**
 * Represents a simple runtime `DoorToDoorTransitTime` entity implementation.
 *
 * @package AdamRocska\ShippingTier
 * @version Version 1.0.0
 * @since   Version 1.0.0
 * @author  Adam Rocska <adam.rocska@adams.solutions>
 */
class DoorToDoorTransitTime implements DoorToDoorTransitTimeEntity
{

    /**
     * The minimum amount of days it takes for a shipment to arrive door to
     * door.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var int
     */
    private $minimumDays;

    /**
     * The maximum amount of days it takes for a shipment to arrive door to
     * door.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @var int
     */
    private $maximumDays;

    /**
     * DoorToDoorTransitTime constructor.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     *
     * @param int $minimumDays The minimum amount of days it takes for a
     *                         shipment to arrive door to door.
     * @param int $maximumDays The maximum amount of days it takes for a
     *                         shipment to arrive door to door.
     *
     * @throws InvalidBoundaries
     */
    public function __construct(int $minimumDays, int $maximumDays)
    {
        if ($maximumDays < $minimumDays) {
            $message = "Maximum days greater than minimum days.";
            $message .= "Values received : ";
            $message .= "\$maximumDays=" . $maximumDays;
            $message .= "\$minimumDays=" . $minimumDays;
            throw new InvalidBoundaries($message);
        }
        $this->minimumDays = $minimumDays;
        $this->maximumDays = $maximumDays;
    }

    /**
     * Returns the minimum necessary transit time in days.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMinimumDays(): int
    {
        return $this->minimumDays;
    }

    /**
     * Returns the maximum necessary transit time.
     *
     * @version Version 1.0.0
     * @since   Version 1.0.0
     * @author  Adam Rocska <adam.rocska@adams.solutions>
     * @return int
     */
    public function getMaximumDays(): int
    {
        return $this->maximumDays;
    }

}
