<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HelpController extends AbstractController
{
    #[Route('/help/new', name: 'app_help_new')]
    public function new(): Response
    {
        return $this->render('admin/new.html.twig');
    }

    #[Route('/help/modif', name: 'app_help_modif')]
    public function modif(): Response
    {
        return $this->render('admin/modif.html.twig');
    }

    #[Route('/help/show', name: 'app_help_show')]
    public function show(): Response
    {
        return $this->render('admin/show.html.twig');
    }
}
