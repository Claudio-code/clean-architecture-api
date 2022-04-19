<?php

namespace App\Application\ProductReview;

use App\Api\Form\ProductReviewForm;
use App\Application\Common\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class ProductReviewFactory
{
    public static function make(Request $request): ProductReviewInputData
    {
        $jsonContent = $request->request->all();
        $input = ProductReviewInputData::makeEmpty();
        FormFactory::create(
            data: $jsonContent,
            className: ProductReviewForm::class,
            entity: $input
        );
        return $input;
    }
}
