<?php

namespace App\Controller\Admin\Trait;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

trait ReadOnlyTrait
{
    public function configureActions(Actions $actions):Actions
    {
        $actions ->add (Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::INDEX) // Ajoute un bouton retour sur la page de modification
            ->add(Crud::PAGE_NEW, Action::INDEX)  
            ->update(Crud::PAGE_EDIT, Action::INDEX, function (Action $action) {
                return $action->setLabel('⬅ Retour à la liste'); // Renomme le bouton en mode édition
            })
            ->update(Crud::PAGE_NEW, Action::INDEX, function (Action $action) {
                return $action->setLabel('⬅ Retour à la liste'); // Renomme le bouton en mode création
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action->setLabel('⬅ Retour à la liste');
            });

        return $actions;
    }
}