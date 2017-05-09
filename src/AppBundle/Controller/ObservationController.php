<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Form\Type\ObservationInitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/add", name="app_observation_add")
     *
     */
    public function observationAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $observation = new Observation();
        $em->persist($observation);

        $form = $this->createForm(ObservationInitType::class, $observation)
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider'
            ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_observation', array(
                'id' => $observation->getId()
            ));
        }

        return $this->render(':Observation:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/observation/update", name="app_observation_update") // AJOUT ID
     *
     */
    public function observationUpdateAction()
    {
        return $this->render('::base.html.twig');
    }

    /**
     * @Route("/observation/delete", name="app_observation_delete") // AJOUT ID
     *
     */
    public function observationDeleteAction()
    {
        return $this->render('::base.html.twig');
    }

    /**
     * @Route("/observation/{id}", name="app_observation") // AJOUT ID
     *
     */
    public function observationAction(Observation $observation)
    {
        return $this->render(':Observation:view.html.twig', array(
            'observation' => $observation
        ));
    }
}