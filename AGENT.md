# AGENTS.md

# DarGuest — Plateforme de conciergerie intelligente pour locations saisonnières

Version: 3.0 (Édition détaillée)
Author: Hassan AFTAH
Stack: Laravel 13 + MySQL + FastAPI + Docker + GitHub Actions

Ce document est la source de vérité unique du projet. Il couvre : le contexte métier, l'architecture, le schéma de base de données complet, le code de référence (migrations, modèles, requêtes, policies, contrôleurs, routes, tests), le service IA FastAPI, la conteneurisation, l'intégration continue, et la feuille de route détaillée.

---

# Table des matières

1. Vue d'ensemble du projet
2. Problème métier
3. Objectifs du projet
4. Acteurs et matrice de permissions
5. Stack technique complète
6. Architecture globale
7. Modèle de données — vue conceptuelle
8. Migrations Laravel complètes (10 tables)
9. Modèles Eloquent complets
10. Form Requests complètes
11. Policies complètes
12. Structure des Contrôleurs
13. Services métier
14. Routes (web.php et api.php)
15. Référence API complète (tous les endpoints)
16. Ressources API (API Resources)
17. Jobs & Queues
18. Notifications Laravel
19. Service IA — FastAPI complet
20. Seeders & Factories
21. Tests Pest
22. Docker & Docker Compose
23. GitHub Actions (CI/CD)
24. Documentation API (Scribe)
25. Sécurité & bonnes pratiques
26. Gestion des erreurs et codes HTTP
27. Variables d'environnement
28. Convention de nommage
29. Convention Git & branches
30. Feuille de route détaillée (15 phases)
31. Definition of Done
32. Checklist finale complète
33. Glossaire
34. Annexes

---

# 1. Vue d'ensemble du projet

DarGuest est une plateforme de conciergerie intelligente destinée aux propriétaires de locations saisonnières (type Airbnb, Booking.com), principalement situés à Agadir et Taghazout, au Maroc.

L'objectif central du projet est d'automatiser la communication entre les propriétaires de logements et leurs voyageurs grâce à l'Intelligence Artificielle, tout en gardant le propriétaire dans la boucle pour les décisions importantes et les urgences.

## 1.1 Constat de départ

Chaque jour, un propriétaire de location saisonnière reçoit un grand nombre de messages de la part de ses voyageurs. La très large majorité de ces messages concernent toujours les mêmes sujets :

