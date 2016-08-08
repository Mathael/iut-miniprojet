Description :
Projet IUT 2 Grenoble 2015 - Mettre en place un interface web de gestion d'un planning scolaire.

Prérequis :
- Apache ou équivalent
- Module SQLITE

Installation :
Placez les fichiers dans le répertoire www ou dans public_html si vous êtes à l'IUT et que le fonctionnement n'a pas changé depuis 2015.
- Si les fichiers sont dans public_html il faut écrire la commande "setup-public-html" dans la console.

Pour finir il faut faire chmod ug+rwx sur le fichier database.bd.
Si ça ne fonctionne pas, il faudra alors tester les droits requis par "others".Dans le cas d'un test chmod 777 fera l'affaire.

REMARQUE:
- Le dossier DATA n'existe pas car nous n'avons pas suivi le "TP" (on à pas fais attention on avais déjà notre structure).
Nous avons donc à la place le dossier SQL.
- Le schema MVC est préservé grâce aux dossiers CONTROLERS, VIEWS et MODELS.
- Le dossier ANALYSIS contient notre rapport et nos diagrammes.
