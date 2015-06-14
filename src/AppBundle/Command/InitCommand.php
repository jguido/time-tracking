<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 15/06/15
 * Time: 00:56
 */

namespace AppBundle\Command;

use Application\Sonata\UserBundle\Entity\User;
use dElt4\SynthesisBundle\Entity\Configuration;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends ContainerAwareCommand {
    protected function configure() {
        $this
            ->setName('time:init')
            ->setDescription("Commande d'installation de time tracking.");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $_em = $this
            ->getContainer()
            ->get('doctrine.orm.default_entity_manager');

        $pdo = $_em->getConnection()->getWrappedConnection();

        $pdo->exec('TRUNCATE Configuration;ALTER TABLE Configuration AUTO_INCREMENT = 1');

        $config = new Configuration();
        $_em->persist($config);
        $_em->flush($config);

        $output->writeln(sprintf("<info>Création du user admin</info>"));
        $password = 'timeadmin';
        $user = new User();
        $user
            ->setUsername('admin')
            ->setPlainPassword($password)
            ->setSuperAdmin(true)
            ->setEmail('admin@mail.fr')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setEnabled(true);

        $output->writeln(sprintf("<error>Le mot de passe de l'admin est : %s</error>", $password));
        $output->writeln(sprintf("<info>Fin de l'installation de time tracking</info>"));
    }
} 