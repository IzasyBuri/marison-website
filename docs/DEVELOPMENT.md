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

### Articles Archive and native Post URLs

Articles use native WordPress Posts. Each environment must provision one normal
WordPress Page titled **Artikel** with the slug `artikel`, then assign that Page as
the site's Posts Page under **Settings → Reading**. Keep **Your homepage displays**
set to **A static page** with the existing Homepage Page selected as the front
page; WordPress only activates the Posts Page boundary in this normal static-page
configuration. This is one WordPress
`page_for_posts` configuration boundary; do not create or assume a second
language-specific WordPress option.

When Polylang Free is active, create and link the English translation of the
Artikel Page through the normal Polylang Page language controls, then verify the
actual translated Posts Page URL produced by that runtime. Polylang's current
behavior, not a hard-coded `/articles/` convention, is the source of truth for the
English archive navigation and URL. The Artikel Page's `post_content` is not the
archive introduction owner: `templates/home.html` and the controlled theme
presentation provide the archive structure and localized introduction/empty state.

In the local Polylang Free verification, an English Page slug of
`articles-fixture` produced the translated archive at `/en/articles-fixture/`,
while the configured native Post base produced translated Article details at
`/en/artikel/[post-slug]/`. This is evidence of the runtime behavior, not a
hard-coded production slug requirement; verify the actual translated Page slug
and links after each environment is provisioned.

Set the native Post permalink structure explicitly in **Settings → Permalinks**:

```text
/artikel/%postname%/
```

Click **Save Changes** after changing this structure and after provisioning the
Artikel Page on each local/staging database. This is an explicit runtime database
configuration change; Marison source does not silently mutate
`permalink_structure`, flush rules on every request, add redirects, or edit
`.htaccess`. The expected native routes are `/artikel/` and
`/artikel/[post-slug]/`, with the English routes determined by the active
Polylang/WordPress configuration.

The public Article archive is the native Posts Page main query. The theme narrows
only that frontend main query to nine published native Posts, newest published
date first with Post ID descending as the deterministic tie-breaker, and leaves
Polylang's language filter intact. Search, admin, REST, Pages, Projects, KPR, and
Homepage secondary queries are not changed. Native WordPress pagination semantics
remain authoritative: valid pages paginate server-side, while a nonexistent page
such as `/artikel/page/999/` may return the normal WordPress 404 without clamping
or redirecting it.

Article editors continue to use the normal Post editor for title, date, featured
image, category, and body content. Category labels are display-only in V1 and do
not link to a category archive. Comments and public author archive links are not
rendered.

The Article → Project selector stores an ordered array in
`_marison_article_projects`. Values are canonical Indonesian Project IDs. For an
English Article, presentation starts from the current-language translated Post,
but `marison-core` resolves the canonical Indonesian Article first and reads the
relationship from that canonical source. Existing Polylang shared-meta
synchronization remains unchanged; no translated Project IDs or competing English
relationship array is created. Each stored Project is then presented in English
when its translation exists, otherwise the canonical Indonesian Project is shown
with an honest missing-translation note. Invalid/trashed/unpublished Projects are
omitted while the relative order of remaining valid Projects is preserved.

For local validation, create clearly synthetic Indonesian/English Article Posts,
an Indonesian-only Post, categories, media, and related Projects. Verify the
Indonesian archive/detail, the actual English Polylang archive/detail URL, valid
and nonexistent pagination, Homepage Article links, Project Detail related
Article links, and route coexistence with `/`, `/en/`, `/perumahan/`,
`/perumahan/[project]/`, and `/kpr/`. Remove all synthetic content and scripts
after validation. Database content, Page assignments, Polylang relationships,
permalinks, and uploads remain computer-specific state; Git synchronizes only the
templates, theme/plugin source, and this documentation.

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

`marison-core` registers the Project and Career CPTs with Polylang through the
native `pll_get_post_types` integration before Polylang builds its rewrite cache.
This is the only V1 CPT multilingual routing integration: do not add a custom
router or manually create `/en/perumahan/` or `/en/karier/` rewrite rules. After
activating both plugins or changing CPT/Page slugs, save Permalinks normally and
verify the generated English Project and Vacancy URLs, language attribute, and
canonical fallback behavior.

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

