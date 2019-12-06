<?php

namespace App\Form;

use App\Entity\BACorrespondence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BACorrespondenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receivedConfirmationEmail')
            ->add('breachOneDate')
            ->add('breachOneNotification')
            ->add('breachOneDateReceived')
            ->add('breachOneNotificationFilePath')
            ->add('breachOneNotificationNotAffected')
            ->add('breachOneDateOfBooking')
            ->add('breachOneEmailAddressUsed')
            ->add('breachOneBookingReference')
            ->add('breachOneBookingPlatform')
            ->add('breachOnePaymentMethod')
            ->add('breachOneBookingConfirmationFilePath')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BACorrespondence::class,
        ]);
    }
}
