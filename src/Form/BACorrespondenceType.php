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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
                ],
            ])
            ->add('breachOneNotificationFile', FileType::class, [
                'mapped' => false,
                'label' => 'Please upload a copy of the notification:',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Maximum file size is 2 Megabytes',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'text/plain',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Allows formats: PDF; DOC; DOCX; TXT; JPEG; JPG; PNG'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
                ],
            ])
            ->add('breachOneEmailAddressUsed', TextType::class, [
                'label' => 'Email address used for the booking related to the claim:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('breachOneBookingReference', TextType::class, [
                'label' => 'Booking Reference:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('breachOneBookingPlatform', ChoiceType::class, [
                'label' => 'The booking was made on British Airways:',
                'choices' => [
                    'Please Select' => '',
                    'Website' => 'Website',
                    'Mobile Application' => 'Mobile Application',
                    'Other' => 'Other',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
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
                    'Other' => 'Other',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('breachOneBookingConfirmationFile', FileType::class, [
                'label' => 'Please upload a copy of the booking notification:',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Maximum file size is 2 Megabytes',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'text/plain',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Allows formats: PDF; DOC; DOCX; TXT; JPEG; JPG; PNG'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
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
