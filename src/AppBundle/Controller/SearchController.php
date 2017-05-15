<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 13/05/2017
 * Time: 20:16
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Taxref;
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

    /**
     * @Route("/rechercher/rafraichir", name="app_search_refresh")
     * @Method("POST")
     */
    public function searchAjaxAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $name = $request->request->get('name');
        $family = $request->request->get('family');
        $department = $request->request->get('department');
        $page = $request->request->get('page');

        if($name != ""){ // RECHERCHE PAR NOM
            $taxrefRepository =  $this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref');

            if($taxrefRepository->findBy(array('lbName' => $name))){ // => RECHERCHE PAR LB_NOM
                $response = $this->searchByLbName($name, $page);

            } elseif($taxrefRepository->findBy(array('vernacularName' => $name))) { // RECHERCHE PAR NOM VERNACULAIRE
                $response = $this->searchByVernName($name, $page);

            } else {
                $response = $this->renderView('search/_error.html.twig', array('message' => 'L\'espèce recherchée n\'existe pas.'));
            }

        } elseif($department != 0){ // RECHERCHE PAR DEPARTEMENT
            $response = $this->searchByDepartment($department, $page);

        } elseif($family != ""){ // RECHERCHE PAR FAMILLE
            $response = $this->searchByFamily($family, $page);

        } else { // SI AUCUN CRITERE DE RECHERCHE => AFFICHE ERREUR
            $response = $this->renderView('search/_error.html.twig', array('message' => 'Vous devez indiquer un critère de recherche.'));
        }

        return new JsonResponse(array('response' => $response), 200);
    }

    // renvoie la réponse quand la recherche a été effectuée par un LB_NAME
    private function searchByLbName($name, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $specie = $em->getRepository('AppBundle:Taxref')->findOneBy(array('lbName' => $name));

        return $this->renderView('search/_specie.html.twig', array(
            'specie' => $specie
        ));
    }

    // renvoie la réponse quand la recherche a été effectuée par un nom vernaculaire
    private function searchByVernName($name, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $speciesList = $em->getRepository('AppBundle:Taxref')->findBy(array('vernacularName' => $name));
        if(count($speciesList) < 2){ // Si le nom vernaculaire n'est associé qu'à une espèce alors afficher la fiche espèce directement
            return $this->searchByLbName($speciesList[0]->getLbName(), $page);
        }

        return $this->renderView('search/_speciesList.html.twig', array(
            'speciesList' => $speciesList
        ));
    }

    // renvoie la réponse quand la recherche a été effectuée par département
    private function searchByDepartment($department, $page)
    {
        return 'department';
    }

    // renvoie la réponse quand la recherche a été effectyée par famille
    private function searchByFamily($family, $page)
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération de la liste des espèces pour la page demandée
        $nbPerPage = Taxref::SEARCH_NUM_ITEMS;
        $speciesList = $em->getRepository('AppBundle:Taxref')->getSpeciesByFamily($family, $page, $nbPerPage);
        $nbPageTotal = ceil(count($speciesList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            return $this->renderView('search/_error.html.twig', array('message' => 'La page demandée n\'existe pas.'));
        }

        return $this->renderView('search/_speciesList.html.twig', array(
            'speciesList' => $speciesList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

}