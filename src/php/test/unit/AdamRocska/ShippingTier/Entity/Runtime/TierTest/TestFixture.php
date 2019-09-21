<?php


namespace AdamRocska\ShippingTier\Entity\Runtime\TierTest;


use SplFileInfo;

class TestFixture
{
    const DATASET_FILE_EXTENSION = "csv";

    /**
     * @var iterable
     */
    private $csvRecords = [];

    /**
     * @var ?int
     */
    private $winnerRecordIndex;

    /**
     * @var string
     */
    private $descriptionPath;

    /**
     * TestFixture constructor.
     *
     * @param SplFileInfo $splFileInfo
     */
    public function __construct(SplFileInfo $splFileInfo)
    {
        assert($splFileInfo->isFile());
        assert($splFileInfo->isReadable());
        assert($splFileInfo->getExtension() === self::DATASET_FILE_EXTENSION);
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

        $this->descriptionPath = substr(
                                     $splFileInfo->getRealPath(),
                                     0,
                                     -1 * strlen(self::DATASET_FILE_EXTENSION))
                                 . "md";

        $descriptionPathFileInfo = new SplFileInfo($this->descriptionPath);
        assert($descriptionPathFileInfo->isFile(), "A textual description must exist for this dataset.");
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

    /**
     * @return string
     */
    public function getDescriptionPath(): string
    {
        return $this->descriptionPath;
    }

}