<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Entity\Picture;
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
        $observation = new Observation();
        $observation->setDatetime(new \DateTime());
        $observation->setTaxref($this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref')->findOneBy(array('cdName' => $cdName)));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($observation);

        // faire un service
        $observation->addPicture(new Picture());
        $observation->addPicture(new Picture());
        $observation->addPicture(new Picture());

        $form = $this->createForm(ObservationInitType::class, $observation, array(
            'attr' => array('id' => 'observation_form')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // service suppression filename
            $pictures = $observation->getPictures();
            foreach ($pictures as $picture) {
                if(!$picture->getImageFile()) {
                    $observation->removePicture($picture);
                }
            }

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
     * @Route("/observation/update", name="app_observation_update")
     *
     */
    public function observationUpdateAction()
    {
        return $this->render('::base.html.twig');
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
        $observation->setTaxref($this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref')->findOneBy(array('cdName' => $observation->getTaxref()->getCdName())));

        $observation->setPictures($this->getDoctrine()->getManager()->getRepository('AppBundle:Picture')->findBy(array('observation' => $observation)));

        return $this->render(':Observation:view.html.twig', array(
            'observation' => $observation
        ));
    }
}