- Le mot de passe du réseau Wi-Fi.
- Les horaires de check-in et de check-out.
- Le règlement intérieur du logement.
- Les instructions d'accès (clés, digicode, boîte à clés, etc.).
- Les informations de stationnement.
- Les recommandations locales (restaurants, plages, écoles de surf, taxis, pharmacies).
- Les urgences (fuite d'eau, panne électrique, incendie, perte de clés).

Répondre individuellement à chacune de ces demandes représente une charge de travail répétitive, chronophage, et qui laisse peu de place aux tâches à réelle valeur ajoutée (accueil personnalisé, gestion des urgences, amélioration du logement, etc.).

## 1.2 La solution proposée

DarGuest permet à chaque propriétaire de renseigner une seule fois, pour chaque logement, l'ensemble des informations utiles. Lorsqu'un voyageur envoie un message, le système :

1. Détecte automatiquement la langue utilisée par le voyageur.
2. Identifie la catégorie de la demande (Wi-Fi, check-in, recommandation, urgence, etc.).
3. Évalue le niveau d'urgence de la demande.
4. Recherche les informations pertinentes dans la fiche du logement concerné.
5. Génère une réponse contextualisée, dans la langue du voyageur si possible.
6. Alerte immédiatement le propriétaire si une urgence est détectée.

Le propriétaire garde toujours la main : il peut consulter l'historique de toutes les analyses IA, répondre manuellement à tout moment, et recevoir une notification pour chaque nouveau message ou urgence.

## 1.3 Exemples concrets de questions traitées automatiquement

- "What is the Wi-Fi password?"
- "À quelle heure est le check-in ?"
- "¿Puedo aparcar cerca del apartamento?"
- "Können Sie ein gutes Restaurant empfehlen?"
- "هل يوجد صيدلية بالقرب من الشقة؟"

## 1.4 Exemples concrets d'urgences détectées automatiquement

- Fuite d'eau dans la salle de bain.
- Coupure d'électricité générale.
- Départ de feu / odeur de brûlé.
- Perte des clés du logement.
- Porte d'entrée bloquée ou cassée.
- Urgence médicale d'un voyageur.

## 1.5 Philosophie du projet

L'IA n'a pas pour objectif de remplacer le propriétaire, mais de :

- Réduire drastiquement le temps consacré aux réponses répétitives.
- Garantir une disponibilité 24h/24 pour les questions simples.
- Améliorer la réactivité en cas d'urgence réelle.
- Laisser le propriétaire se concentrer sur les situations qui nécessitent réellement son intervention humaine.

---

# 2. Problème métier

## 2.1 Constats de cadrage projet

- Un propriétaire gérant 3 à 5 logements peut recevoir en moyenne 15 à 30 messages par jour en haute saison.
- Une estimation raisonnable situe à plus de 70% la part des messages qui concernent des informations déjà connues et statiques (Wi-Fi, horaires, règlement).
- Le délai moyen de réponse manuelle dégrade l'expérience voyageur, en particulier en cas d'urgence survenant la nuit.

## 2.2 Conséquences du problème

| Conséquence | Impact |
|---|---|
| Temps perdu | Réponses répétitives chronophages |
| Réponses tardives | Frustration du voyageur |
| Expérience dégradée | Avis négatifs, baisse de réputation |
| Urgences mal gérées | Risque matériel ou humain accru |
| Charge mentale | Fatigue du propriétaire multi-logements |

## 2.3 Solution apportée par DarGuest

DarGuest introduit un concierge IA capable de comprendre les demandes en langage naturel, dans plusieurs langues, et de générer des réponses fiables car strictement basées sur les données enregistrées par le propriétaire — jamais inventées.

---

# 3. Objectifs du projet

## 3.1 Objectif principal

Développer une plateforme web de conciergerie intelligente permettant d'améliorer la communication entre propriétaires de locations saisonnières et voyageurs.

## 3.2 Objectifs fonctionnels détaillés

L'application devra permettre de :

- Gérer les comptes des propriétaires et des voyageurs (inscription, connexion, profil).
- Gérer plusieurs logements par propriétaire, avec leurs images et informations complètes.
- Centraliser toutes les informations relatives aux logements (Wi-Fi, horaires, règlement, accès, parking).
- Gérer des recommandations locales par catégorie (restaurants, plages, taxis, pharmacies, etc.).
- Permettre aux voyageurs de réserver un logement et de consulter leurs réservations.
- Faciliter les échanges entre propriétaires et voyageurs via un système de conversation.
- Automatiser les réponses aux questions fréquentes grâce à l'Intelligence Artificielle.
- Détecter automatiquement les situations urgentes.
- Notifier immédiatement le propriétaire lorsqu'une urgence est détectée.
- Réduire le temps consacré aux réponses manuelles.
- Améliorer l'expérience utilisateur des voyageurs.
- Fournir une API REST sécurisée, documentée et facilement exploitable.

## 3.3 Objectifs techniques

- Développer une API REST complète avec Laravel 13.
- Sécuriser l'API avec Laravel Sanctum (Bearer Token).
- Fournir une interface web de démonstration avec Blade.
- Isoler le traitement IA dans un microservice FastAPI indépendant.
- Garantir un traitement fiable des réponses IA au format JSON structuré.
- Couvrir le code par des tests automatisés Pest.
- Conteneuriser l'application avec Docker.
- Mettre en place une intégration continue avec GitHub Actions.
- Déployer l'application sur une plateforme Cloud.
- Documenter intégralement l'API avec Scribe.

---

# 4. Acteurs et matrice de permissions

L'application comporte deux types d'utilisateurs, stockés dans une seule table `users` avec une colonne `role` (`owner` ou `guest`). Aucun rôle administrateur n'est prévu en version 1.

## 4.1 Owner (Propriétaire)

Le propriétaire est responsable de la gestion de ses logements et de la relation avec ses voyageurs.

Il peut :
- Créer un compte et se connecter.
- Gérer son profil (nom, email, téléphone, avatar, mot de passe).
- Créer, modifier et supprimer plusieurs logements.
- Ajouter, réordonner et supprimer plusieurs images par logement.
- Renseigner toutes les informations utiles du logement (Wi-Fi, check-in, check-out, règlement, parking, accès).
- Ajouter, modifier et supprimer des recommandations locales.
- Consulter les réservations de tous ses logements.
- Consulter les conversations liées à ses logements.
- Répondre manuellement aux voyageurs.
- Consulter l'historique des analyses IA de chaque message.
- Recevoir des notifications lors de nouveaux messages.
- Être averti immédiatement lorsqu'une urgence est détectée.
- Consulter son tableau de bord (statistiques globales).

## 4.2 Guest (Voyageur)

Le voyageur est un utilisateur ayant réservé (ou souhaitant réserver) un logement.

Il peut :
- Créer un compte et se connecter.
- Gérer son profil.
- Consulter les logements disponibles.
- Réserver un logement disponible.
- Consulter la liste et le détail de ses réservations.
- Accéder aux conversations liées à ses réservations.
- Envoyer des messages au propriétaire.
- Recevoir automatiquement les réponses générées par l'IA.
- Consulter l'historique de ses conversations.
- Recevoir des notifications concernant ses réservations et ses échanges.
- Consulter son tableau de bord.

## 4.3 Matrice de permissions (résumé)

| Action | Owner | Guest |
|---|---|---|
| Créer un logement | ✅ (le sien) | ❌ |
| Modifier un logement | ✅ (le sien) | ❌ |
| Supprimer un logement | ✅ (le sien) | ❌ |
| Consulter les logements disponibles | ✅ | ✅ |
| Réserver un logement | ❌ | ✅ |
| Consulter ses réservations | ✅ (celles de ses logements) | ✅ (les siennes) |
| Envoyer un message | ✅ (réponse) | ✅ (question) |
| Consulter une conversation | ✅ (les siennes) | ✅ (les siennes) |
| Ajouter une recommandation | ✅ (son logement) | ❌ |
| Consulter les analyses IA | ✅ | ❌ |
| Recevoir des notifications | ✅ | ✅ |

Toute vérification d'accès doit passer par une **Laravel Policy** dédiée à la ressource concernée (voir section 11).

---

# 5. Stack technique complète

## 5.1 Backend

| Composant | Version / Détail |
|---|---|
| Laravel | 13.x |
| PHP | 8.3 |
| Blade | Interface web de démonstration |
| Laravel Breeze | Authentification web (register/login/logout/reset) |
| Laravel Sanctum | Authentification API par Bearer Token |
| Laravel Form Requests | Validation des entrées |
| Laravel API Resources | Normalisation des réponses JSON |
| Laravel Policies | Gestion des autorisations |
| Laravel Jobs & Queues | Traitement IA asynchrone |
| Laravel HTTP Client | Communication avec le microservice FastAPI |
| Laravel Notifications | Notifications in-app / mail / broadcast |

## 5.2 Service IA (Python)

| Composant | Version / Détail |
|---|---|
| Python | 3.11+ |
| FastAPI | Framework du microservice IA |
| Uvicorn | Serveur ASGI |
| Pydantic | Schémas de validation des payloads |
| python-dotenv | Gestion des variables d'environnement |
| Client LLM | OpenAI SDK (ou équivalent, configurable) |

## 5.3 Base de données

| Composant | Détail |
|---|---|
| SGBD | MySQL 8.x |
| ORM | Eloquent |
| Structure | Migrations |
| Données de démo | Seeders + Factories |

## 5.4 Tests

| Composant | Détail |
|---|---|
| Framework | Pest |
| Types | Feature Tests, Unit Tests |
| Couverture visée | Authentification, CRUD logements, réservations, conversations, IA (mock HTTP), policies |

## 5.5 Outils de développement

Visual Studio Code, Git, GitHub, Composer, Node.js, npm, Postman.

## 5.6 Conteneurisation

Docker, Docker Compose (services : `app`, `mysql`, `nginx`, `ai-service`, `redis` pour les queues).

## 5.7 Intégration continue

GitHub Actions : lint, tests Pest, build Docker, (optionnel) déploiement automatique.

## 5.8 Documentation

Scribe (documentation API générée depuis les annotations de contrôleurs), README.md, ce fichier AGENTS.md.

---

# 6. Architecture globale

## 6.1 Schéma d'architecture

```
                        ┌─────────────────────┐
                        │   Navigateur Web    │
                        │  (Owner / Guest)    │
                        └──────────┬──────────┘
                                   │
                    ┌──────────────┴──────────────┐
                    │                              │
            Interface Blade                 Client API externe
           (Breeze + sessions)             (Bearer Token Sanctum)
                    │                              │
                    └──────────────┬───────────────┘
                                   │
                         ┌─────────▼─────────┐
                         │     Laravel 13      │
                         │  (Controllers,      │
                         │   Services,          │
                         │   Policies,          │
                         │   Form Requests)     │
                         └─────────┬───────────┘
                                   │
                    ┌──────────────┼───────────────┐
                    │              │               │
             ┌──────▼─────┐ ┌──────▼──────┐ ┌──────▼──────┐
             │   MySQL    │ │ Redis Queue │ │ Notifications│
             │ (Eloquent) │ │  (Jobs)     │ │  (mail/db)  │
             └────────────┘ └──────┬──────┘ └─────────────┘
                                   │
                          Job: AnalyzeMessageJob
                                   │
                         ┌─────────▼─────────┐
                         │   HTTP Client       │
                         │ (Laravel → FastAPI)│
                         └─────────┬───────────┘
                                   │
                         ┌─────────▼─────────┐
                         │      FastAPI        │
                         │  (Service IA        │
                         │   indépendant)      │
                         └─────────┬───────────┘
                                   │
                         ┌─────────▼─────────┐
                         │        LLM          │
                         └─────────┬───────────┘
                                   │
                          JSON structuré
                                   │
                         ┌─────────▼─────────┐
                         │   Laravel stocke     │
                         │   AI_Analysis        │
                         │   + notifie si       │
                         │   urgence            │
                         └─────────────────────┘
```

## 6.2 Répartition des responsabilités

**Laravel gère :**
Authentification, autorisation, base de données, dashboard, logements, réservations, recommandations, conversations, notifications, règles métier, vues, orchestration des Jobs.

**FastAPI gère uniquement :**
Détection de langue, classification d'intention, détection d'urgence, génération de réponse, prompt engineering, communication avec le LLM, retour JSON structuré. Le service Python n'écrit jamais directement en base de données — Laravel reste la source de vérité unique.

## 6.3 Flux de communication détaillé

1. Le voyageur envoie un message via l'API ou l'interface Blade.
2. Laravel valide la requête (Form Request) et enregistre le message (statut initial : en attente d'analyse).
3. Laravel dispatch un `AnalyzeMessageJob` dans une queue dédiée (`ai-analysis`).
4. Le Job récupère les informations du logement concerné (Property + PropertyInfo + Recommendations).
5. Le Job envoie une requête HTTP POST vers `FastAPI /api/analyze` avec un payload structuré.
6. FastAPI traite la demande et retourne un JSON structuré.
7. Laravel valide le JSON reçu (champs requis, types).
8. Laravel enregistre le résultat dans `AI_Analysis`, lié au message d'origine.
9. Si `urgent = true`, Laravel déclenche une Notification immédiate vers le propriétaire.
10. Le voyageur reçoit la réponse générée (affichage en temps réel ou polling selon l'implémentation).

---

# 7. Modèle de données — vue conceptuelle

Le schéma comporte **10 entités**, cohérentes avec le MCD/MLD validés du projet.

1. **User** — comptes Owner et Guest.
2. **Property** — logements.
3. **PropertyImage** — images des logements.
4. **PropertyInfo** — informations pratiques du logement (relation 1-1 avec Property).
5. **Recommendation** — recommandations locales par logement.
6. **Reservation** — réservations effectuées par les voyageurs.
7. **Conversation** — conversation liée à une réservation (relation 1-1).
8. **Message** — messages échangés dans une conversation.
9. **AI_Analysis** — résultat de l'analyse IA d'un message (relation 0,1 côté Message).
10. **Notification** — notifications envoyées aux utilisateurs.

## 7.1 Cardinalités

| Association | Cardinalité côté gauche | Cardinalité côté droit |
|---|---|---|
| User (Owner) — Property | (0,N) | (1,1) |
| Property — PropertyImage | (0,N) | (1,1) |
| Property — PropertyInfo | (0,1) | (1,1) |
| Property — Recommendation | (0,N) | (1,1) |
| User (Guest) — Reservation | (0,N) | (1,1) |
| Property — Reservation | (0,N) | (1,1) |
| Reservation — Conversation | (0,1) | (1,1) |
| Conversation — Message | (0,N) | (1,1) |
| User — Message (sender) | (0,N) | (1,1) |
| Message — AI_Analysis | (0,1) | (1,1) |
| User — Notification | (0,N) | (1,1) |

## 7.2 Règle importante — pourquoi AI_Analysis reste une table séparée

Contrairement à une variante simplifiée qui stockerait les champs IA directement dans `messages`, ce projet garde `AI_Analysis` comme table dédiée, pour les raisons suivantes :

- Seuls les messages envoyés par un **Guest** sont analysés — un message de réponse envoyé par l'**Owner** n'a jamais d'analyse associée. La cardinalité (0,1) côté Message reflète correctement cette règle.
- Cela évite d'avoir des colonnes `NULL` systématiques sur les messages du propriétaire.
- Cela permet de faire évoluer indépendamment le schéma de sortie de l'IA (ajout de nouveaux champs) sans toucher à la table `messages`.
- Cela respecte la 3NF (troisième forme normale) en séparant les données "message brut" des données "résultat d'analyse".

---

# 8. Migrations Laravel complètes (10 tables)

Toutes les migrations utilisent `foreignId()->constrained()` pour les clés étrangères, et respectent l'ordre de création pour éviter les erreurs de dépendances.

## 8.1 `2024_01_01_000001_create_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->enum('role', ['owner', 'guest'])->index();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

## 8.2 `2024_01_01_000002_create_properties_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('city')->index();
            $table->string('address');
            $table->decimal('price_per_night', 8, 2);
            $table->unsignedInteger('capacity');
            $table->unsignedTinyInteger('bedrooms');
            $table->unsignedTinyInteger('bathrooms');
            $table->enum('status', ['available', 'unavailable', 'maintenance'])
                  ->default('available')
                  ->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
```

## 8.3 `2024_01_01_000003_create_property_images_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_images');
    }
};
```

## 8.4 `2024_01_01_000004_create_property_infos_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('wifi_name')->nullable();
            $table->string('wifi_password')->nullable();
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->boolean('parking')->default(false);
            $table->text('parking_info')->nullable();
            $table->text('access_instructions')->nullable();
            $table->text('house_rules')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_infos');
    }
};
```

## 8.5 `2024_01_01_000005_create_recommendations_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->enum('category', [
                'restaurant', 'cafe', 'beach', 'surf_school',
                'taxi', 'pharmacy', 'hospital', 'supermarket', 'atm',
            ])->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
