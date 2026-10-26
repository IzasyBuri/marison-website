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

### Local pretty-permalink setup

After the initial WordPress setup, open **Settings → Permalinks**, select
**Post name**, and click **Save Changes** once on each computer. This is the
normal WordPress permalink workflow; it writes the generated rules to the
container's writable `/var/www/html/.htaccess`. The Compose Apache image already
loads `mod_rewrite` and permits WordPress overrides, so do not edit `.htaccess`
manually or add a custom `/en/` redirect. If a local runtime ever returns an
Apache 404 for a known pretty URL, repeat this WordPress admin save operation
before investigating application code.

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

Homepage editorial copy belongs to the canonical WordPress Homepage Page content,
not a shared theme template. The controlled `Marison Homepage Content` pattern can
seed the structure; editors can translate the linked English Page independently in
Polylang. Dynamic Project, Location, and Article sections remain read-only theme
presentation fed by `marison-core`.

## Housing Directory v1 phase

The Housing Directory is a normal WordPress Page with the slug `perumahan`. Create
the Indonesian Page, use the slug-based `page-perumahan.html` structural template,
and insert the controlled `Marison Housing Directory Content` pattern. Create and
link its English translation through Polylang; the translated Page uses the generic
`page.html` structural fallback when its translated slug differs. Editorial title
and introduction belong to each Page's content and may be edited independently;
the `marison/housing-directory` block supplies the server-rendered discovery UI.
Do not create a Project archive or a location archive. After creating or changing
these Pages, save **Settings → Permalinks** once so the normal WordPress Page and
existing Project single rewrite rules are refreshed; do not commit `.htaccess`.

The Directory accepts these shareable GET parameters:

| Parameter | Contract |
|---|---|
| `location_term_id` | Optional validated `marison_location` City / Regency term ID at depth 3 |
| `province_term_id` | Optional validated Province term ID at depth 2; when combined with City / Regency, it must be the direct parent |
| `project_status` | Optional fixed value: `upcoming`, `ongoing`, or `completed` |
| `paged` | Server-rendered page number; normalized to a positive value; no user page-size parameter |

The Directory uses a fixed page size of **9** and deterministic publish-date
descending/ID-descending order. Core queries canonical Indonesian Projects only,
then resolves English presentation through the existing Resolver. A missing English
Project translation remains in the business result and displays the canonical
Indonesian presentation rather than being silently removed. Location labels remain
shared in V1.

The unfiltered `/perumahan/` Page is indexable. Active filter and pagination query
states receive `noindex,follow` through the core `wp_robots` integration; no SEO
plugin or custom canonical route is required. The base Page and translated Page
permalinks remain WordPress/Polylang responsibilities.

For local validation, create clearly synthetic Country → Province → City / Regency
terms and valid published Projects, then remove them and any temporary scripts after
testing. Validate the unfiltered Page, City/Regency and Province filters, optional
Project Status, mismatch/invalid input, pagination, English fallback, `/en/`, and
the existing `/perumahan/[project]/` permalink. WordPress Page and Polylang content
is database state, so each computer must reproduce the Page setup locally; Git
contains only the template, pattern, core logic, styles, and this workflow.

It does not include frontend Unit presentation, public Unit routes, CSV import/export,
siteplan data, pricing, KPR, Career, multilingual integration, frontend forms,
production connections, or deployment.

## Project Detail v1 phase

The public Project Detail is the native `marison_project` single template at
`/perumahan/[project]/`. The controlled `single-marison_project.html` template owns
the Header → Project Detail block → Footer structure; `marison-core` owns the focused
`ProjectDetail` read model and all canonical business lookups. No Project archive,
House Type URL, or Unit URL is created.

The read model resolves a translated Project presentation from the canonical
Indonesian Project ID. Status, location, House Type ownership, Unit inventory,
availability source, Branch contact, KPR state, and Article relationships always use
canonical/shared data. English title and editorial content use the linked translation;
missing House Type or Article translations fall back to the canonical presentation and
are labelled honestly. Polylang can be inactive without disabling Indonesian Project
Detail rendering.

Project Detail availability has exactly one public source:

| Mode | Public contract |
|---|---|
| `units` | Derived `available`, `booked`, and `sold` totals plus public Unit identifier/status rows; no internal row IDs or private data |
| `manual` | Configured aggregate counts only, labelled as a manual summary requiring Branch confirmation; no Unit rows |
| incomplete/unavailable | Honest notice; no fabricated zeroes or competing source |

Units-mode rows use a fixed server-side page size of **12** through the validated
`unit_page` query parameter. There is no public page-size control, infinite scroll, SPA,
or global Unit route. Unit/House Type relationships are checked against the canonical
Project before a House Type label is shown.

Project contact is read only through `ContactResolver`: Primary Branch WhatsApp,
Primary Branch telephone, configured corporate fallback, then unavailable. Hero,
Availability, mobile sticky action, and final Contact section reuse the same resolver
result; WhatsApp links do not create Leads. A compact mobile action appears only after
the Hero and hides at the final Contact section. The final Contact section remains in
normal flow when no contact is available.

Articles can be related to zero, one, or many canonical Projects through the controlled
`_marison_article_projects` metadata field and the Project editor's Project Terkait
box. Related Articles remain at their normal Article URLs and are omitted when no
canonical relationship exists. KPR is an educational entry to the localized `/kpr/`
destination; the Project page does not calculate installments. Location uses the
existing City/Regency, Province, and address data. Interactive map providers are
deferred because none is approved.

## Lead and contact foundation phase

The approved Lead/contact foundation adds a private prefixed Lead table, restricted
Lead administration, consent-aware internal submission, Project → Branch contact
resolution, and empty-by-default corporate fallback settings. WhatsApp URL generation
does not create a Lead; only an intentional consent-bearing submission does.

