<?php


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
            if ($fixtureFileInfo->getExtension() === "csv") {
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