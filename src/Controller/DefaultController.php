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
use App\Repository\CommentRepository;



use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('default/index.html.twig',
            [ 'articles' => $articles ]);
    }


    // article page display only one article with his id
    /**
     * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    // public function vueArticle(ArticleRepository $articleRepository, $id)
    // ou Param converter
    public function vueArticle(Article $article, Request $request, EntityManagerInterface $manager)
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
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('vue_article', ['id'=>$article->getId()]);
        }

        // View
        return $this->render('default/vue.html.twig',
            [
                'article'=> $article,
                'form'=>$form->createView()

            ]);
    }

    // article page display only one article with his id
    /**
     * @Route("/article/ajouter", name="ajouter_article")
     */
    public function ajouter(Request $request, EntityManagerInterface $manager)
    {
        // dump($request);die;

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        // dump($request);die;
        if($form->isSubmitted() && $form->isValid())
        {
            // dump($article); die();
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('liste_articles');
        }

        return $this->render('default/ajouter.html.twig', ['form' => $form->createView()]);
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
}
