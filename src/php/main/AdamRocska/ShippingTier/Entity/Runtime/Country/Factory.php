<?php


namespace AdamRocska\ShippingTier\Entity\Runtime\Country;


use AdamRocska\ShippingTier\Entity\Country as CountryEntity;
use AdamRocska\ShippingTier\Entity\Runtime\Country;
use AdamRocska\ShippingTier\Entity\Runtime\Country\Factory\Exception\IncorrectFileInfo;
use SplFileInfo;

class Factory
{
    const DEFAULT_COUNTRY_LIST_CSV_FILE_PATH        = __DIR__
                                                      . DIRECTORY_SEPARATOR
                                                      . "Factory"
                                                      . DIRECTORY_SEPARATOR
                                                      . "data"
                                                      . DIRECTORY_SEPARATOR
                                                      . "data_csv.csv";
    const DEXPECTED_COUNTRY_LIST_CSV_FILE_EXTENSION = "csv";
    /**
     * @var SplFileInfo
     */
    private $countryListCsv;

    /**
     * Factory constructor.
     *
     * @param SplFileInfo $countryListCsv
     *
     * @throws IncorrectFileInfo
     */
    public function __construct(SplFileInfo $countryListCsv = null)
    {
        if (is_null($countryListCsv)) {
            $countryListCsv = new SplFileInfo(
                self::DEFAULT_COUNTRY_LIST_CSV_FILE_PATH
            );
        }

        $errorCode    = 0;
        $errorMessage = "CSV input file info is incorrect: ";

        if (!$countryListCsv->isFile()) {
            $errorCode    |= IncorrectFileInfo::NOT_FILE;
            $errorMessage .= "Not a file. ";
        }
        if (!$countryListCsv->isReadable()) {
            $errorCode    |= IncorrectFileInfo::NOT_READABLE;
            $errorMessage .= "Not readable. ";
        }
        $extension = $countryListCsv->getExtension();
        if ($extension !== self::DEXPECTED_COUNTRY_LIST_CSV_FILE_EXTENSION) {
            $errorCode    |= IncorrectFileInfo::UNEXPECTED_FILE_EXTENSION;
            $errorMessage .= "Unexpected file extension : \""
                             . $extension
                             . "\".";
        }

        if ($errorCode !== 0) {
            throw new IncorrectFileInfo(rtrim($errorMessage), $errorCode);
        }

        $this->countryListCsv = $countryListCsv;
    }

    /**
     * @return CountryEntity[]
     */
    public function getCountries(): iterable
    {
        $splFileObject = $this->countryListCsv->openFile();
        $countries     = [];
        while (!$splFileObject->eof()) {
            $csvRow = $splFileObject->fgetcsv();
            if (count($csvRow) !== 2) {
                continue;
            }
            list($label, $isoCode) = $csvRow;
            if (strlen($isoCode) > 3) {
                continue;
            }
            $countries[] = new Country($isoCode, $label);
        }
        return $countries;
    }
}