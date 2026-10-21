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

## Directory responsibilities

| Directory | Responsibility |
|---|---|
| `docs/` | Project rules and development documentation |
| `wp-content/themes/marison/` | Future presentation theme |
| `wp-content/plugins/marison-core/` | Future Marison business-data plugin |
| `sample-data/` | Future non-sensitive reproducible development data |

## Foundation-phase limits

The current project phase does not include homepage implementation, visual design,
real project content, project post types, unit management, Elementor, page
builders, production connections, or deployment.
