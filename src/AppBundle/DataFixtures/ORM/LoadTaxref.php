<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 28/04/2017
 * Time: 05:30
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Taxref;
use AppBundle\Entity\TaxrefLien;

class LoadTaxref implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
       $taxrefCsv = fopen(dirname(__FILE__).'/Files/taxref.csv', 'r');
       $i = 0;
        while(!feof($taxrefCsv)) {
            $line = fgetcsv($taxrefCsv, 600, ';');

            if($i > 0){
                $taxref[$i] = new Taxref();
                $taxref[$i]->setRegne($line[0]);
                $taxref[$i]->setPhylum($line[1]);
                $taxref[$i]->setClasse($line[2]);
                $taxref[$i]->setOrdre($line[3]);
                $taxref[$i]->setFamille($line[4]);
                $taxref[$i]->setCdNom($line[5]);
                $taxref[$i]->setCdTaxsup($line[6]);
                $taxref[$i]->setCdRef($line[7]);
                $taxref[$i]->setRang($line[8]);
                $taxref[$i]->setLbNom($line[9]);
                $taxref[$i]->setLbAuteur($line[10]);
                $taxref[$i]->setNomComplet($line[11]);
                $taxref[$i]->setNomValide($line[12]);
                $taxref[$i]->setNomVern($line[13]);
                $taxref[$i]->setNomVernEng($line[14]);
                $taxref[$i]->setHabitat($line[15]);
                $taxref[$i]->setFr($line[16]);
                $taxref[$i]->setGf($line[17]);
                $taxref[$i]->setMar($line[18]);
                $taxref[$i]->setGua($line[19]);
                $taxref[$i]->setSm($line[20]);
                $taxref[$i]->setSb($line[21]);
                $taxref[$i]->setSpm($line[22]);
                $taxref[$i]->setMay($line[23]);
                $taxref[$i]->setEpa($line[24]);
                $taxref[$i]->setReu($line[25]);
                $taxref[$i]->setSa($line[26]);
                $taxref[$i]->setTa($line[27]);
                $taxref[$i]->setTaaf($line[28]);
                $taxref[$i]->setNc($line[29]);
                $taxref[$i]->setWf($line[30]);
                $taxref[$i]->setPf($line[31]);
                $taxref[$i]->setCli($line[32]);

                if($taxref[$i]->getRegne() != null){
                    $manager->persist($taxref[$i]);
                }
            }

            // FLUSH toutes les 25 persistances pour améliorer les performances de chargement
            if($i % 25 == 0){
                $manager->flush();
                $manager->clear();
            }

            $i = $i + 1;
        }
        fclose($taxrefCsv);

        $manager->flush();
    }
}