<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', null , array(
                'label_attr' => array(
                    "class" => "col-form-label"
                ),
                'attr' => array(
                    "class" => 'form-control'
                )
            ))
            ->add('firstname', null , array(
                'label_attr' => array(
                    "class" => "col-form-label"
                ),
                'attr' => array(
                    "class" => 'form-control'
                )
            ))
            ->add('birthdate', DateType::class, array(
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'label_attr' => array(
                    "class" => "col-form-label"
                ),
                'attr' => array(
                    "class" => 'form-control'
                )
            ))
            ->add('password', PasswordType::class , array(
                'label_attr' => array(
                    "class" => "col-form-label"
                ),
                'attr' => array(
                    "class" => 'form-control'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['update']
        ]);
    }
}
