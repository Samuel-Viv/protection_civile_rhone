<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleDetailController extends AbstractController
{
    #[Route('/article/detail/{id<\d+>}', name: 'app_article_detail')]
    public function index(ArticleRepository $articleRepository, int $id): Response
    {
        $article = $articleRepository->find($id);

        if (!$article) {
            throw $this->createNotFoundException('The article does not exist');
        }
        
        return $this->render('article_detail/index.html.twig', [
            'article' => $article,
            'images' => $article->getArticleImages(),
        ]);
    }
}
