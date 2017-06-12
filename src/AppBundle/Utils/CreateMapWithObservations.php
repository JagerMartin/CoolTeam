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
        $map->setMapOption('zoom', 5);
        $map->setMapOption('MapTypeId', 'terrain');
        $map->setMapOption('streetViewControl', false);
        $map->setCenter(new Coordinate(47.208744, 2.651214));

        foreach ($observations as $observation){
            $latitude = $random ? $this->addRandomizedOffset($observation->getLatitude()) : $observation->getLatitude();
            $longitude = $random ? $this->addRandomizedOffset($observation->getLongitude()) : $observation->getLongitude();

            $circle = new Circle(new Coordinate($latitude, $longitude), 50000, ['clickable' => false]);
            $circle->setOptions(array(
                'fillColor' => '#EABE66',
                'fillOpacity' => 0.9,
                'strokeColor' => '#e0a01f',
                'strokeWeight' => 0.5
            ));
            $map->getOverlayManager()->addCircle($circle);
        }

        return $map;
    }

    private function addRandomizedOffset($coordinate){
        $randomizedOffset = rand(-5, 5) / 100;
        return ($coordinate + $randomizedOffset);
    }
}