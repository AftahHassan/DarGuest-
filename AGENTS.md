# DarGuest — Guide Agent (Fonctionnalités détaillées)

Application Laravel de conciergerie pour locations saisonnières à **Agadir / Taghazout (Maroc)**.
Plateforme où les **propriétaires** publient des logements et les **voyageurs** réservent, communiquent et reçoivent un support IA multilingue.

---

## 1. Stack & outillage

- **Framework** : Laravel 12 (Blade + Tailwind CSS v3 + Alpine.js)
- **Base de données** : MySQL (via XAMPP localement)
- **Auth** : Breeze (sessions), Laravel Sanctum (API tokens), Laravel Socialite (Google OAuth)
- **IA** : API Groq (`llama-3.3-70b-versatile`, JSON output) via `config/services.php`
- **Queue** : base de données (`database` driver), file `ai-analysis`
- **Front** : Blade components + Alpine.js + Tailwind. Thème : couleur primaire **navy** (`navy.700 = #1d4ed8`).

### Commandes utiles
```bash
composer install          # dépendances PHP
npm install && npm run build   # dépendances & build front (Tailwind)
php artisan migrate       # schéma DB
php artisan queue:work --queue=ai-analysis   # traite l'analyse IA
php artisan serve         # serveur local
php artisan view:cache / view:clear   # cache des vues
npm run build             # recompile Tailwind (voir app-*.css généré)
```

---

## 2. Rôles utilisateurs

Champ `users.role`, deux valeurs :

| Rôle | Privilèges |
|------|-----------|
| `owner` (propriétaire) | CRUD ses logements, gère images/infos/recommandations, gère le statut des réservations, consulte la messagerie et les urgences IA, dashboard de revenus |
| `guest` (voyageur) | Parcourt les logements disponibles, crée des réservations, discute avec le propriétaire + assistant IA |

Le rôle est choisi à l'inscription (`register`) et **ne peut pas être modifié** ensuite.

---

## 3. Authentification & sécurité

Fichiers : `routes/auth.php`, `app/Http/Controllers/Auth/*`, `app/Http/Controllers/Auth/SocialiteController.php`

1. **Inscription** (`POST /register`, `RegisteredUserController`) — validation : `first_name`, `last_name`, `email` unique, `phone` (optionnel), `role` (`owner`|`guest`), `password` confirmé `min:8` + majuscule + chiffre. Connecte l'utilisateur puis redirige vers `/dashboard`.
2. **Connexion / Déconnexion** — Breeze classique (`AuthenticatedSessionController`).
3. **Google OAuth** (`GET /auth/google` + callback) — `SocialiteController` : si l'email existe déjà, associe le `google_id` ; sinon crée un compte avec rôle par défaut `guest` (aucun rôle proposé). `email_verified_at` défini à `now()`.
4. **Mot de passe oublié / réinitialisation** — `PasswordResetLinkController` + `NewPasswordController`.
5. **Vérification d'email** — `EmailVerificationPromptController`, `VerifyEmailController` (route signée + throttle `6,1`).
6. **Mot de passe** — `PasswordController` (mise à jour après confirmation), `ConfirmablePasswordController`.

Toutes les routes de l'app sont sous `middleware('auth')`.

---

## 4. Dashboards (`DashboardController@index`)

Redirige selon le rôle de l'utilisateur connecté.

### Dashboard propriétaire (`dashboard/owner.blade.php`)
Statistiques :
- `total_properties`, `available_properties`, `total_reservations`, `pending_reservations`
- `unread_notifications`, `urgent_messages` (analyses IA `urgency = true`)
- `total_revenue` (somme des réservations `confirmed`)
- `ai_messages_count`, `ai_time_saved` (≈ 5 min × analyses non urgentes)
- Variations factices (12 %, 8 %, 0 %, 25 %) pour l'effet visuel

Listes récentes :
- Logements (6 derniers, avec images)
- Conversations (5 dernières, avec invité + logement)
- Analyses urgentes (5 dernières)
- Réservations (8 dernières)
- Graphique revenus / réservations par mois (année en cours, via `MONTH(created_at)`)

### Dashboard voyageur (`dashboard/guest.blade.php`)
- `total_reservations`, `upcoming_reservations` (check-in futur + statut `pending`/`confirmed`), `unread_notifications`
- Logements disponibles (6 derniers) avec CTA réservation
- Prochaines réservations (3, triées par check-in)

---

## 5. Logements / Propriétés

