# 📋 CandidatureTracker — DevTrack Laravel SCRUM Board

**Sprint:** 18/05/2026 → 22/05/2026 | **Deadline:** Vendredi 22/05 – 16:30

---

## 🐳 Docker Setup — Empty GitHub Repo (Start Here)

> Follow these steps **before anything else** on an empty cloned repo.

### Step 1 — Clone your repo and enter it

```bash
git clone https://github.com/<your-username>/candidature-tracker.git
cd candidature-tracker
```

### Step 2 — Create Laravel project in a temp folder, then move files

```bash
# Create Laravel app in a temp folder (outside the repo)
composer create-project laravel/laravel candidature-tracker-temp

# Copy everything into your cloned repo
cp -r candidature-tracker-temp/. .

# Remove the temp folder
rm -rf candidature-tracker-temp
```

### Step 3 — Install Laravel Sail

```bash
composer require laravel/sail --dev
php artisan sail:install
# When prompted, select: mysql
```

### Step 4 — Files to create / configure

**`.env`** — Edit the generated `.env`:

```yaml
APP_NAME=CandidatureTracker
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=candidature_tracker
DB_USERNAME=sail
DB_PASSWORD=password
```

**`.gitignore`** — Verify these lines exist (add if missing):

```yaml
/vendor/
/node_modules/
.env
.env.backup
/storage/*.key
/public/hot
/public/storage
```

**`compose.yaml`** — Created automatically by Sail. Verify it contains these services:

```yaml
services:
    laravel.test:
        build:
            context: ./vendor/laravel/sail/runtimes/8.3
            dockerfile: Dockerfile
        ports:
            - '${APP_PORT:-80}:80'
        environment:
            - DB_HOST=mysql
        depends_on:
            - mysql
    mysql:
        image: 'mysql/mysql-server:8.0'
        ports:
            - '${FORWARD_DB_PORT:-3306}:3306'
        environment:
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            MYSQL_DATABASE: '${DB_DATABASE}'
            MYSQL_USER: '${DB_USERNAME}'
            MYSQL_PASSWORD: '${DB_PASSWORD}'
        volumes:
            - 'sail-mysql:/var/lib/mysql'
    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        ports:
            - '8081:80'
        environment:
            PMA_HOST: mysql
        depends_on:
            - mysql
volumes:
    sail-mysql:
        driver: local
```

> ⚠️ **phpMyAdmin is not added by Sail automatically** — add it manually to `compose.yaml` as shown above.

### Step 5 — Start Docker and verify

```bash
./vendor/bin/sail up -d

# Add alias for convenience (add to ~/.bashrc or ~/.zshrc)
alias sail='./vendor/bin/sail'

# Verify the app is running
# → http://localhost should show the Laravel welcome page
```

### Step 6 — Generate app key

```bash
sail artisan key:generate
```

### Step 7 — Configure Pest for TDD

```bash
sail composer require pestphp/pest pestphp/pest-plugin-laravel --dev
sail artisan pest:install

# Create a dedicated test database
# Add to .env:
# DB_TEST_DATABASE=candidature_tracker_test

# phpunit.xml — verify the test database environment:
# <env name="DB_DATABASE" value="candidature_tracker_test"/>
# <env name="APP_ENV" value="testing"/>
```

### Step 8 — Initial commit

```bash
git add .
git commit -m "Initial Laravel + Sail setup with MySQL, phpMyAdmin and Pest"
git push origin main
```

### Step 9 — Create feature branches

```bash
git checkout -b feature/auth
git push origin feature/auth

git checkout main
git checkout -b feature/candidatures
git push origin feature/candidatures

git checkout main
git checkout -b feature/entretiens
git push origin feature/entretiens

git checkout main
git checkout -b feature/api
git push origin feature/api
```

---

## 📋 Legend

| Label | Meaning |
|-------|---------|
| `ARCH` | Architecture / Setup |
| `DOCKER` | Docker / Infrastructure |
| `AUTH` | Authentication |
| `CAND` | Candidature Management |
| `ENT` | Entretien Management |
| `POLICY` | Policies & Authorization |
| `TEST` | Pest Tests (TDD) |
| `QA` | Code Quality / Security |
| `DEBUG` | Debugging Tools |
| `DOC` | Documentation / Livrables |
| `BONUS` | Bonus Feature |

---

## 🏃 Sprint 1 — Infrastructure, Setup & First Tests

