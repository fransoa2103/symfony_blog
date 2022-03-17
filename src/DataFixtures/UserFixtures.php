<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Paul');
        $user->setPassword('$2y$13$4X9C6wFhVMPLYuSxg0ZJK.2genA2QB.BvxM5E.WadSjaFRpAO0ppu');
        $manager->persist($user);
        
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$/tD3CdVVe91UcUJwp/4wC.DcGys8ZdrAbm1T7hapMNiolTKU/4ut.');
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
