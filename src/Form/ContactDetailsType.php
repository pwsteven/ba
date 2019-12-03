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
            ->add('houseNameNumber', TextType::class, [
                'label' => 'House Name/Number',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('streetAddress', TextType::class, [
                'label' => 'Street Address',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('streetAddress2', TextType::class, [
                'label' => 'Street Address Line 2',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('townCity', TextType::class, [
                'label' => 'Town/City',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('county', TextType::class, [
                'label' => 'County',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Postcode',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('emailAddress', EmailType::class, [
                'label' => ' 7. Please provide your email address',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('mobileTelephoneNumber', TextType::class, [
                'label' => ' 8. Please provide your mobile/telephone number',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
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
