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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/rechercher/autocompletion", name="app_search_autocomplete")
     * @Method("GET")
     */
    public function autocompletionAjaxAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }
        // Récupération de la valeur du champ de texte
        $val = $request->query->get('val');

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref');

        $lbNameMatching = $repository->getSpeciesWithLbNameLike($val);
        $vernNameMatching = $repository->getSpeciesWithVernNameLike($val);

        $list = array();
        foreach ($lbNameMatching as $taxref){
            $list[] = $taxref->getLbName();
        }
        foreach ($vernNameMatching as $taxref) {
            $list[] = $taxref->getVernacularName();
        }
        $list = array_unique($list);
        sort($list);

        return new JsonResponse(
            array(
                'message' => 'Success!',
                'list' => json_encode($list)
            ), 200);

    }

}