Contrôleur : `app/Http/Controllers/Web/PropertyController.php`
Service : `app/Services/PropertyService.php` (create / update / delete)
Policy : `app/Policies/PropertyPolicy.php`

### CRUD
- **index** : liste paginée (12/page). Pour un `owner` → ses propres logements ; pour un `guest` → logements `available`.
- **create** : réservé aux `owner` (`authorize('create')`).
- **store** : `StorePropertyRequest` → `PropertyService::create` (attribue `owner_id`).
- **show** : charge `images`, `info`, `recommendations`.
- **edit / update** : uniquement le propriétaire.
- **destroy** : soft delete, uniquement le propriétaire.

### Filtres / tri (index)
- `status` (pour owner), `search` (titre ou ville), `city` (liste distincte des villes), `price_min`, `price_max`
- `sort` : `price_asc`, `price_desc`, `name_asc`, `name_desc`, `date_asc`, défaut `latest()`

### Champs (`properties` table)
`owner_id`, `title`, `description`, `city`, `address`, `price_per_night` (decimal:2), `capacity`, `bedrooms`, `bathrooms`, `status` (`available`|`rented`|...), `latitude`/`longitude` (decimal:7), soft deletes.
Scopes : `available()`, `inCity($city)`.

### Images (`PropertyImage`)
- Upload multiple (`POST properties/{property}/images`) → stockées sur le disque `public` dans `properties/`, position auto-incrémentée (`max('position') + 1`), max 4 Mo/image.
- Suppression (`DELETE property-images/{propertyImage}`) → efface le fichier de `Storage::disk('public')`.
- Affichage via composant `components/gallery.blade.php`.

### Infos pratique (`PropertyInfo`, hasOne)
`POST/PUT properties/{property}/info` (`PropertyController@updateInfo`) : `wifi_name`, `wifi_password`, `check_in`/`check_out` (`H:i`), `parking` (bool), `parking_info`, `access_instructions`, `house_rules`. Upsert via `updateOrCreate`. Ces données servent de **contexte à l'IA**.

### Recommandations (`Recommendation`, hasMany)
`PropertyController@storeRecommendation` :
- `category` ∈ `restaurant, cafe, beach, surf_school, taxi, pharmacy, hospital, supermarket, atm`
- `title` (obligatoire), `description`, `address`, `phone`
- Si `edit_id` présent → mise à jour, sinon création.
- Suppression : `DELETE recommendations/{recommendation}`.

---

## 6. Réservations

Contrôleur : `app/Http/Controllers/Web/ReservationController.php`
Service : `app/Services/ReservationService.php`
Policy : `app/Policies/ReservationPolicy.php`

### Création (`ReservationService::create`)
1. Récupère le logement.
2. Calcule `total_price = nights × price_per_night` (`diffInDays` entre check-in et check-out).
3. Crée la réservation avec statut `pending`.
4. **Crée automatiquement une `Conversation`** liée (`status = open`, `started_at = now()`).
5. Envoie une notification `new_reservation` au propriétaire.

Champs : `guest_id`, `property_id`, `check_in_date`, `check_out_date` (dates castées), `number_of_guests`, `special_request`, `total_price`, `status`, soft deletes.

### Statuts
`pending` → (owner) → `confirmed` | `cancelled`. Valeurs gérées par `UpdateReservationStatusRequest`.

### Gestion (routes)
- `GET reservations` : liste paginée (9/page), filtrée par rôle (owner → ses propriétés, guest → ses réservations). Filtres : `status`, `search` (titre logement ou nom voyageur), `guest`, `property`, `date_from`, `date_to`. Tris : check-in/check-out, prix, asc/desc.
- `GET reservations/{reservation}` : autorisé si guest de la résa OU owner du logement. Charge `property`, `guest`, `conversation.messages.sender`, `conversation.messages.aiAnalysis`.
- `PATCH reservations/{reservation}/status` : **owner uniquement** (`updateStatus` policy).
- `PATCH reservations/{reservation}/cancel` : guest OU owner. `ReservationService::cancel` passe le statut à `cancelled` et notifie l'autre partie (`reservationCancelled`).

---

## 7. Messagerie & assistant IA

Contrôleur : `app/Http/Controllers/Web/ConversationController.php`
Service : `app/Services/MessageService.php`
Policy : `app/Policies/ConversationPolicy.php`

### Conversation
- Une conversation existe **par réservation** (hasOne).
- Liste (`index`) : conversations où l'utilisateur est guest OU owner du logement. Affiche dernier message, compteur `unread_count` (messages non-AI, non-lus, pas de l'utilisateur).
- `?conversation=` sélectionne la conversation active et la marque lue (`markAsRead`).
- `show` : charge `reservation.property`, `reservation.guest`, `messages.aiAnalysis`, marque comme lue.

