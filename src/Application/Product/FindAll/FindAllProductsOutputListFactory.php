<?php

namespace App\Application\Product\FindAll;


use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class FindAllProductsOutputListFactory
{
    public static function make(SlidingPagination $products): FindAllProductsOutputData
    {
        $findAllProductsOutputData = new FindAllProductsOutputData(
            $products->getPage(),
            $products->getItemNumberPerPage()
        );
        foreach ($products->getItems() as $product) {
            $findAllProductsOutputData->addProduct($product);
        }
        return $findAllProductsOutputData;
    }
}