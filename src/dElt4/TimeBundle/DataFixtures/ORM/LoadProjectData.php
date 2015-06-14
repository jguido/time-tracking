<?php

namespace  dElt4\TimeBundle\DataFixtures\ORM;

use dElt4\TimeBundle\Entity\Project;
use dElt4\TimeBundle\Entity\ProjectHasUser;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProjectData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository('ApplicationSonataUserBundle:User')->findAll();
        foreach(range(0, 10) as $i) {
            $phus = array();
            foreach ($users as $user) {
                $projectHasUser = new ProjectHasUser();
                $projectHasUser
                    ->setUser($user)
                    ->setCostPerDay(850);
                $phus[] = $projectHasUser;
            }
            $project = new Project();
            $project
                ->setProjectHasUsers($phus)
                ->setPrice(10000)
                ->setDescription('description '.$i)
                ->setTitle('Project fixture '.$i);

            $manager->persist($project);
        }
        $manager->flush();
    }
}