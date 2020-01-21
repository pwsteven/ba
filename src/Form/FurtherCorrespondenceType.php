<?php

namespace App\Form;

use App\Entity\FurtherCorrespondence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class FurtherCorrespondenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personalInformationBreachedFile', FileType::class, [
                'label' => '12. Please upload a copy of the email from BA confirming that your personal information has been breached:',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'Maximum file size is 1 Megabytes',
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
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('receivedAnyOtherBACorrespondence', ChoiceType::class, [
                'label' => ' 13. Have you received any other correspondence from BA regarding the breach?',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control form-control-lg',
                ],
            ])
            ->add('allCorrespondenceSentReceivedFile', FileType::class, [
                'label' => '14. Please upload copies of all correspondence sent to and received from BA regarding the claim:',
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
            'data_class' => FurtherCorrespondence::class,
        ]);
    }
}