### Envoi de message (`MessageService::send`)
1. Crée le message (`sender_id`, `sender_type` = rôle, `message`).
2. Notifie le destinataire (`newMessage`).
3. **Si l'expéditeur est un guest → dispatch `AnalyzeMessageJob` sur la file `ai-analysis`**.

### Analyse IA (`GroqAnalysisService`, `AnalyzeMessageJob`)
- Job `ShouldQueue`, 3 tentatives, backoff 5 s.
- Envoie au modèle Groq un JSON structuré : contexte du logement (infos pratique + recommandations) + message du voyageur.
- `systemPrompt` : assistant de conciergerie DarGuest. **Ne jamais inventer d'info**, répondre dans la langue du voyageur, détecter les vraies urgences. Réponse **JSON uniquement**.
- Catégories : `accommodation, check_in, check_out, wifi, parking, restaurant, taxi, beach, surf_school, house_rules, technical_problem, emergency, other`.
- À la réussite :
  1. Crée une `AiAnalysis` (langue, catégorie, urgence, réponse générée, sortie structurée, confidence, `analyzed_at`).
  2. Crée un message `sender_type = ai` avec la réponse générée (visible des deux parties).
  3. Si `urgent` → notification `emergency` au propriétaire.
- En cas d'échec (API, JSON invalide) : log l'erreur, crée une analyse de repli (`category=other`, urgence false) et un message AI : *"Nous ne pouvons pas générer de réponse automatique pour le moment. Le propriétaire vous contactera sous peu."*

---

## 8. Notifications

Contrôleur : `app/Http/Controllers/Web/NotificationController.php`
Service : `app/Services/NotificationService.php`
Policy : `app/Policies/NotificationPolicy.php`

### Types générés (`notifications.type`)
| Type | Déclencheur | Destinataire |
|------|-------------|--------------|
| `new_reservation` | `ReservationService::create` | propriétaire |
| `reservation_cancelled` | `ReservationService::cancel` | l'autre partie |
| `new_message` | `MessageService::send` | l'autre partie |
| `emergency` | `GroqAnalysisService::notifyOwner` | propriétaire |

### Interface (`notifications/index.blade.php`)
- Filtres : `type`, `unread`.
- Statistiques : `total`, `unread`, `urgent` (type `emergency` non lues).
- `markAsRead` (GET/POST), `markAllAsRead`, `destroy`.

### En-tête (`layouts/header.blade.php`)
- Badge de compteur non lues + dropdown "Toutes marquer comme lues".

---

## 9. Profil utilisateur (`ProfileController`)

Routes : `GET/PATCH/DELETE /profile`
Partials : `profile/partials/{update-profile-information-form,update-password-form,delete-user-form}.blade.php`
- Mise à jour nom/email (`ProfileUpdateRequest`).
- Changement de mot de passe (nécessite confirmation).
- Suppression de compte.

---

## 10. Pages publiques

- `/` → `welcome` (landing). Composants : `landing/{navbar,hero,features,how-it-works,advantages,statistics,ai-section,testimonials,faq,footer}`.
- `/conditions`, `/confidentialite`, `/support` → pages statiques.

---

## 11. API REST (Sanctum)

`routes/api.php` — contrôleurs `app/Http/Controllers/Api/*` :

| Méthode | Endpoint | Contrôleur |
|---------|----------|-----------|
| POST | `/register`, `/login` | `Api\AuthController` |
| POST | `/logout`, `GET /me`, `GET /user` | `Api\AuthController` (auth:sanctum) |
| apiResource | `/properties` | `Api\PropertyController` |
| POST | `/properties/{property}/images` | `Api\PropertyImageController` |
| DELETE | `/property-images/{propertyImage}` | `Api\PropertyImageController` |
| GET/PUT | `/properties/{property}/info` | `Api\PropertyInfoController` |
| GET/POST | `/properties/{property}/recommendations` | `Api\RecommendationController` |
| PUT/DELETE | `/recommendations/{recommendation}` | `Api\RecommendationController` |
| apiResource | `/reservations` (sans destroy) | `Api\ReservationController` |
| PATCH | `/reservations/{reservation}/cancel` | `Api\ReservationController` |
| GET | `/conversations`, `/conversations/{conversation}` | `Api\ConversationController` |
| GET/POST | `/conversations/{conversation}/messages` | `Api\MessageController` |
| GET | `/notifications` | `Api\NotificationController` |
| PATCH | `/notifications/{notification}/read`, `/notifications/read-all` | `Api\NotificationController` |

