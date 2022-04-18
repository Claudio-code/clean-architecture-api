<?php

namespace App\Tests\src\Feature\Application\Product\Create;

use App\Application\Product\Create\CreateProductUseCase;
use App\Application\Product\Create\ProductOutputData;
use App\Domain\Common\UploadFile;
use App\Domain\Entity\Product\Product;
use App\Domain\Exception\EmptyValueException;
use App\Domain\Exception\InvalidPriceException;
use App\Infrastructure\Persistence\Repository\ProductRepository;
use App\Tests\src\Utils\Traits\CreateProductMocksTrait;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CreateProductUseCaseTest extends TestCase
{
    use CreateProductMocksTrait;

    private LegacyMockInterface|ProductRepository|MockInterface $productRepository;
    private LegacyMockInterface|ParameterBagInterface|MockInterface $parameterBagInterface;
    private CreateProductUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parameterBagInterface = \Mockery::mock(ParameterBagInterface::class);
        $uploadFile = new UploadFile($this->parameterBagInterface);
        $this->productRepository = \Mockery::mock(ProductRepository::class);
        $this->useCase = new CreateProductUseCase(
            productRepository: $this->productRepository,
            product: new Product($uploadFile),
        );
    }

    /** @test  */
    public function shouldSaveNewProduct(): void
    {
        $this->parameterBagInterface
            ->shouldReceive('get')
            ->once()
            ->andReturn('wdd');
        $input = $this->createProductInputDataWithAllValidFields();
        $this->productRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($this->createProductPersistenceWithValidFields());

        $result = $this->useCase->create($input);
        self::assertInstanceOf(ProductOutputData::class, $result);
    }

    /** @test */
    public function shouldReturnExceptionIfNameIsEmpty(): void
    {
        self::expectException(EmptyValueException::class);
        $input = $this->createProductInputDataWithInvalidTitle();
        $this->useCase->create($input);
    }

    /** @test */
    public function shouldReturnExceptionIfPriceIsEmpty(): void
    {
        self::expectException(InvalidPriceException::class);
        $input = $this->createProductInputDataWithInvalidPrice();
        $this->useCase->create($input);
    }
}
