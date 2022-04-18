<?php

namespace App\Application\Common;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;

class FormFactory
{
    public static function create(array $data, string $className, object &$entity): FormInterface
    {
        $formFactory = Forms::createFormFactory();
        $formEntity = $formFactory->create($className, $entity);
        $formEntity->submit($data);
        return $formEntity;
    }
}