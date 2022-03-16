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

        $state = ['draft','publish'];
        // Create 3 categories
        for($i = 1; $i<=3; $i++)
        {
            $category = new Category();
            $category->setName($faker->sentence($nbWords = 1));
            $manager->persist($category);

            // Create between 4 and 6 articles
            for($j = 1; $j<= mt_rand(4,6); $j++)
            {
                // transform faker->paragraphs'array to string
                // $content = '<p>'. $faker->text(100).'</p>';
                // Start new Article
                $article = new Article();
                $article->setTitre($faker->sentence(3))
                        ->setContent($faker->paragraph(3, false))
                        ->setCreatedDate($faker->dateTimeBetween('-6 months)'))
                        ->setState($state[array_rand($state)])
                        ->addCategory($category);
                $manager->persist($article);

                // Create between 1 and 3 comment(s)
                    for($k = 1; $k<= mt_rand(1,3); $k++)
                    {
                        // transform faker->paragraphs'array to string
                        // $content = '<p>'. $faker->text(100) .'</p>';
                        // create dateComment between Now and article>getCreatedDate
                        $days = (new \DateTime())->diff($article->getCreatedDate())->days;
                        // Start new Comment
                        $comment = new Comment;
                        $comment->setAuthor($faker->name)
                                ->setContenu($faker->paragraph(3, false))
                                ->setDateComment($faker->dateTimeBetween('-'.$days.' days'))
                                ->setArticle($article);
                        $manager->persist($comment);
                    }
                }
           }
        $manager->flush();
    }
}