**Objectif:** Docker up, Laravel initialized, Pest configured, migrations ready, debugging tools installed, Tailwind working
**Durée:** Jour 1 — Lundi 18/05

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-01 | Initialize GitHub repo + branches | `ARCH` | High | 0.3h | **Action:**<br>- Create branches: `feature/auth`, `feature/candidatures`, `feature/entretiens`, `feature/api`<br>- `.gitignore`: ignore `vendor/`, `.env`, `node_modules/`, `storage/*.key`<br>- `README.md`: push initial skeleton<br>- Jira board created and shared with `abderahmane.merradou@gmail.com` before 16:00 |
| [ ] | T-02 | Install Laravel via Sail | `DOCKER` | High | 1h | **Action:**<br>- Follow the Docker Setup section above<br>- `composer create-project laravel/laravel candidature-tracker-temp`<br>- Copy files into cloned repo<br>- `composer require laravel/sail --dev`<br>- `php artisan sail:install` → choose **mysql**<br>- Add phpMyAdmin service manually to `compose.yaml` |
| [ ] | T-03 | Start Docker + verify environment | `DOCKER` | High | 0.5h | **Action:**<br>- `./vendor/bin/sail up -d`<br>- Verify `http://localhost` → Laravel welcome page<br>- Verify `http://localhost:8081` → phpMyAdmin login<br>- Add alias: `alias sail='./vendor/bin/sail'` |
| [ ] | T-04 | Configure `.env` | `ARCH` | High | 0.3h | **Files to Edit:**<br>- `.env`: `APP_NAME=CandidatureTracker`, `DB_HOST=mysql`, `DB_DATABASE=candidature_tracker`, `DB_USERNAME=sail`, `DB_PASSWORD=password`<br>- `APP_URL=http://localhost`<br>- Run `sail artisan key:generate` if not done |
| [ ] | T-05 | Install Tailwind CSS (v4) | `ARCH` | High | 0.5h | **Action:**<br>- `sail npm install`<br>- `sail npm install -D @tailwindcss/vite`<br>- Edit `vite.config.js` → add `@tailwindcss/vite` plugin<br>- `resources/css/app.css` → add `@import 'tailwindcss';`<br>- `sail npm run dev` → verify styles load on welcome page |
| [ ] | T-06 | Install + configure Pest | `TEST` | High | 0.5h | **Action:**<br>- `sail composer require pestphp/pest pestphp/pest-plugin-laravel --dev`<br>- `sail artisan pest:install`<br>- `phpunit.xml`: set `DB_DATABASE=candidature_tracker_test`, `APP_ENV=testing`<br>- `sail artisan test` → must pass the default welcome test ✅<br>- Add `uses(RefreshDatabase::class)` in `tests/Pest.php` for Feature tests |
| [ ] | T-07 | Migration — Table `users` (default) | `ARCH` | High | 0.2h | **Action:**<br>- Default Laravel `users` migration is already present<br>- Verify columns: `id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `timestamps`<br>- No changes needed — Breeze will handle it |
| [ ] | T-08 | Migration — Table `candidatures` | `ARCH` | High | 1h | **Files to Create:**<br>- `sail artisan make:migration create_candidatures_table`<br>- **Columns:** `id` (PK), `user_id` (FK → users.id, onDelete cascade), `company` (string, 255), `position` (string, 255), `offer_url` (string, nullable), `status` (enum: `['sent', 'interview', 'offer', 'rejected', 'withdrawn']`, default: `sent`), `priority` (enum: `['low', 'medium', 'high']`, default: `medium`), `notes` (text, nullable), `applied_at` (date), `deleted_at` (timestamp, nullable — for SoftDeletes), `timestamps`<br>- Use `$table->softDeletes();` — do NOT add `deleted_at` manually |
| [ ] | T-09 | Migration — Table `entretiens` | `ARCH` | High | 1h | **Files to Create:**<br>- `sail artisan make:migration create_entretiens_table`<br>- **Columns:** `id` (PK), `candidature_id` (FK → candidatures.id, onDelete cascade), `type` (enum: `['phone', 'video', 'onsite', 'technical', 'hr']`), `scheduled_at` (datetime), `preparation_notes` (text, nullable), `result` (enum: `['pending', 'passed', 'failed']`, default: `pending`), `timestamps` |
| [ ] | T-10 | Model `Candidature` + SoftDeletes + relationships | `ARCH` | High | 1h | **Files to Create:**<br>- `sail artisan make:model Candidature`<br>- Add `use SoftDeletes;` trait (import `Illuminate\Database\Eloquent\SoftDeletes`)<br>- `$fillable = ['user_id', 'company', 'position', 'offer_url', 'status', 'priority', 'notes', 'applied_at']`<br>- Relationships:<br>&nbsp;&nbsp;- `user(): BelongsTo` → `User::class`<br>&nbsp;&nbsp;- `entretiens(): HasMany` → `Entretien::class`<br>- **Accessor `getStatusLabelAttribute()`:**<br>&nbsp;&nbsp;`return match($this->status) { 'sent' => 'Envoyée', 'interview' => 'Entretien', 'offer' => 'Offre reçue', 'rejected' => 'Refusée', 'withdrawn' => 'Retirée' };`<br>- **Accessor `getPriorityLabelAttribute()`:**<br>&nbsp;&nbsp;`return match($this->priority) { 'low' => 'Basse', 'medium' => 'Moyenne', 'high' => 'Haute' };` |
| [ ] | T-11 | Model `Entretien` + relationships | `ARCH` | High | 0.5h | **Files to Create:**<br>- `sail artisan make:model Entretien`<br>- `$fillable = ['candidature_id', 'type', 'scheduled_at', 'preparation_notes', 'result']`<br>- Relationships:<br>&nbsp;&nbsp;- `candidature(): BelongsTo` → `Candidature::class`<br>- **Accessor `getTypeLabelAttribute()`:**<br>&nbsp;&nbsp;`return match($this->type) { 'phone' => 'Téléphonique', 'video' => 'Visioconférence', 'onsite' => 'Présentiel', 'technical' => 'Technique', 'hr' => 'RH' };`<br>- **Accessor `getResultLabelAttribute()`:**<br>&nbsp;&nbsp;`return match($this->result) { 'pending' => 'En attente', 'passed' => 'Réussi', 'failed' => 'Échoué' };` |
| [ ] | T-12 | Model `User` + relationships | `ARCH` | High | 0.3h | **Files to Edit:**<br>- `app/Models/User.php`<br>- Add: `candidatures(): HasMany` → `Candidature::class`<br>- Verify `$fillable` includes `name`, `email`, `password` |
| [ ] | T-13 | Seeders | `ARCH` | High | 1h | **Files to Create:**<br>- `sail artisan make:seeder UserSeeder` → 2 users: `test@example.com` / `password` and `other@example.com` / `password`<br>- `sail artisan make:seeder CandidatureSeeder` → 5 candidatures for user 1 (mixed statuses and priorities), 2 for user 2<br>- `sail artisan make:seeder EntretienSeeder` → 3 entretiens distributed across candidatures of user 1<br>- `DatabaseSeeder.php`: call all three seeders in order<br>- `sail artisan migrate:fresh --seed` must pass ✅ |
| [ ] | T-14 | Install Laravel Debugbar | `DEBUG` | High | 0.5h | **Action:**<br>- `sail composer require barryvdh/laravel-debugbar --dev`<br>- Set `DEBUGBAR_ENABLED=true` in `.env` (only in dev)<br>- Open `http://localhost` → Debugbar panel must appear at bottom<br>- Confirm the **SQL** tab is visible |
| [ ] | T-15 | Pest — Model unit tests | `TEST` | High | 1h | **Files to Create:**<br>- `sail artisan pest:test Unit/CandidatureTest --unit`<br>- **Tests to write:**<br>&nbsp;&nbsp;- `it('has correct fillable fields')` → assert `$fillable` matches expected array<br>&nbsp;&nbsp;- `it('returns status_label accessor in French')` → create model instance, assert each status maps to correct French label<br>&nbsp;&nbsp;- `it('returns priority_label accessor in French')` → same for priority<br>&nbsp;&nbsp;- `it('belongs to a user')` → assert relationship method exists and returns correct type<br>&nbsp;&nbsp;- `it('has many entretiens')` → assert relationship exists<br>- `sail artisan pest:test Unit/EntretienTest --unit`<br>&nbsp;&nbsp;- `it('returns type_label accessor in French')`<br>&nbsp;&nbsp;- `it('returns result_label accessor in French')`<br>&nbsp;&nbsp;- `it('belongs to a candidature')`<br>- `sail artisan test` → all unit tests must pass ✅ |

