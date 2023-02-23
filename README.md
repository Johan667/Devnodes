DEVNODES

Installation du projet en local

1. Suivez les instructions pour cloner le dépôt sur votre système. Vous pouvez le faire en utilisant la commande git clone dans votre terminal. Le dépôt est disponible à l'adresse https://github.com/Johan667/Devnodes.git, vous pouvez cloner le dépôt en exécutant la commande suivante :
git clone https://github.com/Johan667/Devnodes.git

2. Exécutez la commande composer install pour installer les dépendances de l'application
composer install

3. Une fois que vous avez suivi toutes les étapes d'installation, vous pouvez lancer l'application Symfony en exécutant la commande symfony server:start
Ouvrez votre navigateur web et accédez à l'URL indiquée dans les instructions d'installation pour voir l'application en action.

4. Pour avoir la base donnée, exécutez la commande symfony d:d:c, cela vous créera la base de donnée configuré dans le .env
symfony d:d:c

5. Vous avez plus qu'à faire un symfony d:m:m pour migrer la version du site.
symfony d:m:m

C'est tout ! Si vous avez suivi toutes ces étapes correctement, vous devriez maintenant avoir une application Symfony installée et en cours d'exécution sur votre système. 



Installation du projet en production

1.    Clonez votre dépôt GitHub sur votre serveur de production à l'aide de la commande git clone. Assurez-vous que vous avez installé Git sur votre serveur de production.
      Voici le lien du dépôt : https://github.com/Johan667/Devnodes.git

2.    Une fois que vous avez cloné votre dépôt sur votre serveur de production,

3.    Installez les dépendances de l'application Symfony en utilisant la commande Composer install.

4.    Si Composer n'est pas encore installé sur votre serveur, suivez les instructions pour l'installer.

5.    Configurez votre environnement de production en modifiant le fichier app/config/parameters.yml. Vous devrez mettre à jour les paramètres de base de données, d'authentification, etc. pour refléter votre environnement de production.

6.    Configurez votre serveur web pour pointer vers le répertoire web de votre application Symfony. Vous pouvez utiliser un serveur web tel que Apache ou Nginx pour cela.

7. Enfin, utilisez mRemote pour vous connecter à votre serveur de production et exécuter les commandes nécessaires pour démarrer votre application Symfony.
La première étape consiste à installer les dépendances du projet en exécutant la commande suivante : composer install --no-dev --optimize-autoloader
Cette commande installe les dépendances de l'application Symfony sans les dépendances de développement et optimise le chargement automatique des classes.

Ensuite, vous devez configurer votre environnement en exécutant la commande suivante :
php bin/console cache:clear --env=prod
Cette commande nettoie le cache de l'application et configure l'environnement de production.
Enfin, vous pouvez lancer votre application en utilisant un serveur web. Pour cela, vous pouvez utiliser le serveur web intégré de Symfony en exécutant la commande suivante :

php bin/console server:start --env=prod
Cette commande démarre le serveur web de développement de Symfony en mode production.