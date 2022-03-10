<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController

{
    // list articles = default page
    /**
     * @Route("/", name="liste_articles", methods={"GET"})
     */
    public function listeArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();


        /* $articles = $articleRepository->findBy
        (
            ['titre'        => "article n°1"],
            ['createdDate'  => 'DESC']
        );
        */

        return $this->render('default/index.html.twig',
            [ 'articles' => $articles ]);
    }

    // article page display only one article with his id
    /**
     * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET"})
     */
    // public function vueArticle(ArticleRepository $articleRepository, $id)
    // ou avec Param converter
    public function vueArticle(Article $article)
    {
//         $article =$articleRepository->find($id);
        return $this->render('default/vue.html.twig',['article'=> $article]);
    }

    // article page display only one article with his id
    /**
     * @Route("/article/add", name="add_article")
     */
    public function addArticle(EntityManagerInterface $manager)
    {
        $article = new Article();
        $article->setTitre("new title");
        $article->setContent("Contenu de mon article");
        $article->setCreatedDate(new \DateTime());

        $manager->persist($article);
        $manager->flush();
    }
}