```

## 8.6 `2024_01_01_000006_create_reservations_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->unsignedInteger('number_of_guests');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
                  ->default('pending')
                  ->index();
            $table->text('special_request')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
```

## 8.7 `2024_01_01_000007_create_conversations_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->unique()->constrained()->cascadeOnDelete();
            $table->enum('status', ['open', 'closed', 'archived'])->default('open')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
```

## 8.8 `2024_01_01_000008_create_messages_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->enum('sender_type', ['guest', 'owner'])->index();
            $table->text('message');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
```

## 8.9 `2024_01_01_000009_create_ai_analyses_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('detected_language', 10)->nullable();
            $table->enum('category', [
                'accommodation', 'check_in', 'check_out', 'wifi', 'parking',
                'restaurant', 'taxi', 'beach', 'surf_school', 'house_rules',
                'technical_problem', 'emergency', 'other',
            ])->index();
            $table->boolean('urgency')->default(false)->index();
            $table->text('generated_response')->nullable();
            $table->json('structured_output')->nullable();
            $table->decimal('confidence', 4, 3)->nullable();
            $table->timestamp('analyzed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_analyses');
    }
};
```

## 8.10 `2024_01_01_000010_create_notifications_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('type', [
                'new_reservation', 'new_message', 'emergency',
                'reservation_cancelled', 'system',
            ])->index();
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
```

---

# 9. Modèles Eloquent complets

## 9.1 `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
        'phone', 'role', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ----- Relations -----

    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'guest_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ----- Scopes -----

    public function scopeOwners($query)
    {
        return $query->where('role', 'owner');
    }

    public function scopeGuests($query)
    {
        return $query->where('role', 'guest');
    }

    // ----- Helpers -----

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
```

## 9.2 `app/Models/Property.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id', 'title', 'description', 'city', 'address',
        'price_per_night', 'capacity', 'bedrooms', 'bathrooms',
        'status', 'latitude', 'longitude',
    ];

    protected function casts(): array
    {
        return [
            'price_per_night' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    // ----- Relations -----

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('position');
    }

    public function info()
    {
        return $this->hasOne(PropertyInfo::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // ----- Scopes -----

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeInCity($query, string $city)
    {
        return $query->where('city', $city);
    }
}
```

## 9.3 `app/Models/PropertyImage.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'image', 'position'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
```

## 9.4 `app/Models/PropertyInfo.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'wifi_name', 'wifi_password',
        'check_in', 'check_out', 'parking', 'parking_info',
        'access_instructions', 'house_rules',
    ];

    protected function casts(): array
    {
        return [
            'parking' => 'boolean',
        ];
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
```

## 9.5 `app/Models/Recommendation.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'category', 'title',
        'description', 'address', 'phone', 'website',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
```

## 9.6 `app/Models/Reservation.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guest_id', 'property_id', 'check_in_date', 'check_out_date',
        'number_of_guests', 'total_price', 'status', 'special_request',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'total_price' => 'decimal:2',
        ];
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }
}
```

## 9.7 `app/Models/Conversation.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['reservation_id', 'status', 'started_at', 'closed_at'];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }
}
```

## 9.8 `app/Models/Message.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['conversation_id', 'sender_id', 'sender_type', 'message'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function aiAnalysis()
    {
        return $this->hasOne(AiAnalysis::class);
    }
}
```

## 9.9 `app/Models/AiAnalysis.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnalysis extends Model
{
    use HasFactory;

    protected $table = 'ai_analyses';

    protected $fillable = [
        'message_id', 'detected_language', 'category', 'urgency',
        'generated_response', 'structured_output', 'confidence', 'analyzed_at',
    ];

    protected function casts(): array
    {
        return [
            'urgency' => 'boolean',
            'structured_output' => 'array',
            'confidence' => 'decimal:3',
            'analyzed_at' => 'datetime',
        ];
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
```

## 9.10 `app/Models/Notification.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'type', 'is_read'];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
```

---

# 10. Form Requests complètes

## 10.1 `app/Http/Requests/StorePropertyRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isOwner();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'integer', 'min:0'],
            'status' => ['sometimes', 'in:available,unavailable,maintenance'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'images' => ['nullable', 'array', 'max:20'],
            'images.*' => ['image', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre du logement est obligatoire.',
            'price_per_night.min' => 'Le prix par nuit doit être positif.',
        ];
    }
}
```

## 10.2 `app/Http/Requests/UpdatePropertyRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('property'));
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'city' => ['sometimes', 'required', 'string', 'max:100'],
            'address' => ['sometimes', 'required', 'string', 'max:255'],
            'price_per_night' => ['sometimes', 'required', 'numeric', 'min:0'],
            'capacity' => ['sometimes', 'required', 'integer', 'min:1'],
            'bedrooms' => ['sometimes', 'required', 'integer', 'min:0'],
            'bathrooms' => ['sometimes', 'required', 'integer', 'min:0'],
            'status' => ['sometimes', 'in:available,unavailable,maintenance'],
        ];
    }
}
```

## 10.3 `app/Http/Requests/StorePropertyInfoRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('property'));
    }

    public function rules(): array
    {
        return [
            'wifi_name' => ['nullable', 'string', 'max:100'],
            'wifi_password' => ['nullable', 'string', 'max:100'],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
            'parking' => ['boolean'],
            'parking_info' => ['nullable', 'string'],
            'access_instructions' => ['nullable', 'string'],
            'house_rules' => ['nullable', 'string'],
        ];
    }
}
```

## 10.4 `app/Http/Requests/StoreRecommendationRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecommendationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('property'));
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'in:restaurant,cafe,beach,surf_school,taxi,pharmacy,hospital,supermarket,atm'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'website' => ['nullable', 'url', 'max:255'],
        ];
    }
}
```

## 10.5 `app/Http/Requests/StoreReservationRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isGuest();
    }

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'number_of_guests' => ['required', 'integer', 'min:1'],
            'special_request' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
```

## 10.6 `app/Http/Requests/StoreMessageRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('view', $this->route('conversation'));
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:2000'],
        ];
    }
}
```

## 10.7 `app/Http/Requests/RegisterRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:owner,guest'],
        ];
    }
}
```

---

# 11. Policies complètes

## 11.1 `app/Policies/PropertyPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Property $property): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isOwner();
    }

    public function update(User $user, Property $property): bool
    {
        return $user->id === $property->owner_id;
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->id === $property->owner_id;
    }
}
```

## 11.2 `app/Policies/ReservationPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->guest_id
            || $user->id === $reservation->property->owner_id;
    }

    public function create(User $user): bool
    {
        return $user->isGuest();
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->property->owner_id;
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->guest_id
            || $user->id === $reservation->property->owner_id;
    }
}
```

## 11.3 `app/Policies/ConversationPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        $reservation = $conversation->reservation;

        return $user->id === $reservation->guest_id
            || $user->id === $reservation->property->owner_id;
    }
}
```

## 11.4 `app/Policies/RecommendationPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\Recommendation;
use App\Models\User;

class RecommendationPolicy
{
    public function update(User $user, Recommendation $recommendation): bool
    {
        return $user->id === $recommendation->property->owner_id;
    }

    public function delete(User $user, Recommendation $recommendation): bool
    {
        return $user->id === $recommendation->property->owner_id;
    }
}
```

## 11.5 `app/Policies/NotificationPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
    public function view(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id;
    }

    public function update(User $user, Notification $notification): bool
    {
        return $user->id === $notification->user_id;
    }
}
```

## 11.6 Enregistrement dans `app/Providers/AuthServiceProvider.php`

```php
protected $policies = [
    \App\Models\Property::class => \App\Policies\PropertyPolicy::class,
    \App\Models\Reservation::class => \App\Policies\ReservationPolicy::class,
    \App\Models\Conversation::class => \App\Policies\ConversationPolicy::class,
    \App\Models\Recommendation::class => \App\Policies\RecommendationPolicy::class,
    \App\Models\Notification::class => \App\Policies\NotificationPolicy::class,
];
```

---

# 12. Structure des Contrôleurs

Chaque contrôleur reste léger : il valide via le Form Request, délègue au Service, puis retourne une API Resource.

## 12.1 `app/Http/Controllers/Api/PropertyController.php`

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Services\PropertyService;

class PropertyController extends Controller
{
    public function __construct(protected PropertyService $properties) {}

    public function index()
    {
        return PropertyResource::collection(
            Property::available()->with('images', 'info')->paginate(15)
        );
    }

    public function store(StorePropertyRequest $request)
    {
        $property = $this->properties->create($request->user(), $request->validated());

        return new PropertyResource($property);
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);

        return new PropertyResource($property->load('images', 'info', 'recommendations'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property = $this->properties->update($property, $request->validated());

        return new PropertyResource($property);
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        $this->properties->delete($property);

        return response()->json(['message' => 'Logement supprimé.'], 200);
    }
}
```

