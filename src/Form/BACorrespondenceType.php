<?php

namespace App\Form;

use App\Entity\BACorrespondence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BACorrespondenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receivedConfirmationEmail', ChoiceType::class, [
                'label' => ' 9. Have you received an email from BA confirming that your personal information has been compromised?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOneNotification', ChoiceType::class, [
                'label' => ' 10. Did you receive notification that you had been affected by the data event occurring between 21 April 2018 – 28 July 2018?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOneDateReceived', DateType::class, [
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y'), 2018),
                'placeholder' => [
                    'day' => 'Day', 'month' => 'Month', 'year' => 'Year'
                ],
                'label' => 'Date Received',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOneNotificationNotAffected', ChoiceType::class, [
                'label' => 'Have you since received notification confirming you were not affected?',
                'choices' => [
                    'Please Select' => '',
                    'YES, not received' => 'YES not received',
                    'NO, received' => 'No received',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOneDateOfBooking', DateType::class, [
                'format' => 'dd-MM-yyyy',
                'years' => range('2018', '2018'),
                'placeholder' => [
                    'day' => 'Day', 'month' => 'Month', 'year' => 'Year'
                ],
                'label' => 'Date of Booking',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOneEmailAddressUsed', TextType::class, [
                'label' => 'Email address used for the booking related to the claim:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOneBookingReference', TextType::class, [
                'label' => 'Booking Reference:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOneBookingPlatform', ChoiceType::class, [
                'label' => 'Platform the British Airways booking was made on:',
                'choices' => [
                    'Please Select' => '',
                    'Website' => 'Website',
                    'Mobile Application' => 'Mobile Application',
                    'Other' => 'Other Platform',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachOnePaymentMethod', ChoiceType::class, [
                'label' => 'The booking was paid for using:',
                'choices' => [
                    'Please Select' => '',
                    'Credit Card' => 'Credit Card',
                    'Debit Card' => 'Debit Card',
                    'Cash' => 'Cash',
                    'Air Miles' => 'Air Miles',
                    'Apple Pay' => 'Apple Pay',
                    'PayPal' => 'PayPal',
                    'Other' => 'Other Payment Method',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoNotification', ChoiceType::class, [
                'label' => ' 11. Did you receive notification that you had been affected by the data event occurring between 10.58pm on 21 August 2018 – 9.45pm on 5 September 2018?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoDateReceived', DateType::class, [
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y'), 2018),
                'placeholder' => [
                    'day' => 'Day', 'month' => 'Month', 'year' => 'Year'
                ],
                'label' => 'Date Received',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoNotificationNotAffected', ChoiceType::class, [
                'label' => 'Have you since received notification confirming you were not affected?',
                'choices' => [
                    'Please Select' => '',
                    'YES, not received' => 'YES not received',
                    'NO, received' => 'No received',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoDateOfBooking', DateType::class, [
                'format' => 'dd-MM-yyyy',
                'years' => range('2018', '2018'),
                'placeholder' => [
                    'day' => 'Day', 'month' => 'Month', 'year' => 'Year'
                ],
                'label' => 'Date of Booking',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoEmailAddressUsed', TextType::class, [
                'label' => 'Email address used for the booking related to the claim:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoBookingReference', TextType::class, [
                'label' => 'Booking Reference:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoBookingPlatform', ChoiceType::class, [
                'label' => 'Platform the British Airways booking was made on:',
                'choices' => [
                    'Please Select' => '',
                    'Website' => 'Website',
                    'Mobile Application' => 'Mobile Application',
                    'Other' => 'Other Platform',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('breachTwoPaymentMethod', ChoiceType::class, [
                'label' => 'The booking was paid for using:',
                'choices' => [
                    'Please Select' => '',
                    'Credit Card' => 'Credit Card',
                    'Debit Card' => 'Debit Card',
                    'Cash' => 'Cash',
                    'Air Miles' => 'Air Miles',
                    'Apple Pay' => 'Apple Pay',
                    'PayPal' => 'PayPal',
                    'Other' => 'Other Payment Method',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BACorrespondence::class,
        ]);
    }
}
