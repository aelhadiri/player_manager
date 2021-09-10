<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AdminFixtures extends Fixture
{
    public const CLUB_REFERENCE = 'club-';

    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $admin = new User();
        $admin->setlastName($faker->lastName());
        $admin->setFirstName($faker->firstName());
        $admin->setEmail('admin@example.com');
        $password = $this->passwordEncoder->hashPassword($admin, 'admin2021');
        $admin->setPassword($password);
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);
        $manager->flush();
    }
}