**Sprint 1 — Definition of Done:**

- [ ] `sail up -d` starts all services without error
- [ ] `http://localhost` shows Laravel + Tailwind working
- [ ] `http://localhost:8081` shows phpMyAdmin
- [ ] `sail artisan migrate:fresh --seed` runs cleanly with no errors
- [ ] Debugbar visible on every page
- [ ] `sail artisan test` passes all unit tests (models, accessors, relationships)
- [ ] All 2 models have `$fillable`, relationships and accessors defined

---

## 🏃 Sprint 2 — Authentication (US1)

**Objectif:** Registration, Login and Logout fully functional with main layout
**Durée:** Jour 2 matin — Mardi 19/05
**Branch:** `feature/auth`

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-16 | Install Laravel Breeze (Blade) | `AUTH` | High | 0.5h | **Action:**<br>- `sail composer require laravel/breeze --dev`<br>- `sail artisan breeze:install blade`<br>- `sail npm run dev`<br>- `sail artisan migrate`<br>- Test `http://localhost/register` → register form must appear |
| [ ] | T-17 | `US1` — Register / Login / Logout | `AUTH` | High | 1.5h | **Files to Verify/Edit:**<br>- `resources/views/auth/register.blade.php`: fields `name`, `email`, `password`, `password_confirmation`, `@csrf`, `@error` messages<br>- `resources/views/auth/login.blade.php`: fields `email`, `password`, `@csrf`<br>- `RegisteredUserController@store`: validate → `User::create()` → redirect `/dashboard`<br>- `AuthenticatedSessionController@destroy`: `Auth::logout()` → redirect `/`<br>- **Routes:** `GET/POST /register`, `GET/POST /login`, `POST /logout` |
| [ ] | T-18 | Main layout `layouts/app.blade.php` | `AUTH` | High | 1.5h | **Files to Create/Edit:**<br>- `resources/views/layouts/app.blade.php`:<br>&nbsp;&nbsp;- `@vite(['resources/css/app.css', 'resources/js/app.js'])` in `<head>`<br>&nbsp;&nbsp;- Navbar with `@auth` → Dashboard + Logout button `\| @guest` → Login + Register<br>&nbsp;&nbsp;- Flash messages: `@if(session('success'))` and `@if(session('error'))`<br>&nbsp;&nbsp;- `@yield('content')` in main body |
| [ ] | T-19 | Protect all routes under `auth` middleware | `AUTH` | High | 0.3h | **Files to Edit:**<br>- `routes/web.php`: wrap all candidature + entretien routes in `Route::middleware('auth')->group(function () { ... })`<br>- Redirect to `/login` is default behavior with `auth` middleware<br>- Test: direct access to `/dashboard` without login → must redirect to `/login` |
| [ ] | T-20 | Pest — Authentication feature tests | `TEST` | High | 1.5h | **Files to Create:**<br>- `sail artisan pest:test Feature/AuthTest`<br>- **Tests to write:**<br>&nbsp;&nbsp;- `it('allows a guest to register with valid data')` → POST `/register`, assert user created in DB, assert redirected to `/dashboard`<br>&nbsp;&nbsp;- `it('blocks registration with invalid data')` → POST without email, assert session has errors<br>&nbsp;&nbsp;- `it('allows a registered user to login')` → POST `/login`, assert authenticated<br>&nbsp;&nbsp;- `it('rejects login with wrong password')` → assert not authenticated<br>&nbsp;&nbsp;- `it('logs out an authenticated user')` → POST `/logout`, assert guest<br>&nbsp;&nbsp;- `it('redirects guests to login when accessing dashboard')` → GET `/dashboard`, assert redirect to `/login`<br>- `sail artisan test` → all auth tests must pass ✅ |

**Sprint 2 — Definition of Done:**

- [ ] Registration creates a new user and redirects to `/dashboard`
- [ ] Login with seeded credentials works
- [ ] Logout redirects to `/` or `/login`
- [ ] Direct access to `/dashboard` without login → redirect `/login`
- [ ] `@auth`/`@guest` in layout shows correct nav links
- [ ] Flash messages display correctly
- [ ] All authentication Pest tests pass ✅

---

## 🏃 Sprint 3 — Candidatures CRUD + Filtres (US2, US3, US4, US5, US6, US7, US8, US9)

