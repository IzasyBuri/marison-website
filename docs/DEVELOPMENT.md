# Development Workflow

This guide is for one developer working on the Marison ID project from a home
computer and an office computer.

## Source of truth

GitHub is the source of truth for source code and project documentation. Each
computer should have its own local clone. Commit and push code and documentation
to GitHub; do not use Git to synchronize WordPress databases or uploads.

## Branches

| Branch | Purpose |
|---|---|
| `main` | Stable, approved code only |
| `develop` | Integration branch for development |
| `feat/*` | One new task or feature |
| `fix/*` | One bug fix |

Do not develop directly on `main`. One task should use one feature or fix branch.

## Start work on either computer

Open a terminal in the repository and update the integration branch:

```bash
git switch develop
git pull --ff-only origin develop
```

Create a branch for the task:

```bash
git switch -c feat/short-task-name
```

Use a clear branch name, such as `feat/project-search` or
`fix/mobile-navigation`.

## Local prerequisites

The foundation environment uses Docker Compose with the official WordPress and
MariaDB images. Install Docker Desktop with its Linux engine enabled before
starting the local runtime. Git is required. PHP, Composer, Node.js, and npm are
useful for later implementation work but are not required by the foundation
runtime itself.

Docker, Docker Compose, and image versions are selected in `docker-compose.yml`
through `.env`. The committed `.env.example` records the current development
version policy; update image versions deliberately, validate them locally, and
review the WordPress upgrade before changing the shared example.

## Local WordPress setup

From the repository root on a new computer:

```powershell
Copy-Item .env.example .env
docker compose config
docker compose up -d
```

Open `http://localhost:8080/` and complete the normal WordPress setup wizard.
Choose a local-only administrator username and password; never reuse production
credentials. The database connection is supplied by Compose. Activate **Marison**
under **Appearance → Themes** and **Marison Core** under **Plugins**.

The repository code is mounted into:

```text
wp-content/themes/marison/       → /var/www/html/wp-content/themes/marison/
wp-content/plugins/marison-core/ → /var/www/html/wp-content/plugins/marison-core/
```

WordPress core is provided by the container and is not committed to Git. The
database and WordPress runtime volume are local Docker volumes. Uploads and debug
logs are local runtime data and are ignored by Git.

Useful lifecycle commands:

```powershell
docker compose ps
docker compose logs -f wordpress
docker compose stop
docker compose start
docker compose down
```

To intentionally reset the local WordPress installation, including its database,
first confirm that no local content is needed and run:

```powershell
docker compose down -v
```

This is a local destructive operation only. It does not affect another computer,
GitHub, staging, or production.

## During work

1. Keep the task within its approved scope.
2. Keep presentation in the `marison` theme and business logic in
   `marison-core`.
3. Prefer native WordPress APIs and minimal dependencies.
4. Do not install plugins or page builders without explicit approval.
5. Do not place secrets or real production data in the repository.
6. Test changes locally before committing.
7. Check the changed-file list before staging files:

```bash
git status
git diff
```

## Finish work

Stage only intended files, commit, and push the task branch:

```bash
git add <intended-files>
git commit -m "Describe the task"
git push -u origin feat/short-task-name
```

Review the branch and merge it into `develop` through the agreed review process.
Only approved stable work should later move from `develop` to `main`.

## Switching computers

Before leaving one computer, push completed work to GitHub. On the other computer,
pull the relevant branch before continuing. Do not copy or commit a local
WordPress database to solve synchronization problems.

Local databases, uploads, caches, and local configuration are computer-specific.
If reproducible development fixtures are needed later, place sanitized fixtures
in `sample-data/` and create an approved importer separately. No importer exists
in the foundation phase.

Computer A and Computer B each keep their own `.env`, Docker volumes, WordPress
passwords, database, uploads, cache, and local settings. GitHub synchronizes only
the repository source, documentation, and approved non-sensitive sample data.

## Coding standards

- Follow WordPress PHP coding conventions and keep Marison business logic in
  `marison-core`, not in the theme.
- Validate input strictly, sanitize values at boundaries, escape output at render
  time, check capabilities, and use nonces for state-changing authenticated actions.
- Future custom SQL must use prepared queries and controlled migrations.
- Keep frontend JavaScript minimal; do not introduce a framework without approval.
- Keep CSS mobile-first, theme-owned, token-based, and aligned with
  `docs/DESIGN-SYSTEM.md`.
- Do not add ACF, Elementor, multilingual, SEO, caching, forms, or security
  plugins in the foundation phase.

## Directory responsibilities

| Directory | Responsibility |
|---|---|
| `docs/` | Project rules and development documentation |
| `wp-content/themes/marison/` | Future presentation theme |
| `wp-content/plugins/marison-core/` | Future Marison business-data plugin |
| `sample-data/` | Future non-sensitive reproducible development data |

## Unit inventory foundation phase

The current implementation phase includes the approved content-model foundation plus
the first managed Unit inventory foundation inside `marison-core`: a prefixed custom
Unit table, idempotent schema upgrade check, repository/data-access layer, explicit
availability source mode, and server-rendered admin inventory management.

Unit data survives plugin deactivation and uninstall. Normal upgrades run the schema
check automatically; administrators do not execute raw SQL. Local tests may create
temporary synthetic Unit rows, but must delete them before leaving the workspace.

It does not include frontend Unit presentation, public Unit routes, CSV import/export,
siteplan data, pricing, Leads, KPR, Career, multilingual integration, forms,
production connections, or deployment.

Location V1 enforces one three-level hierarchy and only allows Project assignment
to a depth-three City / Regency term. It does not store a separate semantic level
field or verify that a term name is actually a Country, Province, City, or Regency;
staff should follow the displayed Country → Province → City / Regency guidance.
