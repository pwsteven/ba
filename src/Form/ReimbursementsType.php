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

class ReimbursementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('financialLossSuffered', ChoiceType::class, [
                'label' => ' 22. Have you ever been reimbursed for the financial loss you suffered?',
                'choices' => [
                    'Please Select' => '',
                    'No' => 'NO',
                    'Yes' => 'YES',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('provider', TextType::class, [

            ])
            ->add('amountReimbursed', MoneyType::class, [

            ])
            ->add('reimbursementFiles', FileType::class, [
                'mapped' => false,
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
