<?php

namespace App\Form;

use App\Entity\Complaints;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComplaintsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lodgedComplaint', ChoiceType::class, [
                'label' => ' 15. Have you lodged a formal complaint through British Airways official procedures?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('complaintMade', DateType::class, [
                'label' => 'When was the complaint made?',
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y'), 2018),
                'placeholder' => [
                    'day' => 'Day', 'month' => 'Month', 'year' => 'Year'
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('receivedResponse', ChoiceType::class, [
                'label' => 'Have you received a response to your complaint?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'Yes',
                    'No' => 'No',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('satisfiedResponse', ChoiceType::class, [
                'label' => 'Are you satisfied with the response to your complaint?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'Yes',
                    'No' => 'No',
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('reasonUnsatisfied', TextareaType::class, [
                'label' => 'If you are unsatisfied with your complaint, please explain your reasons for this:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('contactedIOC', ChoiceType::class, [
                'label' => ' 16. Have you contacted the Information Commissioner\'s Office about the British Airways data breach?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('contactedActionFraud', ChoiceType::class, [
                'label' => ' 17. Have you contacted Action Fraud about the British Airways data breach?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('accessedGetSafeOnline', ChoiceType::class, [
                'label' => ' 18. Have you accessed "Get Safe Online" following the British Airways data breach?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Complaints::class,
        ]);
    }
}
