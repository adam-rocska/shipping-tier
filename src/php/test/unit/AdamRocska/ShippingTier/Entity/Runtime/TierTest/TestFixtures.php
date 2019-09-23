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

namespace AdamRocska\ShippingTier\Entity\Runtime\TierTest;


use DirectoryIterator;
use SplFileInfo;

/**
 * Class TestFixtures
 *
 * @package AdamRocska\ShippingTier\Entity\Runtime\TierTest
 * @internal
 */
class TestFixtures
{

    const TEST_FIXTURE_DIR = __DIR__
                             . DIRECTORY_SEPARATOR
                             . "testFixtures"
                             . DIRECTORY_SEPARATOR;

    /**
     * @var TestFixtures
     */
    private static $instance;

    /**
     * @var TestFixture[]
     */
    private $testFixtures = [];

    /**
     * TestFixtures constructor.
     */
    private function __construct()
    {
        $testFixtureDirInfo = new SplFileInfo(self::TEST_FIXTURE_DIR);
        assert($testFixtureDirInfo->isDir());
        assert($testFixtureDirInfo->isReadable());
        $testFixtureDir = new DirectoryIterator(
            $testFixtureDirInfo->getRealPath()
        );
        foreach ($testFixtureDir as $fixtureFileInfo) {
            $extension = $fixtureFileInfo->getExtension();
            if ($extension === TestFixture::DATASET_FILE_EXTENSION) {
                $key                      = $fixtureFileInfo->getFilename();
                $this->testFixtures[$key] = new TestFixture($fixtureFileInfo);
            }
        }
    }

    public static function getInstance(): TestFixtures
    {
        if (!isset(self::$instance)) {
            self::$instance = new TestFixtures();
        }
        return self::$instance;
    }

    /**
     * @return TestFixture[]
     */
    public function getTestFixtures(): array
    {
        return $this->testFixtures;
    }
}