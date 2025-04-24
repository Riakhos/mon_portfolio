# Mon Portfolio

Bienvenue dans le projet **Mon Portfolio**, une application Symfony permettant de présenter vos compétences, expériences, projets, et bien plus encore. Ce projet inclut des fonctionnalités telles que la gestion des utilisateurs, un tableau de bord administrateur, un blog, un formulaire de contact, et l'intégration de Google Sign-In.

---

## 🚀 Fonctionnalités principales

- **Page d'accueil** : Présentation des statistiques, compétences, frameworks, APIs, et services.
- **À propos** : Informations personnelles, expériences professionnelles, formations, et langues.
- **Projets** : Liste des projets avec détails, compétences utilisées, frameworks, et APIs.
- **Blog** : Articles de blog avec commentaires.
- **Espace membre** : Gestion des informations personnelles et des commentaires.
- **Tableau de bord administrateur** : Gestion des utilisateurs, projets, articles de blog, expériences, et services.
- **Formulaire de contact** : Envoi de messages avec possibilité de réponse via EasyAdmin.
- **Authentification avec Google** : Connexion et inscription via Google Sign-In.

---

## 🛠️ Technologies utilisées

- **Backend** : Symfony 6
- **Frontend** : Bootstrap 5, CSS personnalisé
- **Base de données** : MySQL
- **Authentification** : Symfony Security, Google Sign-In
- **Gestion des fichiers** : EasyAdmin
- **Autres** : Intégration des réseaux sociaux, gestion des cookies tiers

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
- `templates/register/index.html.twig` : Page d'inscription.
- `templates/login/index.html.twig` : Page de connexion.
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
    git clone https://github.com/riakhos/mon_portfolio.git
    cd mon_portfolio
    ```

2. Installez les dépendances :
    ```bash
    composer install
    ```

3. Configurez la base de données dans le fichier `.env` :
    ```bash
    DATABASE_URL="mysql://username:password@127.0.0.1:3306/mon_portfolio"
    ```

4. Créez la base de données et exécutez les migrations :
    ```bash
    symfony console doctrine:database:create
    symfony console doctrine:migrations:migrate
    ```

5. Configurez Google Sign-In dans le fichier `.env` :
    ```bash
    GOOGLE_CLIENT_ID=your-google-client-id
    ```

6. Installez les assets :
    ```bash
    symfony console assets:install public
    ```

7. Lancez le serveur Symfony :
    ```bash
    symfony server:start
    ```

8. Accédez à l'application dans votre navigateur :
    ```bash
    http://127.0.0.1:8000
    ```

---

## 🌟 Fonctionnalités spécifiques à Google Sign-In

- **Connexion via Google** : Les utilisateurs peuvent se connecter à leur compte en utilisant leur compte Google.
- **Inscription via Google** : Les nouveaux utilisateurs peuvent s'inscrire en utilisant leur compte Google.
- **Redirection intelligente** : Si un utilisateur tente de se connecter sans compte, il est redirigé vers la page d'inscription.

---

## 📜 Licence

- Ce projet est sous licence MIT.
- Vous êtes libre de l'utiliser, de le modifier et de le distribuer.

---

## 🙌 Remerciements

- Merci à tous les contributeurs et aux bibliothèques open-source utilisées dans ce projet.

---

## 📧 Contact

- Pour toute question ou suggestion, contactez-moi à **richard.bonnegent@gmail.com**.