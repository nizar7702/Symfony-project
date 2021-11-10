<?php

namespace App\DataFixtures;

use App\Entity\Product2;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; $i++) {
            $product = new Product2();
            $product->setLib("lib $i")
                ->setPru($i * 10 + 5)
                ->setDescription("description de l'article n° $i")
                ->setIm("http://placehold.it/350*150");
            $manager->persist($product);
        }

        $manager->flush();
    }
}
