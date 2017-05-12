<?php
/**
 * Created by PhpStorm.
 * User: MisterX
 * Date: 12/05/2017
 * Time: 18:46
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData
    extends AbstractFixture
    implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail('admin@exemple.com');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->addRole('ROLE_SUPER_ADMIN');
        $userManager->updateUser($user);

        $user = $userManager->createUser();
        $user->setUsername('observ1');
        $user->setEmail('observ1@exemple.com');
        $user->setPlainPassword('observ1');
        $user->setEnabled(true);
        $user->addRole('ROLE_OBSERVER');
        $userManager->updateUser($user);

        $user = $userManager->createUser();
        $user->setUsername('observ2');
        $user->setEmail('observ2@exemple.com');
        $user->setPlainPassword('observ2');
        $user->setEnabled(true);
        $user->addRole('ROLE_OBSERVER');
        $userManager->updateUser($user);

        $user = $userManager->createUser();
        $user->setUsername('naturaliste1');
        $user->setEmail('naturaliste1@exemple.com');
        $user->setPlainPassword('naturaliste1');
        $user->setEnabled(true);
        $user->addRole('ROLE_NATURALIST');
        $userManager->updateUser($user);

        $user = $userManager->createUser();
        $user->setUsername('naturaliste2');
        $user->setEmail('naturaliste2@exemple.com');
        $user->setPlainPassword('naturaliste2');
        $user->setEnabled(true);
        $user->addRole('ROLE_NATURALIST');
        $userManager->updateUser($user);

        $user = $userManager->createUser();
        $user->setUsername('administratif1');
        $user->setEmail('administratif1@exemple.com');
        $user->setPlainPassword('administratif1');
        $user->setEnabled(true);
        $user->addRole('ROLE_ADMINISTRATIF');

        $userManager->updateUser($user);
    }

    /**
     * Sets the container.
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

}