**Objectif:** Full candidature management — list, create, edit, archive, restore, filter
**Durée:** Jour 2 après-midi + Jour 3 — Mardi 19/05 → Mercredi 20/05
**Branch:** `feature/candidatures`

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-21 | `CandidaturePolicy` — Authorization rules | `POLICY` | High | 1h | **Files to Create:**<br>- `sail artisan make:policy CandidaturePolicy --model=Candidature`<br>- **Methods to define:**<br>&nbsp;&nbsp;- `viewAny(User $user)` → always true (any auth user can view their own list)<br>&nbsp;&nbsp;- `view(User $user, Candidature $candidature)` → `$candidature->user_id === $user->id`<br>&nbsp;&nbsp;- `create(User $user)` → always true<br>&nbsp;&nbsp;- `update(User $user, Candidature $candidature)` → `$candidature->user_id === $user->id`<br>&nbsp;&nbsp;- `delete(User $user, Candidature $candidature)` → `$candidature->user_id === $user->id`<br>&nbsp;&nbsp;- `restore(User $user, Candidature $candidature)` → `$candidature->user_id === $user->id`<br>&nbsp;&nbsp;- `forceDelete(User $user, Candidature $candidature)` → `$candidature->user_id === $user->id` |
| [ ] | T-22 | `CandidatureController` — Scaffold | `CAND` | High | 0.5h | **Files to Create:**<br>- `sail artisan make:controller CandidatureController --resource`<br>- Add `$this->authorize()` calls in every relevant method<br>- Use `with()` on every query — zero N+1 |
| [ ] | T-23 | `US2` — Dashboard (candidature list) | `CAND` | High | 2h | **Files to Create/Edit:**<br>- `CandidatureController@index`:<br>&nbsp;&nbsp;- `$candidatures = auth()->user()->candidatures()->withCount('entretiens')->get()`<br>&nbsp;&nbsp;- Pass to view: `['candidatures' => $candidatures]`<br>- `resources/views/candidatures/index.blade.php`:<br>&nbsp;&nbsp;- `@forelse` loop — display empty state if no candidatures<br>&nbsp;&nbsp;- Card per candidature: company, position, `$cand->status_label`, `$cand->priority_label`, applied_at, entretien count<br>&nbsp;&nbsp;- Edit + Archive buttons<br>- **Route:** `GET /dashboard` → `candidatures.index` (named route) |
| [ ] | T-24 | `US3` — Create a candidature | `CAND` | High | 1.5h | **Files to Create/Edit:**<br>- `CandidatureController@create`: `$this->authorize('create', Candidature::class)`<br>- `CandidatureController@store`:<br>&nbsp;&nbsp;- `$this->authorize('create', Candidature::class)`<br>&nbsp;&nbsp;- Validate via `StoreCandidatureRequest`<br>&nbsp;&nbsp;- `Candidature::create([..., 'user_id' => auth()->id()])`<br>- `resources/views/candidatures/create.blade.php`: fields `company`, `position`, `offer_url`, `status` (select), `priority` (select), `notes`, `applied_at`, `@csrf`<br>- **Routes:** `GET /candidatures/create` → `candidatures.create` · `POST /candidatures` → `candidatures.store` |
| [ ] | T-25 | `StoreCandidatureRequest` + `UpdateCandidatureRequest` | `ARCH` | High | 0.5h | **Files to Create:**<br>- `sail artisan make:request StoreCandidatureRequest`<br>&nbsp;&nbsp;- `authorize()` → `return true;`<br>&nbsp;&nbsp;- `rules()`: `company\|required\|string\|max:255`, `position\|required\|string\|max:255`, `offer_url\|nullable\|url`, `status\|required\|in:sent,interview,offer,rejected,withdrawn`, `priority\|required\|in:low,medium,high`, `notes\|nullable\|string`, `applied_at\|required\|date`<br>- `sail artisan make:request UpdateCandidatureRequest`<br>&nbsp;&nbsp;- Same rules as Store |
| [ ] | T-26 | `US4` — View candidature detail | `CAND` | High | 1h | **Files to Create/Edit:**<br>- `CandidatureController@show`:<br>&nbsp;&nbsp;- `$this->authorize('view', $candidature)`<br>&nbsp;&nbsp;- `$candidature->load('entretiens')`<br>- `resources/views/candidatures/show.blade.php`:<br>&nbsp;&nbsp;- All candidature fields with French labels<br>&nbsp;&nbsp;- Entretien list section: type label, scheduled_at, result label<br>&nbsp;&nbsp;- "Add Entretien" button<br>- **Route:** `GET /candidatures/{candidature}` → `candidatures.show` |
| [ ] | T-27 | `US5` — Edit a candidature | `CAND` | High | 1.5h | **Files to Create/Edit:**<br>- `CandidatureController@edit`:<br>&nbsp;&nbsp;- `$this->authorize('update', $candidature)`<br>- `CandidatureController@update`:<br>&nbsp;&nbsp;- `$this->authorize('update', $candidature)`<br>&nbsp;&nbsp;- Validate via `UpdateCandidatureRequest`<br>&nbsp;&nbsp;- `$candidature->update($validated)`<br>- `resources/views/candidatures/edit.blade.php`: pre-filled form with `@method('PUT')`, `@csrf`<br>- **Routes:** `GET /candidatures/{candidature}/edit` → `candidatures.edit` · `PUT /candidatures/{candidature}` → `candidatures.update` |
| [ ] | T-28 | `US6` — Archive a candidature (SoftDelete) | `CAND` | High | 1h | **Files to Edit:**<br>- `CandidatureController@destroy`:<br>&nbsp;&nbsp;- `$this->authorize('delete', $candidature)`<br>&nbsp;&nbsp;- `$candidature->delete()` (SoftDeletes — sets `deleted_at`)<br>&nbsp;&nbsp;- `return redirect()->route('candidatures.index')->with('success', 'Candidature archivée.')`<br>- Archive button in `candidatures/index.blade.php` with `@method('DELETE')` form, `@csrf`<br>- **Route:** `DELETE /candidatures/{candidature}` → `candidatures.destroy` |
| [ ] | T-29 | `US7` + `US8` — Archives page + Restore | `CAND` | High | 1.5h | **Files to Create/Edit:**<br>- `CandidatureController@archives`:<br>&nbsp;&nbsp;- `Candidature::onlyTrashed()->where('user_id', auth()->id())->get()`<br>- `CandidatureController@restore`:<br>&nbsp;&nbsp;- `$candidature = Candidature::onlyTrashed()->findOrFail($id)`<br>&nbsp;&nbsp;- `$this->authorize('restore', $candidature)`<br>&nbsp;&nbsp;- `$candidature->restore()`<br>- `resources/views/candidatures/archives.blade.php`: `@forelse`, list with Restore button<br>- **Routes:** `GET /candidatures/archives` → `candidatures.archives` · `PATCH /candidatures/{candidature}/restore` → `candidatures.restore` |
| [ ] | T-30 | `US9` — Filtres statut + priorité | `CAND` | High | 1.5h | **Files to Edit:**<br>- `CandidatureController@index`:<br>&nbsp;&nbsp;- Read `$request->status` and `$request->priority` query params<br>&nbsp;&nbsp;- Chain `->when($status, fn($q) => $q->where('status', $status))`<br>&nbsp;&nbsp;- Chain `->when($priority, fn($q) => $q->where('priority', $priority))`<br>- `candidatures/index.blade.php`:<br>&nbsp;&nbsp;- Filter form: `GET` method, `select` for status (options in French), `select` for priority, Submit + Reset button<br>&nbsp;&nbsp;- Preserve active filter values with `old()` or `request()` helper<br>- **Route:** reuses `GET /dashboard` with query params |
| [ ] | T-31 | Pest — Candidature policy tests | `TEST` | High | 1.5h | **Files to Create:**<br>- `sail artisan pest:test Feature/CandidaturePolicyTest`<br>- **Tests to write:**<br>&nbsp;&nbsp;- `it('blocks a user from viewing another user candidature')` → actingAs(user2), GET `/candidatures/{user1_cand}`, assert 403<br>&nbsp;&nbsp;- `it('blocks a user from editing another user candidature')` → actingAs(user2), GET `/candidatures/{user1_cand}/edit`, assert 403<br>&nbsp;&nbsp;- `it('blocks a user from updating another user candidature')` → actingAs(user2), PUT `/candidatures/{user1_cand}`, assert 403<br>&nbsp;&nbsp;- `it('blocks a user from archiving another user candidature')` → actingAs(user2), DELETE `/candidatures/{user1_cand}`, assert 403<br>&nbsp;&nbsp;- `it('allows a user to manage their own candidature')` → actingAs(owner), assert 200/redirect<br>- `sail artisan test` → all policy tests must pass ✅ |
| [ ] | T-32 | Pest — Candidature CRUD feature tests | `TEST` | High | 2h | **Files to Create:**<br>- `sail artisan pest:test Feature/CandidatureCrudTest`<br>- **Tests to write:**<br>&nbsp;&nbsp;- `it('creates a candidature with valid data')` → actingAs(user), POST `/candidatures`, assert in DB, assert redirect<br>&nbsp;&nbsp;- `it('rejects candidature creation with missing required fields')` → POST without company, assert session errors<br>&nbsp;&nbsp;- `it('updates a candidature')` → actingAs(owner), PUT, assert updated in DB<br>&nbsp;&nbsp;- `it('archives a candidature using soft delete')` → DELETE, assert `deleted_at` is not null in DB<br>&nbsp;&nbsp;- `it('restores an archived candidature')` → PATCH restore, assert `deleted_at` is null<br>&nbsp;&nbsp;- `it('shows archived candidature in archives page')` → soft-delete, GET archives, assert company visible<br>&nbsp;&nbsp;- `it('filters candidatures by status')` → create 2 candidatures with different statuses, GET with filter, assert only correct one shown<br>- `sail artisan test` → all CRUD tests must pass ✅ |

