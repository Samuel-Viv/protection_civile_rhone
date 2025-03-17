<?php

namespace App\Tests\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ArticleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;


    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testArticlesPage()
    {
        // Se connecter avec un utilisateur ayant ROLE_USER (ajoute un utilisateur en base si nécessaire)
        $this->client->loginUser($this->entityManager->getRepository(User::class)->findOneBy(['username' => 'admin']));
        // Récupérer une catégorie (ou en créer une si nécessaire)
        $category = $this->entityManager->getRepository(Category::class)->findOneBy([]);

        if (!$category) {
            $this->fail('Aucune catégorie trouvée dans la base de données.');
        }


        // Accéder à la page des articles avec une catégorie
        $this->client->request('GET', '/articles/' . $category->getId());

        // Vérifier que la réponse est un succès (200 OK)
        $this->assertResponseIsSuccessful();

        // Vérifier que la catégorie est bien affichée
        $this->assertSelectorTextContains('.nav-li a.active', $category->getNameCategory());

        // Récupérer un article publié de cette catégorie
        $article = $this->entityManager->getRepository(Article::class)->findOneBy(['isPublished' => true]);
        // Vérifier que le titre de l'article est bien présent
        $this->assertSelectorTextContains('h5', $article->getTitle());
    }
}
