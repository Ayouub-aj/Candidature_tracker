# 📋 CandidatureTracker

 A full-stack web application to track job applications and interviews — built with Laravel 11, Docker Sail, Tailwind CSS v4, and tested with Pest.

---

## 📑 Table of Contents

- [Project Overview](#-project-overview)
- [Tech Stack](#-tech-stack)
- [Architecture](#-architecture)
- [Getting Started](#-getting-started)
- [Environment Configuration](#-environment-configuration)
- [Database](#-database)
- [Running the Application](#-running-the-application)
- [Test Credentials](#-test-credentials)
- [Routes Reference](#-routes-reference)
- [Running Tests](#-running-tests)
- [Key Laravel Concepts](#-key-laravel-concepts)
- [MCD & MLD](#-mcd--mld)
- [Project Structure](#-project-structure)
- [Git Workflow](#-git-workflow)

---

## 🧭 Project Overview

**CandidatureTracker** is a job application management platform that allows authenticated users to:

- **Track candidatures** (job applications) with statuses, priorities, notes, and application dates
- **Manage interviews (entretiens)** tied to each candidature, with type, scheduling, preparation notes, and results
- **Archive and restore** candidatures using Laravel SoftDeletes
- **Filter** their list by status and priority
- **Stay secure** — each user can only access their own data, enforced via Laravel Policies

---

## 🛠 Tech Stack

| Layer | Technology | Version |
|---|---|---|
| Language | PHP | 8.3 |
| Framework | Laravel | 11.x |
| Containerization | Docker + Laravel Sail | Latest |
| Database | MySQL | 8.0 |
| DB Admin UI | phpMyAdmin | Latest |
| Frontend | Blade + Tailwind CSS | v4 |
| Asset Bundler | Vite | Latest |
| Authentication | Laravel Breeze (Blade) | Latest |
| Testing | Pest + pest-plugin-laravel | Latest |
| Debugging | Laravel Debugbar | Latest |

---

## 🏗 Architecture

```
candidature-tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CandidatureController.php   # Full CRUD + archive + restore + filter
│   │   │   └── EntretienController.php     # Full CRUD, scoped to candidature
│   │   ├── Requests/
│   │   │   ├── StoreCandidatureRequest.php
│   │   │   ├── UpdateCandidatureRequest.php
│   │   │   ├── StoreEntretienRequest.php
│   │   │   └── UpdateEntretienRequest.php
│   │   └── Policies/
│   │       ├── CandidaturePolicy.php       # Ownership-based authorization
│   │       └── EntretienPolicy.php         # Scoped via parent candidature
│   └── Models/
│       ├── User.php                        # hasMany Candidature
│       ├── Candidature.php                 # SoftDeletes, accessors, relationships
│       └── Entretien.php                   # belongsTo Candidature, accessors
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_candidatures_table.php
│   │   └── create_entretiens_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       ├── CandidatureSeeder.php
│       └── EntretienSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php               # Main layout with nav, flash messages
│   ├── candidatures/
│   │   ├── index.blade.php                 # Dashboard / list with filters
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   ├── show.blade.php                  # Detail + entretien list
│   │   └── archives.blade.php
│   └── entretiens/
│       ├── create.blade.php
│       └── edit.blade.php
├── tests/
│   ├── Unit/
│   │   ├── CandidatureTest.php
│   │   └── EntretienTest.php
│   └── Feature/
│       ├── AuthTest.php
│       ├── CandidaturePolicyTest.php
│       ├── CandidatureCrudTest.php
│       ├── EntretienPolicyTest.php
│       ├── EntretienCrudTest.php
│       └── UnauthorizedAccessTest.php
├── compose.yaml                            # Docker services (Laravel, MySQL, phpMyAdmin)
└── .env
```

---

## 🚀 Getting Started

### Prerequisites

Make sure you have installed:
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Composer](https://getcomposer.org/)
- Git

---

### Step 1 — Clone the repository

```bash
git clone https://github.com/<your-username>/candidature-tracker.git
cd candidature-tracker
```

---

### Step 2 — Install PHP dependencies

```bash
composer install
```

---

### Step 3 — Copy and configure environment

```bash
cp .env.example .env
```

Then edit `.env` — see [Environment Configuration](#-environment-configuration) below.

---

### Step 4 — Start Docker services

```bash
./vendor/bin/sail up -d
```

> **Tip:** Add an alias so you can type `sail` instead of `./vendor/bin/sail`:
> ```bash
> alias sail='./vendor/bin/sail'
> # Add this line to ~/.bashrc or ~/.zshrc to make it permanent
> ```

---

### Step 5 — Generate application key

```bash
sail artisan key:generate
```

---

### Step 6 — Run migrations and seed the database

```bash
sail artisan migrate:fresh --seed
```

This creates all tables and inserts:
- 2 test users
- 7 candidatures (5 for user 1, 2 for user 2) with mixed statuses and priorities
- 3 entretiens distributed across user 1's candidatures

---

### Step 7 — Install and build frontend assets

```bash
sail npm install
sail npm run dev
```

> For production build: `sail npm run build`

---

### Step 8 — Verify everything is running

| URL | Expected |
|-----|----------|
| `http://localhost` | Laravel welcome page with Tailwind styles |
| `http://localhost/dashboard` | Redirects to `/login` (auth required) |
| `http://localhost:8081` | phpMyAdmin login screen |

---

## ⚙️ Environment Configuration

Key variables in your `.env` file:

```dotenv
APP_NAME=CandidatureTracker
APP_ENV=local
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=candidature_tracker
DB_USERNAME=sail
DB_PASSWORD=password

# Test database (used by Pest)
DB_TEST_DATABASE=candidature_tracker_test

# Debugbar (disable in production)
DEBUGBAR_ENABLED=true
```

### `phpunit.xml` — Test environment

```xml
<env name="DB_DATABASE" value="candidature_tracker_test"/>
<env name="APP_ENV" value="testing"/>
```

---

## 🗄 Database

### Table: `users`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint | PK |
| `name` | varchar(255) | |
| `email` | varchar(255) | unique |
| `email_verified_at` | timestamp | nullable |
| `password` | varchar(255) | hashed |
| `remember_token` | varchar(100) | nullable |
| `created_at` / `updated_at` | timestamp | |

---

### Table: `candidatures`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint | PK |
| `user_id` | bigint | FK → users.id (cascade delete) |
| `company` | varchar(255) | |
| `position` | varchar(255) | |
| `offer_url` | varchar(255) | nullable |
| `status` | enum | `sent`, `interview`, `offer`, `rejected`, `withdrawn` — default: `sent` |
| `priority` | enum | `low`, `medium`, `high` — default: `medium` |
| `notes` | text | nullable |
| `applied_at` | date | |
| `deleted_at` | timestamp | nullable — used by SoftDeletes |
| `created_at` / `updated_at` | timestamp | |

---

### Table: `entretiens`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint | PK |
| `candidature_id` | bigint | FK → candidatures.id (cascade delete) |
| `type` | enum | `phone`, `video`, `onsite`, `technical`, `hr` |
| `scheduled_at` | datetime | |
| `preparation_notes` | text | nullable |
| `result` | enum | `pending`, `passed`, `failed` — default: `pending` |
| `created_at` / `updated_at` | timestamp | |

---

## 🔐 Test Credentials

| User | Email | Password |
|------|-------|----------|
| User 1 (5 candidatures) | `test@example.com` | `password` |
| User 2 (2 candidatures) | `other@example.com` | `password` |

> Attempting to access User 1's candidatures while logged in as User 2 returns a **403 Forbidden**.

---

## 🗺 Routes Reference

All routes except `/login` and `/register` are protected by the `auth` middleware.

### Authentication (managed by Laravel Breeze)

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/register` | `register` | Show registration form |
| POST | `/register` | — | Process registration |
| GET | `/login` | `login` | Show login form |
| POST | `/login` | — | Process login |
| POST | `/logout` | `logout` | Logout current user |

### Candidatures

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/dashboard` | `candidatures.index` | List active candidatures (with filters) |
| GET | `/candidatures/create` | `candidatures.create` | Show create form |
| POST | `/candidatures` | `candidatures.store` | Save new candidature |
| GET | `/candidatures/{candidature}` | `candidatures.show` | View candidature detail |
| GET | `/candidatures/{candidature}/edit` | `candidatures.edit` | Show edit form |
| PUT | `/candidatures/{candidature}` | `candidatures.update` | Update candidature |
| DELETE | `/candidatures/{candidature}` | `candidatures.destroy` | Soft-delete (archive) |
| GET | `/candidatures/archives` | `candidatures.archives` | List archived candidatures |
| PATCH | `/candidatures/{candidature}/restore` | `candidatures.restore` | Restore from archive |
| DELETE | `/candidatures/{candidature}/force` | `candidatures.force-delete` | *(Bonus)* Permanently delete |

### Entretiens (nested under candidatures)

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/candidatures/{candidature}/entretiens/create` | `entretiens.create` | Show add entretien form |
| POST | `/candidatures/{candidature}/entretiens` | `entretiens.store` | Save new entretien |
| GET | `/entretiens/{entretien}/edit` | `entretiens.edit` | Show edit form |
| PUT | `/entretiens/{entretien}` | `entretiens.update` | Update entretien |
| DELETE | `/entretiens/{entretien}` | `entretiens.destroy` | Delete entretien |

### Filter Parameters (on `GET /dashboard`)

| Param | Values | Example |
|-------|--------|---------|
| `status` | `sent`, `interview`, `offer`, `rejected`, `withdrawn` | `?status=interview` |
| `priority` | `low`, `medium`, `high` | `?priority=high` |

---

## 🧪 Running Tests

```bash
# Run the full test suite
sail artisan test

# Run with coverage report (optional)
sail artisan test --coverage

# Run a specific test file
sail artisan test tests/Feature/CandidatureCrudTest.php

# Run a specific test by name
sail artisan test --filter "creates a candidature with valid data"
```

### Test Suite Overview

| File | Type | Covers |
|------|------|--------|
| `Unit/CandidatureTest.php` | Unit | `$fillable`, status/priority accessors, relationships |
| `Unit/EntretienTest.php` | Unit | type/result accessors, relationship to candidature |
| `Feature/AuthTest.php` | Feature | Register, login, logout, redirect guests |
| `Feature/CandidaturePolicyTest.php` | Feature | Cross-user 403 on view/edit/update/delete |
| `Feature/CandidatureCrudTest.php` | Feature | Create, update, archive, restore, filter |
| `Feature/EntretienPolicyTest.php` | Feature | Cross-user 403 on add/edit/delete entretien |
| `Feature/EntretienCrudTest.php` | Feature | Create, update, delete, show on detail page |
| `Feature/UnauthorizedAccessTest.php` | Feature | *(Bonus)* Guest redirects, 403 on direct URL access |

> **Minimum:** ≥ 15 tests passing across all suites.

---

## 🧠 Key Laravel Concepts

### Policies — Authorization

Policies enforce ownership-based access control. Every controller action calls `$this->authorize()` — there is **zero** manual `abort(403)` in the codebase.

```php
// CandidaturePolicy.php
public function update(User $user, Candidature $candidature): bool
{
    return $candidature->user_id === $user->id;
}

// CandidatureController.php
public function update(UpdateCandidatureRequest $request, Candidature $candidature)
{
    $this->authorize('update', $candidature); // throws 403 if policy returns false
    $candidature->update($request->validated());
    return redirect()->route('candidatures.index')->with('success', 'Candidature mise à jour.');
}
```

---

### SoftDeletes — Archive & Restore

`Candidature` uses Laravel's `SoftDeletes` trait. Deleting a candidature sets `deleted_at` rather than removing the row — preserving data while hiding it from normal queries.

```php
// Model
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidature extends Model
{
    use SoftDeletes;
}

// Archive (soft delete)
$candidature->delete();          // sets deleted_at

// Restore
$candidature->restore();         // clears deleted_at

// Query only trashed
Candidature::onlyTrashed()->where('user_id', auth()->id())->get();

// Permanent delete (bonus)
$candidature->forceDelete();
```

---

### Accessors — French Labels in Views

Raw enum values (`sent`, `high`, `phone`) are transformed into readable French labels via Eloquent accessors. Views always use the accessor, never the raw value.

```php
// Candidature.php
public function getStatusLabelAttribute(): string
{
    return match($this->status) {
        'sent'      => 'Envoyée',
        'interview' => 'Entretien',
        'offer'     => 'Offre reçue',
        'rejected'  => 'Refusée',
        'withdrawn' => 'Retirée',
    };
}

// In Blade view
{{ $candidature->status_label }}  {{-- outputs "Entretien" instead of "interview" --}}
```

---

### Form Request Classes — Validation

All validation is handled in dedicated `FormRequest` classes, keeping controllers lean and clean. There is **zero** `$request->validate()` inside controllers.

```php
// StoreCandidatureRequest.php
public function rules(): array
{
    return [
        'company'    => 'required|string|max:255',
        'position'   => 'required|string|max:255',
        'offer_url'  => 'nullable|url',
        'status'     => 'required|in:sent,interview,offer,rejected,withdrawn',
        'priority'   => 'required|in:low,medium,high',
        'notes'      => 'nullable|string',
        'applied_at' => 'required|date',
    ];
}
```

---

### Eager Loading — Preventing N+1

All queries that iterate over related models use `with()` or `withCount()` to load relationships in a single query, eliminating N+1 issues verifiable via Laravel Debugbar.

```php
// Dashboard — load entretien count in one query
$candidatures = auth()->user()
    ->candidatures()
    ->withCount('entretiens')
    ->get();

// Candidature detail — load entretiens in one query
$candidature->load('entretiens');
```

---

### Eloquent Relationships

```php
// User → Candidature (one-to-many)
class User extends Model {
    public function candidatures(): HasMany {
        return $this->hasMany(Candidature::class);
    }
}

// Candidature → Entretien (one-to-many)
class Candidature extends Model {
    public function entretiens(): HasMany {
        return $this->hasMany(Entretien::class);
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}

// Entretien → Candidature (many-to-one)
class Entretien extends Model {
    public function candidature(): BelongsTo {
        return $this->belongsTo(Candidature::class);
    }
}
```

---

## 📐 MCD & MLD

### MCD — Conceptual Data Model

```
┌──────────┐           ┌───────────────────┐           ┌────────────┐
│   USER   │           │   CANDIDATURE     │           │ ENTRETIEN  │
├──────────┤           ├───────────────────┤           ├────────────┤
│ name     │ 1 ──── * │ company           │ 1 ──── * │ type       │
│ email    │           │ position          │           │ scheduled  │
│ password │           │ offer_url         │           │ prep_notes │
└──────────┘           │ status            │           │ result     │
                       │ priority          │           └────────────┘
                       │ notes             │
                       │ applied_at        │
                       └───────────────────┘
```

**Entities:** User, Candidature, Entretien
**Cardinalities:**
- A User has **1..N** Candidatures (a user can have many candidatures)
- A Candidature has **0..N** Entretiens (a candidature can have zero or more interviews)

---

### MLD — Logical Data Model

```
users (
    id              BIGINT UNSIGNED     PK,
    name            VARCHAR(255)        NOT NULL,
    email           VARCHAR(255)        NOT NULL UNIQUE,
    email_verified_at TIMESTAMP         NULL,
    password        VARCHAR(255)        NOT NULL,
    remember_token  VARCHAR(100)        NULL,
    created_at      TIMESTAMP,
    updated_at      TIMESTAMP
)

candidatures (
    id              BIGINT UNSIGNED     PK,
    user_id         BIGINT UNSIGNED     FK → users.id (CASCADE DELETE),
    company         VARCHAR(255)        NOT NULL,
    position        VARCHAR(255)        NOT NULL,
    offer_url       VARCHAR(255)        NULL,
    status          ENUM('sent','interview','offer','rejected','withdrawn')  DEFAULT 'sent',
    priority        ENUM('low','medium','high')                             DEFAULT 'medium',
    notes           TEXT                NULL,
    applied_at      DATE                NOT NULL,
    deleted_at      TIMESTAMP           NULL,
    created_at      TIMESTAMP,
    updated_at      TIMESTAMP
)

entretiens (
    id                  BIGINT UNSIGNED  PK,
    candidature_id      BIGINT UNSIGNED  FK → candidatures.id (CASCADE DELETE),
    type                ENUM('phone','video','onsite','technical','hr')  NOT NULL,
    scheduled_at        DATETIME         NOT NULL,
    preparation_notes   TEXT             NULL,
    result              ENUM('pending','passed','failed')  DEFAULT 'pending',
    created_at          TIMESTAMP,
    updated_at          TIMESTAMP
)
```

---

## 🌿 Git Workflow

### Branches

| Branch | Purpose |
|--------|---------|
| `main` | Stable, production-ready code |
| `feature/auth` | Laravel Breeze authentication setup |
| `feature/candidatures` | Candidature CRUD, policies, filters, archive/restore |
| `feature/entretiens` | Entretien CRUD and policies |
| `feature/api` | *(Reserved)* API endpoints |

### Commit Convention

```bash
# Examples of well-formed commit messages used in this project
git commit -m "Initial Laravel + Sail setup with MySQL, phpMyAdmin and Pest"
git commit -m "Add candidatures and entretiens migrations"
git commit -m "Add Candidature model with SoftDeletes and accessors"
git commit -m "Add CandidaturePolicy with ownership checks"
git commit -m "Implement SoftDeletes archive and restore on candidatures"
git commit -m "Add status_label and priority_label accessors to Candidature"
git commit -m "Implement filter by status and priority on dashboard"
git commit -m "Fix N+1 on dashboard with eager loading withCount"
git commit -m "Add Pest unit tests for Candidature and Entretien models"
git commit -m "Add Pest feature tests for authentication"
git commit -m "Add Pest feature tests for CandidaturePolicy"
git commit -m "Add Pest feature tests for candidature CRUD"
git commit -m "Add Pest feature tests for EntretienPolicy"
git commit -m "Add Pest feature tests for entretien CRUD"
git commit -m "Add README with full documentation"
```

---

## 🐳 Docker Services

| Service | Port | Purpose |
|---------|------|---------|
| `laravel.test` | `80` | Laravel application |
| `mysql` | `3306` | MySQL 8.0 database |
| `phpmyadmin` | `8081` | Database admin UI |

### Useful Sail Commands

```bash
# Start all services in background
sail up -d

# Stop all services
sail down

# Rebuild containers (after compose.yaml changes)
sail build --no-cache

# Open a shell inside the container
sail shell

# Run Artisan commands
sail artisan migrate:fresh --seed
sail artisan cache:clear
sail artisan route:list

# Run Composer commands
sail composer require <package>

# Run npm commands
sail npm install
sail npm run dev
sail npm run build
```

---

## 🛡 Security Checklist

- [x] All routes behind `auth` middleware (except login/register)
- [x] `CandidaturePolicy` enforces ownership on every action
- [x] `EntretienPolicy` enforces ownership via parent candidature
- [x] All forms include `@csrf`
- [x] All mutations use `@method('PUT')` / `@method('DELETE')` / `@method('PATCH')`
- [x] All user input validated via `FormRequest` classes
- [x] `$fillable` defined on all models (no mass assignment vulnerability)
- [x] Zero `abort(403)` — all authorization through `$this->authorize()`
- [x] SoftDeletes preserve data integrity on archive
- [x] N+1 eliminated with eager loading (verifiable via Debugbar)

---

*Sprint 18/05/2026 → 22/05/2026 — CandidatureTracker by [Your Name]*