## 12.2 `app/Http/Controllers/Api/MessageController.php`

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Services\MessageService;

class MessageController extends Controller
{
    public function __construct(protected MessageService $messages) {}

    public function index(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        return MessageResource::collection(
            $conversation->messages()->with('aiAnalysis')->paginate(30)
        );
    }

    public function store(StoreMessageRequest $request, Conversation $conversation)
    {
        $message = $this->messages->send($conversation, $request->user(), $request->validated('message'));

        return new MessageResource($message);
    }
}
```

## 12.3 Liste des contrôleurs REST à implémenter

| Contrôleur | Ressource | Méthodes |
|---|---|---|
| `Auth\RegisterController` | Inscription | store |
| `Auth\LoginController` | Connexion | store, destroy |
| `ProfileController` | Profil | show, update |
| `PropertyController` | Logements | index, store, show, update, destroy |
| `PropertyImageController` | Images | store, destroy |
| `PropertyInfoController` | Infos logement | show, update |
| `RecommendationController` | Recommandations | index, store, update, destroy |
| `ReservationController` | Réservations | index, store, show, update, cancel |
| `ConversationController` | Conversations | index, show |
| `MessageController` | Messages | index, store |
| `NotificationController` | Notifications | index, markAsRead |
| `DashboardController` | Tableau de bord | ownerStats, guestStats |

---

# 13. Services métier

## 13.1 `app/Services/PropertyService.php`

```php
<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;

class PropertyService
{
    public function create(User $owner, array $data): Property
    {
        $property = Property::create([...$data, 'owner_id' => $owner->id]);

        if (! empty($data['images'])) {
            foreach ($data['images'] as $position => $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create(['image' => $path, 'position' => $position]);
            }
        }

        return $property->load('images');
    }

    public function update(Property $property, array $data): Property
    {
        $property->update($data);

        return $property->fresh();
    }

    public function delete(Property $property): void
    {
        $property->delete();
    }
}
```

## 13.2 `app/Services/MessageService.php`

```php
<?php

namespace App\Services;

use App\Jobs\AnalyzeMessageJob;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class MessageService
{
    public function send(Conversation $conversation, User $sender, string $content): Message
    {
        $message = $conversation->messages()->create([
            'sender_id' => $sender->id,
            'sender_type' => $sender->role,
            'message' => $content,
        ]);

        if ($sender->isGuest()) {
            AnalyzeMessageJob::dispatch($message)->onQueue('ai-analysis');
        }

        return $message;
    }
}
```

## 13.3 `app/Services/AiAnalysisService.php`

```php
<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAnalysisService
{
    public function analyze(Message $message): void
    {
        $property = $message->conversation->reservation->property;

        $payload = [
            'message' => $message->message,
            'guest_language' => 'unknown',
            'property' => [
                'title' => $property->title,
                'wifi_name' => $property->info?->wifi_name,
                'wifi_password' => $property->info?->wifi_password,
                'check_in' => $property->info?->check_in,
                'check_out' => $property->info?->check_out,
                'parking' => $property->info?->parking,
                'house_rules' => $property->info?->house_rules,
                'recommendations' => $property->recommendations->map(fn ($r) => [
                    'category' => $r->category,
                    'name' => $r->title,
                ]),
            ],
        ];

        try {
            $response = Http::timeout(15)
                ->baseUrl(config('services.ai.base_url'))
                ->post('/api/analyze', $payload);

            if (! $response->successful()) {
                throw new \RuntimeException('AI service returned an error.');
            }

            $data = $response->json();

            $this->validateResponse($data);

            $analysis = $message->aiAnalysis()->create([
                'detected_language' => $data['language'],
                'category' => \Illuminate\Support\Str::snake($data['category']),
                'urgency' => $data['urgent'],
                'generated_response' => $data['response'],
                'structured_output' => $data,
                'confidence' => $data['confidence'] ?? null,
                'analyzed_at' => now(),
            ]);

            if ($data['urgent']) {
                $this->notifyOwner($message);
            }
        } catch (\Throwable $e) {
            Log::error('AI analysis failed', ['message_id' => $message->id, 'error' => $e->getMessage()]);

            $message->aiAnalysis()->create([
                'category' => 'other',
                'urgency' => false,
                'generated_response' => 'We are currently unable to generate an automatic response. The owner will contact you shortly.',
                'analyzed_at' => now(),
            ]);
        }
    }

    protected function validateResponse(array $data): void
    {
        foreach (['language', 'category', 'urgent', 'response', 'confidence'] as $field) {
            if (! array_key_exists($field, $data)) {
                throw new \RuntimeException("Missing field in AI response: {$field}");
            }
        }
    }

    protected function notifyOwner(Message $message): void
    {
        $owner = $message->conversation->reservation->property->owner;

        Notification::create([
            'user_id' => $owner->id,
            'title' => 'Urgence détectée',
            'content' => "Message urgent reçu : \"{$message->message}\"",
            'type' => 'emergency',
        ]);
    }
}
```

---

# 14. Routes (web.php et api.php)

## 14.1 `routes/api.php`

```php
<?php

use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\PropertyImageController;
use App\Http\Controllers\Api\PropertyInfoController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::apiResource('properties', PropertyController::class);
    Route::post('properties/{property}/images', [PropertyImageController::class, 'store']);
    Route::delete('property-images/{propertyImage}', [PropertyImageController::class, 'destroy']);
    Route::get('properties/{property}/info', [PropertyInfoController::class, 'show']);
    Route::put('properties/{property}/info', [PropertyInfoController::class, 'update']);

    Route::apiResource('properties.recommendations', RecommendationController::class)
        ->shallow()->except(['show']);

    Route::apiResource('reservations', ReservationController::class)->except(['destroy']);
    Route::patch('reservations/{reservation}/cancel', [ReservationController::class, 'cancel']);

    Route::get('conversations', [ConversationController::class, 'index']);
    Route::get('conversations/{conversation}', [ConversationController::class, 'show']);
    Route::get('conversations/{conversation}/messages', [MessageController::class, 'index']);
    Route::post('conversations/{conversation}/messages', [MessageController::class, 'store']);

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead']);

    Route::get('dashboard/owner', [DashboardController::class, 'ownerStats']);
    Route::get('dashboard/guest', [DashboardController::class, 'guestStats']);
});
```

## 14.2 `routes/web.php` (démonstration Blade)

```php
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->isOwner()
            ? view('dashboard.owner')
            : view('dashboard.guest');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('properties', \App\Http\Controllers\Web\PropertyController::class);
    Route::resource('reservations', \App\Http\Controllers\Web\ReservationController::class)
        ->only(['index', 'show']);
    Route::get('conversations/{conversation}', [\App\Http\Controllers\Web\ConversationController::class, 'show'])
        ->name('conversations.show');
});

