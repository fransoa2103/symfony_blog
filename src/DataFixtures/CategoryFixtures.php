<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // EXAMPLE
        // $sport = new Category();
        // $sport->setName('Sport');

        // $sport->addArticle($this->getReference('article-1'));
        // $sport->addArticle($this->getReference('article-2'));
        // $sport->addArticle($this->getReference('article-3'));

        // $manager->persist($sport);
        // $manager->flush();
    }

    public function getDependencies()
    {
        return [ArticleFixtures::class];
    }

}