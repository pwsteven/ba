<?php

namespace App\Form;

use App\Entity\EmotionalDistress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class EmotionalDistressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personalDetails', ChoiceType::class, [
                'label' => ' 24. Are you concerned that your personal details will be used fraudulently now or at some point in the future? Examples of 
                            fraudulent use of your personal data include: identity fraud; debit/credit card fraud; publication of your details on the 
                            dark web (i.e. a collection of websites that exist on an encrypted network and cannot be found by using traditional search 
                            engines or visited by using traditional search engines or visited by using traditional browsers); ransom/scam emails; or 
                            supply your details to facilitate unwanted advertising/marketing sales.',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'YES',
                    'No' => 'NO',
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('emotionsExperiencedNew', ChoiceType::class, [
                'label' => ' 25. Upon finding out that your personal information had been breached, did you experience any type of emotional distress? 
                            If so, please indicate which of the following emotions you experienced:',
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Anxiety' => 'Anxiety',
                    'Shock' => 'Shock',
                    'Stress' => 'Stress',
                    'Annoyance' => 'Annoyance',
                    'Anger' => 'Anger',
                    'Frustration' => 'Frustration',
                    'Upset' => 'Upset',
                    'Other (please specify)' => 'Other',
                    'None of the above' => 'None',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('emotionsExperiencedComment', TextareaType::class, [
                'label' => 'Please add more info in the text field below...',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('emotionalDistressLasted', ChoiceType::class, [
                'label' => ' 26. Please indicate how long your emotional distress lasted?',
                'choices' => [
                    'Please Select' => '',
                    'N/A' => 'N/A',
                    '1 day or less' => '1 day or less',
                    '2 to 3 days' => '2 to 3 days',
                    'Up to a week' => 'Up to a week',
                    'More than 7 days' => 'More than 7 days',
                    'Ongoing' => 'Ongoing',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('breachQuestionA', ChoiceType::class, [
                'label' => 'Feeling nervous, anxious or on edge?',
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Not at all' => 0,
                    'Several days' => 1,
                    'More than half the days' => 2,
                    'Nearly every day' => 3,
                ],
                'attr' => [
                    'class' => 'select_multiple',
                ],
            ])
            ->add('breachQuestionA_example', TextareaType::class, [
                'label' => 'Provide examples if possible:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('breachQuestionB', ChoiceType::class, [
                'label' => 'Not being able to stop or control worrying?',
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Not at all' => 0,
                    'Several days' => 1,
                    'More than half the days' => 2,
                    'Nearly every day' => 3,
                ],
                'attr' => [
                    'class' => 'select_multiple',
                ],
            ])
            ->add('breachQuestionB_example', TextareaType::class, [
                'label' => 'Provide examples if possible:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('breachQuestionC', ChoiceType::class, [
                'label' => 'Worrying too much about different things?',
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Not at all' => 0,
                    'Several days' => 1,
                    'More than half the days' => 2,
                    'Nearly every day' => 3,
                ],
                'attr' => [
                    'class' => 'select_multiple',
                ],
            ])
            ->add('breachQuestionC_example', TextareaType::class, [
                'label' => 'Provide examples if possible:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('breachQuestionD', ChoiceType::class, [
                'label' => 'Trouble relaxing?',
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Not at all' => 0,
                    'Several days' => 1,
                    'More than half the days' => 2,
                    'Nearly every day' => 3,
                ],
                'attr' => [
                    'class' => 'select_multiple',
                ],
            ])
            ->add('breachQuestionD_example', TextareaType::class, [
                'label' => 'Provide examples if possible:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('breachQuestionE', ChoiceType::class, [
                'label' => 'Being so restless that it is hard to sit still?',
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Not at all' => 0,
                    'Several days' => 1,
                    'More than half the days' => 2,
                    'Nearly every day' => 3,
                ],
                'attr' => [
                    'class' => 'select_multiple',
                ],
            ])
            ->add('breachQuestionE_example', TextareaType::class, [
                'label' => 'Provide examples if possible:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('breachQuestionF', ChoiceType::class, [
                'label' => 'Becoming easily annoyed or irritable?',
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Not at all' => 0,
                    'Several days' => 1,
                    'More than half the days' => 2,
                    'Nearly every day' => 3,
                ],
                'attr' => [
                    'class' => 'select_multiple',
                ],
            ])
            ->add('breachQuestionF_example', TextareaType::class, [
                'label' => 'Provide examples if possible:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('breachQuestionG', ChoiceType::class, [
                'label' => 'Feeling afraid as if something awful might happen?',
                'multiple' => true,
                'expanded' => false,
                'choices' => [
                    'Not at all' => 0,
                    'Several days' => 1,
                    'More than half the days' => 2,
                    'Nearly every day' => 3,
                ],
                'attr' => [
                    'class' => 'select_multiple',
                ],
            ])
            ->add('breachQuestionG_example', TextareaType::class, [
                'label' => 'Provide examples if possible:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('diagnosedConditions', ChoiceType::class, [
                'label' => ' 28. Please indicate whether you have ever been diagnosed as suffering from any of the following conditions:',
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Anxiety' => 'Anxiety',
                    'Depression' => 'Depression',
                    'Both' => 'Both',
                    'None' => 'None',
                    'Other (please specify)' => 'Other',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('diagnosedConditionsExample', TextareaType::class, [
                'label' => 'Please add more info in the text field below...',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('impactCondition', ChoiceType::class, [
                'label' => ' 29. Did finding out that your personal information had been breached have an impact on your condition?',
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Not applicable' => 'Not applicable',
                    'No effect' => 'No effect',
                    'Symptoms were exacerbated' => 'Symptoms were exacerbated',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('impactConditionExample', TextareaType::class, [
                'label' => 'If your symptoms got worse, please provide details:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('stepsTaken', ChoiceType::class, [
                'label' => ' 30. What, if any, steps have you taken as a result of the breach?',
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Contacted your bank(s)' => 'Contacted your bank(s)',
                    'Obtained new bank card(s)' => 'Obtained new bank card(s)',
                    'Changed password(s)' => 'Changed password(s)',
                    'Changed email address(es)' => 'Changed email address(es)',
                    'Contacted BA' => 'Contacted BA',
                    'Signed up to credit monitoring and/or fraud detection service' => 'Signed up to credit monitoring and/or fraud detection service',
                    'None' => 'None',
                    'Other (please specify)' => 'Other',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('stepsTakenExample', TextareaType::class, [
                'label' => 'Please add more info in the text field below...',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('stepsTakenDetails', TextareaType::class, [
                'label' => '31. In the event you have taken any of the steps above, please describe the inconvenience that this has caused you and the time taken to do so:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('stepsTakenFiles', FileType::class, [
                'label' => '32. If you have any documents evidencing the steps you have taken as a result of the breach, please upload these. Please Note: any personal information 
                that you would prefer not to disclose (such as account numbers) can be blanked out before uploading.',
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
                    'class' => 'form-control',
                    'multiple' => 'multiple',
                ],
            ])
            ->add('adverseConsequences', ChoiceType::class, [
                'label' => ' 33. Which, if any of the following adverse consequences have you suffered as a result of the breach?',
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Refused credit' => 'Refused credit',
                    'Difficulties obtaining finance' => 'Difficulties obtaining finance',
                    'Identity theft' => 'Identity theft',
                    'Debit or credit card fraud' => 'Debit or credit card fraud',
                    'Targeted for unwanted advertising/marketing or sales' => 'Targeted for unwanted advertising/marketing or sales',
                    'Personal information published online without your consent' => 'Personal information published online without your consent',
                    'Received ransom/blackmail/scam emails' => 'Received ransom/blackmail/scam emails',
                    'None' => 'None',
                    'Other (please specify)' => 'Other',
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('adverseConsequencesExample', TextareaType::class, [
                'label' => 'Please add more info in the text field below...',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('adverseConsequencesDetails', TextareaType::class, [
                'label' => '34. Please provide details of the adverse consequences regarding the breach:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('adverseConsequencesFiles', FileType::class, [
                'label' => '35. If you have any documents evidencing the consequences of the breach, please upload these. Please Note: any personal information 
                that you would prefer not to disclose (such as account numbers) can be blanked out before uploading.',
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
                    'class' => 'form-control',
                    'multiple' => 'multiple',
                ],
            ])
            ->add('additionalInformation', TextareaType::class, [
                'label' => '36. Please add in the box below any other additional information that may be of relevance. 
                This is an opportunity for you to tell us how the breach has affected you personally:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('leadTestClaimant', ChoiceType::class, [
                'label' => ' 37. Please indicate whether you would be willing to be contacted by a member of the Your Lawyers team regarding participation 
                as a “lead test” claimant or on the Your Lawyers Client Committee. Please note that members of the client committee will be required to 
                engage in regular meetings and contact with Your Lawyers. Please only say yes if you are prepared to sacrifice the time:',
                'choices' => [
                    'Please Select' => '',
                    'Yes' => 'LEAD TEST CASE',
                    'No' => 'STANDARD'
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
            'data_class' => EmotionalDistress::class,
        ]);
    }
}
