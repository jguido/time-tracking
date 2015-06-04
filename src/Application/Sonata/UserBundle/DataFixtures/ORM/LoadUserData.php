<?php

namespace Mana\Bundle\UserBundle\DataFixtures\ORM;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('admin')
            ->setPlainPassword('admin123')
            ->setSuperAdmin(true)
            ->setEmail('admin@mail.fr')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setEnabled(true);

        $manager->persist($user);
        $manager->flush($user);

        $user = new User();
        $user
            ->setUsername('user')
            ->setPlainPassword('user123')
            ->setSuperAdmin(false)
            ->setEmail('user@mail.fr')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setEnabled(true);

        $manager->persist($user);
        $manager->flush($user);
    }
}