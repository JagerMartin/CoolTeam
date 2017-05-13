<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Entity\Taxref;
use AppBundle\Form\ObservationInitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/add/{cdName}", name="app_observation_add", defaults={"cdName" = 3762})
     *
     */
    public function observationAddAction(Request $request, $cdName)
    {
        $observation = new Observation();
        $observation->setDatetime(new \DateTime());
        
        $observation->setTaxref($this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref')->findOneBy(array('cdName' => $cdName)));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($observation);

        dump($observation);

        $form = $this->createForm(ObservationInitType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('info', "Observation ajoutée.");
            return $this->redirectToRoute('app_observation', array(
                'id' => $observation->getId()
            ));
        }

        return $this->render(':Observation:add.html.twig', array(
            'form' => $form->createView(),
            'observation' => $observation
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