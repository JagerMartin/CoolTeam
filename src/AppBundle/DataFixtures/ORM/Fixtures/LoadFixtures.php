<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 06/04/2017
 * Time: 14:33
 */

namespace AppBundle\DataFixtures\ORM\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        Fixtures::load(__DIR__.'/fixtures.yml', $manager);
    }
}