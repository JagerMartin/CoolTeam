<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 08/05/2017
 * Time: 13:03
 */

namespace AppBundle\Utils;


use AppBundle\Entity\TaxrefLink;
use AppBundle\Entity\TaxrefLinkFile;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ReloadTaxrefLink
{
    private $em;
    private $helper;

    public function __construct(EntityManager $em, UploaderHelper $helper)
    {
        $this->em = $em;
        $this->helper = $helper;
    }

    public function reloadTaxrefLink()
    {
        $this->resetTable();

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder($delimiter = ';')]);
        $data = $serializer->decode(file_get_contents($this->getLastFileUrl()), 'csv');

        $this->loadTable($data);
    }

    private function resetTable()
    {
        $em = $this->em;
        $taxrefLinks = $em->getRepository('AppBundle:TaxrefLink')->findAll();
        $i = 0;
        foreach ($taxrefLinks as $taxrefLink){
            $taxrefLink = $em->merge($taxrefLink);
            $em->remove($taxrefLink);

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
        $lastTaxrefLink = $this->em->getRepository('AppBundle:TaxrefLinkFile')->getLastFile();
        $url = $this->helper->asset($lastTaxrefLink[0], 'taxrefLinkFile', TaxrefLinkFile::class);
        return $url;
    }

    private function loadTable($data)
    {
        $em = $this->em;
        $i = 0;
        foreach ($data as $datum){
            $taxrefLink = new TaxrefLink();
            $taxrefLink->setCtName($datum['CT_NAME']);
            $taxrefLink->setCtType($datum['CT_TYPE']);
            $taxrefLink->setCtAuthors($datum['CT_AUTHORS']);
            $taxrefLink->setCtTitle($datum['CT_TITLE']);
            $taxrefLink->setCtUrl($datum['CT_URL']);
            $taxrefLink->setCdName($datum['CD_NOM']);
            $taxrefLink->setCtSpId($datum['CT_SP_ID']);
            $taxrefLink->setUrlSp($datum['URL_SP']);

            $em->persist($taxrefLink);

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