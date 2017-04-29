<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxrefLink
 *
 * @ORM\Table(name="taxref_link")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxrefLinkRepository")
 */
class TaxrefLink
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
    private $ctName;

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
    private $ctAuthors;

    /**
     * @var string
     *
     * @ORM\Column(name="CT_TITLE", type="string", length=255)
     */
    private $ctTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="CT_URL", type="string", length=255)
     */
    private $ctUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="CD_NAME", type="integer", unique=true)
     */
    private $cdName;

    /**
     * @var int
     *
     * @ORM\Column(name="CT_SP_ID", type="string", length=255)
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
     * Set ctName
     *
     * @param string $ctName
     *
     * @return TaxrefLink
     */
    public function setCtName($ctName)
    {
        $this->ctName = $ctName;

        return $this;
    }

    /**
     * Get ctName
     *
     * @return string
     */
    public function getCtName()
    {
        return $this->ctName;
    }

    /**
     * Set ctType
     *
     * @param string $ctType
     *
     * @return TaxrefLink
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
     * Set ctAuthors
     *
     * @param string $ctAuthors
     *
     * @return TaxrefLink
     */
    public function setCtAuthors($ctAuthors)
    {
        $this->ctAuthors = $ctAuthors;

        return $this;
    }

    /**
     * Get ctAuthors
     *
     * @return string
     */
    public function getCtAuthors()
    {
        return $this->ctAuthors;
    }

    /**
     * Set ctTitle
     *
     * @param string $ctTitle
     *
     * @return TaxrefLink
     */
    public function setCtTitle($ctTitle)
    {
        $this->ctTitle = $ctTitle;

        return $this;
    }

    /**
     * Get ctTitle
     *
     * @return string
     */
    public function getCtTitle()
    {
        return $this->ctTitle;
    }

    /**
     * Set ctUrl
     *
     * @param string $ctUrl
     *
     * @return TaxrefLink
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
     * Set cdName
     *
     * @param integer $cdName
     *
     * @return TaxrefLink
     */
    public function setCdName($cdName)
    {
        $this->cdName = $cdName;

        return $this;
    }

    /**
     * Get cdName
     *
     * @return integer
     */
    public function getCdName()
    {
        return $this->cdName;
    }

    /**
     * Set ctSpId
     *
     * @param integer $ctSpId
     *
     * @return TaxrefLink
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
     * @return TaxrefLink
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
