<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[IsGranted('ROLE_USER')]
    public function index(ArticleRepository $articleRepository): Response
    {
         // Recherche des articles en avant et publiés, triés par date de création (6 articles max)
         $featuredArticles = $articleRepository->findBy(
            ['isFeatured' => true, 'isPublished' => true], // Conditions : en avant et publié
            ['created_at' => 'DESC'],
            6
        );

        // Passer les articles et leurs premières images à la vue
        $articles = [];
        foreach ($featuredArticles as $article) {
            $images = $article->getArticleImages();  // Récupérer les images associées à l'article
            $firstImage = $images->isEmpty() ? null : $images->first(); // Si des images existent, prendre la première
            $articles[] = [
                'article' => $article,
                'image' => $firstImage ? $firstImage->getImageName() : null // Récupérer le nom du fichier de l'image
            ];
        }

        // Renvoie la réponse avec les articles en avant et leurs images
        return $this->render('home/index.html.twig', [
            'articles' => $articles, // Passer les articles avec images à la vue
        ]);
    }
}
