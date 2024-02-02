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

        $imageLinks = [
            'https://www.engelvoelkers.com/images/8e1d5576-e715-46a1-8927-e53cf2c37281/villa-moderne-dans-un-lotissement-exclusif-%C3%A0-mijas',
            'https://www.medvillaespagne.fr/images/viviendas/2776/g_5jayvg5sy4jqubkntdjh.jpg',
            'https://dubai-immo.com/wp-content/uploads/2022/05/villa-venise-damac-lagoons-pool.png',
            'https://www.civitatis.com/blog/wp-content/uploads/2020/12/castillo-chambord-loira.jpg',
            'https://media.admagazine.fr/photos/6581a62b820622c0d59da13c/16:9/w_2560%2Cc_limit/Chateau_Vouzeron36.jpeg',
            'https://www.jaimemonpatrimoine.fr/images/FO_Gallery/vignette-chateaux-chateau-de-menthon-c-fabio-comparelli_1639402616.jpg',
            'https://static.actu.fr/uploads/2023/06/b39cb2826d946b79cb2826d948b9cbv-960x640.jpg',
            'https://www.illico-travaux.com/wp-content/uploads/2022/04/Renovation-apprtement-Les-Sables-dOlonne-11042022-1604-1280x720.jpeg',
            'https://media-cdn.tripadvisor.com/media/vr-splice-j/09/46/c2/88.jpg',
            'https://www.sothebysrealty-france.com/datas/biens/images/23063/23063_00-2023-05-18-0036.jpg',
            'https://www.vivons-maison.com/sites/default/files/styles/740px/public/field/image/appartement-de-ville-moderne.jpg?itok=glB-GqEQ'
        ];

        $faker = \Faker\Factory::create('fr_FR');
        $randomLink = $faker->randomElement($imageLinks);

        for ($i = 0; $i < 10; $i++) {


            $annonce = new Ads();
            $annonce
                ->setCity($faker->city)
                ->setCountry($faker->country)
                ->setAddress($faker->address)
                ->setDescription($faker->word(10))
                ->setPrice($faker->randomNumber(4))
                ->setSleeping($faker->randomNumber(1))
                ->setSize($faker->randomNumber(3))
                ->setImagePath($randomLink);

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
        $imageLinks = [
            'https://www.engelvoelkers.com/images/8e1d5576-e715-46a1-8927-e53cf2c37281/villa-moderne-dans-un-lotissement-exclusif-%C3%A0-mijas',
            'https://www.medvillaespagne.fr/images/viviendas/2776/g_5jayvg5sy4jqubkntdjh.jpg',
            'https://dubai-immo.com/wp-content/uploads/2022/05/villa-venise-damac-lagoons-pool.png',
            'https://www.civitatis.com/blog/wp-content/uploads/2020/12/castillo-chambord-loira.jpg',
            'https://media.admagazine.fr/photos/6581a62b820622c0d59da13c/16:9/w_2560%2Cc_limit/Chateau_Vouzeron36.jpeg',
            'https://www.jaimemonpatrimoine.fr/images/FO_Gallery/vignette-chateaux-chateau-de-menthon-c-fabio-comparelli_1639402616.jpg',
            'https://static.actu.fr/uploads/2023/06/b39cb2826d946b79cb2826d948b9cbv-960x640.jpg',
            'https://www.illico-travaux.com/wp-content/uploads/2022/04/Renovation-apprtement-Les-Sables-dOlonne-11042022-1604-1280x720.jpeg',
            'https://media-cdn.tripadvisor.com/media/vr-splice-j/09/46/c2/88.jpg',
            'https://www.sothebysrealty-france.com/datas/biens/images/23063/23063_00-2023-05-18-0036.jpg',
            'https://www.vivons-maison.com/sites/default/files/styles/740px/public/field/image/appartement-de-ville-moderne.jpg?itok=glB-GqEQ'
        ];

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $image = new Image();
            $randomLink = $faker->randomElement($imageLinks);
            $image->setImagePath($randomLink);
            $manager->persist($image);
        }

        $manager->flush();
    }
}