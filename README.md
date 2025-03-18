Projet de site interne pour la protection civil du Rhone.

1/ Prérequis:

Composer
Xampp
VsCode
Php (version 8.2 minimum)
Symfony (version 5)

2/ Installation:

Créer un répertoire "procetion_civile" dans le répertoire "htdocs" dans xampp. Dans VsCode ouvrer votre répertoire "protection_civile" et taper dans le terminal 'cd <nom du répertoire>' ensuite 'git clone https://github.com/Samuel-Viv/protection_civile_rhone.git 'afin de télécharger le projet. Taper ensuite dans le terminal 'composer install' Installation de la base de donnée taper:
</br>
php bin/console doctrine:database:create.
</br>
php bin/console doctrine:migrations:migrate.
</br>
Création des fixtures: php bin/console doctrine:fixtures:load

3/ Faire les tests unitaire

Vous devez écrire dans le terminal 'php bin/console doctrine:database:create --env=test'.
</br>
Ensuite 'php bin/console doctrine:schema:update --force --env=test'.
</br>
'php bin/console doctrine:fixtures:load --env=test'.
</br>
Et enfin pour lancer les tests 'php bin/phpunit'.
