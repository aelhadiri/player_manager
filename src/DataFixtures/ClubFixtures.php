<?php

namespace App\DataFixtures;

use App\Entity\Club;
use App\Entity\User as ClubManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClubFixtures extends Fixture
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
        for ($i = 1; $i <= 5; $i++) {
            $clubManager = new ClubManager();
            $clubManager->setlastName($faker->lastName());
            $clubManager->setFirstName($faker->firstName());
            $clubManager->setEmail(sprintf('club.manager_%d@example.com', $i));
            $password = $this->passwordEncoder->hashPassword($clubManager, 'testing');
            $clubManager->setPassword($password);
            $clubManager->setRoles(["ROLE_MANAGER"]);
            $manager->persist($clubManager);

            $club = new Club();
            $club->setName('club_' . $i);
            $club->setClubManager($clubManager);
            $this->addReference(self::CLUB_REFERENCE . $i, $club);
            $manager->persist($club);
        }
        $manager->flush();
    }
}

