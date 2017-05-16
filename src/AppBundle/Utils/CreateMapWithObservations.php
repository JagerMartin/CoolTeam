<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 16/05/2017
 * Time: 21:30
 */

namespace AppBundle\Utils;


use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use AppBundle\Entity\Observation;
use Ivory\GoogleMap\Overlay\Circle;

class CreateMapWithObservations
{
    public function createMapWithObservations($observations, $random = true){
        $map = new Map();
        $map->setMapOption('zoom', 0);

        foreach ($observations as $observation){
            $latitude = $random ? $this->addRandomizedOffset($observation->getLatitude()) : $observation->getLatitude();
            $longitude = $random ? $this->addRandomizedOffset($observation->getLongitude()) : $observation->getLongitude();

            $circle = new Circle(new Coordinate($latitude, $longitude), 10000, ['clickable' => false]);
            $map->getOverlayManager()->addCircle($circle);
        }

        return $map;
    }

    private function addRandomizedOffset($coordinate){
        $randomizedOffset = rand(-5, 5) / 100;
        return ($coordinate + $randomizedOffset);
    }
}