**Sprint 3 — Definition of Done:**

- [ ] Dashboard shows only the authenticated user's candidatures
- [ ] French labels used everywhere (`status_label`, `priority_label`) — no raw enum values in views
- [ ] `@forelse` on all lists with empty state handled
- [ ] Create, edit, archive, restore all functional
- [ ] Filters by status and priority work correctly
- [ ] Policy blocks cross-user access (403)
- [ ] Zero `abort(403)` — all through `$this->authorize()`
- [ ] All Pest CRUD and Policy tests pass ✅

---

## 🏃 Sprint 4 — Entretiens CRUD (US10, US11)

**Objectif:** Full entretien management — add, edit, delete within a candidature
**Durée:** Jour 4 matin — Jeudi 21/05
**Branch:** `feature/entretiens`

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-33 | `EntretienPolicy` — Authorization rules | `POLICY` | High | 1h | **Files to Create:**<br>- `sail artisan make:policy EntretienPolicy --model=Entretien`<br>- **Methods to define:**<br>&nbsp;&nbsp;- `create(User $user, Candidature $candidature)` → `$candidature->user_id === $user->id`<br>&nbsp;&nbsp;- `update(User $user, Entretien $entretien)` → `$entretien->candidature->user_id === $user->id`<br>&nbsp;&nbsp;- `delete(User $user, Entretien $entretien)` → `$entretien->candidature->user_id === $user->id`<br>- **Note:** always eager-load `candidature` before running policy checks to avoid N+1 |
| [ ] | T-34 | `EntretienController` — Scaffold | `ENT` | High | 0.5h | **Files to Create:**<br>- `sail artisan make:controller EntretienController --resource`<br>- All methods must call `$this->authorize()` before any action<br>- All queries must use `with()` — zero N+1 |
| [ ] | T-35 | `US10` — Add an entretien | `ENT` | High | 2h | **Files to Create/Edit:**<br>- `EntretienController@create`:<br>&nbsp;&nbsp;- Receive `$candidature` from route<br>&nbsp;&nbsp;- `$this->authorize('create', [Entretien::class, $candidature])`<br>- `EntretienController@store`:<br>&nbsp;&nbsp;- `$this->authorize('create', [Entretien::class, $candidature])`<br>&nbsp;&nbsp;- Validate via `StoreEntretienRequest`<br>&nbsp;&nbsp;- `Entretien::create([..., 'candidature_id' => $candidature->id])`<br>&nbsp;&nbsp;- Redirect to `candidatures.show`<br>- `resources/views/entretiens/create.blade.php`:<br>&nbsp;&nbsp;- Fields: `type` (select: options in French), `scheduled_at` (datetime-local input), `preparation_notes` (textarea, optional), `result` (select), `@csrf`<br>- **Routes:** `GET /candidatures/{candidature}/entretiens/create` → `entretiens.create` · `POST /candidatures/{candidature}/entretiens` → `entretiens.store` |
| [ ] | T-36 | `StoreEntretienRequest` + `UpdateEntretienRequest` | `ARCH` | High | 0.5h | **Files to Create:**<br>- `sail artisan make:request StoreEntretienRequest`<br>&nbsp;&nbsp;- `authorize()` → `return true;`<br>&nbsp;&nbsp;- `rules()`: `type\|required\|in:phone,video,onsite,technical,hr`, `scheduled_at\|required\|date`, `preparation_notes\|nullable\|string`, `result\|required\|in:pending,passed,failed`<br>- `sail artisan make:request UpdateEntretienRequest`<br>&nbsp;&nbsp;- Same rules as Store |
| [ ] | T-37 | `US11` — Edit + Delete an entretien | `ENT` | High | 1.5h | **Files to Create/Edit:**<br>- `EntretienController@edit`:<br>&nbsp;&nbsp;- `$this->authorize('update', $entretien)`<br>- `EntretienController@update`:<br>&nbsp;&nbsp;- `$this->authorize('update', $entretien)`<br>&nbsp;&nbsp;- Validate via `UpdateEntretienRequest`, `$entretien->update($validated)`<br>- `EntretienController@destroy`:<br>&nbsp;&nbsp;- `$this->authorize('delete', $entretien)`<br>&nbsp;&nbsp;- `$entretien->delete()` + redirect to `candidatures.show` with flash<br>- `resources/views/entretiens/edit.blade.php`: pre-filled form, `@method('PUT')`, `@csrf`<br>- `candidatures/show.blade.php`: Edit + Delete buttons per entretien (`@method('DELETE')`, `@csrf`, JS confirm)<br>- **Routes:** `GET /entretiens/{entretien}/edit` → `entretiens.edit` · `PUT /entretiens/{entretien}` → `entretiens.update` · `DELETE /entretiens/{entretien}` → `entretiens.destroy` |
| [ ] | T-38 | Pest — Entretien policy tests | `TEST` | High | 1h | **Files to Create:**<br>- `sail artisan pest:test Feature/EntretienPolicyTest`<br>- **Tests to write:**<br>&nbsp;&nbsp;- `it('blocks a user from adding entretien to another user candidature')` → actingAs(user2), POST to user1 candidature entretiens, assert 403<br>&nbsp;&nbsp;- `it('blocks a user from editing another user entretien')` → assert 403<br>&nbsp;&nbsp;- `it('blocks a user from deleting another user entretien')` → assert 403<br>&nbsp;&nbsp;- `it('allows the owner to manage their entretiens')` → assert correct redirect/200<br>- `sail artisan test` → all policy tests must pass ✅ |
| [ ] | T-39 | Pest — Entretien CRUD feature tests | `TEST` | High | 1.5h | **Files to Create:**<br>- `sail artisan pest:test Feature/EntretienCrudTest`<br>- **Tests to write:**<br>&nbsp;&nbsp;- `it('creates an entretien with valid data')` → actingAs(owner), POST, assert in DB with correct `candidature_id`<br>&nbsp;&nbsp;- `it('rejects entretien creation with invalid type')` → POST with `type=invalid`, assert session errors<br>&nbsp;&nbsp;- `it('rejects entretien creation with past scheduled_at')` → assert session errors (if validation includes `after:now`)<br>&nbsp;&nbsp;- `it('updates an entretien')` → PUT, assert updated in DB<br>&nbsp;&nbsp;- `it('deletes an entretien')` → DELETE, assert not in DB<br>&nbsp;&nbsp;- `it('shows entretiens on candidature detail page')` → GET `candidatures.show`, assert entretien type label visible<br>- `sail artisan test` → all entretien tests must pass ✅ |

