<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $userManager = $this->container->get('fos_user.user_manager');
        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@insset.com');
        $admin->setPlainPassword('admin');
        $admin->addRole(User::ROLE_SUPER_ADMIN);
        $admin->setEnabled(true);
        $manager->persist($admin);
        $userManager->updateUser($admin);

        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setEmail('user@insset.com');
        $user->setPlainPassword('user');
        $user->addRole(User::ROLE_DEFAULT);
        $user->setEnabled(true);
        $manager->persist($user);
        
        $userManager->updateUser($user);

        $manager->flush();
    }
}