<?php

namespace App\Application\Product\Create;

use App\Api\Form\ProductForm;
use App\Application\Common\FormFactory;
use App\Application\Common\FormValidate;
use Symfony\Component\HttpFoundation\Request;

class CreateProductInputDataFactory
{
    public static function make(Request $request): CreateProductInputData
    {
        $jsonContent = $request->request->all();
        $input = CreateProductInputData::makeEmpty();
        $form = FormFactory::create(
            data: $jsonContent,
            className: ProductForm::class,
            entity: $input
        );
        FormValidate::validate($form);
        return $input;
    }
}
