# 🌱 PlanteWeb

Un projet de base de données et de site web permettant de gérer ses plantes, d’ajouter des notes personnelles et de suivre des événements liés à leur entretien.

## Description du projet

PlanteWeb est une application dont le but est d’aider un utilisateur à garder un suivi complet de ses plantes.  
Chaque utilisateur peut :

- Créer un compte (nom d’utilisateur + mot de passe).
- Se connecter pour accéder à son espace personnel.
- Ajouter une ou plusieurs plantes dans son espace.
- Ajouter des **notes personnelles** sur chacune de ses plantes.
- Enregistrer des **événements** (ex. arrosage, rempotage, engrais) avec une date et un commentaire.

## Structure de la base de données

La base de données `planteWeb` contient les tables suivantes :

- **utilisateur** : informations sur les membres inscrits (nom, email, mot de passe, date d’inscription).
- **plante** : chaque plante appartient à un utilisateur (nom, type, date d’acquisition).
- **note** : notes personnelles liées à une plante (titre, contenu).
- **typeEvenement** : liste des types d’événements possibles (arrosage, rempotage, etc.).
- **evenement** : événements datés associés à une plante (type, date, commentaire).

Les relations sont organisées avec des clés étrangères et l’option `ON DELETE CASCADE` pour garantir la cohérence des données :  
- Supprimer un utilisateur supprime aussi ses plantes, notes et événements.  
- Supprimer une plante supprime aussi ses notes et événements.
