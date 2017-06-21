<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isCharterAccepted', CheckboxType::class, array(
                'label' => 'J\'accepte la Charte du Respect et de la protection des oiseaux.(Obligatoire pour pouvoir valider)',
                'required' => true,
                'data' => false,
                'constraints' => array(
                    new IsTrue(array(
                        'message' => 'Vous devez accepter la Charte du Respect et de la protection des oiseaux'
                    ))
                )
            ))
            ->add('isNewsletterSubscriber', CheckboxType::class, array(
                'label' => 'Recevoir les actualités de l\'association',
                'required' => false,
                'data' => false
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}