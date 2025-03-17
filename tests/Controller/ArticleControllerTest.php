<?php

namespace App\Tests\Controller;

use App\Entity\Article;
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

    public function testHomePage()
    {
        // Se connecter avec un utilisateur ayant ROLE_USER (ajoute un utilisateur en base si nécessaire)
        $this->client->loginUser($this->entityManager->getRepository(User::class)->findOneBy(['username' => 'admin']));

          // Récupérer un article aléatoire depuis la base de données
          $article = $this->entityManager->getRepository(Article::class)->findOneBy([]);

          // Si aucun article n'est trouvé, échouer le test
          if (!$article) {
              $this->fail('Aucun article trouvé dans la base de données.');
          }
  

        // Accéder à la page des articles
        $this->client->request('GET', '/article/detail/' . $article->getId());

        // Vérifier que la réponse est un succès (200 OK)
        $this->assertResponseIsSuccessful();

        // Vérifier que le titre de l'article et le contune sont présents dans la page
        $this->assertSelectorTextContains('h1', $article->getTitle());
        $this->assertSelectorTextContains('p', $article->getContent());

    }
}
