<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // EXAMPLE
        /* for($i = 1; $i<=10; $i++) {
            $comment = new Comment();
            $comment->setContenu("commentaire de mon article n°");
            $comment->setAuthor("François CB");
            $comment->setDateComment(new \DateTime());
            // Many To One
            $comment->setArticle($this->getReference('article-1'));

            $manager->persist($comment);
        }
        $manager->flush();
        */
    }
    // Appelle la Class Article avant la création d'un commentaire pour récupérer l'id de l'article
    // To get article id, Call Article Class before create a comment then get article Id
    public function getDependencies()
    {
        return [ ArticleFixtures::class ];
    }
}