**Sprint 4 — Definition of Done:**

- [ ] Entretiens display on candidature detail page with French labels
- [ ] Add entretien (scoped to a candidature) — works correctly
- [ ] Edit entretien — pre-filled form functional
- [ ] Delete entretien — removed from DB, redirect with flash
- [ ] Policy blocks cross-user access for all entretien actions
- [ ] Zero `abort(403)` — all through `$this->authorize()`
- [ ] Zero N+1 — all queries use `with()`
- [ ] All Pest entretien tests pass ✅

---

## 🏃 Sprint 5 — Bonus Features

**Objectif:** Extra features for additional credit
**Durée:** Jour 4 fin — Jeudi 21/05 (si temps disponible)

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-40 | Bonus — File Storage (CV, lettre de motivation) | `BONUS` | Low | 2h | **Files to Edit:**<br>- Migration: add `attachment_path` (string, nullable) to `candidatures` table via new migration<br>- `Candidature::$fillable`: add `attachment_path`<br>- `StoreCandidatureRequest` / `UpdateCandidatureRequest`: add `attachment\|nullable\|file\|mimes:pdf,doc,docx\|max:2048`<br>- `CandidatureController@store`: `$path = $request->file('attachment')->store('attachments', 'public');` then save path<br>- `CandidatureController@destroy`: `Storage::disk('public')->delete($candidature->attachment_path)` before soft delete<br>- `candidatures/show.blade.php`: show download link if `attachment_path` exists<br>- `sail artisan storage:link` to create symlink<br>- **Pest test:** `it('stores an attachment with a candidature')`, `it('deletes the attachment when candidature is force deleted')` |
| [ ] | T-41 | Bonus — Pest tests: unauthorized access | `BONUS` | Low | 1h | **Files to Create/Edit:**<br>- `sail artisan pest:test Feature/UnauthorizedAccessTest`<br>- **Tests to write:**<br>&nbsp;&nbsp;- `it('redirects unauthenticated user from dashboard to login')` → GET `/dashboard`, assert redirect `/login`<br>&nbsp;&nbsp;- `it('redirects unauthenticated user from candidature create to login')` → GET `/candidatures/create`, assert redirect<br>&nbsp;&nbsp;- `it('redirects unauthenticated user from archives to login')` → GET `/candidatures/archives`, assert redirect<br>&nbsp;&nbsp;- `it('returns 403 when user accesses another user candidature via show')` → assert 403<br>- `sail artisan test` → all tests must pass ✅ |
| [ ] | T-42 | Bonus — Force delete from Archives | `BONUS` | Low | 0.5h | **Files to Edit:**<br>- `CandidatureController@forceDelete`:<br>&nbsp;&nbsp;- `$candidature = Candidature::onlyTrashed()->findOrFail($id)`<br>&nbsp;&nbsp;- `$this->authorize('forceDelete', $candidature)`<br>&nbsp;&nbsp;- If bonus T-40 done: `Storage::disk('public')->delete($candidature->attachment_path)`<br>&nbsp;&nbsp;- `$candidature->forceDelete()`<br>- `candidatures/archives.blade.php`: "Supprimer définitivement" button with JS confirm, `@method('DELETE')`, `@csrf`<br>- **Route:** `DELETE /candidatures/{candidature}/force` → `candidatures.force-delete` |

---

## 🏃 Sprint 6 — QA, Debugging & Livrables

**Objectif:** Security audit, N+1 fix, full test suite green, README, commits check
**Durée:** Jour 5 — Vendredi 22/05

