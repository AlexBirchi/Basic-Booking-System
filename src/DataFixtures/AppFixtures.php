<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Facility;
use App\Entity\Property;
use App\Entity\PropertyType;
use App\Entity\RoomType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $country1 = new Country();
        $country1->setName('Romania');
        $country2 = new Country();
        $country2->setName('Spain');

        $city1 = new City();
        $city1->setName('Craiova');
        $city1->setCountry($country1);
        $city2 = new City();
        $city2->setName('Valcea');
        $city2->setCountry($country1);
        $city3 = new City();
        $city3->setName('Brasov');
        $city3->setCountry($country1);

        for ($i = 0; $i < 15; $i++) {
            $facility = new Facility();
            $facility->setName('facility ' . $i);
            if($i <= 10){
                $facility->setIsRoomFacility(true);
            } else {
                $facility->setIsPropertyFacility(true);
            }
            $manager->persist($facility);
        }

        $propertyType1 = new PropertyType();
        $propertyType1->setName('Hotel');
        $propertyType2 = new PropertyType();
        $propertyType2->setName('Apartament');
        $propertyType2->setHasMultipleRooms(true);

        $roomType1 = new RoomType();
        $roomType1->setName('Bedroom');
        $roomType2 = new RoomType();
        $roomType2->setName('Living room');
        $roomType3 = new RoomType();
        $roomType3->setName('Twin room');
        $roomType4 = new RoomType();
        $roomType4->setName('Double room');

        $manager->persist($country1);
        $manager->persist($country2);
        $manager->persist($city1);
        $manager->persist($city2);
        $manager->persist($city3);
        $manager->persist($propertyType1);
        $manager->persist($propertyType2);
        $manager->persist($roomType1);
        $manager->persist($roomType2);
        $manager->persist($roomType3);
        $manager->persist($roomType4);

        $manager->flush();
    }
}
