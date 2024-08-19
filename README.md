# To-Do List Application

## Description
Cette application de gestion de tâches (To-Do List) permet aux utilisateurs de créer, lire, mettre à jour et supprimer des tâches. Le backend est développé en PHP avec une base de données MySQL, tandis que le frontend est construit en React.

## Structure du Projet

### Backend

Le backend est développé en PHP  et expose une API RESTful pour gérer les tâches.

- **API Endpoints** :
  - `POST /tasks` : Créer une nouvelle tâche.
  - `GET /tasks` : Récupérer la liste des tâches.
  - `PUT /tasks/:id` : Mettre à jour une tâche spécifique.
  - `DELETE /tasks/:id` : Supprimer une tâche spécifique.

- **Fichiers** :
  - `backend/api/get.php` : Endpoint pour récupérer les tâches.
  - `backend/api/post.php` : Endpoint pour créer une nouvelle tâche.
  - `backend/api/put.php` : Endpoint pour mettre à jour une tâche.
  - `backend/api/delete.php` : Endpoint pour supprimer une tâche.
  - `backend/connexion_bd.php` : Fichier de connexion à la base de données.
  - `backend/token/verifyToken.php` : Vérification du token de sécurité.
  - `backend/config/todolist_db` : base de donnees de l'application.

### Frontend

Le frontend est développé avec React et fournit une interface utilisateur pour interagir avec l'API.

- **Fichiers** :
  - `frontend/public/index.html` : Fichier HTML principal.
  - `frontend/src/components/Task.js` : Composant pour afficher une tâche.
  - `frontend/src/components/TaskForm.js` : Composant pour créer et éditer une tâche.
  - `frontend/src/components/TaskList.js` : Composant pour afficher la liste des tâches.
  - `frontend/src/components/TaskEditForm.js` : Composant pour éditer une tâche.
  - `frontend/src/App.js` : Composant principal de l'application.
  - `frontend/src/index.js` : Point d'entrée de l'application React.
  - `frontend/src/services/todoService.js` : Fonctions pour appeler l'API.

## Installation

### Backend

1. **Configuration de la base de données** :
   - Assurez-vous d'avoir une base de données MySQL en fonctionnement.
   - Créez une base de données et une table `tasks` avec les colonnes suivantes :
     - `id` : Identifiant unique (auto-incrémenté).
     - `title` : Titre de la tâche (obligatoire).
     - `description` : Description de la tâche (optionnelle).
     - `completed` : Statut de la tâche (boolean, par défaut false).
     - `created_at` et `updated_at` (facultatifs) : Horodatages pour la création et la mise à jour.

   - Configurez le fichier `backend/connexion_bd.php` avec vos informations de connexion à la base de données :
     ```php
     $pdo = new PDO('mysql:host=localhost;dbname=nom_de_votre_base', 'utilisateur', 'mot_de_passe');
     ```

2. **Démarrer le serveur PHP** :
   - Placez le dossier `backend` dans le répertoire web de votre serveur (par exemple, `htdocs` pour XAMPP ou `www` pour WAMP).
   - Accédez à l'URL correspondante dans votre navigateur, par exemple : `http://localhost/backend`.

### Frontend

1. **Installer les dépendances** :
   https://github.com/sounkalo20/todolistMitics.git
   cd todolistMitics
   npm install
   npm start