| Done | # | Task | Label | Priority | Time | Detailed Implementation & Files |
| :---: | :--- | :--- | :---: | :---: | :---: | :--- |
| [ ] | T-43 | Audit — All Form Requests in place | `QA` | High | 0.5h | **Files to Audit:**<br>- `CandidatureController@store` → uses `StoreCandidatureRequest` (not `$request->validate()`) ✅<br>- `CandidatureController@update` → uses `UpdateCandidatureRequest` ✅<br>- `EntretienController@store` → uses `StoreEntretienRequest` ✅<br>- `EntretienController@update` → uses `UpdateEntretienRequest` ✅<br>- Auth forms → handled by Breeze ✅ |
| [ ] | T-44 | Audit — `@csrf` on all forms | `QA` | High | 0.3h | **Forms to Audit:**<br>- `candidatures/create.blade.php` → `@csrf` ✅<br>- `candidatures/edit.blade.php` → `@csrf` + `@method('PUT')` ✅<br>- `candidatures/index.blade.php` (archive form) → `@csrf` + `@method('DELETE')` ✅<br>- `candidatures/archives.blade.php` (restore form) → `@csrf` + `@method('PATCH')` ✅<br>- `entretiens/create.blade.php` → `@csrf` ✅<br>- `entretiens/edit.blade.php` → `@csrf` + `@method('PUT')` ✅<br>- `candidatures/show.blade.php` (delete entretien) → `@csrf` + `@method('DELETE')` ✅ |
| [ ] | T-45 | Audit — `$fillable` on all models | `QA` | High | 0.2h | **Files to Check:**<br>- `Candidature::$fillable` = `['user_id', 'company', 'position', 'offer_url', 'status', 'priority', 'notes', 'applied_at']`<br>- `Entretien::$fillable` = `['candidature_id', 'type', 'scheduled_at', 'preparation_notes', 'result']`<br>- `User::$fillable` = `['name', 'email', 'password']` (set by Breeze) |
| [ ] | T-46 | Audit — `@forelse` on all lists | `QA` | High | 0.3h | **Views to Check:**<br>- `candidatures/index.blade.php` → `@forelse` with `@empty` block showing "Aucune candidature active" ✅<br>- `candidatures/archives.blade.php` → `@forelse` with `@empty` showing "Aucune candidature archivée" ✅<br>- `candidatures/show.blade.php` (entretiens) → `@forelse` with `@empty` showing "Aucun entretien planifié" ✅ |
| [ ] | T-47 | Audit — Zero `abort(403)` | `POLICY` | High | 0.3h | **Action:**<br>- `grep -r "abort(403)" app/Http/Controllers/` → must return **0 results**<br>- Every authorization must go through `$this->authorize()`<br>- Every action button must use `@can` or `@cannot` in views |
| [ ] | T-48 | Debugbar — Detect and fix N+1 | `DEBUG` | High | 1h | **Action:**<br>- Open `/dashboard` → check SQL tab in Debugbar<br>- If N+1 detected (repeated queries for entretiens): fix with `->withCount('entretiens')`<br>- Open `/candidatures/{id}` → check entretiens queries<br>- Confirm total query count is stable regardless of number of candidatures/entretiens |
| [ ] | T-49 | Pest — Full test suite green | `TEST` | High | 1h | **Action:**<br>- `sail artisan test` → **all tests must pass** ✅<br>- Fix any failing tests before proceeding<br>- Check test coverage summary: models, auth, CRUD, policies, unauthorized access<br>- Expected minimum: ≥ 15 passing tests across all suites<br>- `sail artisan test --coverage` (optional) to visualize coverage |
| [ ] | T-50 | Full flow test — manual verification | `QA` | High | 1h | **Scenarios to verify:**<br>- Access `/dashboard` without login → redirect `/login` ✅<br>- Register new user → dashboard shows `@forelse` empty state ✅<br>- Create candidature → appears in dashboard with correct French labels ✅<br>- Edit candidature → pre-filled form, updates correctly ✅<br>- Filter by status → only matching candidatures shown ✅<br>- Archive candidature → disappears from dashboard ✅<br>- Navigate to archives → archived candidature visible ✅<br>- Restore → reappears in active list ✅<br>- Add entretien to candidature → appears on detail page with French labels ✅<br>- Edit + delete entretien → works correctly ✅<br>- Login as second user → cannot access first user's candidatures (403) ✅ |
| [ ] | T-51 | MCD & MLD | `DOC` | High | 1h | **Deadline: Lundi 18/05 avant 16:00**<br>- **MCD:** Entités (User, Candidature, Entretien), attributs sans types ni FK, relations avec cardinalités<br>- **MLD:** Tables avec types, PK (souligné), FK (avec flèches)<br>- Doit correspondre exactement aux migrations<br>- Format: draw.io, Looping, ou papier scanné |
| [ ] | T-52 | `README.md` complet | `DOC` | High | 0.5h | **Vérifier que README contient:**<br>- Description du projet<br>- Stack: Laravel 11, PHP 8.3, MySQL 8.0, Docker Sail, Tailwind CSS v4, Pest<br>- Instructions d'installation complètes (clone → env → sail up → migrate:fresh --seed)<br>- Credentials de test (email + password)<br>- Table des routes (toutes nommées)<br>- MCD & MLD (diagrams ou liens)<br>- Section concepts clés (Policies, SoftDeletes, Accessors, Form Requests)<br>- Commande pour lancer les tests: `sail artisan test` |
| [ ] | T-53 | Jira board + Backlog | `DOC` | High | 0.3h | **Action:**<br>- Vérifier que le board Jira est partagé avec `abderahmane.merradou@gmail.com` avant lundi 16h<br>- Sprint backlog complet avec toutes les US (US1 → US11)<br>- Chaque US a un ticket avec critères d'acceptation<br>- Historique visible (pas de tickets créés à la dernière minute) |
| [ ] | T-54 | Git audit — commits | `DOC` | High | 0.3h | **Action:**<br>- `git log --oneline` → vérifier ≥ 15 commits avec messages explicites<br>- Vérifier branches: `feature/auth`, `feature/candidatures`, `feature/entretiens`<br>- Exemples de messages corrects: `Add CandidaturePolicy with ownership checks`, `Implement SoftDeletes on Candidature model`, `Add status_label accessor to Candidature model`, `Fix N+1 on dashboard with eager loading`, `Add Pest tests for candidature CRUD`, `Implement filter by status and priority` |

**Sprint 6 — Definition of Done:**

- [ ] All forms have `@csrf` and use Form Request classes
- [ ] All models have `$fillable` defined
- [ ] `@forelse` used on all lists with empty state handled
- [ ] Zero `abort(403)` in controllers — all through `$this->authorize()`
- [ ] N+1 confirmed fixed via Debugbar
- [ ] `sail artisan test` → all tests pass ✅ (≥ 15 tests)
- [ ] Both user flows tested and working (own data vs cross-user 403)
- [ ] README complete with install instructions + credentials + `sail artisan test` command
- [ ] ≥ 15 commits with explicit messages

---

## 📦 Final Deliverables Checklist

