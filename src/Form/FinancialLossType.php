<?php

namespace App\Form;

use App\Entity\FinancialLoss;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class FinancialLossType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('typeFinancialLoss', ChoiceType::class, [
                'label' => ' 19. Have you incurred any financial loss as a result of the breach, and if so what type of financial loss:',
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'No financial loss suffered' => 'No financial loss suffered',
                    'Bank charges' => 'Bank charges',
                    'Payment for any credit monitoring services' => 'Payment for any credit monitoring services',
                    'Termination or cancellation of transactions' => 'Termination or cancellation of transactions',
                    'Increased rate of finance' => 'Increased rate of finance',
                    'Other (please specify)' => 'Other'
                ],
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ])
            ->add('typeFinancialLossOtherComment', TextareaType::class, [
                'label' => 'Please add more info in the text field below...',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('totalLossAmount', MoneyType::class, [
                'label' => '20. What was the total amount of the financial loss suffered?',
                'currency' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg'
                ]
            ])
            ->add('financialLossFiles', FileType::class, [
                'label' => '21. Please upload all documents evidencing the financial loss suffered:',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
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
                        ]),
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                    'multiple' => 'multiple',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FinancialLoss::class,
        ]);
    }
}
