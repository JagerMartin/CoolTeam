<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    /**
     * @Route("/observ", name="app_observ")
     *
     */
    public function observAction()
    {
        return $this->render('AppBundle:MainController:index.html.twig');
    }
}