<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                null,
                array(
                    'label_attr' => array(
                        "class" => "col-form-label"
                    ),
                    'attr' => array(
                        "class" => 'form-control'
                    )
                )
            )
            ->add(
                'password',
                PasswordType::class,
                array(
                    'label_attr' => array(
                        "class" => "col-form-label"
                    ),
                    'attr' => array(
                        "class" => 'form-control'
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
