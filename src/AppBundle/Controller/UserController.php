<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/users", name="app_user")
     *
     */
    public function observAction()
    {
        return $this->render('AppBundle:MainController:index.html.twig');
    }
}