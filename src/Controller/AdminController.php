<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */

class AdminController extends AbstractController
{
    /** *******************************************************************************************************
     *
     * @Route("/article/ajouter", name="ajouter_article")
     * @Route("/article/{id}/edit", name="edit_article",requirements={"id"="\d+"}, methods={"GET", "POST"})
     *
     ******************************************************************************************************** */
    

    public function ajouter(Article $article = null, Request $request, EntityManagerInterface $manager)
    {
        $article === null ? $article = new Article() : null;

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($form->get('draft')->isClicked())
            {
                $article->setState('draft');
            }
            else
            {
                $article->setState('to publish');
            }

            if( $manager->persist($article) === null){ $manager->flush(); }
            return $this->redirectToRoute('liste_articles');
        }

        return $this->render('default/ajouter.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }



    /** **********************************************************************************************************
     * 
     * @Route("/article/draft", name="liste_draft")
     * 
     * ******************************************************************************************************** */

    public function listeArticlesDraft(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(['state'=>'draft']);

        return $this->render('default/index.html.twig',
            [
                'articles' => $articles,
                'draft' => true,

            ]);
    }
}
