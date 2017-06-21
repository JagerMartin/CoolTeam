<?php

namespace AppBundle\Form;

use SC\DatetimepickerBundle\Form\Type\DatetimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                'invalid_message' => 'Date et/ou heure non valide.',
                'placeholder' => 'jj/mm/aaaa hh:mm',
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
                'invalid_message' => 'Champ obligatoire.',
                'choices' => array(
                    'Mâle' => 'male',
                    'Femelle' => 'femelle',
                    'Inconnu' => 'inconnu'
                ), 'expanded' => true, 'multiple' => false
            ))
            ->add('observation', TextareaType::class, array(
                'invalid_message' => 'Champ obligatoire, 500 caractères max.'
            ))
            ->add('latitude', NumberType::class, array(
                'invalid_message' => 'Caractères numériques uniquement',
                'scale' => 10,
                'attr' => array(
                    'onchange' => 'codeLatLng();'
                )
            ))
            ->add('longitude', NumberType::class, array(
                'invalid_message' => 'Caractères numériques uniquement',
                'scale' => 10,
                'attr' => array(
                    'onchange' => 'codeLatLng();'
                )
            ))
            ->add('department', TextType::class, array(
                'invalid_message' => 'Champ obligatoire'
            ))
            ->add('pictures', CollectionType::class, array(
                    'entry_type' => PictureType::class
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }
}