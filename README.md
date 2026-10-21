# Marison ID

Marison ID is the greenfield WordPress project for the official Marison Group
website at `marison.id`.

The website will eventually serve as Marison Group's corporate website, housing
project portfolio, housing discovery site, lead-generation site, KPR simulation
site, and career portal. It is planned for Indonesian and English audiences and
for projects across Java.

This repository currently contains **project foundation only**. Website features,
visual design, project data, unit management, and the local WordPress runtime are
not implemented yet.

## Repository structure

```text
docs/
  PROJECT-RULES.md       Permanent project rules
  DEVELOPMENT.md         Local development and Git workflow
wp-content/
  themes/
    marison/             Future custom presentation theme
  plugins/
    marison-core/        Future business-data plugin
sample-data/              Future reproducible development data
```

The existing-site audit document, if present in `docs/`, is historical reference
material only. This project is a new build and must not modify the production
site.

## Architecture responsibilities

### `marison` theme

The custom `marison` theme will eventually handle presentation: templates,
styles, accessible markup, responsive layouts, and reusable display components.
It must not become the storage layer for business data.

### `marison-core` plugin

The custom `marison-core` plugin will eventually handle Marison-specific business
data and behavior, including projects, units, locations, marketing contacts,
careers, and KPR configuration. Those features are intentionally not implemented
in this foundation phase.

Elementor and other page builders are not part of this project. Native WordPress
editing and minimal dependencies are the target.

## Git workflow

- `main` is stable and must not be used for direct development.
- `develop` is the integration branch for approved development work.
- `feat/*` is for new work.
- `fix/*` is for bug fixes.
- One task uses one feature or fix branch.
- Pull the latest branch before starting work.
- Push the branch after completing work.
- Merge into `develop` first; update `main` only through an approved stable
  release process.

The same workflow is used on the home computer and the office computer. GitHub
is the source of truth for source code and documentation. Local WordPress
databases are not synchronized through Git.

## Working from two computers

Before starting a task on either computer:

```bash
git switch develop
git pull --ff-only origin develop
git switch -c feat/short-task-name
```

After the task is complete:

```bash
git status
git add <intended-files>
git commit -m "Describe the task"
git push -u origin feat/short-task-name
```

Review and merge the branch into `develop`. Do not assume that a database, media
library, or local WordPress settings on one computer exist on the other computer.

## What must never be committed

- WordPress database exports or dumps;
- `wp-config.php` and local configuration files;
- `.env` files, credentials, passwords, API keys, or private keys;
- WordPress uploads and generated media;
- cache, logs, temporary files, and backup files;
- production connection details or deployment secrets.

The root `.gitignore` contains the baseline protections. Review `git status`
before every commit.

## Current phase

This is a foundation-only project. Do not start homepage implementation, visual
design, project post types, unit management, real project content, Elementor
installation, page-builder installation, production connection, or deployment
without explicit approval.
