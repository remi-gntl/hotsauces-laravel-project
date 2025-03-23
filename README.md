# HotSauces 🔥 - Projet Laravel 

## Description
Ce projet est une application web développée avec Laravel permettant aux utilisateurs d'ajouter leurs sauces préférées, ainsi que de liker ou disliker les sauces ajoutées par les autres.
Développé dans le cadre de la ressource R4.01 Architecture logicielle du Semestre 4

## Fonctionnalités
- Inscription et authentification des utilisateurs
- Ajout d'une nouvelle sauce avec image et description
- Affichage de la liste des sauces disponibles
- Modification et suppression d'une sauce par son créateur
- Like / Dislike des sauces par les utilisateurs
- API REST pour gérer les sauces

## Modèles
### Sauce
| Champ           | Type     | Description |
|---------------|---------|-------------|
| userId        | String  | Identifiant unique de l'utilisateur qui a créé la sauce |
| name          | String  | Nom de la sauce |
| manufacturer  | String  | Fabricant de la sauce |
| description   | String  | Description de la sauce |
| mainPepper    | String  | Principal ingrédient épicé |
| imageUrl      | String  | URL de l'image de la sauce |
| heat          | Number  | Niveau de piquant (1 à 10) |
| likes        | Number  | Nombre de likes |
| dislikes      | Number  | Nombre de dislikes |
| usersLiked    | Array   | Liste des utilisateurs ayant liké |
| usersDisliked | Array   | Liste des utilisateurs ayant disliké |

### Utilisateur
| Champ     | Type   | Description |
|-----------|-------|-------------|
| email     | String | Adresse e-mail (unique) |
| password  | String | Mot de passe haché |

## Installation
1. Cloner le dépôt :
```bash
 git clone https://github.com/remi-gntl/hotsauces-laravel-project.git
```
2. Installer les dépendances :
```bash
composer install
```
3. Configurer l'environnement :
```bash
cp .env.example .env
php artisan key:generate
```
4. Configurer la base de données dans `.env` puis exécuter :
```bash
php artisan migrate
```
5. Lancer le serveur :
```bash
php artisan serve
```

## Routes principales
| Méthode | Route | Description |
|---------|-------|-------------|
| GET | /sauces | Liste toutes les sauces |
| GET | /sauces/{id} | Affiche une sauce spécifique |
| POST | /sauces | Ajoute une nouvelle sauce |
| PUT | /sauces/{id} | Modifie une sauce existante |
| DELETE | /sauces/{id} | Supprime une sauce |
| POST | /sauces/{id}/like | Like / Dislike une sauce |

## API
L'application peut être utilisée comme une API REST pour interagir avec les sauces via les routes définies ci-dessus.

## Auteur
- Rémi Gentil
