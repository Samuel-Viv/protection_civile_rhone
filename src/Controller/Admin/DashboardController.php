<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\ArticleImage;
use App\Entity\Category;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        
            ->setTitle('<h4 class="mt-3">Protection Civile Rhône - Administration</h4>')
            ->setFaviconPath('assets/images/favicon/favicon.ico')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Navigation');
        yield MenuItem::linktoRoute('Accueil', 'fa fa-home', 'app_home');
        yield MenuItem::section('Base de données');
        yield MenuItem::linkToCrud('Utilisateur', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Articles', 'fa fa-newspaper-o', Article::class);
        yield MenuItem::section('Aide');
        yield MenuItem::linktoRoute('Création', 'fa-solid fa-lightbulb', 'app_help_new');
        yield MenuItem::linktoRoute('Editer', 'fa-solid fa-pencil', 'app_help_modif');
        yield MenuItem::linktoRoute('Détails', 'fa-solid fa-magnifying-glass', 'app_help_show');
    }
}
