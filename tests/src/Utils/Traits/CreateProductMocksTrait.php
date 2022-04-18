<?php

namespace App\Tests\src\Utils\Traits;

use App\Application\Product\Create\CreateProductInputData;
use App\Infrastructure\Persistence\Entity\Product;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

trait CreateProductMocksTrait
{
    private function createProductInputDataWithAllValidFields(): CreateProductInputData
    {
        $uploadedFile = \Mockery::mock(UploadedFile::class);
        $uploadedFile->shouldReceive('guessExtension')
            ->once()
            ->andReturn('png');
        $uploadedFile->shouldReceive('getClientOriginalName')
            ->once()
            ->andReturn('e1f2f313.png');
        $uploadedFile->shouldReceive('move')
            ->once()
            ->andReturn(\Mockery::mock(File::class));


        $input = CreateProductInputData::makeEmpty();
        $input->setPrice(121.21);
        $input->setBrand('ford');
        $input->setImage($uploadedFile);
        $input->setTitle('carro');
        return $input;
    }

    private function createProductInputDataWithInvalidTitle(): CreateProductInputData
    {
        $input = $this->createProductInputDataWithAllValidFields();
        $input->setTitle('');
        return $input;
    }

    private function createProductInputDataWithInvalidPrice(): CreateProductInputData
    {
        $input = $this->createProductInputDataWithAllValidFields();
        $input->setPrice(0);
        return $input;
    }

    private function createProductPersistenceWithValidFields(): Product
    {
        $product = new Product();
        $product->setId(Uuid::v4());
        $product->setTitle('carro');
        $product->setImage('image.png');
        $product->setBrand('ford');
        $product->setPrice(122.21);
        return $product;
    }
}