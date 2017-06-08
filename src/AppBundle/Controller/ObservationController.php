<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Form\ObservationInitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    /**
     * @Route("/observation/add/{cdName}", name="app_observation_add")
     *
     */
    public function observationAddAction(Request $request, $cdName)
    {
        $em = $this->getDoctrine()->getManager();
        $observation = new Observation();
        $em->persist($observation);
        $observation->setDatetime(new \DateTime());
        $observation->setTaxref($this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref')->findOneBy(array('cdName' => $cdName)));
        if ($observation->getTaxref() === null) {
            $this->addFlash('danger', "Veuillez revoir votre recherche");
            return $this->redirectToRoute('app_search');
        }
        $observation->setUser($this->getUser());
        $this->get('app.pictures')->generate($observation);
        $form = $this->createForm(ObservationInitType::class, $observation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $observation->setStatus(Observation::PENDING);
            $this->get('app.pictures')->deleteEmptyPicture($observation);
            $em->flush();
            $this->addFlash('info', "Observation ajoutée");
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
     * @Route("/observation/update/{id}", name="app_observation_update")
     *
     */
    public function observationUpdateAction(Request $request, Observation $observation)
    {
        $this->get('app.pictures')->generate($observation);
        $form = $this->createForm(ObservationInitType::class, $observation);
        $form->handleRequest($request);
        //
        dump($observation);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $observation->setStatus(Observation::PENDING);
            $this->get('app.pictures')->deleteEmptyPicture($observation);
            dump($observation);
            $em->flush();
            $this->addFlash('info', "Observation modifiée");
            return $this->redirectToRoute('app_observation', array(
                'id' => $observation->getId()
            ));
        }
        return $this->render(':Observation:update.html.twig', array(
            'form' => $form->createView(),
            'observation' => $observation
        ));
    }

    /**
     * @Route("/observation/delete", name="app_observation_delete")
     *
     */
    public function observationDeleteAction()
    {
        return $this->render('::base.html.twig');
    }

    /**
     * @Route("/observation/{id}", name="app_observation")
     *
     */
    public function observationAction(Observation $observation)
    {
        //$observation->setTaxref($this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref')->findOneBy(array('cdName' => $observation->getTaxref()->getCdName())));

        //$observation->setUser($this->getDoctrine()->getManager()->getRepository('AppBundle:User')->find($observation->getUser()->getId()));

        //$observation->setPictures($this->getDoctrine()->getManager()->getRepository('AppBundle:Picture')->findBy(array('observation' => $observation)));

        dump($observation);

        return $this->render(':Observation:view.html.twig', array(
            'observation' => $observation
        ));
    }
}