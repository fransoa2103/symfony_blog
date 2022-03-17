<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Form\CommentType;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\VerifComment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form;

class DefaultController extends AbstractController

{
    /**
     * list articles = default page
     * @Route("/", name="liste_articles", methods={"GET"})
     */

    public function listeArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(['state'=>'publish']);

        return $this->render('default/index.html.twig',
            [
                'articles'      => $articles,
                'draft'         => false
            ]);
    }


    // article page display only one article with his id
    // public function vueArticle(ArticleRepository $articleRepository, $id) equal (Article $article) because it's a Param converter

    /**
     * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function vueArticle  (   Article $article,
                                    Request $request,
                                    EntityManagerInterface $manager,
                                    VerifComment $verifWord )
    {
        $comment = new Comment();

        // get 'id' parameter from $article * on récupère l'id de l'article //
        $comment->setArticle($article);

        // Form start
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Control and register
        if($form->isSubmitted() && $form->isValid())
        {
            // control bad words
            if ($verifWord->authorizedComment($comment) === false)
            {
                $manager->persist($comment);
                $manager->flush();
                return $this->redirectToRoute('vue_article', ['id'=>$article->getId()]);
            }
            else
            {
                $this->addFlash(
                    'notice',
                    'your content don\'t respect the author, please rewrite your comment!'
                );
            }
        }

        // View
        return $this->render('default/vue.html.twig',
            [
                'article'=> $article,
                'form'=>$form->createView()
            ]);
    }

    
    /**
     * @Route("/article/ajouter", name="ajouter_article")
     * @Route("/article/{id}/edit", name="edit_article",requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
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

    // list Categories
    /**
     * @Route("/categories", name="liste_categories", methods={"GET", "POST"})
     */
    public function listeCategories(CategoryRepository $categorieRepository, EntityManagerInterface $manager, Request $request)
    {
        $categories = $categorieRepository->findAll();

        $categorie = new Category();

        // Form start
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

        // Control and register
        if($form->isSubmitted() && $form->isValid())
        {
            //dump($categorie); die;
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute('liste_categories');
        }

        // View
        return $this->render('default/categories.html.twig',
            [ 'categories' => $categories,
                'form'=>$form->createView() ]);
    }
 
    /**
     * @Route("/article/draft", name="liste_draft")
     */
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
