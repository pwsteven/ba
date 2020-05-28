<?php

namespace App\Form;

use App\Entity\Reimbursements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class ReimbursementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('financialLossSuffered', ChoiceType::class, [
                'label' => ' 22. Have you ever been reimbursed for the financial loss you suffered?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',

                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('provider', TextType::class, [
                'label' => 'Please state who provided the reimbursement:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('amountReimbursed', MoneyType::class, [
                'label' => 'Please enter the amount you were reimbursed:',
                'required' => false,
                'currency' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reimbursements::class,
        ]);
    }
}