require __DIR__.'/auth.php';
```

---

# 15. Référence API complète (tous les endpoints)

## 15.1 Authentification

| Méthode | URL | Auth | Description |
|---|---|---|---|
| POST | `/api/register` | Non | Créer un compte (owner ou guest) |
| POST | `/api/login` | Non | Connexion, retourne un Bearer Token |
| POST | `/api/logout` | Oui | Révoque le token courant |
| GET | `/api/profile` | Oui | Consulter son profil |
| PUT | `/api/profile` | Oui | Modifier son profil |

## 15.2 Logements

| Méthode | URL | Auth | Rôle | Description |
|---|---|---|---|---|
| GET | `/api/properties` | Oui | Tous | Liste des logements disponibles |
| POST | `/api/properties` | Oui | Owner | Créer un logement |
| GET | `/api/properties/{id}` | Oui | Tous | Détail d'un logement |
| PUT | `/api/properties/{id}` | Oui | Owner (propriétaire) | Modifier un logement |
| DELETE | `/api/properties/{id}` | Oui | Owner (propriétaire) | Supprimer un logement |
| POST | `/api/properties/{id}/images` | Oui | Owner | Ajouter des images |
| DELETE | `/api/property-images/{id}` | Oui | Owner | Supprimer une image |
| GET | `/api/properties/{id}/info` | Oui | Tous | Consulter les infos du logement |
| PUT | `/api/properties/{id}/info` | Oui | Owner | Modifier les infos du logement |

## 15.3 Recommandations

| Méthode | URL | Auth | Rôle | Description |
|---|---|---|---|---|
| GET | `/api/properties/{id}/recommendations` | Oui | Tous | Liste des recommandations |
| POST | `/api/properties/{id}/recommendations` | Oui | Owner | Ajouter une recommandation |
| PUT | `/api/recommendations/{id}` | Oui | Owner | Modifier une recommandation |
| DELETE | `/api/recommendations/{id}` | Oui | Owner | Supprimer une recommandation |

## 15.4 Réservations

| Méthode | URL | Auth | Rôle | Description |
|---|---|---|---|---|
| GET | `/api/reservations` | Oui | Tous | Liste des réservations (filtrées par rôle) |
| POST | `/api/reservations` | Oui | Guest | Créer une réservation |
| GET | `/api/reservations/{id}` | Oui | Tous | Détail d'une réservation |
| PUT | `/api/reservations/{id}` | Oui | Owner | Mettre à jour le statut |
| PATCH | `/api/reservations/{id}/cancel` | Oui | Guest / Owner | Annuler une réservation |

## 15.5 Conversations et Messages

| Méthode | URL | Auth | Rôle | Description |
|---|---|---|---|---|
| GET | `/api/conversations` | Oui | Tous | Liste des conversations de l'utilisateur |
| GET | `/api/conversations/{id}` | Oui | Tous | Détail d'une conversation |
| GET | `/api/conversations/{id}/messages` | Oui | Tous | Historique des messages |
| POST | `/api/conversations/{id}/messages` | Oui | Tous | Envoyer un message |

## 15.6 Notifications

| Méthode | URL | Auth | Description |
|---|---|---|---|
| GET | `/api/notifications` | Oui | Liste des notifications de l'utilisateur |
| PATCH | `/api/notifications/{id}/read` | Oui | Marquer comme lue |

## 15.7 Dashboard

| Méthode | URL | Auth | Rôle | Description |
|---|---|---|---|---|
| GET | `/api/dashboard/owner` | Oui | Owner | Statistiques propriétaire |
| GET | `/api/dashboard/guest` | Oui | Guest | Statistiques voyageur |

## 15.8 Codes de statut HTTP utilisés

| Code | Signification |
|---|---|
| 200 | Succès (lecture / mise à jour) |
| 201 | Ressource créée |
| 204 | Suppression réussie (sans contenu) |
| 401 | Non authentifié |
| 403 | Non autorisé (Policy) |
| 404 | Ressource introuvable |
| 422 | Erreur de validation |
| 429 | Trop de requêtes (rate limit) |
| 500 | Erreur serveur |
| 503 | Service IA indisponible |

---

# 16. Ressources API (API Resources)

## 16.1 `app/Http/Resources/PropertyResource.php`

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'city' => $this->city,
            'address' => $this->address,
            'price_per_night' => $this->price_per_night,
            'capacity' => $this->capacity,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'status' => $this->status,
            'images' => PropertyImageResource::collection($this->whenLoaded('images')),
            'info' => new PropertyInfoResource($this->whenLoaded('info')),
            'recommendations' => RecommendationResource::collection($this->whenLoaded('recommendations')),
            'created_at' => $this->created_at,
        ];
    }
}
```

## 16.2 `app/Http/Resources/MessageResource.php`

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_type' => $this->sender_type,
            'message' => $this->message,
            'ai_analysis' => $this->whenLoaded('aiAnalysis', fn () => [
                'category' => $this->aiAnalysis?->category,
                'urgency' => $this->aiAnalysis?->urgency,
                'response' => $this->aiAnalysis?->generated_response,
                'language' => $this->aiAnalysis?->detected_language,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
```

---

# 17. Jobs & Queues

## 17.1 `app/Jobs/AnalyzeMessageJob.php`

```php
<?php

namespace App\Jobs;

use App\Models\Message;
use App\Services\AiAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 5;

    public function __construct(public Message $message) {}

    public function handle(AiAnalysisService $service): void
    {
        $service->analyze($this->message);
    }
}
```

## 17.2 Configuration de la queue (`config/queue.php`)

Utiliser le driver `redis` en production et `database` en développement local. Créer une queue dédiée `ai-analysis` pour isoler les traitements IA des autres tâches asynchrones (envoi d'e-mails, etc.).

```bash
php artisan queue:work redis --queue=ai-analysis --tries=3 --timeout=30
```

---

# 18. Notifications Laravel

## 18.1 `app/Notifications/EmergencyDetected.php`

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as LaravelNotification;
use Illuminate\Notifications\Messages\MailMessage;

class EmergencyDetected extends LaravelNotification
{
    use Queueable;

    public function __construct(protected string $content) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Urgence détectée sur votre logement')
            ->line($this->content)
            ->action('Voir la conversation', url('/dashboard'));
    }

    public function toArray($notifiable): array
    {
        return ['content' => $this->content];
    }
}
```

---

# 19. Service IA — FastAPI complet

## 19.1 Structure du dossier

```
ai-service/
├── main.py
├── requirements.txt
├── .env
└── app/
    ├── api/
    │   └── analyze.py
    ├── schemas/
    │   ├── request.py
    │   └── response.py
    ├── services/
    │   ├── language_detector.py
    │   ├── classifier.py
    │   ├── urgency_detector.py
    │   └── response_generator.py
    └── prompts/
        └── system_prompt.py
```

## 19.2 `main.py`

```python
from fastapi import FastAPI
from app.api.analyze import router as analyze_router

app = FastAPI(title="DarGuest AI Service", version="1.0.0")

app.include_router(analyze_router, prefix="/api")


@app.get("/health")
def health_check():
    return {"status": "ok"}
```

## 19.3 `app/schemas/request.py`

```python
from typing import List, Optional
from pydantic import BaseModel


class Recommendation(BaseModel):
    category: str
    name: str


class PropertyContext(BaseModel):
    title: str
    wifi_name: Optional[str] = None
    wifi_password: Optional[str] = None
    check_in: Optional[str] = None
    check_out: Optional[str] = None
    parking: Optional[bool] = None
    house_rules: Optional[str] = None
    recommendations: List[Recommendation] = []


class AnalyzeRequest(BaseModel):
    message: str
    guest_language: Optional[str] = "unknown"
    property: PropertyContext
```

## 19.4 `app/schemas/response.py`

```python
from pydantic import BaseModel, Field


class AnalyzeResponse(BaseModel):
    language: str
    category: str
    urgent: bool
    confidence: float = Field(ge=0, le=1)
    response: str
```

## 19.5 `app/api/analyze.py`

```python
from fastapi import APIRouter
from app.schemas.request import AnalyzeRequest
from app.schemas.response import AnalyzeResponse
from app.services.language_detector import detect_language
from app.services.classifier import classify_category
from app.services.urgency_detector import detect_urgency
from app.services.response_generator import generate_response

router = APIRouter()


@router.post("/analyze", response_model=AnalyzeResponse)
def analyze_message(payload: AnalyzeRequest):
    language = detect_language(payload.message, payload.guest_language)
    category = classify_category(payload.message)
    urgent = detect_urgency(payload.message)
    response_text, confidence = generate_response(
        payload.message, payload.property, language, category, urgent
    )

    return AnalyzeResponse(
        language=language,
        category=category,
        urgent=urgent,
        confidence=confidence,
        response=response_text,
    )
```

## 19.6 `app/services/urgency_detector.py`

```python
EMERGENCY_KEYWORDS = [
    "fire", "incendie", "feu",
    "water leak", "fuite d'eau", "inondation",
    "gas leak", "fuite de gaz",
    "broken door", "porte cassée", "porte bloquée",
    "lost keys", "perte des clés", "clés perdues",
    "medical emergency", "urgence médicale",
    "electricity failure", "panne électrique", "coupure de courant",
]


def detect_urgency(message: str) -> bool:
    normalized = message.lower()
    return any(keyword in normalized for keyword in EMERGENCY_KEYWORDS)
```

## 19.7 `app/prompts/system_prompt.py`

```python
SYSTEM_PROMPT = """
Tu es l'assistant IA de conciergerie DarGuest.

Règles strictes :
1. Tu ne dois JAMAIS inventer d'information.
2. Tu ne peux utiliser QUE les informations fournies dans le contexte du logement.
3. Si une information demandée n'existe pas dans le contexte, réponds poliment
   que le propriétaire sera contacté et pourra répondre directement.
4. Réponds si possible dans la langue du message du voyageur.
5. Ta réponse doit être concise, chaleureuse et professionnelle.
6. Ne donne jamais de conseil médical, juridique ou de sécurité au-delà de la
   simple transmission d'une alerte au propriétaire.
"""
```

## 19.8 `app/services/response_generator.py` (exemple avec structured output)

```python
import json
from openai import OpenAI
from app.prompts.system_prompt import SYSTEM_PROMPT

client = OpenAI()


def generate_response(message: str, property_context, language: str, category: str, urgent: bool):
    context_json = json.dumps(property_context.model_dump(), ensure_ascii=False)

    completion = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=[
            {"role": "system", "content": SYSTEM_PROMPT},
            {"role": "user", "content": f"Contexte logement: {context_json}\n\nMessage voyageur ({language}): {message}\n\nCatégorie détectée: {category}\nUrgence: {urgent}"},
        ],
        temperature=0.3,
    )

    text = completion.choices[0].message.content.strip()
    confidence = 0.95 if not urgent else 0.99

    return text, confidence
```

## 19.9 `requirements.txt`

```
fastapi==0.115.0
uvicorn[standard]==0.30.6
pydantic==2.9.2
python-dotenv==1.0.1
openai==1.51.0
```

## 19.10 Lancement du service

```bash
cd ai-service
python -m venv venv
source venv/bin/activate       # Linux / macOS
venv\Scripts\activate          # Windows
pip install -r requirements.txt
uvicorn main:app --reload --port 8000
```

---

# 20. Seeders & Factories

## 20.1 `database/factories/UserFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'role' => fake()->randomElement(['owner', 'guest']),
        ];
    }

    public function owner(): static
    {
        return $this->state(fn () => ['role' => 'owner']);
    }

    public function guest(): static
    {
        return $this->state(fn () => ['role' => 'guest']);
    }
}
```

## 20.2 `database/factories/PropertyFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'owner_id' => User::factory()->owner(),
            'title' => fake()->streetName().' Villa',
            'description' => fake()->paragraph(),
            'city' => fake()->randomElement(['Agadir', 'Taghazout']),
            'address' => fake()->address(),
            'price_per_night' => fake()->numberBetween(300, 1500),
            'capacity' => fake()->numberBetween(2, 8),
            'bedrooms' => fake()->numberBetween(1, 4),
            'bathrooms' => fake()->numberBetween(1, 3),
            'status' => 'available',
        ];
    }
}
```

## 20.3 `database/factories/PropertyInfoFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyInfoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'wifi_name' => 'DarGuest_WiFi',
            'wifi_password' => fake()->password(8, 12),
            'check_in' => '15:00',
            'check_out' => '11:00',
            'parking' => fake()->boolean(70),
            'parking_info' => 'Parking gratuit devant le logement.',
            'access_instructions' => 'Boîte à clés à droite de la porte, code envoyé la veille.',
            'house_rules' => 'Non-fumeur. Pas de fête. Silence après 22h.',
        ];
    }
}
```

## 20.4 `database/factories/RecommendationFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecommendationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category' => fake()->randomElement([
                'restaurant', 'cafe', 'beach', 'surf_school',
                'taxi', 'pharmacy', 'hospital', 'supermarket', 'atm',
            ]),
            'title' => fake()->company(),
            'description' => fake()->sentence(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
```

## 20.5 `database/factories/ReservationFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $checkIn = fake()->dateTimeBetween('+1 days', '+30 days');
        $checkOut = (clone $checkIn)->modify('+'.fake()->numberBetween(2, 10).' days');

        return [
            'guest_id' => User::factory()->guest(),
            'property_id' => Property::factory(),
            'check_in_date' => $checkIn->format('Y-m-d'),
            'check_out_date' => $checkOut->format('Y-m-d'),
            'number_of_guests' => fake()->numberBetween(1, 4),
            'total_price' => fake()->numberBetween(500, 5000),
            'status' => 'confirmed',
        ];
    }
}
```

## 20.6 `database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyInfo;
use App\Models\Recommendation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::factory()->owner()->create([
            'email' => 'owner@darguest.test',
        ]);

        $guest = User::factory()->guest()->create([
            'email' => 'guest@darguest.test',
        ]);

        Property::factory()
            ->count(5)
            ->for($owner, 'owner')
            ->has(PropertyInfo::factory())
            ->has(Recommendation::factory()->count(3))
            ->create()
            ->each(function (Property $property) use ($guest) {
                Reservation::factory()->create([
                    'guest_id' => $guest->id,
                    'property_id' => $property->id,
                ]);
            });
    }
}
```

---

# 21. Tests Pest

## 21.1 `tests/Feature/PropertyTest.php`

```php
<?php

