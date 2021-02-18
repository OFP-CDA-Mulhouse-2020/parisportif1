<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Timezone;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //TODO Add agree to terms checkbox
        //TODO Style with class
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'label_attr' => ["class" => "col-form-label"],
                    'attr' => ["class" => 'form-control'],
                    'constraints' => [
                        new NotBlank(['normalizer' => "trim"]),
                        new Email(['mode' => "strict"])
                    ]
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => "The two password must be the same.",
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'mapped' => false,
                    'first_options' => [
                        'label' => 'Password',
                        'label_attr' => ["class" => "col-form-label"],
                        'attr' => ["class" => 'form-control'],

                    ],
                    'second_options' => [
                        'label' => 'Repeat password',
                        'label_attr' => ["class" => "col-form-label"],
                        'attr' => ["class" => 'form-control']
                    ],
                    'constraints' => [
                        new NotBlank(['normalizer' => "trim"]),
                        new Length(['min' => 8, 'max' => 4096]),
                        new NotCompromisedPassword()
                    ]
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ["class" => "col-form-label"],
                    'attr' => ["class" => 'form-control'],
                    'constraints' => [
                        new NotBlank(['normalizer' => "trim"])
                    ]
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ["class" => "col-form-label"],
                    'attr' => ["class" => 'form-control'],
                    'constraints' => [
                        new NotBlank(['normalizer' => "trim"])
                    ]
                ]
            )
            ->add(
                'birthdate',
                DateType::class,
                [
                    'required' => true,
                    'input' => 'datetime_immutable',
                    'widget' => 'single_text',
                    'label_attr' => ["class" => "col-form-label"],
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank(['normalizer' => "trim"]),
                        new LessThanOrEqual(['value' => "-18 years"])
                    ]
                ]
            )
            ->add(
                'countryCode',
                CountryType::class,
                [
                    'required' => true,
                    'label_attr' => ["class" => "col-form-label"],
                    'attr' => ["class" => 'form-control'],
                    'constraints' => [
                        new NotBlank(['normalizer' => "trim"]),
                        new Country()
                    ]
                ]
            )
            ->add(
                'timeZone',
                TimezoneType::class,
                [
                    'required' => true,
                    'label_attr' => ["class" => "col-form-label"],
                    'attr' => ["class" => 'form-control'],
                    'constraints' => [
                        new NotBlank(['normalizer' => "trim"]),
                        new Timezone()
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
                'validation_groups' => ['registerUser', 'Default']
            ]
        );

        $resolver->addAllowedTypes('validation_groups', ["null", "array"]);
    }
}
