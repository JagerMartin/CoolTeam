<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 08/05/2017
 * Time: 13:03
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Taxref;
use AppBundle\Entity\TaxrefFile;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ReloadTaxref
{
    private $em;
    private $helper;

    public function __construct(EntityManager $em, UploaderHelper $helper)
    {
        $this->em = $em;
        $this->helper = $helper;
    }

    public function reloadTaxref()
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder($delimiter = ';')]);

        $data = $serializer->decode(file_get_contents($this->getLastFileUrl()), 'csv');
        $success = $this->checkData($data); // Vérification du contenu du fichier avant chargement
        if(!$success){
            return false;
        }

        $this->resetTable();
        $this->loadTable($data);
        return true;
    }

    private function checkData($data)
    {
        if(empty($data)){
            return false;
        }
        if(array_key_exists('LB_NOM', $data[0]) && array_key_exists('CD_NOM', $data[0])
        && array_key_exists('FAMILLE', $data[0])){
            return true;
        } else {
            return false;
        }
    }

    private function resetTable()
    {
        $em = $this->em;
        $taxrefs = $em->getRepository('AppBundle:Taxref')->findAll();
        $i = 0;
        foreach ($taxrefs as $taxref){
            $taxref = $em->merge($taxref);
            $em->remove($taxref);

            // FLUSH toutes les 25 persistances pour améliorer les performances de chargement
            if($i % 25 == 0){
                $em->flush();
                $em->clear();
            }
            $i = $i + 1;
        }
        $em->flush();
        $em->clear();
    }

    private function getLastFileUrl()
    {
        $lastTaxref = $this->em->getRepository('AppBundle:TaxrefFile')->getLastFile();
        $url = $this->helper->asset($lastTaxref[0], 'taxrefFile', TaxrefFile::class);
        return $url;
    }

    private function loadTable($data)
    {
        $em = $this->em;
        $i = 0;

        foreach ($data as $datum){
            $taxref = new Taxref();
            $taxref->setReign($datum['REGNE']);
            $taxref->setPhylum($datum['PHYLUM']);
            $taxref->setCategory($datum['CLASSE']);
            $taxref->setOrder($datum['ORDRE']);
            $taxref->setFamily($datum['FAMILLE']);
            $taxref->setCdName($datum['CD_NOM']);
            $taxref->setCdTaxsup($datum['CD_TAXSUP']);
            $taxref->setCdRef($datum['CD_REF']);
            $taxref->setRank($datum['RANG']);
            $taxref->setLbName($datum['LB_NOM']);
            $taxref->setLbAuthor($datum['LB_AUTEUR']);
            $taxref->setFullName($datum['NOM_COMPLET']);
            $taxref->setValidName($datum['NOM_VALIDE']);
            $taxref->setVernacularName($datum['NOM_VERN']);
            $taxref->setEngVernacularName($datum['NOM_VERN_ENG']);
            $taxref->setHabitat($datum['HABITAT']);
            $taxref->setFr($datum['FR']);
            $taxref->setGf($datum['GF']);
            $taxref->setMar($datum['MAR']);
            $taxref->setGua($datum['GUA']);
            $taxref->setSm($datum['SM']);
            $taxref->setSb($datum['SB']);
            $taxref->setSpm($datum['SPM']);
            $taxref->setMay($datum['MAY']);
            $taxref->setEpa($datum['EPA']);
            $taxref->setReu($datum['REU']);
            $taxref->setSa($datum['SA']);
            $taxref->setTa($datum['TA']);
            $taxref->setTaaf($datum['TAAF']);
            $taxref->setNc($datum['NC']);
            $taxref->setWf($datum['WF']);
            $taxref->setPf($datum['PF']);
            $taxref->setCli($datum['CLI']);

            $em->persist($taxref);

            // FLUSH toutes les 25 persistances pour améliorer les performances de chargement
            if($i % 25 == 0){
                $em->flush();
                $em->clear();
            }
            $i = $i + 1;
        }
        $em->flush();
    }

}