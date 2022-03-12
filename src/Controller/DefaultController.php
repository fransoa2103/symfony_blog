<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/article/ajouter", name="ajouter_article")
     */
    public function ajouter(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $manager)
    {
        // dump($request);die;

        $form = $this->createFormBuilder()
            ->add('titre', TextType::class,['label'=>"Titre de l'article"])
            ->add('content', TextareaType::class)
            ->add('createdDate', DateType::class, ['widget'=>'single_text', 'input' => 'datetime'])
            // ->setMethod('POST')
            ->getForm();
        $form->handleRequest($request);

        // dump($request);die;
        if($form->isSubmitted() && $form->isValid())
        {
            $article = new Article();
            $article->setTitre($form->get('titre')->getData());
            $article->setContent($form->get('content')->getData());
            $article->setCreatedDate($form->get('createdDate')->getData());
            // add Category
            $category = $categoryRepository->findOneBy(['name'=>'Sport']);
            $article->addCategory($category);

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('liste_articles');
        }



        return $this->render('default/ajouter.html.twig', ['form' => $form->createView()]);
    }
}
