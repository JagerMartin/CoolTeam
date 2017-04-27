<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxrefLink
 *
 * @ORM\Table(name="taxref_lien")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxrefLienRepository")
 */
class TaxrefLien
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="CT_NAME", type="string", length=255)
     */
    private $ctNom;

    /**
     * @var string
     *
     * @ORM\Column(name="CT_TYPE", type="string", length=255)
     */
    private $ctType;

    /**
     * @var string
     *
     * @ORM\Column(name="CT_AUTHORS", type="string", length=255)
     */
    private $ctAuteurs;

    /**
     * @var string
     *
     * @ORM\Column(name="CT_TITLE", type="string", length=255)
     */
    private $ctTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="CT_URL", type="string", length=255)
     */
    private $ctUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="CD_NOM", type="integer", unique=true)
     */
    private $cdNom;

    /**
     * @var int
     *
     * @ORM\Column(name="CT_SP_ID", type="integer", unique=true)
     */
    private $ctSpId;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_SP", type="string", length=255)
     */
    private $urlSp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set ctNom
     *
     * @param string $ctNom
     *
     * @return TaxrefLien
     */
    public function setCtNom($ctNom)
    {
        $this->ctNom = $ctNom;

        return $this;
    }

    /**
     * Get ctNom
     *
     * @return string
     */
    public function getCtNom()
    {
        return $this->ctNom;
    }

    /**
     * Set ctType
     *
     * @param string $ctType
     *
     * @return TaxrefLien
     */
    public function setCtType($ctType)
    {
        $this->ctType = $ctType;

        return $this;
    }

    /**
     * Get ctType
     *
     * @return string
     */
    public function getCtType()
    {
        return $this->ctType;
    }

    /**
     * Set ctAuteurs
     *
     * @param string $ctAuteurs
     *
     * @return TaxrefLien
     */
    public function setCtAuteurs($ctAuteurs)
    {
        $this->ctAuteurs = $ctAuteurs;

        return $this;
    }

    /**
     * Get ctAuteurs
     *
     * @return string
     */
    public function getCtAuteurs()
    {
        return $this->ctAuteurs;
    }

    /**
     * Set ctTitre
     *
     * @param string $ctTitre
     *
     * @return TaxrefLien
     */
    public function setCtTitre($ctTitre)
    {
        $this->ctTitre = $ctTitre;

        return $this;
    }

    /**
     * Get ctTitre
     *
     * @return string
     */
    public function getCtTitre()
    {
        return $this->ctTitre;
    }

    /**
     * Set ctUrl
     *
     * @param string $ctUrl
     *
     * @return TaxrefLien
     */
    public function setCtUrl($ctUrl)
    {
        $this->ctUrl = $ctUrl;

        return $this;
    }

    /**
     * Get ctUrl
     *
     * @return string
     */
    public function getCtUrl()
    {
        return $this->ctUrl;
    }

    /**
     * Set cdNom
     *
     * @param integer $cdNom
     *
     * @return TaxrefLien
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = $cdNom;

        return $this;
    }

    /**
     * Get cdNom
     *
     * @return integer
     */
    public function getCdNom()
    {
        return $this->cdNom;
    }

    /**
     * Set ctSpId
     *
     * @param integer $ctSpId
     *
     * @return TaxrefLien
     */
    public function setCtSpId($ctSpId)
    {
        $this->ctSpId = $ctSpId;

        return $this;
    }

    /**
     * Get ctSpId
     *
     * @return integer
     */
    public function getCtSpId()
    {
        return $this->ctSpId;
    }

    /**
     * Set urlSp
     *
     * @param string $urlSp
     *
     * @return TaxrefLien
     */
    public function setUrlSp($urlSp)
    {
        $this->urlSp = $urlSp;

        return $this;
    }

    /**
     * Get urlSp
     *
     * @return string
     */
    public function getUrlSp()
    {
        return $this->urlSp;
    }
}
