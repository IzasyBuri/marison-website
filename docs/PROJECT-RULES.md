# Marison ID Project Rules

These rules are permanent defaults for developers and AI agents working on this
repository.

## Project boundary

1. This is a greenfield rebuild for Marison Group's official website.
2. The existing `marison.id` website is a visual and content reference only.
3. Do not audit, modify, connect to, or deploy to the existing production site.
4. Do not infer authorization for work outside the requested task.
5. Ask for approval when a task would change the architecture, data model,
   dependencies, deployment setup, or project scope.

## Architecture

1. Keep presentation separate from business data.
2. The `marison` theme owns presentation, templates, styles, accessible markup,
   responsive layouts, and reusable display components.
3. The `marison-core` plugin will own Marison-specific business data and logic.
4. Do not put business data storage in the theme.
5. Do not create project post types, unit management, KPR configuration, career
   features, or other business features until explicitly approved.

## WordPress and dependencies

1. Use native WordPress features and editing wherever practical.
2. Elementor must not be used.
3. Do not install page builders.
4. Do not add WordPress plugins unless explicitly approved.
5. Do not add libraries or frameworks unless a clear requirement justifies them.
6. Prefer lightweight, maintainable, mobile-first implementation.
7. Preserve accessibility, secure coding practices, clear naming, and reusable
   components.

## Git and two-computer workflow

1. GitHub is the source of truth for source code and documentation.
2. `main` is stable; do not develop directly on `main`.
3. Use `develop` for integration work.
4. Use one `feat/*` or `fix/*` branch per task.
5. Pull before starting work and push after completing work.
6. Do not rewrite shared branch history without explicit approval.
7. Do not assume local databases or uploads are synchronized between computers.
8. Keep commits focused and review `git status` before committing.

## Data and secrets

1. Never commit database exports, SQL dumps, or local WordPress databases.
2. Never commit `wp-config.php`, `.env` files, credentials, passwords, API keys,
   private keys, or production connection details.
3. Never commit WordPress uploads, caches, logs, backups, or generated runtime
   files.
4. Keep reproducible, non-sensitive future development fixtures in
   `sample-data/`.
5. Do not create a sample-data importer until it is explicitly requested.
6. Treat any real personal, customer, lead, or property data as sensitive.

## Change safety

1. Do not delete or overwrite existing work without checking its purpose.
2. Do not run destructive commands unless the target and scope are explicit and
   approved.
3. Do not deploy, connect to production, or alter a production database as part
   of local development.
4. Keep documentation aligned with actual repository behavior.
5. When information is unavailable, say so instead of making assumptions.

## Foundation-phase restriction

Until the foundation is approved, do not:

- build the homepage;
- create visual design or production content;
- install Elementor or another page builder;
- implement project, unit, career, KPR, form, or multilingual features;
- create production integrations;
- deploy anything.