## Careers v1 phase

Careers uses one normal WordPress Page for discovery and one public
`marison_career` CPT for vacancy details. Provision an Indonesian Page with the
slug `karier`, insert the controlled **Marison Careers Content** pattern, and
create/link its English translation through Polylang. Verify the actual English
Page URL from that runtime; do not assume it is `/en/careers/`. The Page remains
ordinary editable WordPress content after pattern insertion.

Save **Settings → Permalinks** after provisioning or changing the Careers Page,
then verify `/karier/`, the actual English Page URL, and native vacancy URLs at
`/karier/[vacancy]/`. There is no Career archive, pagination, filter, search, or
separate discovery endpoint. Open listing order is published date descending with
Post ID descending as the deterministic tie-breaker.

The only approved vacancy fields are:

| Field | Language/scope | Contract |
|---|---|---|
| Status | Shared | `open` or `closed`; published vacancies require a valid value |
| Application instructions | Language-specific | Escaped plain text; English never silently falls back to Indonesian |
| Recruitment email | Shared | Validated email; used after an external URL |
| External application URL | Shared | `http`/`https` only; used first |

For an open vacancy, application precedence is external URL, recruitment email,
current-language instructions, then an honest unconfigured state. Closed
vacancies remain directly accessible with HTTP 200, show Closed, are excluded
from `/karier/`, and show no application CTA or destination. External links must
identify that they leave Marison; email links use `mailto:`; instructions are
not rendered as fake buttons. Clicks are not recorded.

`marison-core` owns the `marison_career` registration, custom capabilities,
metadata, validation, publish integrity, explicit shared-meta synchronization,
Polylang language policy, and public read model. The Marison theme owns the
presentation. The single template keeps native `wp:post-title` as the only H1
and native `wp:post-content` as the vacancy body owner, with only the structured
Career application block between them. No applicant CPT/table, form, upload,
CV processing, account, pipeline, ATS API, or applicant data is part of V1.

When Polylang is inactive, Indonesian Careers listing/detail remains functional.
When Polylang is active, English discovery includes only vacancies with a
published English translation, while shared status/email/URL values synchronize
through the explicit allowlist. Instructions, title, excerpt, and body remain
language-specific editorial content.

For local validation, use synthetic non-PII vacancies covering open, closed,
external URL, email, instructions, no destination, missing English instructions,
English-only translation, long content, and empty listing states. Confirm the
Careers routes coexist with `/`, `/en/`, `/perumahan/`, Project detail, `/kpr/`,
`/artikel/`, and Article detail. Remove all test Pages, vacancies, translations,
users/roles, media, scripts, logs, caches, and screenshots afterward. Database
content, Polylang relationships, Page assignments, and permalinks are local
environment state; Git synchronizes source and documentation only.

## About / Tentang Kami v1 phase

About is a normal editable WordPress Page at `/tentang-kami/`; it is not an About
CPT, company-profile table, history store, values taxonomy, team directory, or
settings screen. Provision the Indonesian Page with the slug `tentang-kami`, use
the structural `page-tentang-kami.html` template, and insert the controlled
**Marison About Content** pattern. After insertion, the blocks are ordinary Page
content and editors may replace the headings, copy, approach cards, buttons, and
any optional WordPress-managed images without changing code.

Create and link the English Page independently through Polylang. The English Page
may use its own editorial copy and its actual configured slug; do not assume a
paid translated base slug or hard-code `/en/about-us/`. Existing Header/Footer
navigation and the About/Housing calls to action use the current-language
navigation resolver. If the English translation is missing, retain the existing
Polylang missing-translation behavior rather than redirecting to English Home.

The seed copy is intentionally conservative. It may describe Marison Group as a
housing developer operating in Java, Indonesia, but it must not add unapproved
dates, counts, staff, customers, awards, certifications, partnerships, financial
metrics, milestones, or internal Branch information. About v1 has no dynamic
business-data block and no new `marison-core` changes. The Housing CTA points to
the current-language `/perumahan/` Page; Contact and Branch presentation remain
outside this phase.