use App\Models\Property;
use App\Models\User;

it('allows an owner to create a property', function () {
    $owner = User::factory()->owner()->create();

    $response = $this->actingAs($owner, 'sanctum')->postJson('/api/properties', [
        'title' => 'Villa Sunset',
        'city' => 'Taghazout',
        'address' => 'Rue des Palmiers',
        'price_per_night' => 500,
        'capacity' => 4,
        'bedrooms' => 2,
        'bathrooms' => 1,
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('properties', ['title' => 'Villa Sunset']);
});

it('prevents a guest from creating a property', function () {
    $guest = User::factory()->guest()->create();

    $response = $this->actingAs($guest, 'sanctum')->postJson('/api/properties', [
        'title' => 'Villa Sunset',
    ]);

    $response->assertForbidden();
});

it('prevents an owner from updating another owner property', function () {
    $ownerA = User::factory()->owner()->create();
    $ownerB = User::factory()->owner()->create();
    $property = Property::factory()->for($ownerA, 'owner')->create();

    $response = $this->actingAs($ownerB, 'sanctum')->putJson("/api/properties/{$property->id}", [
        'title' => 'Hack attempt',
    ]);

    $response->assertForbidden();
});

it('allows anyone to list available properties', function () {
    Property::factory()->count(3)->create(['status' => 'available']);
    Property::factory()->create(['status' => 'maintenance']);

    $owner = User::factory()->owner()->create();

    $response = $this->actingAs($owner, 'sanctum')->getJson('/api/properties');

    $response->assertOk()->assertJsonCount(3, 'data');
});
```

## 21.2 `tests/Feature/ReservationTest.php`

```php
<?php

use App\Models\Property;
use App\Models\User;

it('allows a guest to create a reservation', function () {
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->create();

    $response = $this->actingAs($guest, 'sanctum')->postJson('/api/reservations', [
        'property_id' => $property->id,
        'check_in_date' => now()->addDays(5)->toDateString(),
        'check_out_date' => now()->addDays(10)->toDateString(),
        'number_of_guests' => 2,
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('reservations', ['property_id' => $property->id]);
});

it('rejects a reservation with an invalid date range', function () {
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->create();

    $response = $this->actingAs($guest, 'sanctum')->postJson('/api/reservations', [
        'property_id' => $property->id,
        'check_in_date' => now()->addDays(10)->toDateString(),
        'check_out_date' => now()->addDays(5)->toDateString(),
        'number_of_guests' => 2,
    ]);

    $response->assertUnprocessable();
});
```

## 21.3 `tests/Feature/MessageAnalysisTest.php`

```php
<?php

use App\Jobs\AnalyzeMessageJob;
use App\Models\Conversation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

it('dispatches an analysis job when a guest sends a message', function () {
    Queue::fake();

    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest, 'sanctum')->postJson("/api/conversations/{$conversation->id}/messages", [
        'message' => 'What is the wifi password?',
    ])->assertCreated();

    Queue::assertPushedOn('ai-analysis', AnalyzeMessageJob::class);
});

it('stores the ai analysis result', function () {
    Http::fake([
        '*/api/analyze' => Http::response([
            'language' => 'English',
            'category' => 'wifi',
            'urgent' => false,
            'confidence' => 0.97,
            'response' => 'The Wi-Fi password is 123456.',
        ]),
    ]);

    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest, 'sanctum')->postJson("/api/conversations/{$conversation->id}/messages", [
        'message' => 'What is the wifi password?',
    ])->assertCreated();

    $message = $conversation->messages()->first();
    (new App\Jobs\AnalyzeMessageJob($message))->handle(app(App\Services\AiAnalysisService::class));

    $this->assertDatabaseHas('ai_analyses', [
        'message_id' => $message->id,
        'category' => 'wifi',
        'urgency' => false,
    ]);
});

it('falls back gracefully when the ai service is unavailable', function () {
    Http::fake([
        '*/api/analyze' => Http::response([], 503),
    ]);

    $guest = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guest->id]);
    $conversation = Conversation::factory()->for($reservation)->create();

    $this->actingAs($guest, 'sanctum')->postJson("/api/conversations/{$conversation->id}/messages", [
        'message' => 'Fire in the kitchen!',
    ])->assertCreated();

    $message = $conversation->messages()->first();
    (new App\Jobs\AnalyzeMessageJob($message))->handle(app(App\Services\AiAnalysisService::class));

    $this->assertDatabaseHas('ai_analyses', [
        'message_id' => $message->id,
        'category' => 'other',
    ]);
});
```

## 21.4 `tests/Feature/PoliciesTest.php`

```php
<?php

use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;

it('only lets a guest view their own reservation', function () {
    $guestA = User::factory()->guest()->create();
    $guestB = User::factory()->guest()->create();
    $reservation = Reservation::factory()->create(['guest_id' => $guestA->id]);

    $this->assertTrue($guestA->can('view', $reservation));
    $this->assertFalse($guestB->can('view', $reservation));
});

it('lets the owner of the property view the reservation too', function () {
    $owner = User::factory()->owner()->create();
    $guest = User::factory()->guest()->create();
    $property = Property::factory()->for($owner, 'owner')->create();
    $reservation = Reservation::factory()->create([
        'guest_id' => $guest->id,
        'property_id' => $property->id,
    ]);

    $this->assertTrue($owner->can('view', $reservation));
});
```

## 21.5 `tests/Feature/AuthTest.php`

```php
<?php

use App\Models\User;

