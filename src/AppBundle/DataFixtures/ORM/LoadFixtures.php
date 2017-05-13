<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 06/04/2017
 * Time: 14:33
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        Fixtures::load(
            __DIR__.'/Resources/fixtures.yml',
            $manager,
            [
               'providers' => [$this]
            ]
        );
    }

    public function cdNames()
    {
        $genera = [441604, 645315, 698711, 441605, 432708, 459459, 441606, 418715, 459626, 2763, 2765, 459616,
            645631, 1973, 550537, 456607, 550538, 1948, 1958, 199302, 1961, 1960, 2708, 2706, 441860, 441861, 432699, 829197,
            441862, 2398, 2399, 2788, 199311, 813532, 2820, 1953, 1955, 1950, 2794, 2828, 2826, 2785, 2783, 199307, 2786,
            418712, 1964, 836226, 2007, 2005, 2781, 2779, 1970, 1972, 1962, 836223, 1975, 1977, 836222, 2772, 2773, 2770,
            2769, 2767, 441641, 780302, 3590, 441612];

        $key = array_rand($genera);
        return $genera[$key];
    }

    /**
    +     * Get the order of this fixture
    +     * @return integer
    +     */
   public function getOrder()
   {
     return 3;
   }
}