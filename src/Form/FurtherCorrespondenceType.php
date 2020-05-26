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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FurtherCorrespondence::class,
        ]);
    }
}
