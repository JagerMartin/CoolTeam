<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Form\ObservationInitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $this->addFlash('danger', "Veuillez revoir votre recherche.");
            return $this->redirectToRoute('app_search');
        }
        $observation->setUser($this->getUser());
        $this->get('app.pictures')->generate($observation);
        $form = $this->createForm(ObservationInitType::class, $observation)
            ->add('submit', SubmitType::class, array(
                'label' => 'Déposer',
                'attr' => array(
                    'class' => 'btn btn-default btn-primary'
                )
            ));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Ajouter une condition quand la sécurité sera faite pour naturaliste et super-admin -> Observation::VALIDATE
                $observation->setStatus(Observation::PENDING);
                $this->get('app.pictures')->deleteEmptyPicture($observation);
                $em->flush();
                $this->addFlash('info', "Merci d'avoir déposé votre observation.");
                return $this->redirectToRoute('app_observation', array(
                    'id' => $observation->getId()
                ));
            } else {
                $this->addFlash('error', "Les informations sont incorrectes.");
            }
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
        // Ajouter une condition si $observation->getStatus == observation::valide
        // redirect to route homepage avec message d'info :
        // Vous ne pouvez pas modifier une observation validée.

        // Ajouter une condition si le user n'est pas le user dépositaire
        // redirect to route homepage avec message d'info :
        // Vous ne pouvez pas modifier l'annonce d'un autre utilisateur.

        $this->get('app.pictures')->generate($observation);
        $form = $this->createForm(ObservationInitType::class, $observation)
            ->add('submit', SubmitType::class, array(
                'label' => 'Déposer',
                'attr' => array(
                    'class' => 'btn btn-default btn-primary'
                )
            ));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $observation->setStatus(Observation::PENDING);
                $this->get('app.pictures')->deleteEmptyPicture($observation);
                $em->flush();
                $this->addFlash('info', "Votre observation a bien été modifiée.");
                return $this->redirectToRoute('app_observation', array(
                    'id' => $observation->getId()
                ));
            } else {
                $this->addFlash('error', "Les informations sont incorrectes.");
            }
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
        // Ajouter la sécurité (une sécurité plus pointue est à mettre sur les coordonnées)
        // Si Naturaliste, Superadmin, Administratif, Observateur, on peut voir l'observation
        $map = $this->get('app.create_map_with_observations')->createMapWithObservations(array($observation));
        return $this->render(':Observation:view.html.twig', array(
            'observation' => $observation,
            'map' => $map
        ));
    }

    /**
     * @Route("/ajax/picture/delete", name="app_ajax_picture_delete")
     * @Method("POST")
     */
    public function ajaxDeletePictureAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $pictureID = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();

        $picture = $em->getRepository('AppBundle:Picture')->find($pictureID);
        if (!$picture) {
            return new JsonResponse(array('message' => 'Cette image n\'existe pas.'), 400);
        }
        $em->remove($picture);
        $em->flush();

        return new JsonResponse(array('message' => 'OK'), 200);
    }
}