<?php

namespace App\Application\FavoriteProductsListOfClient\Add;

use App\Api\Form\FavoriteProductsListOfClientForm;
use App\Application\Common\FormFactory;
use App\Application\Common\FormValidate;
use Symfony\Component\HttpFoundation\Request;

class FavoriteProductsListOfClientInputDataFactory
{
    public static function make(Request $request): FavoriteProductsListOfClientInputData
    {
        $jsonContent = $request->request->all();
        $input = FavoriteProductsListOfClientInputData::makeEmpty();
        $form = FormFactory::create(
            data: $jsonContent,
            className: FavoriteProductsListOfClientForm::class,
            entity: $input
        );
        FormValidate::validate($form);
        return $input;
    }
}
