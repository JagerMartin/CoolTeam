<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationValidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextareaType::class, array(
                'invalid_message' => '500 caractères max.',
                'required' => false
            ))
            ->add('tocorrect', SubmitType::class, array(
                'label' => ' A corriger',
                'attr' => array(
                    'class' => 'btn btn-default btn-warning acorriger'
                )
            ))
            ->add('validate', SubmitType::class, array(
                'label' => ' Valider',
                'attr' => array(
                    'class' => 'btn btn-default btn-success valider'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }
}