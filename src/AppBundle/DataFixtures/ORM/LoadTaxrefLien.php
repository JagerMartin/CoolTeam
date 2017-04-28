<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 28/04/2017
 * Time: 09:06
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\TaxrefLien;

class LoadTaxrefLien implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $taxrefLienCsv = fopen(dirname(__FILE__).'/Resources/taxref_lien.csv', 'r');
        $i = 0;
        while(!feof($taxrefLienCsv)) {
            $line = fgetcsv($taxrefLienCsv, 600, ';');

            if($i > 0){
                $taxrefLien[$i] = new TaxrefLien();
                $taxrefLien[$i]->setCtNom($line[0]);
                $taxrefLien[$i]->setCtType($line[1]);
                $taxrefLien[$i]->setCtAuteurs($line[2]);
                $taxrefLien[$i]->setCtTitre($line[3]);
                $taxrefLien[$i]->setCtUrl($line[4]);
                $taxrefLien[$i]->setCdNom($line[5]);
                $taxrefLien[$i]->setCtSpid($line[6]);
                $taxrefLien[$i]->setUrlSp($line[7]);

                if($taxrefLien[$i]->getCtNom() != null){
                    $manager->persist($taxrefLien[$i]);
                }
            }

            // FLUSH toutes les 25 persistances pour améliorer les performances de chargement
            if($i % 25 == 0){
                $manager->flush();
                $manager->clear();
            }

            $i = $i + 1;
        }
        fclose($taxrefLienCsv);

        $manager->flush();
    }
}