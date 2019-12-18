<?php

namespace App\Form;

use App\Entity\CreditMonitor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditMonitorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('monitorCredit', ChoiceType::class, [
                'label' => ' 23. Have you signed up for Experian ProtectMyID or accepted any other offer sent to you by British Airways to monitor your credit?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('monitorCreditFilePath', FileType::class, [

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreditMonitor::class,
        ]);
    }
}
