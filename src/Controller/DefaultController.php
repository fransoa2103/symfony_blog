<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController

{
    // list articles = default page
    /**
     * @Route("/", name="liste_articles", methods={"GET"})
     */
    public function listeArticles(): Response
    {
        $articles = [
            [
                'nom' => 'Article 1',
                'id' => 1
            ],
            [
                'nom' => 'Article 2',
                'id' => 2
            ],
            [
                'nom' => 'Article 3',
                'id' => 3
            ]
        ];

        $test = 5;

        return $this->render('default/index.html.twig',
            [ 'articles' => $articles, 'test' => $test
        ]);
    }

    // article page display only one article with his id
    /**
     * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function vueArticle($id){
        return $this->render('default/vue.html.twig',['id'=> $id]);
    }
}
