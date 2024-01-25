<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\Ads;
use App\Entity\Type;
use App\Entity\Image;
use App\Entity\Equipment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $this->loadEquipment($manager);
        $this->loadType($manager);
        $this->loadImage($manager);
        $this->loadAds($manager);
    }

    public function loadAds(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $annonce = new Ads();
            $annonce
                ->setCity($faker->city)
                ->setCountry($faker->country)
                ->setAddress($faker->address)
                ->setDescription($faker->word(10))
                ->setPrice($faker->randomNumber(4))
                ->setSleeping($faker->randomNumber(1))
                ->setSize($faker->randomNumber(3));

            $manager->persist($annonce);
        }

        $manager->flush();
    }

    public function loadEquipment(ObjectManager $manager): void
    {
        // Liste d'équipements
        $equipmentList = [
            'Wi-Fi',
            'Cuisine équipée',
            'Micro-ondes',
            'Lave-vaisselle',
            'Climatisation',
            'Télévision',
            'Lave-linge',
            'Sèche-linge',
            'Parking',
            'Balcon',
            'Piscine',
            'Animaux acceptés',
        ];

        foreach ($equipmentList as $equipmentName) {
            $equipment = new Equipment();
            $equipment->setLabel($equipmentName);

            $manager->persist($equipment);
        }

        $manager->flush();
    }

    public function loadType(ObjectManager $manager): void
    {
        // Liste de types de bien
        $propertyTypes = [
            'Maison',
            'Appartement',
            'Cabane',
            'Château',
            'Villa',
            'Igloo',
        ];

        foreach ($propertyTypes as $typeName) {
            $propertyType = new Type();
            $propertyType->setLabel($typeName);

            $manager->persist($propertyType);
        }

        $manager->flush();
    }

    public function loadImage(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $image = new Image();
            $image->setImagePath($faker->imageUrl());

            $manager->persist($image);
        }

        $manager->flush();
    }
}