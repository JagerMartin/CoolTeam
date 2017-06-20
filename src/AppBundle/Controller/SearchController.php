<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 13/05/2017
 * Time: 20:16
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Observation;
use AppBundle\Entity\Taxref;
use AppBundle\Form\SearchType;
use Ivory\GoogleMap\Map;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/rechercher/{cdName}", name="app_search", defaults={"cdName" = null}, requirements={"cdName": "\d+"})
     */
    public function searchAction($cdName = null)
    {
        $form = $this->createForm(SearchType::class);

        // Si cdName passé en paramètre, récupération du lbName correspondant
        $taxref = $cdName ? $taxref = $this->getDoctrine()->getManager()->getRepository('AppBundle:Taxref')->find($cdName) : null;
        $searchSpecie = $taxref ? $taxref->getLbName() : null;

        return $this->render('search/search.html.twig', array(
            'form' => $form->createView(),
            'searchSpecie' => $searchSpecie
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

        } elseif($department != ""){ // RECHERCHE PAR DEPARTEMENT
            $response = $this->searchByDepartment($department, $page);

        } elseif($family != ""){ // RECHERCHE PAR FAMILLE
            $response = $this->searchByFamily($family, $page);

        } else { // SI AUCUN CRITERE DE RECHERCHE => AFFICHE ERREUR
            $response = $this->renderView('search/_error.html.twig', array('message' => 'Vous devez indiquer un critère de recherche.'));
        }

        return new JsonResponse(array('response' => $response), 200);
    }


    /*
     * Renvoie la réponse quand la recherche a été effectuée PAR LB_NAME
     */
    private function searchByLbName($name, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $specie = $em->getRepository('AppBundle:Taxref')->findOneBy(array('lbName' => $name));

        // Récupération des observations associées
        $nbPerPage = Observation::SEARCH_NUM_ITEMS;
        $observationsList = $em->getRepository('AppBundle:Observation')->getObservationsBySpecie($name, $page, $nbPerPage);
        $nbPageTotal = ceil(count($observationsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            return $this->renderView('search/_error.html.twig', array('message' => 'La page demandée n\'existe pas.'));
        }

        // Création de la carte avec les observations
        $map = $this->get('app.create_map_with_observations')->createMapWithObservations($observationsList);

        return $this->renderView('search/_specie.html.twig', array(
            'specie' => $specie,
            'observationsList' => $observationsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page,
            'map' => $map
        ));
    }


    /*
     * Renvoie la réponse quand la recherche a été effectuée PAR NOM VERNACULAIRE
     */
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


    /*
     * Renvoie la réponse quand la recherche a été effectuée PAR DEPARTEMENT
     */
    private function searchByDepartment($department, $page)
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération de la liste des espèces pour la page demandée
        $nbPerPage = Taxref::SEARCH_NUM_ITEMS;
        $observationsList = $em->getRepository('AppBundle:Observation')->getSpeciesByDepartment($department, $page, $nbPerPage);
        $nbPageTotal = ceil(count($observationsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            return $this->renderView('search/_error.html.twig', array('message' => 'La page demandée n\'existe pas.'));
        }

        $speciesList = array(); // Récupération de l'entité taxref uniquement pour chaque observation
        foreach ($observationsList as $observation){
            $speciesList[] = $observation->getTaxref();
        }

        return $this->renderView('search/_speciesList.html.twig', array(
            'speciesList' => $speciesList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }


    /*
     * Renvoie la réponse quand la recherche a été effectuée PAR FAMILLE
     */
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

    public function specieImageAction($cdName, $imgClass)
    {
        $em = $this->getDoctrine()->getManager();
        $pictures = $em->getRepository('AppBundle:Picture')->getPicturesWithCdName($cdName);
        $picture = $pictures ? $pictures[0] : null;

        return $this->render('search/_picture.html.twig', array(
            'picture' => $picture,
            'imgClass' => $imgClass
        ));
    }

}