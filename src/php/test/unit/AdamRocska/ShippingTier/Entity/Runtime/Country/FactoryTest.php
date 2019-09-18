<?php

namespace AdamRocska\ShippingTier\Entity\Runtime\Country;

use AdamRocska\ShippingTier\Entity\Runtime\Country\Factory\Exception\IncorrectFileInfo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SplFileInfo;

class FactoryTest extends TestCase
{

    public function testConstructor_throwsDescriptiveException(): void
    {
        $notFile = $this->createMockSplFileInfoWithExpectedFields(
            false,
            true,
            Factory::DEXPECTED_COUNTRY_LIST_CSV_FILE_EXTENSION
        );

        $notReadable = $this->createMockSplFileInfoWithExpectedFields(
            true,
            false,
            Factory::DEXPECTED_COUNTRY_LIST_CSV_FILE_EXTENSION
        );

        $wrongExtension = $this->createMockSplFileInfoWithExpectedFields(
            true,
            true,
            "test"
        );

        $notFileNotReadable = $this->createMockSplFileInfoWithExpectedFields(
            false,
            false,
            Factory::DEXPECTED_COUNTRY_LIST_CSV_FILE_EXTENSION
        );

        $notFileWrongExtension =
            $this->createMockSplFileInfoWithExpectedFields(
                false,
                true,
                "test"
            );

        $notReadableWrongExtension =
            $this->createMockSplFileInfoWithExpectedFields(
                true,
                false,
                "test"
            );

        $notFileNotReadableWrongExtension =
            $this->createMockSplFileInfoWithExpectedFields(
                false,
                false,
                "test"
            );

        $this->assertConstructorThrows(
            $notFile,
            IncorrectFileInfo::NOT_FILE,
            "CSV input file info is incorrect: Not a file."
        );
        $this->assertConstructorThrows(
            $notReadable,
            IncorrectFileInfo::NOT_READABLE,
            "CSV input file info is incorrect: Not readable."
        );
        $this->assertConstructorThrows(
            $wrongExtension,
            IncorrectFileInfo::UNEXPECTED_FILE_EXTENSION,
            "CSV input file info is incorrect: Unexpected file extension : \"test\"."
        );
        $this->assertConstructorThrows(
            $notFileNotReadable,
            IncorrectFileInfo::NOT_FILE
            | IncorrectFileInfo::NOT_READABLE,
            "CSV input file info is incorrect: Not a file. Not readable."
        );
        $this->assertConstructorThrows(
            $notFileWrongExtension,
            IncorrectFileInfo::NOT_FILE
            | IncorrectFileInfo::UNEXPECTED_FILE_EXTENSION,
            "CSV input file info is incorrect: Not a file. Unexpected file extension : \"test\"."
        );
        $this->assertConstructorThrows(
            $notReadableWrongExtension,
            IncorrectFileInfo::NOT_READABLE
            | IncorrectFileInfo::UNEXPECTED_FILE_EXTENSION,
            "CSV input file info is incorrect: Not readable. Unexpected file extension : \"test\"."
        );
        $this->assertConstructorThrows(
            $notFileNotReadableWrongExtension,
            IncorrectFileInfo::NOT_FILE
            | IncorrectFileInfo::NOT_READABLE
            | IncorrectFileInfo::UNEXPECTED_FILE_EXTENSION,
            "CSV input file info is incorrect: Not a file. Not readable. Unexpected file extension : \"test\"."
        );

    }

    /**
     * @throws IncorrectFileInfo
     */
    public function testConstructorDefaultFile(): void
    {
        $factoryUnderTest      = new Factory();
        $defaultCountryListCsv = new SplFileInfo(
            Factory::DEFAULT_COUNTRY_LIST_CSV_FILE_PATH
        );
        $factoryToMatchAgainst = new Factory($defaultCountryListCsv);
        $expectedCountries     = $factoryToMatchAgainst->getCountries();

        foreach ($factoryUnderTest->getCountries() as $index => $actualCountry) {
            $this->assertEquals(
                $expectedCountries[$index]->getIsoCode(),
                $actualCountry->getIsoCode(),
                "Expected to return the same country object at the same object for the default country list csv file based factory."
            );
            $this->assertEquals(
                $expectedCountries[$index]->getLabel(),
                $actualCountry->getLabel(),
                "Expected to return the same country object at the same object for the default country list csv file based factory."
            );
        }
    }

    private function assertConstructorThrows(
        SplFileInfo $splFileInfo,
        int $expectedErrorCode,
        string $expectedExceptionMessage
    ): void {
        try {
            new Factory($splFileInfo);
            $this->fail("Should have thrown an exception.");
        } catch (IncorrectFileInfo $exception) {
            $this->assertEquals(
                $expectedErrorCode,
                $exception->getCode(),
                "Exception code should reflect the problem as a tag bit."
            );
            $this->assertEquals(
                $expectedExceptionMessage,
                $exception->getMessage(),
                "Exception message should be descriptive."
            );
        }
    }

    private function createMockSplFileInfoWithExpectedFields(
        bool $isFile = true,
        bool $isReadable = true,
        string $fileExtension = "csv"
    ): SplFileInfo {
        /** @var MockObject|SplFileInfo $mockObject */
        $mockObject = $this->createMock(SplFileInfo::class);
        $mockObject
            ->expects($this->once())
            ->method("isFile")
            ->willReturn($isFile);
        $mockObject
            ->expects($this->once())
            ->method("isReadable")
            ->willReturn($isReadable);
        $mockObject
            ->expects($this->once())
            ->method("getExtension")
            ->willReturn($fileExtension);
        return $mockObject;
    }


}
