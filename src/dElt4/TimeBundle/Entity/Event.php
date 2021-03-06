<?php

namespace dElt4\TimeBundle\Entity;

use FOS\UserBundle\Model\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="dElt4\TimeBundle\Entity\EventRepository")
 */
class Event
{
    const AM = 'am';
    const PM = 'pm';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type("string")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="datetime")
     * @JMS\Type("DateTime<'Y-m-d'>")
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     * @JMS\Type("string")
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @JMS\Type("boolean")
     */
    private $locked;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="dElt4\TimeBundle\Entity\Project", inversedBy="events")
     * @JMS\Type("dElt4\TimeBundle\Entity\Project")
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @JMS\Type("Application\Sonata\UserBundle\Entity\User")
     */
    private $user;

    public function __construct()
    {
        $this->locked = false;
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
     * Set begin
     *
     * @param \DateTime $day
     * @return Event
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set type
     *
     * @param string $end
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get end
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $locked
     * @return $this
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * @return bool
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set project
     *
     * @param Project $project
     * @return Event
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Event
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return $this->getDay().' - '.$this->getType().' - ' . $this->getProject()->getTitle();
    }
}