> NB : `MessageControllert.php` (typo) existe mais n'est pas routé.

---

## 12. Modèle de données (migrations)

| Table | Rôle |
|-------|------|
| `users` | + `role`, `phone`, `avatar`, `google_id` |
| `properties` | logements (soft deletes) |
| `property_images` | `property_id`, `image`, `position` |
| `property_infos` | `property_id`, wifi, horaires, parking, instructions, règles |
| `recommendations` | `property_id`, `category`, `title`, `description`, `address`, `phone` |
| `reservations` | guest/property/dates/prix/statut (soft deletes) |
| `conversations` | `reservation_id`, `status`, `started_at` |
| `messages` | `conversation_id`, `sender_id`, `sender_type` (`user`/`ai`), `message`, `read_at` |
| `ai_analyses` | `message_id`, langue, catégorie, urgence, réponse, `structured_output`, confidence, `analyzed_at` |
| `notifications` | `user_id`, `title`, `content`, `type`, `is_read` |
| `personal_access_tokens` | tokens Sanctum |

Relations clés :
- `User` hasMany `properties` (owner) / `reservations` (guest) / `notifications` / `sentMessages` ; helpers `isOwner()`, `isGuest()`, `fullName()`, scopes `owners()`/`guests()`.
- `Property` hasMany `images` (ordonné par position), `recommendations`, `reservations` ; hasOne `info` ; belongsTo `owner`.
- `Reservation` belongsTo `guest`, `property` ; hasOne `conversation`.
- `Conversation` hasMany `messages`, belongsTo `reservation`, méthode `markAsRead(userId)`.
- `Message` belongsTo `conversation`, `sender` ; hasOne `aiAnalysis`.
- `AiAnalysis` belongsTo `message`.

---

## 13. Services & Jobs

| Classe | Rôle |
|--------|------|
| `PropertyService` | CRUD propriétés (attache `owner_id`) |
| `ReservationService` | création (prix, conversation, notif), changement de statut, annulation |
| `MessageService` | envoi de message + dispatch job IA pour les guests |
| `GroqAnalysisService` | appel API Groq, validation, écriture `AiAnalysis` + réponse AI + notification urgence |
| `NotificationService` | création des notifications (`newReservation`, `reservationCancelled`, `newMessage`) |
| `AnalyzeMessageJob` | job `ShouldQueue` (file `ai-analysis`) exécutant l'analyse Groq |

Policies : `PropertyPolicy` (create=owner, update/delete=owner), `ReservationPolicy` (view=2 parties, create=guest, updateStatus=owner, cancel=2 parties), `ConversationPolicy`, `NotificationPolicy`, `RecommendationPolicy`.

---

## 14. Conventions UI

- **Boutons** : utiliser le composant **`<x-button>`** (`resources/views/components/button.blade.php`).
  - Variantes : `primary` (navy-700, défaut), `secondary`, `success` (émeraude), `danger` (rouge, réservé à la suppression), `outline` (navy), `ghost`.
  - Tailles : `sm`, `md` (défaut), `lg`, `xl`, `icon`.
  - `href="..."` → rend un `<a>` ; `type="submit"`, `full` → `w-full`.
  - **Primary = bleu navy**, jamais noir/`surface-900`. Le rouge (`danger`) reste pour la suppression.
  - Les anciens `x-primary-button`/`x-secondary-button`/`x-danger-button` et `.btn*` sont supprimés — ne pas les réintroduire.
- Composants UI réutilisables : `components/ui/{card,badge,modal,dropdown,dropdown-item,empty-state,search-bar,skeleton,toast,pagination,ai-panel,text-input}.blade.php`.
- Palette navy définie dans `tailwind.config.js` (`navy.600` → `navy.950`).

---

## 15. Config & variables d'environnement (.env)

```env
APP_NAME=DarGuest
DB_CONNECTION=mysql

GROQ_API_KEY=...
GROQ_MODEL=llama-3.3-70b-versatile
GROQ_BASE_URL=https://api.groq.com/openai/v1

GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REDIRECT_URI=...
```

---

## 16. Notes d'historique (à ne pas réintroduire)

- La notification "nouvelle propriété disponible" (`NotificationService::newPropertyAvailable`) a été **retirée volontairement** (commit `9d170ce`) ainsi que son appel dans `PropertyController@store`.
- `MessageControllert.php` (double `t`) est un doublon non routé de `MessageController.php`.
