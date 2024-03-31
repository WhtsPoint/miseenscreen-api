<?php

namespace App\Tests\Unit\CallForm;

use App\Dto\CallFormDto;
use App\Exception\FileIsAlreadyExistsException;
use App\Factory\CallFormFactory;
use App\Interface\CallFormFileUploadInterface;
use App\Model\CallForm;
use App\Utils\Services;
use DateTimeImmutable;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

class CallFormTest extends TestCase
{
    private FakerGenerator $generator;
    private CallForm $callForm;

    public function setUp(): void
    {
        $this->generator = FakerFactory::create();
    }

    /**
     * @dataProvider additionProvider
     * @throws FileIsAlreadyExistsException
     */
    public function test_getters_and_setter(CallFormDto $dto): void
    {
        $callForm = (new CallFormFactory())->create(
            $dto, $this->createStub(CallFormFileUploadInterface::class)
        );

        $this->assertEquals($dto->comment, $callForm->getComment());
        $this->assertEquals($dto->fullName, $callForm->getFullName());
        $this->assertEquals($dto->companyName, $callForm->getCompanyName());
        $this->assertEquals($dto->employeeNumber, $callForm->getEmployeeNumber());
        $this->assertEquals($dto->phone, $callForm->getPhone());
        $this->assertEquals($dto->email, $callForm->getEmail());
        $this->assertEquals($dto->services, $callForm->getServices()->get());
    }

    /**
     * @dataProvider additionProvider
     * @throws FileIsAlreadyExistsException
     */
    public function test_file_upload(CallFormDto $dto): void
    {
        $callForm = (new CallFormFactory())->create(
            $dto, $this->createStub(CallFormFileUploadInterface::class)
        );

        $expectedId = $callForm->getId();

        $files = [self::createStub(File::class)];
        $fileNames = [];
        $storageMock = $this->createMock(CallFormFileUploadInterface::class);
        $storageMock->expects($this->exactly(count($files)))
            ->method('upload')
            ->willReturnCallback(function ($file, $id) use ($expectedId, $files, &$fileNames) {
                $this->assertTrue(in_array($file, $files));
                $this->assertEquals($expectedId, $id);
                $fileName = $this->generator->uuid();

                $fileNames[] = $fileName;

                return $fileName;
            });

        foreach ($files as $file) {
            $callForm->addFile($file, $storageMock);
        }

        $this->assertEqualsCanonicalizing($fileNames, $callForm->getFiles());
    }

    /**
     * @dataProvider additionProvider
     * @throws FileIsAlreadyExistsException
     */
    public function test_posted_at(CallFormDto $dto): void
    {
        $callForm = (new CallFormFactory())->create(
            $dto, $this->createStub(CallFormFileUploadInterface::class)
        );

        $postedAt = $this->createStub(DateTimeImmutable::class);

        $callForm->setPostedAt($postedAt);

        $this->assertEquals($postedAt, $callForm->getPostedAt());
    }

    public static function additionProvider(): array
    {
        return [
            [new CallFormDto(
                'any string comment',
                'any string fullName',
                'any string companyName',
                'any string employeeNumber',
                'any string phone',
                'any string email',
                Services::VALUES
            )]
        ];
    }
}