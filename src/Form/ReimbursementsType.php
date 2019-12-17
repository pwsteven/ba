<?php

namespace App\Form;

use App\Entity\Reimbursements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReimbursementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('financialLossSuffered')
            ->add('provider')
            ->add('amountReimbursed')
            ->add('reimbursementFilesPath')
            ->add('complete')
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reimbursements::class,
        ]);
    }
}
