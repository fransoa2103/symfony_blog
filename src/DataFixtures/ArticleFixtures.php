<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        // Create 5 categories
        for($i = 1; $i<=5; $i++)
        {
            $category = new Category();
            $category->setName($faker->sentence($nbWords = 1));
            $manager->persist($category);

            // Create between 4 and 6 articles
            for($j = 1; $j<= mt_rand(4,6); $j++)
            {
                // transform faker->paragraphs'array to string
                $content = '<p>'. join($faker->paragraphs(5), '<p/><p>') .'</p>';
                // Start new Article
                $article = new Article();
                $article->setTitre($faker->sentence(3))
                        ->setContent($faker->$content)
                        ->setCreatedDate($faker->dateTimeBetween('-6 months)'))
                        ->addCategory($category);
                $manager->persist($article);

                // Createcomments
                    for($k = 1; $k<= mt_rand(4,10); $k++)
                    {
                        // transform faker->paragraphs'array to string
                        $content = '<p>'. join($faker->paragraphs(3), '<p/><p>') .'</p>';
                        // create dateComment between Now and article>getCreatedDate
                        $days = (new \DateTime())->diff($article->getCreatedDate())->days;
                        // Start new Comment
                        $comment = new Comment;
                        $comment->setAuthor($faker->name)
                                ->setContenu($faker->$content)
                                ->setDateComment($faker->dateTimeBetween('-'.$days.' days'))
                                ->setArticle($article);
                        $manager->persist($comment);
                    }
                }
           }
        $manager->flush();
    }
}
