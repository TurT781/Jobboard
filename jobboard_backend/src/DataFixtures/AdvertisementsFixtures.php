<?php

namespace App\DataFixtures;

use App\Entity\Advertisements;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AdvertisementsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            
            $advertisement = new Advertisements();
            $advertisement->setTitle($faker->jobTitle);  
            $advertisement->setCompany($faker->company); 
            $advertisement->setContent($faker->paragraph(2));  
            $advertisement->setAddress($faker->address);
            $advertisement->setExperienceLevel($faker->randomElement(['Junior', 'Mid', 'Senior'])); 
            $advertisement->setEducationLevel($faker->randomElement(["Bachelor's Degree", "Master's Degree", "High School"]));
            $advertisement->setWorkingTime($faker->randomElement(['Full Time', 'Part Time'])); 
            $advertisement->setSalaryMin($faker->numberBetween(2000, 5000));  
            $advertisement->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($advertisement);
        }

        $manager->flush();
    }
}
