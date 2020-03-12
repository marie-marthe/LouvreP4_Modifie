<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;


class Reservationfixtures extends Fixture
{
    public function load($manager)
    {
        for ($i = 1; $i <=10; $i++)
        {
            $reservation = new Reservation();
            $reservation->setNom(" Nom du reservateur n°$i")
                        ->setPrenom(" Prenom du visiteur n°$i")
                        ->setDate_reservation(new DateTime())
                        ->setPrice("$i")
                        ->setTitre("Musée du Louvre")
                        ->setReduction("$i")
                        ->setEmail("email = $i")
                        ->setCode_reservation("$i")
                        ->setImage ("http://placehold.it/350x150");

            $manager->persist($reservation);

        }

            $manager->flush();
    }
}
