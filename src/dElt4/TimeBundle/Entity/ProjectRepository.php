<?php

namespace dElt4\TimeBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
    public function findByUser(UserInterface $user) {
        $projects = $this->findAll();
        $resProjects = array();

        if (count($projects) > 0) {
            foreach ($projects as $project) {
                if ($project instanceof Project && count($project->getUsers()) > 0) {
                    $found = false;
                    foreach ($project->getUsers() as $tmpUser) {
                        if ($tmpUser->getUsername() === $user->getUsername()) {
                            $found = true;
                        }
                    }
                    if ($found) {
                        $resProjects[] = array('id' => $project->getId(), 'title' => $project->getTitle());
                    }
                }
            }
        }

        return $resProjects;
    }

}