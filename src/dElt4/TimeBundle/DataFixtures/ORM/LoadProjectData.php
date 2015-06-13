<?php

namespace  dElt4\TimeBundle\DataFixtures\ORM;

use dElt4\TimeBundle\Entity\Project;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProjectData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach(range(0, 10) as $i) {
            $project = new Project();
            $project
                ->setUsers($manager->getRepository('ApplicationSonataUserBundle:User')->findAll())
                ->setPrice(10000)
                ->setDescription('description '.$i)
                ->setTitle('Project fixture '.$i);

            $manager->persist($project);
        }
        $manager->flush();
    }
}