<?php

namespace App\Tests\src\Utils\Traits;

use App\Application\Product\Update\UpdateProductInputData;

trait UpdateProductMocksTrait
{
    private function updateProductInputDataWithAllValidFields(): UpdateProductInputData
    {
        $input = UpdateProductInputData::makeEmpty();
        $input->setPrice(121.21);
        $input->setBrand('ford');
        $input->setTitle('carro');
        return $input;
    }

    private function updateProductInputDataWithInvalidTitle(): UpdateProductInputData
    {
        $input = $this->updateProductInputDataWithAllValidFields();
        $input->setTitle('');
        return $input;
    }

    private function updateProductInputDataWithInvalidPrice(): UpdateProductInputData
    {
        $input = $this->updateProductInputDataWithAllValidFields();
        $input->setPrice(0);
        return $input;
    }
}