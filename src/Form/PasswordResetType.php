<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PasswordResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => [
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ],
                'label' => 'Please enter new password details...',
                'required' => true,
                'first_options'  => [
                    'label' => 'Enter Password',
                    'constraints' => [
                        new NotBlank([
                           'message' => 'Please enter a password',
                        ]),
                        new Length([
                            'min' => 6,
                            'max' => 12,
                            'minMessage' => 'Password must be longer than 6 characters',
                            'maxMessage' => 'Password max is 12 characters',
                        ]),
                        new Regex([
                           'pattern' => '/^[a-z\-0-9]+$/i',
                           'htmlPattern' => '^[a-zA-Z\-0-9]+$',
                            'message' => 'Password must be alphanumeric',
                        ]),
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
