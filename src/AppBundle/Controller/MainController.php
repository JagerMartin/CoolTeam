<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Newsletter;
use AppBundle\Form\ContactType;
use AppBundle\Form\NewsletterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lastObservations = $em->getRepository('AppBundle:Observation')->findBy(array(), array('datetime' => 'DESC'), 5, 0);

        // Génération de la carte pour ces observations
        $map = $this->get('app.create_map_with_observations')->createMapWithObservations($lastObservations);
        $map->setHtmlId('map_home_canvas');
        $map->setStylesheetOptions(array('width' => '100%', 'height' => '100%'));

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');
        $observerCount = $repository->getUsersCountByRole("ROLE_OBSERVER");
        $naturalistCount = $repository->getUsersCountByRole("ROLE_NATURALIST");
        return $this->render('default/homepage.html.twig', array(
            'map' => $map,
            'lastObservations' => $lastObservations,
            'observerCount' => $observerCount,
            'naturalistCount' => $naturalistCount
        ));

    }

    /**
     * @Route("/contact", name="contact")
     *
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->get('app.send_contact_mail')->sendContactMail($contact);
            $this->addFlash('info', 'Votre message a bien été envoyé, nous répondrons dès que possible à votre demande.');
            return $this->redirectToRoute('contact');
        }

        return $this->render('MainController/contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modemploi", name="modeemploi")
     *
     */
    public function modeemploiAction()
    {
        return $this->render('MainController/modemploi.html.twig');
    }

    /**
     * @Route("/apprendreObserver", name="apprendreObserver")
     *
     */
    public function apprendreObserverAction()
    {
        return $this->render('MainController/apprendreObserver.html.twig');
    }

    /**
     * @Route("/association", name="association")
     *
     */
    public function associationAction()
    {
        return $this->render('MainController/association.html.twig');
    }

    /**
     * @Route("/popupcharte", name="popupcharte")
     *
     */
    public function popupCharteAction()
    {
        return $this->render('MainController/popupcharte.html.twig');
    }

    /**
     * @Route("/mentionslegales", name="mentionslegales")
     *
     */
    public function mentionsLegalesAction()
    {
        return $this->render('MainController/mentionslegales.html.twig');
    }

    /**
     * @Route("/newsletter", name="newsletter")
     */
    public function newsletterAction()
    {
        // Création du formulaire de la newsletter
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter, array(
            'action' => $this->generateUrl('ajax_newsletter')
        ));
        return $this->render('_newsletter_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/ajax/newsletter", name="ajax_newsletter")
     * @Method("POST")
     */
    public function ajaxNewsletterAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isValid()){
            $newsletterRepository = $em->getRepository('AppBundle:Newsletter');
            $isNewsletter = $newsletterRepository->findOneBy(array('email' => $newsletter->getEmail()));
            if(!$isNewsletter){ // Enregistrement de l'email indiqué si il n'est pas déjà enregistré
                $em->persist($newsletter);
                $em->flush();
            }
            $title = "Inscription à la newsletter réussie";
            $body = "Vous êtes maintenant inscrit à la newsletter !";
        } else { // Si le formulaire n'est pas valide
            $title = "Echec de l'inscription à la newsletter";
            $body = "L'adresse email indiquée n'est pas valide.";
        }
        return new JsonResponse(array('title' => $title, 'body' =>$body), 200);
    }
}