For local validation, temporary Indonesian and linked English Pages may be
created, then must be deleted along with temporary media, scripts, screenshots,
logs, caches, and browser artifacts. Save **Settings → Permalinks** after Page
provisioning or slug changes. Database content, Page assignments, Polylang
relationships, and translated editorial copy are local environment state; Git
synchronizes only the template, pattern, theme styles, homepage seed CTA, and
this workflow. After cleanup, `/tentang-kami/` may correctly return 404 until a
real Page is provisioned. Polylang should be reactivated after inactive-mode
checks.

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

## Contact Page v1

Contact v1 is a normal corporate WordPress Page provisioned at `/kontak/` in
Indonesian. Use `page-kontak.html` only for Header → Page content → Footer
structure, then insert `marison/contact-content.php` as a seed and edit the
resulting blocks as ordinary Page content. Provision and translate the linked
English Page independently through Polylang; do not create a router or commit
synthetic Page/database state. The Footer's existing Contact navigation link
continues to use the current-language URL resolver.

The corporate source of truth is restricted to the existing options
`marison_corporate_telephone` and `marison_corporate_email`. The
`Marison\\Core\\Contact\\CorporateContact::read()` boundary validates the
telephone with the existing contact-number semantics and validates email with
`sanitize_email()`/`is_email()`. It returns only public channel kind, display
value, and safe `tel:`/`mailto:` URL fields. Invalid values are omitted; one
valid channel is shown by itself; when both are absent the Page shows an honest
unavailable state. No corporate WhatsApp, address, map, Careers email, site
admin email, Branch data, or Marketing data is used.

The two dynamic theme blocks remain narrow: `marison/corporate-contact` owns
only the configured public channels, while `marison/general-contact-form` owns
only the form and public success/error notice. Hero, explanatory copy, Project
guidance, and the localized `/perumahan/` CTA remain normal editable Page
content in the seed pattern. Generic Contact never calls the Project
`ContactResolver`; Project contact remains Project → Primary Branch → public
contact through the Project Detail flow.

The general form accepts only public `name`, `contact`, optional `message`,
required `consent`, and the existing `website` abuse-protection field. The
controller allowlists those fields and ignores every other POST value. It uses
the existing nonce field `marison_lead_nonce` with nonce action
`marison_submit_lead`, then `LeadSubmission::submit_general()` sets the
server-owned `inquiry_type = general` and `project_id = null` before delegating
to the existing `LeadSubmission::submit()` pipeline. That shared pipeline
continues to own validation, consent/version, abuse protection, repository
storage, and rate recording. The authenticated and unauthenticated hooks are
`admin_post_marison_submit_general_lead` and
`admin_post_nopriv_marison_submit_general_lead`. The persisted contract must be
verified with SQL: `inquiry_type = 'general'` and `project_id IS NULL`.

Submission uses POST → redirect → GET. General submissions redirect only to a
known canonical or Polylang-linked Contact Page URL through `wp_safe_redirect()`
and fall back to `/kontak/`; the public query state is only `success` or
generic `error`. Lead IDs, validation internals, storage errors, nonce details,
and abuse/rate-limit details are not exposed. Refreshing the result Page must
not create another Lead. The form's hidden language hint is used only to select
a known linked Contact URL when no referrer is available; it is not forwarded
to the Lead service. The form is server-rendered and requires no JavaScript.

Corporate phone/email settings are shared across languages; only editorial
copy and visitor-facing labels vary with the linked Page/current language.
Polylang may be disabled for a local check: Indonesian `/kontak/` must remain
functional through the normal Page permalink, then Polylang must be reactivated.

### Contact Page provisioning and cleanup

Before runtime validation, snapshot the original corporate options, complete
Lead ID set, Unit count/IDs, Career fixtures, Polylang state, permalink
structure, and the relevant Lead abuse/rate-limit transient state. Temporary
corporate fixtures and Indonesian/English Contact Pages may be created locally;
they must be removed afterward. Delete only synthetic Contact-test Leads and
restore the saved abuse transient values; preserve pre-existing Lead rows
exactly. Restore original option values, keep Units unchanged, leave Career
fixtures absent, reactivate Polylang, and leave permalinks unchanged. Remove
temporary scripts, screenshots, browser artifacts, dumps, and generated caches
before review. Contact may correctly return 404 after cleanup when no real Page
has been provisioned in that environment.

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

