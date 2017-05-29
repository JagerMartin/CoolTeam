<?php

namespace AppBundle\Form;

use SC\DatetimepickerBundle\Form\Type\DatetimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationInitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datetime', DatetimeType::class, array(
                'label' => 'Date et heure',
                'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy - hh:ii',
                    'weekStart' => 0,
                    'autoclose' => true,
                    'startView' => 'month',
                    'minView' => 'hour',
                    'maxView' => 'decade',
                    'todayBtn' => true,
                    'todayHighlight' => true,
                    'keyboardNavigation' => true,
                    'language' => 'fr',
                    'forceParse' => true,
                    'minuteStep' => 5,
                    'pickerReferer ' => 'default',
                    'pickerPosition' => 'bottom-right',
                    'viewSelect' => 'hour',
                    'showMeridian' => false
                )
            ))
            ->add('sex', ChoiceType::class, array(
                'label' => 'Sexe',
                'choices' => array(
                    'Mâle' => 'male',
                    'Femelle' => 'femelle',
                    'Inconnu' => 'inconnu'
                ), 'expanded' => true, 'multiple' => false
            ))
            ->add('observation', TextareaType::class)
            ->add('latitude', NumberType::class)
            ->add('longitude', NumberType::class)
            ->add('department', TextType::class)
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider',
                'attr' => array(
                    'class' => 'btn-default btn btn-primary pull-right'
                )))
            ->add('pictures', CollectionType::class, array(
                    'entry_type' => PictureType::class)
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }
}