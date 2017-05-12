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
        return $this->render('default/homepage.html.twig');
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