| Livrable | Critère | Statut |
|----------|---------|--------|
| GitHub Repo | ≥ 15 commits avec messages explicites | ⬜ |
| GitHub Repo | Feature branches utilisées | ⬜ |
| GitHub Repo | README avec instructions d'installation complètes | ⬜ |
| Jira | Board partagé avec `abderahmane.merradou@gmail.com` avant lundi 16h | ⬜ |
| Jira | Sprint backlog complet dès lundi après-midi | ⬜ |
| MCD | Entités, attributs, relations avec cardinalités (sans types ni FK) | ⬜ |
| MLD | Tables, types, PK, FK | ⬜ |
| MCD/MLD | Soumis avant lundi 18/05 – 16:00 | ⬜ |
| Présentation | Structure slides respectée | ⬜ |
| Présentation | MCD et MLD slides obligatoires | ⬜ |
| Présentation | Démo live fonctionnelle | ⬜ |
| README.md | Installation complète avec Sail/Docker + credentials de test | ⬜ |
| README.md | Commande `sail artisan test` documentée | ⬜ |
| Migrations | Toutes les tables via migrations (zéro SQL manuel) | ⬜ |
| Seeders | Users, candidatures, entretiens avec statuts variés | ⬜ |
| Debugbar | N+1 identifié et corrigé | ⬜ |
| Tests Pest | `sail artisan test` → ≥ 15 tests passent | ⬜ |
| Tests Pest | Scénarios couverts: accès non autorisé, CRUD valide, CRUD invalide, archive/restauration | ⬜ |

---

## 🏆 Performance Criteria

### Respect du cahier des charges (20%)

| Critère | Statut |
|---------|--------|
| Toutes les User Stories livrées et fonctionnelles (US1 → US11) | ⬜ |
| Routes toutes nommées | ⬜ |
| Toutes les routes protégées par le middleware `auth` | ⬜ |
| Validation via Form Request classes — zéro `$request->validate()` dans les controllers | ⬜ |
| `$fillable` défini sur chaque modèle | ⬜ |
| `@csrf` sur tous les formulaires | ⬜ |
| `@forelse` sur toutes les listes avec cas vide géré | ⬜ |
| Soft Deletes sur `Candidature` avec archive et restauration fonctionnels | ⬜ |
| Statuts et priorités affichés en français dans les vues (via accessors) | ⬜ |
| Zéro N+1 vérifiable en live avec Debugbar | ⬜ |
| MCD et MLD corrects et validés | ⬜ |

### Maîtrise des concepts Laravel (30%)

| Critère | Statut |
|---------|--------|
| `CandidaturePolicy` + `EntretienPolicy` — `$this->authorize()` dans tous les controllers | ⬜ |
| Accessors `status_label`, `priority_label`, `type_label`, `result_label` utilisés dans les vues | ⬜ |
| Zéro `abort(403)` manuel dans le code | ⬜ |
| Relations Eloquent correctes (`hasMany`, `belongsTo`) avec eager loading | ⬜ |
| Capacité à expliquer chaque choix d'implémentation | ⬜ |

### Tests Pest (inclus dans maîtrise des concepts)

| Critère | Statut |
|---------|--------|
| Tests unitaires sur les models (accessors, relations, `$fillable`) | ⬜ |
| Tests feature sur l'authentification | ⬜ |
| Tests feature sur les politiques d'accès (403 cross-user) | ⬜ |
| Tests feature sur le CRUD candidatures (données valides et invalides) | ⬜ |
| Tests feature sur le CRUD entretiens | ⬜ |
| `sail artisan test` → ≥ 15 tests passent sans erreur | ⬜ |

### Qualité de la présentation et démonstration (15%)

| Critère | Statut |
|---------|--------|
| Démo live fluide et complète sans bug bloquant | ⬜ |
| Slides claires avec MCD/MLD expliqués | ⬜ |
| Discours structuré (contexte, architecture, décisions techniques, difficultés rencontrées) | ⬜ |

### Défense orale — Q&A (20%)

| Critère | Statut |
|---------|--------|
| Capacité à définir les concepts Laravel et PHP OOP utilisés dans le projet | ⬜ |
| Réponse structurée (nature, but, exemple tiré du code) | ⬜ |
| Explication démontrant la compréhension (ne pas réciter) | ⬜ |

### Mise en situation (15%)

| Critère | Statut |
|---------|--------|
| Compréhension rapide de la problématique soumise par le jury | ⬜ |
| Proposition d'une approche méthodique avant d'écrire du code | ⬜ |
| Exécution (même partielle) avec la bonne logique | ⬜ |

---

## 🎤 Entretien Individuel Prep (45 min)

### Phase 1 — Présentation + Démonstration (10 min)

| Scénario à démontrer | Préparé |
|----------------------|---------|
| Parcours complet : inscription → créer une candidature → ajouter un entretien | ⬜ |
| Archiver une candidature → aller dans les archives → restaurer | ⬜ |
| Filtrer la liste par statut et par priorité | ⬜ |
| Tenter d'accéder à la candidature d'un autre utilisateur → 403 | ⬜ |
| Lancer `sail artisan test` → tous les tests passent en live | ⬜ |

### Phase 2 — Code Review & Q&A (20 min)

| Concept | Préparé |
|---------|---------|
| Expliquer comment `CandidaturePolicy` bloque l'accès cross-user (montrer le code) | ⬜ |
| Expliquer comment `SoftDeletes` fonctionne et pourquoi `deleted_at` est utilisé | ⬜ |
| Expliquer comment l'accessor `status_label` transforme la valeur brute avant l'affichage | ⬜ |
| Expliquer pourquoi on utilise `StoreEntretienRequest` au lieu de `$request->validate()` | ⬜ |
| Montrer un test Pest et expliquer ce qu'il vérifie et pourquoi | ⬜ |
| Expliquer comment Debugbar a permis de détecter et corriger un N+1 | ⬜ |

### Phase 3 — Mise en situation (15 min)

| Compétence | Préparé |
|-----------|---------|
| Proposer une approche méthodique avant d'écrire du code | ⬜ |
| Identifier la bonne couche Laravel pour résoudre le problème soumis (Policy / Request / Controller / Model) | ⬜ |
| Écrire ou lire un test Pest pour valider un comportement attendu | ⬜ |

---

*Dernière mise à jour : 18/05/2026*
