<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ArticleController extends AbstractController
{
    #[Route('/articles/{id?}', name: 'app_articles')]
    #[IsGranted('ROLE_USER')]
    public function index(CategoryRepository $categoryRepository, ArticleRepository $articleRepository, ?Category $category): Response
    {
        $categories = $categoryRepository->findAll();

         // Sélectionner la première catégorie par défaut si aucune n'est fournie
    if (!$category && !empty($categories)) {
        $category = $categories[0]; // Prend la première catégorie
    }


        $articles = $category ? $category->getArticles() : [];

        $articlesWithImages = [];
        foreach ($articles as $article) {
           $images = $article->getArticleImages();
           $firstImage = !$images->isEmpty() ? $images->first()->getImageName() : null;

           $articlesWithImages[] = [
               'article' => $article,
               'image' => $firstImage,
           ];
        }

        return $this->render('article/index.html.twig', [
            'categories' => $categories,
            'articles' => $articlesWithImages,
            'selectedCategory' => $category,
        ]);
    }
}
