<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * @Route("/admin/utilisateurs/status", name="admin_user_status")
     * @Method("POST")
     */
    public function AjaxChangeUserStatusAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $IDs = json_decode($request->request->get('IDs'));
        $enabled = (bool) $request->request->get('enabled');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:User');

        foreach ($IDs as $id){
            $user = $repository->find($id);
            $user->setEnabled($enabled);
            $em->persist($user);
        }
        $em->flush();

        return new JsonResponse(array('message' => 'OK'), 200);
    }

    /**
     * @Route("/admin/utilisateurs/{filter}/{page}", name="admin_user_list", defaults={"filter": "tous", "page": 1}, requirements={"page": "\d+"})
     */
    public function indexAction($filter = "tous", $page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');
        $nbPerPage = User::NUM_ITEMS; // Récupération du nombre d'utilisateur à afficher par page

        switch($filter){ // Récupération de la liste d'utilisateurs en fonction du filtre
            case "observateurs":
                $usersList = $repository->getUsersByRole($page, $nbPerPage, "ROLE_OBSERVER");
                break;
            case "naturalistes":
                $usersList = $repository->getUsersByRole($page, $nbPerPage, "ROLE_NATURALIST");
                break;
            case "administrateurs":
                $usersList = $repository->getUsersByRole($page, $nbPerPage, "ROLE_ADMIN");
                break;
            default:
                $usersList = $repository->getUsers($page, $nbPerPage);
                break;
        }

        $nbPageTotal = ceil(count($usersList)/$nbPerPage);
        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('adminController/users/users.html.twig', array(
            'usersList' => $usersList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page,
            'filter' => $filter
        ));
    }

    /**
     * @Route("/admin/utilisateurs/menu/{filter}", name="admin_user_list_menu", defaults={"filter": "tous"})
     */
    public function indexUserMenuAction($filter = "tous")
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');
        $userCount = $repository->getUsersCount();
        $observerCount = $repository->getUsersCountByRole("ROLE_OBSERVER");
        $naturalistCount = $repository->getUsersCountByRole("ROLE_NATURALIST");
        $adminCount = $repository->getUsersCountByRole("ROLE_ADMIN");

        return $this->render('adminController/users/_user_list_menu.html.twig', array(
            'filter' => $filter,
            'userCount' => $userCount,
            'observerCount' => $observerCount,
            'naturalistCount' => $naturalistCount,
            'adminCount' => $adminCount
        ));
    }
}