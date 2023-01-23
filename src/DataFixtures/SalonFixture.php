<?php

namespace App\DataFixtures;

use App\Entity\Salon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SalonFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $salon = new Salon();

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