it('registers a new owner account', function () {
    $response = $this->postJson('/api/register', [
        'first_name' => 'Hassan',
        'last_name' => 'Aftah',
        'email' => 'hassan@darguest.test',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
        'role' => 'owner',
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('users', ['email' => 'hassan@darguest.test', 'role' => 'owner']);
});

it('logs in an existing user and returns a token', function () {
    $user = User::factory()->create(['password' => bcrypt('Password123')]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'Password123',
    ]);

    $response->assertOk()->assertJsonStructure(['token']);
});
```

---

# 22. Docker & Docker Compose

## 22.1 `Dockerfile` (application Laravel)

```dockerfile
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache

EXPOSE 9000
CMD ["php-fpm"]
```

## 22.2 `ai-service/Dockerfile`

```dockerfile
FROM python:3.11-slim

WORKDIR /app

COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

COPY . .

EXPOSE 8000
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]
```

## 22.3 `docker-compose.yml`

```yaml
version: "3.9"

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: darguest-app
    volumes:
      - .:/var/www
    depends_on:
      - mysql
      - redis
    environment:
      - APP_ENV=local
      - DB_HOST=mysql
      - REDIS_HOST=redis

  nginx:
    image: nginx:stable-alpine
    container_name: darguest-nginx
    ports:
      - "8080:80"
    volumes:
      - .:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app

  mysql:
    image: mysql:8.0
    container_name: darguest-mysql
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: darguest
      MYSQL_USER: darguest
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: root
    ports:
      - "3307:3306"
    volumes:
      - darguest-mysql-data:/var/lib/mysql

  redis:
    image: redis:7-alpine
    container_name: darguest-redis
    ports:
      - "6379:6379"

  queue:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: darguest-queue
    command: php artisan queue:work redis --queue=ai-analysis --tries=3
    volumes:
      - .:/var/www
    depends_on:
      - mysql
      - redis

  ai-service:
    build:
      context: ./ai-service
      dockerfile: Dockerfile
    container_name: darguest-ai
    ports:
      - "8000:8000"
    env_file:
      - ./ai-service/.env

volumes:
  darguest-mysql-data:
```

## 22.4 `.dockerignore`

```
/vendor
/node_modules
/storage/*.key
.env
docker-compose.override.yml
ai-service/venv
```

## 22.5 `docker/nginx/default.conf`

```nginx
server {
    listen 80;
    index index.php index.html;
    server_name localhost;
    root /var/www/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

---

# 23. GitHub Actions (CI/CD)

## 23.1 `.github/workflows/ci.yml`

```yaml
name: CI

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main, develop]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_DATABASE: darguest_test
          MYSQL_ROOT_PASSWORD: root
        ports:
          - 3306:3306
        options: >-
          --health-cmd="mysqladmin ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=5

    steps:
      - uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: "8.3"
          extensions: mbstring, pdo_mysql, bcmath, zip
          coverage: none

      - name: Copy .env
        run: cp .env.example .env

      - name: Install Composer dependencies
        run: composer install --prefer-dist --no-progress

      - name: Generate app key
        run: php artisan key:generate

      - name: Run migrations
        run: php artisan migrate --force
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: darguest_test
          DB_USERNAME: root
          DB_PASSWORD: root

      - name: Run Pest tests
        run: ./vendor/bin/pest
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: darguest_test
          DB_USERNAME: root
          DB_PASSWORD: root

  ai-service-tests:
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v4

      - name: Setup Python
        uses: actions/setup-python@v5
        with:
          python-version: "3.11"

      - name: Install dependencies
        working-directory: ./ai-service
        run: pip install -r requirements.txt

      - name: Run health check import test
        working-directory: ./ai-service
        run: python -c "import main"

  docker-build:
    runs-on: ubuntu-latest
    needs: [laravel-tests, ai-service-tests]

    steps:
      - uses: actions/checkout@v4

      - name: Build Laravel image
        run: docker build -t darguest-app .

      - name: Build AI service image
        run: docker build -t darguest-ai ./ai-service
```

---

# 24. Documentation API (Scribe)

## 24.1 Installation

```bash
composer require knuckleswtf/scribe
php artisan vendor:publish --tag=scribe-config
```

## 24.2 Annotation d'un contrôleur (exemple)

```php
/**
 * @group Logements
 *
 * Créer un logement
 *
 * Crée un nouveau logement pour le propriétaire authentifié.
 *
 * @authenticated
 * @bodyParam title string required Le titre du logement. Example: Villa Sunset
 * @bodyParam city string required La ville. Example: Taghazout
 * @bodyParam price_per_night numeric required Prix par nuit. Example: 500
 * @response 201 {
 *   "data": { "id": 1, "title": "Villa Sunset", "city": "Taghazout" }
 * }
 */
public function store(StorePropertyRequest $request) { ... }
```

## 24.3 Génération de la documentation

```bash
php artisan scribe:generate
```

La documentation générée est accessible sur `/docs`.

---

# 25. Sécurité & bonnes pratiques

- Toute route API protégée par `auth:sanctum`.
- Toute action sensible protégée par une Policy (`$this->authorize(...)`).
- Toute entrée validée par un Form Request dédié.
- Les mots de passe hashés automatiquement via le cast `password => hashed`.
- CSRF activé pour toutes les routes web (Breeze).
- Rate limiting sur les routes IA (`throttle:20,1` par exemple sur l'envoi de messages).
- Aucune clé API (LLM, etc.) committée : uniquement dans `.env` / secrets GitHub Actions.
- Validation stricte du JSON retourné par FastAPI avant tout enregistrement en base.
- Logs d'erreurs centralisés (`storage/logs/laravel.log`) pour tout échec d'appel IA.

---

# 26. Gestion des erreurs et codes HTTP

| Situation | Comportement attendu |
|---|---|
| FastAPI indisponible | Fallback : réponse polie + log d'erreur, jamais de crash |
| Timeout HTTP | Retry automatique (jusqu'à 3 tentatives via le Job) |
| JSON invalide retourné par l'IA | Rejet, log, réponse de secours enregistrée |
| Champ manquant dans la réponse IA | Exception levée et catchée, fallback appliqué |
| Utilisateur non autorisé | HTTP 403 avec message clair |
| Ressource introuvable | HTTP 404 |
| Erreur de validation | HTTP 422 avec détail des champs en erreur |

---

# 27. Variables d'environnement

## 27.1 Laravel `.env`

```
APP_NAME=DarGuest
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=darguest
DB_USERNAME=darguest
DB_PASSWORD=secret

QUEUE_CONNECTION=redis
REDIS_HOST=redis
REDIS_PORT=6379

SANCTUM_STATEFUL_DOMAINS=localhost:8080

