<?php

namespace dElt4\TimeBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use dElt4\TimeBundle\Entity\Project;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectHasUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="dElt4\TimeBundle\Entity\ProjectHasUserRepository")
 */
class ProjectHasUser
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
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="projectHasUsers")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="dElt4\TimeBundle\Entity\Project", inversedBy="projectHasUsers")
     */
    private $project;

    /**
     * @var float
     *
     * @ORM\Column(name="costPerDay", type="float")
     */
    private $costPerDay;


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
     * @return ProjectHasUser
     */
    public function setUser($user = null)
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
     * @return ProjectHasUser
     */
    public function setProject($project = null)
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
     * Set costPerDay
     *
     * @param float $costPerDay
     * @return ProjectHasUser
     */
    public function setCostPerDay($costPerDay)
    {
        $this->costPerDay = $costPerDay;

        return $this;
    }

    /**
     * Get costPerDay
     *
     * @return float 
     */
    public function getCostPerDay()
    {
        return $this->costPerDay;
    }
}