## Production provisioning matrix and release checklist

This section is the source-of-truth checklist for a new home computer, office
computer, staging environment, or production environment. WordPress Pages,
Posts, CPT records, uploads, Polylang relationships, Reading settings, and
permalinks are environment state. They must be provisioned through normal
WordPress administration or an approved content migration; do not commit a
database dump, fixture content, credentials, or an automatic production seeder.

### Required Page matrix

| Surface | Indonesian Page name | Required slug / route | Template | Seed pattern | English linked Page | Reading / other settings |
|---|---|---|---|---|---|---|
| Homepage | Homepage | No public slug; recommended stable slug `homepage`, public route `/` | `front-page.html` | `homepage-content.php` | Required; link through Polylang and verify `/en/` | **Settings → Reading → A static page**; select the Indonesian Homepage as Front page. In **Languages → Settings → URL modifications**, enable **The front page URL contains the language code instead of the page name or page id**. |
| Housing Directory | Perumahan | `perumahan` → `/perumahan/` | `page-perumahan.html` | `housing-directory-content.php` | Required; actual translated URL is runtime-owned | Save Permalinks after provisioning. Do not create a Project archive or location router. |
| KPR | KPR | `kpr` → `/kpr/` | `page-kpr.html` | `kpr-content.php` | Required; English editorial content may differ | Provision an eligible Indonesian KPR Scheme and explicit Public Default only when approved data exists. The calculator remains `NOT_IMPLEMENTED`. |
| Artikel Posts Page | Artikel | `artikel` → `/artikel/` | `home.html` | `article-archive-content.php` is controlled by the template | Required; link through Polylang and verify the actual English archive URL | Assign this Page under **Settings → Reading → Posts page**. Set native Post structure exactly to `/artikel/%postname%/`, then save Permalinks. |
| Careers | Karier | `karier` → `/karier/` | `page-karier.html` | `careers-content.php` | Required; actual translated URL is runtime-owned | Provision only real published vacancies. Vacancy details use native `/karier/[vacancy]/` CPT URLs; there is no Career archive. |
| About | Tentang Kami | `tentang-kami` → `/tentang-kami/` | `page-tentang-kami.html` | `about-content.php` | Required; actual translated slug is runtime-owned | Save Permalinks after provisioning. Editorial copy and media remain Page-owned. |
| Contact | Kontak | `kontak` → `/kontak/` | `page-kontak.html` | `contact-content.php` | Required; actual translated URL is runtime-owned | Configure only approved corporate telephone/email options. Project contact remains on Project Detail. |
| Privacy | Kebijakan Privasi | `kebijakan-privasi` → `/kebijakan-privasi/` | `page-kebijakan-privasi.html` | `privacy-content.php` | Required before launch; link through Polylang and verify the actual English URL | Page content must be replaced with approved final legal copy before production Lead forms are considered launch-ready. |

For every translated Page, create the English Page in the normal editor,
connect it to its Indonesian source with Polylang, and verify the generated
current-language URL. Do not hard-code `/en/` slugs or redirect missing
translations to English Home. When an English translation is absent, the
existing Resolver may return the canonical Indonesian URL and the UI must make
that fallback honest.

### Polylang URL configuration

For the approved Marison URL architecture, configure these values per
environment through the normal WordPress/Polylang admin UI. They are database
state and are not stored as theme/plugin routing logic in Git:

- Pretty Permalinks enabled in **Settings → Permalinks**.
- **Languages → Settings → URL modifications → The language is set from the
  directory name in pretty permalinks**.
- **Hide URL language information for default language** enabled, so Indonesian
  remains `/` rather than `/id/`.
- **Remove `/language/` in pretty permalinks** selected.
- **The front page URL contains the language code instead of the page name or
  page id** enabled. In Polylang 3.9.1 this is the `redirect_lang` checkbox.

