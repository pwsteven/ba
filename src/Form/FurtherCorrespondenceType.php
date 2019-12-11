<?php

namespace App\Form;

use App\Entity\FurtherCorrespondence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FurtherCorrespondenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personalInformationBreachedFilePath')
            ->add('receivedAnyOtherBACorrespondence')
            ->add('allCorrespondenceSentReceivedFilePath')
            ->add('complete')
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FurtherCorrespondence::class,
        ]);
    }
}
