<?php

namespace dElt4\TimeBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="dElt4\TimeBundle\Entity\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    private $documents;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="dElt4\TimeBundle\Entity\ProjectHasUser", mappedBy="project", cascade={"PERSIST", "REMOVE"})
     */
    private $projectHasUsers;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->projectHasUsers = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set documents
     *
     * @param ArrayCollection $documents
     * @return Project
     */
    public function setDocuments($documents)
    {
        if (count($documents) > 0) {
            foreach ($documents as $document) {
                $this->addDocument($document);
            }
        }

        return $this;
    }

    public function addDocument(Media $document)
    {
        $this->documents->add($document);

        return $this;
    }

    public function removeDocument(Media $document)
    {
        $this->documents->removeElement($document);

        return $this;
    }

    /**
     * Get documents
     *
     * @return ArrayCollection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set users
     *
     * @param ArrayCollection $users
     * @return Project
     */
    public function setProjectHasUsers($projectHasUsers)
    {
        if (count($projectHasUsers) > 0) {
            foreach($projectHasUsers as $projectHasUser) {
                $this->addProjectHasUser($projectHasUser);
            }
        }

        return $this;
    }

    public function addProjectHasUser(ProjectHasUser $projectHasUser)
    {
        $projectHasUser->setProject($this);
        $this->projectHasUsers->add($projectHasUser);

        return $this;
    }

    public function removeUser(ProjectHasUser $projectHasUser)
    {
        $projectHasUser->setProject(null);
        $this->projectHasUsers->removeElement($projectHasUser);

        return $this;
    }

    /**
     * Get users
     *
     * @return ArrayCollection
     */
    public function getProjectHasUsers()
    {
        return $this->projectHasUsers;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Project
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
