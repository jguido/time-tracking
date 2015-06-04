<?php

namespace dElt4\TimeBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tracking
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="dElt4\TimeBundle\Entity\TrackingRepository")
 */
class Tracking
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="dElt4\TimeBundle\Entity\Project")
     */
    private $project;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="workingDate", type="datetime")
     */
    private $workingDate;


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
     * Set user
     *
     * @param User $user
     * @return Tracking
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

    /**
     * Set project
     *
     * @param Project $project
     * @return Tracking
     */
    public function setProject(Project $project)
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
     * Set workingDate
     *
     * @param \DateTime $workingDate
     * @return Tracking
     */
    public function setWorkingDate($workingDate)
    {
        $this->workingDate = $workingDate;

        return $this;
    }

    /**
     * Get workingDate
     *
     * @return \DateTime 
     */
    public function getWorkingDate()
    {
        return $this->workingDate;
    }
}
