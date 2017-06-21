Projet-5-OC2
============

A Symfony project created on April 20, 2017, 1:21 pm.



Installation
------------

1) Clôner le repository Projet-5-OC

2) A la racine du projet, mettre à jour le composer : php composer.phar update

3) Compléter le fichier parameters.yml sur l'exemple de parameters.yml.dist
  - Connexion à une boîte mail d'envois
  - Connexion à la base de donnée
  - Clé Api google map
  
4) Créer la base de donnée sur le serveur local : php bin/console doctrine:database:create

5) Charger les tables doctrines dans la base de donnée : php bin/console doctrine:schema:update --force

6) Charger les fixtures : php bin/console doctrine:fixtures:load

7) Enjoy :)

