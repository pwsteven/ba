<?php

namespace App\Form;

use App\Entity\EmotionalDistress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('emotionsExperienced', ChoiceType::class, [
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
                    'None of the above' => 'None',
                    'Other (please specify)' => 'Other',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('emotionsExperiencedComment')
            ->add('emotionalDistressLasted')
            ->add('breachQuestionA')
            ->add('breachQuestionA_example')
            ->add('breachQuestionB')
            ->add('breachQuestionB_example')
            ->add('breachQuestionC')
            ->add('breachQuestionC_example')
            ->add('breachQuestionD')
            ->add('breachQuestionD_example')
            ->add('breachQuestionE')
            ->add('breachQuestionE_example')
            ->add('breachQuestionF')
            ->add('breachQuestionF_example')
            ->add('breachQuestionG')
            ->add('breachQuestionG_example')
            ->add('diagnosedConditions')
            ->add('diagnosedConditionsExample')
            ->add('impactCondition')
            ->add('impactConditionExample')
            ->add('stepsTaken')
            ->add('stepsTakenExample')
            ->add('stepsTakenDetails')
            ->add('stepsTakenFilesPath')
            ->add('adverseConsequences')
            ->add('adverseConsequencesExample')
            ->add('adverseConsequencesDetails')
            ->add('adverseConsequencesFilesPath')
            ->add('additionalInformation')
            ->add('leadTestClaimant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmotionalDistress::class,
        ]);
    }
}
