<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        // Récupération des 5 dernières observations
        $lastObservations = $em->getRepository('AppBundle:Observation')->findBy(array(), array('datetime' => 'DESC'), 5, 0);

        // Génération de la carte pour ces observations
        $map = $this->get('app.create_map_with_observations')->createMapWithObservations($lastObservations);
        $map->setHtmlId('map_home_canvas');
        $map->setStylesheetOptions(array('width' => '100%', 'height' => '100%'));
        $map->setMapOption('zoom', 1);

        return $this->render('default/homepage.html.twig', array(
            'map' => $map,
            'lastObservations' => $lastObservations
        ));
    }

    /**
     * @Route("/contact", name="contact")
     *
     */
    public function contactAction()
    {
        return $this->render('MainController/contact.html.twig');
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
}
