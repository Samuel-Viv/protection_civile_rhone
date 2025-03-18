<h1>Projet de site interne pour la protection civil du Rhone.</h1>

<h2>1/ Prérequis: </h2>

Composer
Xampp
VsCode
Php (version 8.2 minimum)
Symfony (version 5)

<h2>2/ Installation:</h2>

Créer un répertoire "procetion_civile" dans le répertoire "htdocs" dans xampp. Dans VsCode ouvrer votre répertoire "protection_civile" et taper dans le terminal 'cd <nom du répertoire>' ensuite 'git clone https://github.com/Samuel-Viv/protection_civile_rhone.git 'afin de télécharger le projet. Taper ensuite dans le terminal 'composer install' Installation de la base de donnée taper:
</br>
<em>php bin/console doctrine:database:create</em>
</br>
<em>php bin/console doctrine:migrations:migrate</em>
</br>
Création des fixtures: <em>php bin/console doctrine:fixtures:load </em>

<h2>3/ Faire les tests unitaire</h2>

Vous devez écrire dans le terminal <em>php bin/console doctrine:database:create --env=test</em>.
</br>
Ensuite <em>php bin/console doctrine:schema:update --force --env=test</em>.
</br>
<em>php bin/console doctrine:fixtures:load --env=test</em>
</br>
Et enfin pour lancer les tests <em>php bin/phpunit</em>.
