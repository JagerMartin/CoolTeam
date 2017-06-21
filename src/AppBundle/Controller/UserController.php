<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Newsletter;
use AppBundle\Entity\User;
use AppBundle\Form\UserProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * @Route("admin/utilisateurs/promouvoir/naturaliste/{id}", name="admin_user_promote_naturalist", requirements={"id": "\d+"})
     */
    public function promoteNaturalistAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setRoles(array('ROLE_NATURALIST'));
        $em->persist($user);
        $em->flush();

        $this->addFlash('info', 'L\'utilisateur "'.$user->getFirstName().' '.$user->getLastName().'" a été promu naturaliste.');
        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/admin/utilisateurs/status", name="admin_user_status")
     * @Method("POST")
     */
    public function AjaxChangeUserStatusAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $IDs = json_decode($request->request->get('IDs')); // Récupération de la liste des ID des utilisateurs à modifier
        $enabled = (bool) $request->request->get('enabled'); // Récupération de l'état dans lequel faire passer les utilisateurs

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
     * @Route("/admin/utilisateurs/profile/{id}", name="admin_user_profile", requirements={"id": "\d+"})
     */
    public function userProfileAction(Request $request, User $user)
    {
        // Le profil d'un utilisateur ne peut être consulter que par l'utilisateur lui même ou par un admin
        $currentUser = $this->getUser();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') && !($user->getId() == $currentUser->getId())) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $newsletterRepository = $em->getRepository('AppBundle:Newsletter');
        $newsletter = $newsletterRepository->findBy(array('email' => $user->getEmail()));
        // Vérification si l'utilisateur du profil à afficher est inscrit à la newsletter
        $newsletter ? $user->setIsNewsletterSubscriber(true) : $user->setIsNewsletterSubscriber(false);

        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);
            // Gestion de l'inscription à la newsletter
            $this->manageNewsletterSubscription($user);

            $this->addFlash('info', 'Les informations ont bien été enregistrées');
            $this->redirectToRoute('admin_user_profile', array('id' => $user->getId()));
        }

        return $this->render('adminController/users/profile.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
        ));
    }

    // Méthode privée déchargeant userProfileAction de le gestion de l'inscription à la newsletter
    private function manageNewsletterSubscription(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $newsletterRepository = $em->getRepository('AppBundle:Newsletter');

        // Gestion de l'inscription à la newsletter
        $newsletter = $newsletterRepository->findOneBy(array('email' => $user->getEmail()));
        if($user->getIsNewsletterSubscriber()){ // Si il souhaite recevoir la newsletter
            if(!$newsletter){ // Si il n'est pas déjà inscrit
                $newsletter = new Newsletter();
                $newsletter->setEmail($user->getEmail());
                $em->persist($newsletter);
            }
        } else { // Si il ne souhaite pas recevoir la newsletter
            if($newsletter){ // Si il est inscrit sur la liste
                $em->remove($newsletter);
            }
        }
        $em->flush();
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
                $usersList = $repository->getAdministrators($page, $nbPerPage);
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
        $adminCount = $repository->getUsersCountByRole("ROLE_ADMINISTRATIF") + $repository->getUsersCountByRole("ROLE_SUPER_ADMIN");

        return $this->render('adminController/users/_user_list_menu.html.twig', array(
            'filter' => $filter,
            'userCount' => $userCount,
            'observerCount' => $observerCount,
            'naturalistCount' => $naturalistCount,
            'adminCount' => $adminCount
        ));
    }

}