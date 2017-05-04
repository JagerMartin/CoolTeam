<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaxrefController extends Controller
{
    /**
     * @Route("/taxref", name="app_taxref")
     *
     */
    public function taxrefAction()
    {
        return $this->render('AppBundle:MainController:index.html.twig');
    }
}