<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Observation
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObservationRepository")
 */
class Observation
{
    const SEARCH_NUM_ITEMS = 9;
    const INIT = 0;
    const PENDING = 10;
    const TOCORRECT = 20;
    const VALIDATE = 30;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     * @Assert\DateTime()
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="text", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=500)
     */
    private $observation;


    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     * @Assert\Length(max=500)
     */
    private $comment;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     * @Assert\Type("numeric")
     * @Assert\NotBlank()
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     * @Assert\Type("numeric")
     * @Assert\NotBlank()
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $department;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = self::INIT;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Taxref")
     * @ORM\JoinColumn(referencedColumnName="CD_NAME", name="taxref_CD_NAME")
     */
    private $taxref;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $validator;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Picture", mappedBy="observation")
     * @Assert\Valid()
     */
    private $pictures;

    public function __construct()
    {
        $this->taxref = new Taxref();
        $this->user = new User();
        $this->pictures = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Observation
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return Observation
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Observation
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Observation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set department
     *
     * @param string $department
     *
     * @return Observation
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Observation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set taxref
     *
     * @param \AppBundle\Entity\Taxref $taxref
     *
     * @return Observation
     */
    public function setTaxref(\AppBundle\Entity\Taxref $taxref = null)
    {
        $this->taxref = $taxref;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Observation
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get validator
     *
     * @return \AppBundle\Entity\User
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set validator
     *
     * @param \AppBundle\Entity\User $validator
     *
     * @return Observation
     */
    public function setValidator(\AppBundle\Entity\User $validator = null)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get taxref
     *
     * @return \AppBundle\Entity\Taxref
     */
    public function getTaxref()
    {
        return $this->taxref;
    }

    /**
     * Add picture
     *
     * @param \AppBundle\Entity\Picture $picture
     *
     * @return Observation
     */
    public function addPicture(\AppBundle\Entity\Picture $picture)
    {
        $this->pictures[] = $picture;

        if ($picture) {
            $picture->setObservation($this);
        }

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \AppBundle\Entity\Picture $picture
     */
    public function removePicture(\AppBundle\Entity\Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set pictures
     *
     * @param ArrayCollection $pictures
     *
     * @return Observation
     */
    public function setPictures($pictures = null)
    {
        $this->pictures = $pictures;

        return $this;
    }
}
