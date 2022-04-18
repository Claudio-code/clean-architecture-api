<?php

namespace App\Tests\src\Feature\Application\Product\Update;

use App\Application\Product\Update\UpdateProductUseCase;
use App\Domain\Common\UploadFile;
use App\Domain\Entity\Product\Product as ProductDomain;
use App\Infrastructure\Persistence\Entity\Product;
use App\Infrastructure\Persistence\Repository\ProductRepository;
use App\Tests\src\Utils\DatabaseTestCase;
use App\Tests\src\Utils\Traits\CreateProductMocksTrait;
use App\Tests\src\Utils\Traits\UpdateProductMocksTrait;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UpdateProductUseCaseTest extends DatabaseTestCase
{
    use CreateProductMocksTrait;
    use UpdateProductMocksTrait;

    private LegacyMockInterface|ParameterBagInterface|MockInterface $parameterBagInterface;
    private ProductRepository $productRepository;
    private UpdateProductUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parameterBagInterface = \Mockery::mock(ParameterBagInterface::class);
        $this->parameterBagInterface
            ->shouldReceive('get')
            ->once()
            ->andReturn('wdd');

        $uploadFile = new UploadFile($this->parameterBagInterface);
        $this->productRepository = new ProductRepository($this->paginator , $this->entityManager);
        $this->useCase = new UpdateProductUseCase(
            productRepository: $this->productRepository,
            product: new ProductDomain($uploadFile),
        );
    }

    private function getProductDomain(): ProductDomain
    {
        $input = $this->createProductInputDataWithAllValidFields();
        $domain = new ProductDomain(new UploadFile($this->parameterBagInterface));
        $domain->setProperties($input);
        $domain->saveImage();

        return $domain;
    }

    private function createProduct(): Product
    {
        return $this->productRepository->create($this->getProductDomain());
    }

    /** @test  */
    public function shouldUpdateProductTitle(): void
    {
        $product = $this->createProduct();
        $input = $this->updateProductInputDataWithAllValidFields();
        $input->setTitle('edge');
        $input->setId((string) $product->getId());
        $productOldTitle = $product->getTitle();
        $productUpdated = $this->useCase->update($input);

        self::assertNotEquals($productOldTitle, $productUpdated->title);
        self::assertEquals('edge', $productUpdated->title);
    }

    /** @test  */
    public function shouldUpdateProductPrice(): void
    {
        $newPrice = 12.2;
        $product = $this->createProduct();
        $input = $this->updateProductInputDataWithAllValidFields();
        $input->setPrice($newPrice);
        $input->setId((string) $product->getId());
        $productOldPrice = $product->getPrice();
        $productUpdated = $this->useCase->update($input);

        self::assertNotEquals($productOldPrice, $productUpdated->price);
        self::assertEquals($newPrice, $productUpdated->price);
    }
}
