<?php

namespace App\Api\Form;

use App\Application\User\CreateUserInputData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name')
            ->add('email')
            ->add('password')
            ->add('role');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateUserInputData::class,
            'csrf_protection' => false,
        ]);
    }
}
