<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Form\ObservationInitType;
use AppBundle\Form\ObservationValidType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Vous devez être inscrit pour déposer une observation.');
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $observation = new Observation();
        $em->persist($observation);
        $observation->setDatetime(new \DateTime());
        $observation->setTaxref($this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref')->findOneBy(array('cdName' => $cdName)));
        if ($observation->getTaxref() === null) {
            $this->addFlash('danger', "Veuillez revoir votre recherche.");
            return $this->redirectToRoute('app_search');
        }
        $observation->setUser($user);
        $this->get('app.pictures')->generate($observation);
        $form = $this->createForm(ObservationInitType::class, $observation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($user->hasRole('ROLE_NATURALIST') || $user->hasRole('ROLE_SUPER_ADMIN')) { // Validation immédiate si super_admin ou naturalisete
                    $observation->setStatus(Observation::VALIDATE);
                } else {
                    $observation->setStatus(Observation::PENDING);
                }
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
        if ($observation->getStatus() == Observation::VALIDATE) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas modifier une observation validée.');
        }
        if ($this->getUser()->getId() != $observation->getUser()->getId()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas modifier l\'annonce d\'un autre utilisateur.');
        }

        $this->get('app.pictures')->generate($observation);
        $form = $this->createForm(ObservationInitType::class, $observation);

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
     * @Route("/observation/{id}", name="app_observation")
     *
     */
    public function observationAction(Observation $observation)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Vous devez être inscrit pour voir une observation.');
        }

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

    /**
     * @Route("/observation/validate/{id}", name="app_observation_validate")
     *
     */
    public function observationValidateAction(Request $request, Observation $observation)
    {
        // si on est super admin ou naturaliste on peut accéder à cette page
        // mais si on est naturaliste et que l'observation est validé alors on ne peut pas
        // donc un super admin peut modifier la validation d'une observation

        $map = $this->get('app.create_map_with_observations')->createMapWithObservations(array($observation));

        $form = $this->createForm(ObservationValidType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $observation->setValidator($this->getUser());
                if ($form->get('tocorrect')->isClicked()) {
                    $observation->setStatus(Observation::TOCORRECT);
                    $this->addFlash('info', "L'observation a été mise en correction.");
                } else {
                    $observation->setStatus(Observation::VALIDATE);
                    $this->addFlash('info', "L'observation a été validée.");
                }
                $em->flush();
                return $this->redirectToRoute('app_observations_new');
            } else {
                $this->addFlash('error', "Les informations sont incorrectes.");
            }
        }
        return $this->render(':Observation:validate.html.twig', array(
            'form' => $form->createView(),
            'observation' => $observation,
            'map' => $map
        ));
    }

    /**
     * @Route("/observation/delete/{id}", name="app_observation_delete")
     *
     */
    public function observationDeleteAction(Observation $observation)
    {
        // seul un naturaliste ou un super-admin peut supprimer une observation
        $em = $this->getDoctrine()->getManager();
        $em->remove($observation);
        $em->flush();
        $this->addFlash('info', "L'observation a été supprimée.");
        return $this->redirectToRoute('app_observations_new');
    }

    /**
     * @Route("/observations/new/{page}", name="app_observations_new", defaults={"page" = 1})
     *
     */
    public function observationsNewAction(Request $request, $page)
    {
        // Seul le naturaliste et le super-admin peuvent voir cette page
        $observations = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Observation')->findBy(
                array('status' => Observation::PENDING),
                array('datetime' => 'asc')
            );

        $paginator = $this->get('knp_paginator');
        $observations = $paginator->paginate(
            $observations,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('admin_entry_per_page'))
        );

        return $this->render(':Observations:new.html.twig', array(
            'observations' => $observations
        ));
    }

    /**
     * @Route("/observations/pending/{page}", name="app_observations_pending", defaults={"page" = 1})
     *
     */
    public function observationsPendingAction(Request $request, $page)
    {
        // Seul le l'observateur, le naturaliste et le super-admin peuvent voir cette page
        $observations = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Observation')
            ->findBy(
                array('user' => $this->getUser(), 'status' => Observation::PENDING),
                array('datetime' => 'asc')
            );

        $paginator = $this->get('knp_paginator');
        $observations = $paginator->paginate(
            $observations,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('admin_entry_per_page'))
        );

        $observationsToCorrect = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation')->findBy(array('user' => $this->getUser(), 'status' => Observation::TOCORRECT));

        return $this->render(':Observations:pending.html.twig', array(
            'observations' => $observations,
            'observationsToCorrect' => $observationsToCorrect
        ));
    }

    /**
     * @Route("/observations/validate/{page}", name="app_observations_validate", defaults={"page" = 1})
     *
     */
    public function observationsValidateAction(Request $request, $page)
    {
        // Seul le naturaliste et le super-admin peuvent voir cette page
        $observations = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Observation')
            ->findBy(
                array('validator' => $this->getUser(), 'status' => Observation::VALIDATE),
                array('datetime' => 'asc')
            );
        $paginator = $this->get('knp_paginator');
        $observations = $paginator->paginate(
            $observations,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('admin_entry_per_page'))
        );

        return $this->render(':Observations:validate.html.twig', array(
            'observations' => $observations
        ));
    }

    /**
     * @Route("/observations/gestion/{page}", name="app_observations_gestion", defaults={"page" = 1})
     *
     */
    public function observationsGestionAction(Request $request, $page)
    {
        // Seul le super-admin peuvent voir cette page
        $observations = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Observation')
            ->findBy(
                array('status' => Observation::VALIDATE),
                array('datetime' => 'asc')
            );

        $paginator = $this->get('knp_paginator');
        $observations = $paginator->paginate(
            $observations,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('admin_entry_per_page'))
        );

        return $this->render(':Observations:gestion.html.twig', array(
            'observations' => $observations
        ));
    }

    /**
     * @Route("/observation/invalidate/{id}", name="app_observation_invalidate")
     *
     */
    public function observationInvalidateAction(Observation $observation)
    {
        // seul super-admin peut invalider une observation
        $em = $this->getDoctrine()->getManager();
        $observation->setStatus(Observation::TOCORRECT);
        $observation->setValidator($this->getUser());
        $em->flush();
        $this->addFlash('info', "L'observation a été mise à corriger.");
        return $this->redirectToRoute('app_observations_gestion');
    }

    // A LAISSER EN DERNIER
    /**
     * @Route("/observations/{page}", name="app_observations", defaults={"page" = 1})
     *
     */
    public function observationsAction(Request $request, $page)
    {
        // Seul l'observateur, le naturaliste et le super-admin peuvent voir cette page
        $observations = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Observation')
            ->findBy(
                array('user' => $this->getUser(), 'status' => Observation::VALIDATE),
                array('datetime' => 'desc')
            );

        $paginator = $this->get('knp_paginator');
        $observations = $paginator->paginate(
            $observations,
            $request->query->getInt('page', $page),
            $request->query->getInt('limit', $this->getParameter('admin_entry_per_page'))
        );

        return $this->render(':Observations:view.html.twig', array(
            'observations' => $observations
        ));
    }
}