With a translated static Front Page and this option enabled, the native result
is `/` for Indonesian and `/en/` for English. Merely linking the English Page
translation is not sufficient; this URL-modification setting is also required.
Do not reproduce it with a custom router, redirect, hard-coded `/en/`, or
language-specific Reading option.

### Article Posts Page setup

1. Create the Indonesian **Artikel** Page with slug `artikel`.
2. Insert the controlled article archive pattern only as the seed for editable
   Page/content ownership; the native `home.html` template owns the archive
   structure and the main Posts query.
3. Assign Artikel as the Posts page under **Settings → Reading** while keeping
   **Your homepage displays → A static page** and the Homepage selected as the
   Front page.
4. Create and link the English Artikel Page through Polylang, then verify its
   actual archive URL in the current runtime.
5. Set **Settings → Permalinks → Custom Structure** to exactly:

   ```text
   /artikel/%postname%/
   ```

6. Save Permalinks and verify `/artikel/`, the actual English archive, native
   Indonesian `/artikel/[article]/`, translated Article detail URLs, and
   pagination. Do not add a custom router or silently change this option from
   PHP.

### Homepage setup

Create one normal Indonesian Homepage Page, insert `homepage-content.php`, and
assign it as the Front page under **Settings → Reading → A static page**. The
front-page template is structural; the Page owns editable copy and block
content. Create and link the English Homepage Page through Polylang and verify
the real English front route. Enable the native Polylang URL-modification option
that makes the Front Page URL use the language code, so the production result is
`/` and `/en/` rather than a translated Homepage Page slug. Do not create a
second language-specific Reading option or commit database content.

### Environment checklist

For each environment, complete these steps in order:

1. Checkout the approved branch/release and copy `.env.example` to a local
   `.env`; never copy credentials between environments.
2. Start and validate Docker WordPress/MariaDB, activate Marison and
   marison-core, install/activate Polylang Free independently, and set `id` as
   default with `en` as secondary.
3. Save **Settings → Permalinks** once, configure the Polylang URL modifications
   above, then provision the Page matrix and linked English Pages. Save
   Permalinks again after Page/slug changes.
4. Configure Reading settings, the Article Posts Page, and the exact Article
   permalink structure. Verify `/`, `/en/`, the complete Article route matrix,
   and the translated CPT routes before adding content.
5. Provision real Projects, House Types, Units, Branch assignments, corporate
   contacts, KPR default data, Articles, Careers, About, Contact, and approved
   Privacy content. Use no synthetic fixtures in production.
6. Review translated editorial content and missing-translation fallback states.
   Confirm Project → Branch contact assignments and Lead privacy governance
   before enabling production collection.
7. Run the route, link, accessibility, security, and responsive smoke checks;
   preserve a deployment record outside Git for environment-specific settings.

### Readiness categories

**CODE READY:** theme templates/patterns, localized Resolver links, existing
Lead pipeline, Project/Unit/Career/KPR/Article read models, privacy hooks, and
the no-CMP baseline.

**CONTENT REQUIRED:** real Projects, location terms, House Types, Unit
inventory, Branch assignments, Articles, vacancies, About copy/media, Contact
editorial copy, and translated Page/Post content.

**CONFIGURATION REQUIRED:** theme/plugin activation, Polylang languages and
links, Reading settings, `/artikel/%postname%/`, corporate telephone/email,
eligible KPR default, Project/Branch relationships, and normal Permalink saves.
The Project/Career CPT translation registration is code-provided; the linked
English records and generated runtime URLs still require content provisioning
and verification.

**LEGAL CONTENT READY / LEGAL REVIEW REQUIRED:** this category is not ready in
V1. Replace the Privacy seed with final approved policy copy, decide
retention/access/deletion governance, approve localized wording, and confirm the
consent link points to the published localized Privacy Page. Until this is
complete, the public Lead code may be tested in development but the forms are
**not production-launch-ready**.

### Final legal and tracking decisions

**Terms:** not implemented in V1. A Terms Page requires separate business/legal
approval and approved content.

**Cookies/CMP:** no cookie banner or CMP is installed. The audited V1 frontend
has no approved analytics tracker, advertising tracker, marketing pixel, or
third-party marketing embed. Reassess privacy/cookie requirements separately
if future tracking technology is approved.
