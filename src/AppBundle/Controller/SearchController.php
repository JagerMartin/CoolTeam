<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 13/05/2017
 * Time: 20:16
 */

namespace AppBundle\Controller;


use AppBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{
    /**
     * @Route("/rechercher", name="app_search")
     *
     */
    public function searchAction()
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('search/search.html.twig', array(
            'form' => $form->createView()
        ));
    }

}