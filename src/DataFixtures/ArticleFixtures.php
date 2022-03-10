<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i<=10; $i++) {
            $article = new Article();
            $article->setTitre("article n°".$i);
            $article->setContent("Contenu de mon article");
            $date = new \DateTime();
            $date->modify('-'.$i.' days');
            $article->setCreatedDate($date);
            // One To Many
            $this->addReference('article-'.$i, $article);

            $manager->persist($article);
        }
        $manager->flush();
    }
}
