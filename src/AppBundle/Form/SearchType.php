<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 14/05/2017
 * Time: 03:43
 */

namespace AppBundle\Form;


use AppBundle\Repository\ObservationRepository;
use AppBundle\Repository\TaxrefRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom de l\'espèce :'
            ))
            ->add('family', EntityType::class, array(
                'class' => 'AppBundle\Entity\Taxref',
                'choice_label' => 'family',
                'placeholder' => 'Choisir',
                'label' => 'Famille :',
                'query_builder' => function(TaxrefRepository $repository){
                    return $repository->getFamilyList();
                },
                'choice_value' => 'family'
            ))
            ->add('department', EntityType::class, array(
                'class' => 'AppBundle\Entity\Observation',
                'choice_label' => 'department',
                'placeholder' => 'Choisir',
                'label' => 'Département :',
                'query_builder' => function(ObservationRepository $repository){
                    return $repository->getDepartmentList();
                },
                'choice_value' => 'department'
            ));
    }
}