AI_SERVICE_BASE_URL=http://ai-service:8000
```

## 27.2 `config/services.php` (extrait)

```php
'ai' => [
    'base_url' => env('AI_SERVICE_BASE_URL', 'http://localhost:8000'),
],
```

## 27.3 FastAPI `.env`

```
OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxx
ENVIRONMENT=development
LOG_LEVEL=info
```

---

# 28. Convention de nommage

| Élément | Convention | Exemple |
|---|---|---|
| Tables | pluriel, snake_case | `properties`, `ai_analyses` |
| Modèles | singulier, PascalCase | `Property`, `AiAnalysis` |
| Contrôleurs | PascalCase + suffixe | `PropertyController` |
| Form Requests | Verbe + Ressource + Request | `StorePropertyRequest` |
| Policies | Ressource + Policy | `PropertyPolicy` |
| Routes API | kebab-case, pluriel | `/api/property-images` |
| Jobs | Verbe + Ressource + Job | `AnalyzeMessageJob` |
| Variables | camelCase (PHP), snake_case (colonnes DB) | `$pricePerNight` / `price_per_night` |

---

# 29. Convention Git & branches

## 29.1 Format de commit

```
feat(module): description courte
fix(module): description courte
refactor(module): description courte
docs: description courte
test(module): description courte
```

Exemples :
```
feat(auth): implement Laravel Breeze authentication
feat(property): CRUD properties completed
feat(ai): integrate FastAPI service
feat(reservation): booking workflow
fix(validation): improve reservation rules
test(message): add AI analysis feature tests
docs: update AGENTS.md
```

## 29.2 Stratégie de branches

- `main` — production, toujours stable.
- `develop` — branche d'intégration.
- `feature/auth`, `feature/property`, `feature/recommendation`, `feature/reservation`, `feature/conversation`, `feature/ai`, `feature/notification`, `feature/dashboard`.

Chaque branche `feature/*` est mergée dans `develop` via Pull Request, avec CI verte obligatoire. `develop` n'est mergée dans `main` qu'après validation complète.

---

# 30. Feuille de route détaillée (15 phases)

## Phase 1 — Initialisation du projet
- Créer le projet Laravel 13 (`composer create-project laravel/laravel darguest`).
- Configurer la connexion MySQL.
- Installer Laravel Breeze (stack Blade).
- Configurer Vite et installer les dépendances Node.
- Initialiser Git, créer le dépôt GitHub, premier commit.
- Créer `AGENTS.md` et `README.md`.
- Mettre en place Docker (Dockerfile + docker-compose.yml) dès cette phase.

## Phase 2 — Authentification
- Implémenter Register / Login / Logout / Reset Password via Breeze.
- Ajouter le champ `role` au formulaire d'inscription.
- Installer et configurer Laravel Sanctum pour l'API.
- Créer les endpoints `/api/register` et `/api/login`.
- Ajouter les tests Pest de base sur l'authentification.

## Phase 3 — Base de données
- Créer les 10 migrations (voir section 8).
- Exécuter `php artisan migrate` et vérifier les clés étrangères.
- Ajouter les index nécessaires (email, role, city, status, foreign keys).

## Phase 4 — Modèles Eloquent
- Créer les 10 modèles avec leurs relations complètes (voir section 9).
- Ajouter les Factories associées.
- Vérifier chaque relation via `php artisan tinker`.

## Phase 5 — Gestion des logements
- CRUD complet Property + PropertyImage + PropertyInfo.
- Upload d'images (stockage local `storage/app/public`, lien symbolique `php artisan storage:link`).
- Form Requests + Policy `PropertyPolicy`.
- Tests Pest de CRUD et d'autorisation.

## Phase 6 — Recommandations
- CRUD Recommendation, scoping par logement.
- Validation des catégories (enum).
- Tests Pest.

## Phase 7 — Réservations
- CRUD Reservation, contrôle des dates (`check_out_date > check_in_date`).
- Gestion des statuts (pending, confirmed, cancelled, completed).
- Policy `ReservationPolicy`.
- Tests Pest.

## Phase 8 — Conversations & Messages
- Création automatique d'une Conversation à la première interaction sur une Reservation.
- Envoi de message (Guest et Owner).
- Historique chronologique.
- Policy `ConversationPolicy`.
- Tests Pest.

## Phase 9 — Service IA (FastAPI)
- Créer la structure `ai-service/` (voir section 19).
- Implémenter `/api/analyze` avec les 4 responsabilités (langue, catégorie, urgence, réponse).
- Tests manuels via Postman / curl.

## Phase 10 — Intégration Laravel ↔ FastAPI
- Créer `AnalyzeMessageJob` et `AiAnalysisService`.
- Configurer la queue Redis dédiée `ai-analysis`.
- Gérer les erreurs et le fallback.
- Tests Pest avec `Http::fake()` et `Queue::fake()`.

## Phase 11 — Notifications
- Créer la table et le modèle Notification.
- Déclencher une notification à chaque nouveau message et à chaque urgence.
- Endpoint de liste et de marquage "lu".
- Tests Pest.

## Phase 12 — Dashboards
- Dashboard Owner : logements, réservations, conversations récentes, urgences, notifications.
- Dashboard Guest : réservations, conversations, notifications.
- Vues Blade + endpoints API dédiés.

## Phase 13 — Recherche & filtres
- Filtrage des logements par ville, prix, capacité.
- Filtrage des réservations par statut.
- Pagination systématique sur les listes.

## Phase 14 — Tests & optimisation
- Compléter la couverture Pest sur tous les modules.
- Revue de sécurité (Policies, validation, CSRF).
- Optimisation des requêtes (eager loading, indexes).
- Mise en place complète de la CI GitHub Actions (section 23).

## Phase 15 — Finalisation
- Seed complet de démonstration (comptes, logements, réservations, conversations).
- Documentation API complète avec Scribe.
- Finalisation du README et de ce AGENTS.md.
- Préparation du support de présentation.
- Déploiement sur une plateforme Cloud, vérification de l'URL publique.

---

# 31. Definition of Done

Une fonctionnalité est considérée comme terminée uniquement si :

- ✔ Migration + Modèle + Factory (+ Seeder si nécessaire) créés.
- ✔ Form Request de validation créé et utilisé.
- ✔ Policy d'autorisation créée et enregistrée.
- ✔ Controller + Service implémentés, logique métier hors du controller.
- ✔ Route API (et vue Blade si applicable) ajoutée.
- ✔ Tests Pest écrits et passants.
- ✔ Documentation Scribe à jour pour les endpoints concernés.
- ✔ Commit Git effectué avec un message conforme à la convention.

---

# 32. Checklist finale complète

## Authentification
- [ ] Breeze installé et fonctionnel
- [ ] Register / Login / Logout opérationnels
- [ ] Reset password fonctionnel
- [ ] Gestion des rôles (owner / guest)
- [ ] Page de profil complète
- [ ] Sanctum configuré pour l'API

## Logements
- [ ] CRUD complet
- [ ] Upload multi-images
- [ ] Informations pratiques (PropertyInfo) gérées séparément
- [ ] Validation complète

## Recommandations
- [ ] CRUD complet
- [ ] Catégories validées
- [ ] Scoping par logement respecté

## Réservations
- [ ] Création, mise à jour, annulation
- [ ] Historique des statuts
- [ ] Validation des dates

## Conversations & Messages
- [ ] Création automatique liée à la réservation
- [ ] Envoi de messages (Guest / Owner)
- [ ] Historique chronologique affiché
- [ ] Réponses IA visibles dans la conversation

## Intelligence Artificielle
- [ ] FastAPI opérationnel et testé
- [ ] Connexion Laravel ↔ FastAPI fonctionnelle
- [ ] Traitement asynchrone via Jobs & Queues
- [ ] Validation stricte du JSON structuré
- [ ] Détection de langue fonctionnelle
- [ ] Classification d'intention fonctionnelle
- [ ] Détection d'urgence fonctionnelle
- [ ] Gestion des erreurs et fallback

## Notifications
- [ ] Création automatique (message, urgence)
- [ ] Liste et marquage lu/non lu
- [ ] Alertes urgentes visibles au dashboard

## Dashboard
- [ ] Dashboard Owner complet
- [ ] Dashboard Guest complet

## Base de données
- [ ] 10 migrations exécutées
- [ ] Clés étrangères fonctionnelles
- [ ] Relations testées via tinker et tests Pest
- [ ] Seeders et factories disponibles

## Sécurité
- [ ] Authentification obligatoire sur toutes les routes protégées
- [ ] Policies en place pour chaque ressource sensible
- [ ] Form Requests utilisés partout
- [ ] CSRF actif côté web

## Qualité de code
- [ ] PSR-12 respecté
- [ ] Aucune logique métier dans les controllers ou les vues Blade
- [ ] Eager loading utilisé pour éviter le N+1
- [ ] Aucun code dupliqué significatif

## Livrables
- [ ] Cahier des charges
- [ ] MCD
- [ ] MLD
- [ ] Diagramme d'architecture
- [ ] Dépôt GitHub
- [ ] Projet Laravel complet
- [ ] Documentation API Scribe
- [ ] README.md
- [ ] Dockerfile + docker-compose.yml
- [ ] Workflow GitHub Actions
- [ ] Tests automatisés Pest
- [ ] Support de présentation
- [ ] URL de l'application déployée

---

# 33. Glossaire

| Terme | Définition |
|---|---|
| MCD | Modèle Conceptuel de Données (Merise) |
| MLD | Modèle Logique de Données (Merise) |
| Owner | Propriétaire d'un ou plusieurs logements |
| Guest | Voyageur ayant réservé un logement |
| Structured Output | Réponse IA au format JSON strict et validé |
| Job | Tâche exécutée de manière asynchrone via une Queue |
| Policy | Classe Laravel définissant les règles d'autorisation d'une ressource |
| Form Request | Classe Laravel dédiée à la validation d'une requête HTTP |
| API Resource | Classe Laravel qui normalise la sortie JSON d'un modèle |
| Sanctum | Système d'authentification API par token de Laravel |
| Breeze | Starter kit d'authentification web de Laravel |
| Fallback | Réponse de secours utilisée en cas d'échec du service IA |

---

# 34. Annexes

## 34.1 Commandes Laravel utiles

```bash
composer create-project laravel/laravel darguest
php artisan serve
php artisan migrate
php artisan migrate:fresh --seed
php artisan make:model Property -m
php artisan make:controller Api/PropertyController --api
php artisan make:request StorePropertyRequest
php artisan make:policy PropertyPolicy --model=Property
php artisan make:job AnalyzeMessageJob
php artisan make:notification EmergencyDetected
php artisan storage:link
php artisan queue:work redis --queue=ai-analysis
php artisan scribe:generate
```

## 34.2 Commandes FastAPI utiles

```bash
python -m venv venv
source venv/bin/activate
pip install fastapi uvicorn python-dotenv openai
uvicorn main:app --reload --port 8000
```

## 34.3 Commandes Docker utiles

```bash
docker-compose up -d --build
docker-compose exec app php artisan migrate --seed
docker-compose logs -f queue
docker-compose down -v
```

## 34.4 Conseils pour la soutenance finale

1. Expliquer le problème métier et sa solution.
2. Présenter l'architecture globale (Laravel + FastAPI).
3. Démontrer l'authentification et les rôles.
4. Démontrer la gestion des logements.
5. Démontrer le workflow de réservation.
6. Envoyer un message voyageur en direct.
7. Montrer la requête envoyée à FastAPI.
8. Afficher la réponse IA générée.
9. Démontrer la détection d'urgence en direct.
10. Montrer les notifications reçues par le propriétaire.
11. Expliquer le schéma de base de données (MCD/MLD).
12. Expliquer l'architecture Laravel (Controller → Service → Model).
13. Expliquer l'intégration IA (Job → HTTP → FastAPI → JSON).
14. Présenter l'historique Git et la CI GitHub Actions.
15. Conclure sur les axes d'amélioration futurs.

---

# Fin de AGENTS.md

Ce document constitue la source de vérité unique du projet DarGuest. Tout contributeur, humain ou assistant IA, doit s'y référer tout au long du cycle de développement, et le mettre à jour à chaque décision d'architecture significative.
