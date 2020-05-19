<?php

namespace App\Form;

use App\Entity\ContactDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('streetAddress', TextType::class, [
                'label' => 'Street Address',
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
            ->add('streetAddress2', TextType::class, [
                'label' => 'Street Address Line 2',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
            ->add('streetAddress3', TextType::class, [
                'label' => 'Street Address Line 3',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
            ->add('townCity', TextType::class, [
                'label' => 'Town/City',
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
            ->add('county', TextType::class, [
                'label' => 'County',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Postcode',
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => ' 7. Please provide your Email Address',
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
            ->add('mobileTelephoneNumber', TextType::class, [
                'label' => ' 8. Please provide your Mobile/Telephone Number',
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactDetails::class,
        ]);
    }
}
