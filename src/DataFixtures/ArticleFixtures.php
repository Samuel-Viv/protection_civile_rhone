<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleImage;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création de quelques catégories fictives
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setNameCategory($faker->word());
            $manager->persist($category);
            $categories[] = $category;
        }

        // Création de 10 articles fictifs
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(6))
                ->setContent($faker->paragraph(10))
                ->setAuthor($faker->name())
                ->setIsPublished($i < 5)
                ->setIsFeatured($i < 5)
                ->setUrlVideo($faker->boolean() ? $faker->url() : null)
                ->setFileVideo($faker->boolean() ? 'video' . $i . '.mp4' : null)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            // Attribution aléatoire de 1 à 3 catégories
            $randomCategories = $faker->randomElements($categories, rand(1, 3));
            foreach ($randomCategories as $category) {
                $article->addCategory($category);
            }

            // Ajout d'une image associée
            $articleImage = new ArticleImage();
            $imageName = 'camion.jpg';
            $articleImage->setImageName($imageName)
                ->setArticle($article)
                ->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($article);
            $manager->persist($articleImage);
        }

        $manager->flush();
    }
}