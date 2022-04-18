<?php

namespace App\Application\Product\Update;

use App\Api\Form\ProductUpdateForm;
use App\Application\Common\FormFactory;
use App\Application\Common\FormValidate;
use Symfony\Component\HttpFoundation\Request;

class UpdateProductInputDataFactory
{
    public static function make(Request $request): UpdateProductInputData
    {
        $jsonContent = $request->request->all();
        $input = UpdateProductInputData::makeEmpty();
        $form = FormFactory::create(
            data: $jsonContent,
            className: ProductUpdateForm::class,
            entity: $input
        );
        FormValidate::validate($form);
        return $input;
    }
}