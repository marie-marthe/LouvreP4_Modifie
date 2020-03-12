<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{

    public function load($manager)
    {

        $manager->flush();
    }
}
