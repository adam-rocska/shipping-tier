<?php


namespace AdamRocska\ShippingTier\Entity\Runtime\TierTest;


use SplFileInfo;

class TestFixture
{

    /**
     * @var iterable
     */
    private $csvRecords = [];

    /**
     * @var ?int
     */
    private $winnerRecordIndex;

    /**
     * TestFixture constructor.
     *
     * @param SplFileInfo $splFileInfo
     */
    public function __construct(SplFileInfo $splFileInfo)
    {
        assert($splFileInfo->isFile());
        assert($splFileInfo->isReadable());
        assert($splFileInfo->getExtension() === "csv");
        $splFileObject  = $splFileInfo->openFile();
        $csvRecordIndex = 0;
        while (!$splFileObject->eof()) {
            $csvRecord = $splFileObject->fgetcsv();
            assert(
                count($csvRecord) === 4,
                "CSV file must have exactly 4 columns. Please read testFixtures.md"
            );
            $isWinner           = trim($csvRecord[0]) === "true";
            $shouldMatch        = trim($csvRecord[1]) === "true";
            $minTime            = intval(trim($csvRecord[2]));
            $maxTime            = intval(trim($csvRecord[3]));
            $this->csvRecords[] = [$shouldMatch, $minTime, $maxTime];
            if ($isWinner) {
                assert(
                    is_null($this->winnerRecordIndex),
                    "There can only be one winner record defined. Please read testFixtures.md"
                );
                $this->winnerRecordIndex = $csvRecordIndex;
            }
            $csvRecordIndex++;
        }
    }

    /**
     * Returns a list of tuples of `list($hasCountry, $minTransit, $maxTransit)`
     *
     * @return iterable
     */
    public function getCsvRecords(): iterable
    {
        return $this->csvRecords;
    }

    /**
     * Returns an integer, if a winning shipping method is determined.
     * Returns null if no winning shipping methods are specified.
     *
     * @return int|null
     */
    public function getWinnerRecordIndex(): ?int
    {
        return $this->winnerRecordIndex;
    }
}