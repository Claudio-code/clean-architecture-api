<?php

namespace App\Api\Form;

use App\Application\ProductReview\ProductReviewInputData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductReviewForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientEmail')
            ->add('productId')
            ->add('review')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductReviewInputData::class,
            'csrf_protection' => false,
        ]);
    }
}