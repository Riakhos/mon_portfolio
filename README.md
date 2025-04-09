# Mon Portfolio

Bienvenue dans le projet **Mon Portfolio**, une application Symfony permettant de présenter vos compétences, expériences, projets, et bien plus encore. Ce projet inclut des fonctionnalités telles que la gestion des utilisateurs, un tableau de bord administrateur, un blog, et un formulaire de contact.

---

## 🚀 Fonctionnalités principales

- **Page d'accueil** : Présentation des statistiques, compétences, frameworks, APIs, et services.
- **À propos** : Informations personnelles, expériences professionnelles, formations, et langues.
- **Projets** : Liste des projets avec détails, compétences utilisées, frameworks, et APIs.
- **Blog** : Articles de blog avec commentaires.
- **Espace membre** : Gestion des informations personnelles et des commentaires.
- **Tableau de bord administrateur** : Gestion des utilisateurs, projets, articles de blog, expériences, et services.
- **Formulaire de contact** : Envoi de messages avec possibilité de réponse via EasyAdmin.

---

## 🛠️ Technologies utilisées

- **Backend** : Symfony 6
- **Frontend** : Bootstrap 5, CSS personnalisé
- **Base de données** : MySQL
- **Authentification** : Symfony Security
- **Gestion des fichiers** : EasyAdmin
- **Autres** : Google Sign-In, gestion des réseaux sociaux

---

## 📂 Structure du projet

### **Dossiers principaux**

- `src/Controller` : Contient les contrôleurs pour les différentes fonctionnalités.
- `src/Entity` : Définit les entités utilisées dans la base de données.
- `src/Form` : Définit les formulaires utilisés dans l'application.
- `templates` : Contient les fichiers Twig pour le rendu des pages.
- `public/uploads` : Contient les fichiers téléchargés (images, CV, etc.).

### **Fichiers importants**

- `templates/home/index.html.twig` : Page d'accueil.
- `templates/home/about.html.twig` : Page "À propos".
- `templates/account/index.html.twig` : Espace membre.
- `templates/admin/dashboard.html.twig` : Tableau de bord administrateur.

---

## ⚙️ Installation

### **Prérequis**

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- MySQL

### **Étapes**

1. Clonez le dépôt :
    ```bash
    git clone https://github.com/votre-utilisateur/mon_portfolio.git
    cd mon_portfolio
    ```

2. Installez les dépendances :
    ```bash
    composer install
    ```

3. Configurez la base de données dans le fichier .env :
    ```bash
    DATABASE_URL="mysql://username:password@127.0.0.1:3306/mon_portfolio"
    ```

4. Créez la base de données et exécutez les migrations :
    ```bash
    symfony console doctrine:database:create
    symfony console doctrine:migrations:migrate
    ```

5. Installez les assets :
    ```bash
    symfony console assets:install public
    ```

6. Lancez le serveur Symfony :
    ```bash
    symfony server:start
    ```

7. Accédez à l'application dans votre navigateur :
    ```bash
    [composer install](http://127.0.0.1:8000)
    ```

### **Informations supplémentaires :**

1. 🖼️ **Captures d'écran**
   - Page d'accueil
        ![Page d'accueil](public/screenshots/homepage.png)
   - Tableau de bord administrateur
        ![Tableau de bord administrateur](public/screenshots/admin_dashboard.png)
        
2. 📜 **Licence**
    - Ce projet est sous licence MIT.
    - Vous êtes libre de l'utiliser, de le modifier et de le distribuer.

3. 🙌 **Remerciements**
    - Merci à tous les contributeurs et aux bibliothèques open-source utilisées dans ce projet.

4. 📧 **Contact**
    - Pour toute question ou suggestion
    - Contactez-moi à richard.bonnegent@gmail.com.