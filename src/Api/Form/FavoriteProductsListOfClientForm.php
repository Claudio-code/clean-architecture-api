<?php

namespace App\Api\Form;

use App\Application\FavoriteProductsListOfClient\Add\FavoriteProductsListOfClientInputData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FavoriteProductsListOfClientForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientEmail')
            ->add('productId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FavoriteProductsListOfClientInputData::class,
            'csrf_protection' => false,
        ]);
    }
}