Lead retention duration remains **TO BE DEFINED before launch**. No automatic cleanup
runs locally or in development. WordPress privacy requests are commonly driven by an
email identifier, while this V1 Lead model stores WhatsApp/telephone contact values.
Phone-only Leads may therefore require an authorized internal lookup/deletion workflow.
This operational limitation must be resolved before launch; do not add a new personal
identifier merely to work around it. Local tests must remove all synthetic Leads
before handoff.

Location V1 enforces one three-level hierarchy and only allows Project assignment
to a depth-three City / Regency term. It does not store a separate semantic level
field or verify that a term name is actually a Country, Province, City, or Regency;
staff should follow the displayed Country → Province → City / Regency guidance.

## KPR Scheme foundation phase

KPR Scheme is managed as a non-public CPT with typed metadata and one explicit
Public Default option pointer. The foundation stores percentage-point annual rates,
normalized integer-month tenure options, `default_dp_percent`, date-only effective
dates, and disclaimer text.

The calculator boundary validates inputs but returns `NOT_IMPLEMENTED`; it does not
calculate installments or imply financing approval. Before calculation work begins,
Marison must approve the interest method/formula, rate treatment, rounding, DP
semantics, tenure interpretation, included/excluded fees, subsidy/eligibility rules,
and final disclaimer/legal wording.

The current V1 two-decimal rate normalization is an implementation convention, not a
permanent business rule. If a future approved Scheme requires greater precision, the
domain/storage boundary must evolve without changing the percentage-point meaning of
existing values.

## KPR Page v1 phase

The public KPR experience is a normal WordPress Page at `/kpr/`; it is not a public
KPR Scheme archive or Scheme single. The native `page-kpr.html` template owns only
Header → Page content → Footer structure. Insert the `marison/kpr-content` pattern
into the Indonesian Page as a seed, then edit the resulting blocks as ordinary Page
content. Create and translate the linked English Page independently through Polylang;
Page education may diverge between languages.

The `marison/kpr-status` dynamic block is deliberately narrow. It consumes the
`marison-core` `KprPage` read model for Public Default availability, safe configured
Scheme facts, calculator state, and disclaimer/editorial translation state. It does
not own the Page's education, render input controls, collect Leads, expose pricing,
or produce payment figures. When a valid Public Default exists, the public state is
still `NOT_IMPLEMENTED` until Marison approves and implements the calculation formula.
When no eligible default exists, education remains available and the status is shown
as unavailable without selecting a replacement or fabricating assumptions.

Annual rate remains an exact percentage-point annual configuration, tenure remains
integer months (with exact year equivalents shown where possible), `default_dp_percent`
remains a default simulation assumption rather than a minimum or eligibility rule,
and effective date remains date-only. These structured values are shared and are not
duplicated into English KPR Scheme records.

Scheme title and disclaimer are editorial/public text. During the Polylang admin
initialization lifecycle (`pll_init` in an admin request), the active Scheme's
canonical values are registered in **Languages → Translations** through Polylang's
string API. The internal registration keys include the active Scheme identity, the
`Marison KPR` group is used, titles are single-line strings, and disclaimers are
multiline strings. Indonesian uses the canonical text; English uses the matching
Polylang string translation when configured. If no English editorial translation
exists, the read model returns a `MISSING_TRANSLATION` state and the page labels the
canonical Indonesian fallback honestly. A changed canonical source string is a new
Polylang source value, so an old translation is not applied to the changed text; an
inactive/deleted Scheme is not registered on later admin requests. No custom
translation table or duplicate financial Scheme is created. A missing configured
disclaimer is reported as unavailable rather than replaced with new legal copy.
Polylang resolves a translation by canonical source text and language; two Schemes
with intentionally identical canonical text therefore share that identical source
translation, while different title/disclaimer source text cannot inherit the other
Scheme's translation.

Each environment must provision the Indonesian `/kpr/` Page and linked English Page
locally; Page content, Polylang relationships, and Scheme title/disclaimer string
translations configured through **Languages → Translations** are WordPress database
state and are not synchronized through Git. Each independent home/office local
database may require its own translation setup. Production/staging content migration
must preserve the relevant WordPress and Polylang database content; do not commit
database exports. Numeric KPR configuration remains single-source and is not
re-entered per language. Keep the KPR Scheme CPT non-public and restore any local
test Scheme, Public Default pointer, temporary Page, and Polylang state after runtime
validation. The Homepage and Project Detail KPR links resolve through the existing
localized Resolver and should not gain separate routing logic.

## Frontend design-system foundation phase

The Marison Block Theme keeps design tokens in `theme.json` and semantic interaction/
component behavior in the small theme stylesheet. Foundation patterns may demonstrate
tokens, statuses, forms, cards, and image treatments locally, but are not production
Homepage/Directory/Project pages or a public style-guide route. Validate theme changes
at desktop and mobile widths, including focus, contrast, reduced motion, and overflow.

## Multilingual foundation phase

The local multilingual dependency is Polylang Free `3.9.1`, installed through the
normal WordPress plugin workflow. It is intentionally ignored at
`wp-content/plugins/polylang/` and is not committed or copied into Marison source.

Configure Indonesian (`id`) as the default language and English (`en`) as the
secondary language under `/en/`. Each local/staging environment must install and
activate the approved free plugin independently; Git synchronizes only Marison source
and documentation, not third-party plugin files or language/content database state.

Polylang absence must leave Indonesian business data operable. Translation helpers
return safe unavailable/default-language states. Unit, Lead, and KPR structured data
remain language-independent; no translated custom tables are created.

House Type featured-media synchronization is acceptable for V1 but is not a permanent
business rule; language-specific media may be supported only after explicit approval.
