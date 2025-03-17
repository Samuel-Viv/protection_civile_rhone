<?php

namespace App\Controller\Admin;

use App\Entity\Article;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;
use App\Form\ArticleImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ArticleCrudController extends AbstractCrudController
{
    use  Trait\ReadOnlyTrait;
    
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $previewAction = Action::new('preview', 'Aperçu de l\'articel', 'fa fa-external-link')
            ->linkToUrl(function (Article $article) {
                return $this->urlGenerator->generate('app_article_detail', ['id' => $article->getId()]);
            })
            ->setHtmlAttributes(['target' => '_blank']);
    
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $previewAction)
            ->add(Crud::PAGE_DETAIL, $previewAction)
            ->update(Crud::PAGE_INDEX, Action::EDIT, fn (Action $action) => $action)
            ->update(Crud::PAGE_INDEX, Action::DELETE, fn (Action $action) => $action);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('category')
                ->setLabel('Catégorie')
                ->setCrudController(CategoryCrudController::class),
            TextField::new('title')
                ->setLabel('Titre'),
            TextareaField::new('content')
                ->setLabel('Contenu de l\'article'),
            TextField::new('url_video')
                ->setLabel('Url youtube'),
            ImageField::new('file_video')
                ->setLabel('Vidéo à télécharger')
                ->setUploadDir('public/uploads/videos')
                ->setBasePath('/uploads/videos')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFileConstraints([
                    new File([
                        'maxSize' => '100M',
                        'mimeTypes' => [
                            'video/mp4',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une vidéo valide (MP4)',
                        'maxSizeMessage' => 'Veuillez télécharger une vidéo valide 100M maximum'
                    ]),
                ])
                ->setRequired(false),
            
            CollectionField::new('articleImages')
            ->setLabel('Images')
            ->setEntryType(ArticleImageType::class)
            ->setTemplatePath('admin/fields/article_image.html.twig'),
                
            TextField::new('author')
            ->setLabel('Auteur'),

            DateTimeField::new('created_at', 'Créé le ')
                ->onlyOnDetail(),

            DateTimeField::new('updated_at', 'Mis à jour le')
                ->onlyOnDetail(),
            
            BooleanField::new('isPublished', 'Publié'),
            
            BooleanField::new('isFeatured', 'En avant'),
        ];
    }
}
