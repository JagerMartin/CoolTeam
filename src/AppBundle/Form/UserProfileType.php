<?php

namespace AppBundle\Form;

use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, array(
                'required' => false,
                'label' => 'Photo de profil :'
            ))
            ->add('organization', TextType::class, array(
                'label' => 'Faites-vous parti d\'une association / entreprise / collectivité locale qui oeuvre pour la nature ?'
            ))
            ->add('observationFrequency', TextType::class, array(
                'label' => 'Votre fréquence d\'observation des oiseaux :'
            ))
            ->add('speciality', TextType::class, array(
                'label' => 'Êtes-vous spécialisé dans une famille d\'oiseaux ?'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Modifier mon email :'
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Modifier mon mot de passe :'
            ))
            ->add('isNewsletterSubscriber', CheckboxType::class, array(
                'label' => 'Recevoir la newsletter',
                'required' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

}
