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
    // Récupérer l'article de bienvenue s'il est en avant et publié
    $welcomeArticle = $articleRepository->findOneBy([
        'isWelcome' => true,
        'isFeatured' => true,
        'isPublished' => true,
    ]);

    // Récupérer les autres articles en avant (exclure l'article de bienvenue s'il existe)
    $criteria = [
        'isFeatured' => true,
        'isPublished' => true,
    ];
    $order = ['created_at' => 'DESC'];

    $otherArticles = $articleRepository->findBy($criteria, $order, 6);

    // S'il y a un article de bienvenue, l'enlever de la liste pour ne pas l'avoir en double
    if ($welcomeArticle) {
        $otherArticles = array_filter($otherArticles, function ($a) use ($welcomeArticle) {
            return $a->getId() !== $welcomeArticle->getId();
        });
        // Le placer en premier
        array_unshift($otherArticles, $welcomeArticle);
    }

    // Construire le tableau final avec image
    $articles = [];
    foreach ($otherArticles as $article) {
        $images = $article->getArticleImages();
        $firstImage = $images->isEmpty() ? null : $images->first();
        $articles[] = [
            'article' => $article,
            'image' => $firstImage ? $firstImage->getImageName() : null,
        ];
    }

        // Renvoie la réponse avec les articles en avant et leurs images
        return $this->render('home/index.html.twig', [
            'articles' => $articles, // Passer les articles avec images à la vue
        ]);
    }
}
