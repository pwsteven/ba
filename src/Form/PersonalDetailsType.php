<?php

namespace App\Form;

use App\Entity\PersonalDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PersonalDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => ' 1. What is your First Name? (Please provide your legal first name, not a nickname or shortened name.)',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('middleName', TextType::class, [
                'label' => '2. What is your Middle Name? (Please provide your legal middle name, if you have one.)',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ],
                'required' => false,
            ])
            ->add('surname', TextType::class, [
                'label' => ' 3. What is your Surname?',
                'attr' => [
                    'class' => 'form-control form-control-default form-txt-inverse',
                ]
            ])
            ->add('dateOfBirth', BirthdayType::class, [
                'format' => 'dd-MM-yyyy',
                'placeholder' => [
                    'day' => 'Day', 'month' => 'Month', 'year' => 'Year'
                ],
                'widget' => 'choice',
                'label' => ' 4. What is your full date of birth?'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonalDetails::class,
        ]);
    }
}
