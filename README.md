Projet de site interne pour la protection civil du Rhone.

1/ Prérequis:

Composer
Xampp
VsCode
Php (version 8.2 minimum)
Symfony (version 5)

2/ Installation:

Créer un répertoire "procetion_civile" dans le répertoire "htdocs" dans xampp. Dans VsCode ouvrer votre répertoire "protection_civile" et taper dans le terminal 'cd <nom du répertoire>' ensuite 'git clone https://github.com/Samuel-Viv/protection_civile_rhone.git 'afin de télécharger le projet. Taper ensuite dans le terminal 'composer install' Installation de la base de donnée taper:

php bin/console doctrine:database:create

php bin/console doctrine:migrations:migrate 

Création des fixtures: php bin/console doctrine:fixtures:load
