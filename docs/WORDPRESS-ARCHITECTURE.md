# WordPress Technical Architecture Marison ID v1

## 1. Document Information

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Domain | `marison.id` |
| Dokumen | WordPress Technical Architecture v1 |
| Status | Draft untuk human review |
| Branch | `feat/wordpress-architecture-v1` |
| Baseline visual | Commit `1b0be64` |
| Bahasa dokumen | Bahasa Indonesia |
| Sumber | PRD, Content Model, Information Architecture, User Flows, Design System, Core Wireframes, Core Visual Direction, Project Rules |
| Cakupan | Storage, theme/plugin boundary, admin, security, privacy, multilingual, deployment, operations |
| Di luar cakupan | PHP, SQL schema, theme/plugin files, installation, deployment, production access |

Dokumen ini adalah keputusan arsitektur konseptual. Dokumen ini tidak membuat
implementasi WordPress dan tidak mengotorisasi instalasi plugin, pembuatan tabel,
atau perubahan Hostinger.

---

## 2. Purpose

Dokumen ini menerjemahkan arsitektur produk Marison ID yang telah disetujui menjadi
fondasi WordPress yang aman, dapat dirawat, dan dapat diimplementasikan tanpa
menebak ulang keputusan penting.

Tujuan teknis:

1. Memisahkan presentation dari business data.
2. Memakai kemampuan native WordPress sebelum menambah dependency.
3. Menyediakan editing aman bagi staf non-teknis tanpa layout chaos.
4. Menjaga 30+ Project tetap mudah dikelola.
5. Menyediakan strategi Unit yang dapat tumbuh menjadi ribuan atau puluhan ribu
   baris tanpa langsung mengorbankan portability WordPress.
6. Menjaga Lead sebagai data internal yang sensitif dan dapat dihapus atau diekspor.
7. Mempertahankan shared data antara Bahasa Indonesia dan English.
8. Memisahkan code release dari content/database release.
9. Menjadi praktis pada Hostinger Business dan dua komputer development.

### Non-goals

- Tidak memilih provider peta, CAPTCHA, SMTP, atau provider CRM.
- Tidak menentukan formula KPR.
- Tidak membangun CRM, sales pipeline, HR system, atau applicant database.
- Tidak menentukan SQL schema, nama capability final, atau kode PHP.
- Tidak menjadikan WordPress sebagai pengganti ERP atau inventory system penuh.

---

## 3. Architecture Principles

### 3.1 Separation of concerns

- **Theme `marison`** memiliki presentation: template, accessible markup,
  responsive layout, reusable display patterns, dan asset loading.
- **Plugin `marison-core`** memiliki business data dan business logic: registration,
  relationship, validation, admin workflow, availability derivation, contact
  routing, privacy hooks, dan data integrations.
- Business data tidak boleh disimpan hanya di theme.
- `marison-core` tidak boleh mengasumsikan markup atau template tertentu dari theme.

### 3.2 Native WordPress first

Untuk setiap kebutuhan, evaluasi berurutan:

1. Posts, Pages, Custom Post Types, Taxonomies, Post Meta, Term Meta, Options,
   Settings API, Block Editor, Patterns, `theme.json`, Roles/Capabilities, dan
   REST API dengan permission yang tepat.
2. Admin screen atau storage abstraction di `marison-core` bila native UI tidak
   cukup aman atau nyaman.
3. Custom database table hanya bila query, volume, privacy, atau lifecycle memang
   membutuhkannya.
4. Third-party plugin hanya bila manfaatnya jelas, dependency disetujui, dan
   fallback/exit strategy diketahui.

### 3.3 Single source of truth

- Availability totals berasal dari Unit individual bila inventory individual ada.
- Public Project contact berasal dari tepat satu Primary Branch.
- Project Status dan Unit Status adalah dua domain berbeda.
- Shared structured data tidak dibuat ulang untuk English.
- Manual fallback hanya aktif saat mode individual inventory tidak aktif.

### 3.4 Honest public data

Data yang kosong, unavailable, atau belum valid tidak diisi dengan placeholder yang
tampak sebagai fakta. Public output harus menghilangkan atau menjelaskan data yang
belum tersedia.

### 3.5 Preserve before delete

Project selesai, Unit terjual, assignment sebelumnya, KPR scheme historis, dan
Vacancy closed dipertahankan bila masih memiliki nilai bisnis. Lead berbeda:
penghapusan harus dapat dilakukan sesuai kebijakan retention yang akan ditetapkan.

### 3.6 Minimal frontend dependency

Theme harus ringan, tanpa Elementor, tanpa page builder, tanpa frontend framework
yang tidak diperlukan, dan dengan JavaScript sesedikit mungkin.

### 3.7 Security and privacy by default

Internal object tidak menjadi public hanya karena WordPress dapat mengeksposnya
melalui query atau REST. Permission, validation, escaping, dan privacy lifecycle
harus dipikirkan saat storage dipilih.

---

## 4. High-Level Architecture

```text
Visitor
  │
  ▼
WordPress Core
  ├── Block Editor / Pages / native Posts
  ├── REST API dengan allowlist dan permission checks
  ├── Media Library
  └── Users / Roles / Capabilities
  │
  ├─────────────────────────────────────────────────────────────┐
  ▼                                                             ▼
Theme: marison                                      Plugin: marison-core
  ├── theme.json                                         ├── Project data
  ├── templates / template parts                          ├── Branch / marketing
  ├── locked patterns                                     ├── House Type structure
  ├── accessible presentation                             ├── Unit storage + rules
  ├── responsive layout                                   ├── Leads + privacy hooks
  ├── Project / Article / Career views                    ├── KPR schemes
  └── asset loading                                       ├── Career registration
                                                          ├── locations / facilities
                                                          ├── admin interfaces
                                                          ├── derived availability
                                                          ├── routing / validation
                                                          └── integrations
  │                                                             │
  └────────────────────────── reads approved public data ───────┘
  │
  ▼
Public pages: /, /perumahan/, /perumahan/[project]/, /artikel/,
/karier/, /kpr/, conditional location pages, /en/ translations

Internal only: Leads, Marketing assignments, raw Unit management,
inactive KPR administration, internal settings, migration/log records
```

### Boundary rule

Jika `marison` dinonaktifkan, Project, Unit, Lead, Branch, KPR, Career, dan
relationship data harus tetap tersimpan. Public presentation boleh tidak lengkap,
tetapi data bisnis tidak boleh hilang.

### Public URL intent

- Project: `/perumahan/[project]/`
- Article: `/artikel/[article]/`
- Vacancy: `/karier/[vacancy]/`
- Indonesian canonical: root `/`
- English linked experience: `/en/`
- Location pages: conditional, bukan halaman massal otomatis

Exact registration dan rewrite code ditetapkan pada implementation plan berikutnya.

---

## 5. Theme Architecture

### 5.1 Evaluated approaches

| Approach | Editor freedom | Layout safety | Performance | Maintainability | Native WordPress | AI/developer complexity |
|---|---|---|---|---|---|---|
| A. Custom Block Theme | Tinggi jika dibiarkan; dapat dikurasi | Baik dengan locked templates/patterns | Sangat baik bila ringan | Baik dan modern | Paling native | Sedang |
| B. Classic Theme + Block Editor support | Rendah–sedang | Sangat ketat | Baik | Lebih banyak template/legacy surface | Baik | Sedang–tinggi |
| C. Hybrid terkontrol | Sedang | Baik | Baik | Baik jika boundary jelas | Baik | Sedang |

### 5.2 Recommendation

**Rekomendasi: Controlled Custom Block Theme (`marison`) dengan business logic tetap
di `marison-core`.** Ini adalah pendekatan A dengan guardrail operasional dalam
pengalaman editing, bukan campuran tanggung jawab theme/plugin.

Alasan:

- Staf memperoleh pengalaman Block Editor native untuk editorial content.
- `theme.json`, templates, template parts, dan patterns menjadi design system yang
  dapat dikelola melalui Git.
- Theme dapat menyajikan Project, Directory, Article, Career, KPR, dan mobile
  experience tanpa page builder.
- Layout Project tidak diserahkan kepada drag-and-drop bebas.
- Block Theme lebih sejalan dengan arah WordPress jangka panjang daripada classic
  theme yang memerlukan banyak coupling.

Classic Theme tidak dipilih karena editor experience kurang native. Block Theme
tanpa guardrail juga tidak dipilih karena layout mudah rusak.

### 5.3 Theme owns

- `theme.json` untuk design tokens dan editor controls yang diizinkan.
- Templates untuk Home, Project index/detail, Article, Career, KPR, About, Contact,
  location context, dan fallback states.
- Template parts untuk Header, Footer, navigation, breadcrumb, dan recurring CTA.
- Patterns untuk Project, availability, House Type summary, Article/Career card,
  location discovery, notices, dan contact presentation.
- Accessible HTML, responsive behavior, focus states, reduced motion, dan asset load.
- Presentation yang membaca data contract dari `marison-core`.
- Canonical/hreflang presentation melalui multilingual integration boundary.

### 5.4 Theme must not own

- Registration atau persistence Project, Unit, Branch, Lead, KPR, Career, Marketing,
  Location, Facility, atau relationship bisnis.
- Availability calculation, contact routing, public-default KPR enforcement, lead
  retention, import, migrations, atau privacy deletion logic.
- Business status definitions yang dapat hilang ketika theme diganti.
- Direct dependency pada markup theme sebagai syarat plugin bekerja.
- Data pribadi, credentials, atau production configuration.

### 5.5 Editor freedom without layout chaos

1. **Public templates dikunci.** Project detail memiliki urutan section yang
   ditentukan theme; editor mengisi content melalui structured fields.
2. **Patterns dikunci pada struktur.** Pattern Project menyediakan slot konten,
   bukan section arbitrary yang dapat dihapus/diurutkan bebas.
3. **Content-only editing bila sesuai.** Staff mengubah teks, image, dan link yang
   disediakan tanpa mengubah layout. WordPress mendukung konsep template lock
   `contentOnly` untuk area yang memakai template.
4. **Block allowlist.** Hanya block yang diperlukan yang tersedia pada area editorial;
   custom HTML dan layout escape hatch bukan jalur normal staf.
5. **Global styles terpusat.** Warna, font, spacing, dan template parts dikelola dari
   source theme, bukan style lokal setiap halaman.
6. **Business fields dipisahkan dari freeform content.** Status, lokasi, Branch,
   House Type, Unit, progress, dan KPR bukan paragraph yang dapat diedit sembarang.
7. **Site Editor bukan workflow harian.** Hak mengubah template, template part,
   navigation global, dan global styles dibatasi kepada Administrator/developer.
8. **Preview dan validation sebelum publish.** Project publik tidak boleh publish
   bila identity, location/status, atau contact integrity yang diwajibkan gagal.

Ini memberi content freedom pada copy, media, Article, dan Vacancy, sekaligus
menjaga layout safety untuk Project, Directory, Header/Footer, dan availability.

### 5.6 Theme primitives

| Primitive | Peran Marison |
|---|---|
| `theme.json` | Token design system dan pembatasan editor controls |
| Templates | Struktur halaman yang stabil dan route-aware |
| Template parts | Header, Footer, navigation, breadcrumb, recurring contact context |
| Patterns | Section/presentation reusable dan terkurasi |
| Locked patterns | Project, availability, dan contact agar structure tidak rusak |
| Content-only areas | Copy/editorial fields yang aman diedit staf |

Tidak ada implementasi file atau konfigurasi dalam dokumen ini.

---

## 6. marison-core Architecture

`marison-core` adalah plugin wajib untuk business data dan business logic Marison.
Plugin ini harus dapat diaktifkan tanpa `marison` dan tetap mempertahankan data.

### 6.1 Responsibilities

- Register Project, Branch, Marketing, KPR, Career, dan object lain sesuai storage.
- Register controlled taxonomies dan reference data.
- Menyediakan typed data contract untuk theme dan public queries.
- Menyediakan admin screens yang lebih aman daripada raw meta editing.
- Memvalidasi relationship dan fixed status values.
- Menghitung derived availability dari Unit source of truth.
- Menjaga manual fallback dan derived mode mutually exclusive.
- Resolve Project → Primary Branch → public contact.
- Menyimpan dan membatasi Lead access serta lifecycle hooks.
- Menjaga one-public-default KPR invariant.
- Menyediakan export/delete/privacy hooks.
- Menangani schema version, migrations, seed reference data, dan compatibility.
- Menyediakan REST routes hanya melalui allowlist dan permission checks.
- Menyediakan logging ringan untuk kegagalan penting.

### 6.2 Non-responsibilities

- Tidak memiliki visual design atau bergantung pada selector/class theme.
- Tidak menjadi CRM pipeline, lead scoring, campaign automation, atau HR system.
- Tidak mengirim data internal ke REST/public template tanpa sanitization dan policy.

### 6.3 Module boundaries

Module konseptual yang sebaiknya dipisahkan:

1. `content`: Project, Article relationships, Career.
2. `inventory`: House Type, Unit, imports, availability.
3. `operations`: Branch, Marketing, routing.
4. `finance`: KPR schemes, public default, simulator contract.
5. `reference`: Location, Facility, settings.
6. `privacy`: Lead lifecycle, export, deletion.
7. `admin`: menus, screens, roles, validation messages.
8. `integration`: multilingual, SEO, cache, REST boundaries.
9. `migration`: schema/version dan safe upgrades.

Module boundaries adalah arahan maintainability, bukan nama folder/class final.

---

## 7. Entity Storage Decision Matrix

| Konsep | Recommended storage | Why / query needs | Scale | Admin experience | Translation | Public / internal | Main risk |
|---|---|---|---|---|---|---|---|
| Project | Custom Post Type + typed meta/relations | Public URL, index, location/status filter, detail | 30+ dan tumbuh | Structured Project editor | ID source Indonesia; editorial translated; shared copied | Public | Relationship validation |
| Project Status | Controlled registered post meta / enum-like value | Tiga state workflow fixed; filter memakai meta query yang dibatasi | Tepat 3 | Select terbatas; tidak ada term management | Stable value shared; display label translated | Public | Invalid/arbitrary value bila validation dilewati |
| House Type | Non-public Custom Post Type + Project relation | Stable identity untuk Unit references, structured fields, media, translation, revisions | Beberapa per Project | Dedicated House Type admin UI | Canonical ID linked; numeric/business fields shared; description translated | Public via Project only | Orphan/mismatched Project relation |
| Housing Unit | Dedicated custom database table | Project/status/type filters, counts, batch updates, future siteplan | Ribuan–puluhan ribu | Dedicated inventory screen + CSV workflow | Language-neutral; rendered via Project translation | Raw internal; summary public | Custom migration/history |
| Unit Status | Controlled domain in Unit table | Fast status filtering/count; fixed values | Semua Unit | Select/bulk update terbatas | Value shared; labels translated | Raw internal; summary public | Import bypass validation |
| Country | Term in hierarchical Location taxonomy | Reusable reference and future expansion | Rendah | Managed reference screen | Label translated; code shared | Reference/conditional public | Wrong parent |
| Province | Child Location term | Province filter and ancestor query | Puluhan–ratusan | Dependent selector | Label translated; identity shared | Reference/conditional public | Parent mismatch |
| City / Regency | Grandchild Location term | Direct discovery and project query | Puluhan–ribuan | Dependent selector, no free typing | Label translated; identity shared | Reference/conditional public | Duplicate names/thin pages |
| Branch Office | Non-public Custom Post Type + meta | One Branch handles many Projects; current contact resolution | Rendah–menengah | Simple Branch screen | Public copy translated if needed; phones shared | Public subset; internal private | Invalid contact |
| Branch public contact | Branch post meta | Resolve current WhatsApp/telephone | Satu WhatsApp; phone optional | Format-validated fields | Shared numbers | Public selected fields | Stale number affects many Projects |
| Marketing Person/Team | Private CPT/managed record | Reusable lookup without login account | Rendah–menengah | Restricted operations screen | Internal; no public translation | Internal | Exposure of personnel data |
| Marketing Assignment | Managed relation records in core | Many-to-many with active/previous state | Rendah–menengah | Project/Marketing assignment screen | Shared internal relation | Internal | Becoming CRM by scope creep |
| Facility | Custom taxonomy + project context meta | Reusable common references | Puluhan–ratusan | Curated catalog + Project selector | Labels/descriptions translated | Public when attached | Taxonomy sprawl |
| Lead | Dedicated private custom database table | Recent/source/retention queries, export/delete | Unknown; moderate/growing | Restricted Lead screen | Source record language-neutral | Internal only | Custom privacy/migration |
| KPR Scheme | Custom Post Type + meta | Multiple historical schemes and revisions | Rendah | Restricted Scheme editor | Public copy translated; numeric shared | Admin; default output public | Multiple defaults |
| Public Default KPR | Option/Settings pointer to one scheme | Singleton lookup and explicit admin action | 0/1 | Restricted setting/action | Pointer shared | Setting internal; result public | Stale/deleted pointer |
| Article | Native WordPress Post | Native revisions, archive, published query | Hundreds–thousands | Block Editor | Linked translations | Public when published | Relation UI |
| Article categories | Native `category` taxonomy | Native editorial grouping; avoid extra plugin | Rendah–menengah | Curated native terms | Labels translated | Public taxonomy | Term sprawl |
| Career Vacancy | Custom Post Type + active/closed field | Listing/detail/status/date query | Rendah–menengah | Structured editor | Editorial translated; destination shared | Public when published | Closed SEO policy |
| Project progress | Project post meta | Current snapshot; render with Project | One per Project | Numeric + short description | Percentage shared; description translated | Public | Stale owner/cadence |
| Availability summary | Derived Unit counts; manual Project fallback by mode | One active source; cacheable counts | Per Project/status | Source mode and fallback fields | Counts shared; source note translated | Public summary | Cache/dual mode |
| Corporate contact settings | Options/Settings API | Small singleton read | Very low | Restricted settings screen | Values shared; copy translated | Selected fields public | Missing fallback |

### 7.1 Storage rules

- CPT tidak otomatis berarti public. `publicly_queryable`, `show_ui`, `show_in_rest`,
  dan capabilities dipilih per object.
- Meta business wajib memiliki type, validation, default, owner, visibility, dan
  translation policy.
- Raw serialized/JSON collection tidak boleh menjadi escape hatch tanpa schema
  version dan migration path.
- Relationships memakai stable IDs/keys, bukan display labels.
- Internal data tidak dibuat public hanya demi mempermudah theme query.

---

## 8. Project Architecture

Project adalah public Custom Post Type dan pusat housing journey. Project memiliki
public detail `/perumahan/[project]/`, tetapi data operasional tidak digabungkan ke
dalam paragraph bebas.

### Data and relationships

- title/name dan slug;
- fixed Project Status post-meta value: `upcoming`, `ongoing`, atau `completed`;
- Indonesian description dan linked English description;
- Province/City/Regency relation;
- address dan provider-independent coordinate data;
- tepat satu Primary Branch untuk Project public V1;
- Project-related House Type records dengan tepat satu owning Project;
- Unit inventory relation melalui Unit table;
- Facility relations dan Project-specific context;
- current progress percentage + optional short description;
- featured image, gallery, site plan bila tersedia;
- optional Article relation.

### Project Status storage

Project Status is a controlled registered post-meta value, not a taxonomy. The only
approved stored values are:

| Stored value | Public label |
|---|---|
| `upcoming` | Akan Datang |
| `ongoing` | Sedang Berjalan |
| `completed` | Selesai |

The value is language-independent and is validated on admin save, import, REST write,
and migration. Administrators select one of the three values; they do not create
terms or arbitrary status labels. Directory filtering remains possible through a
bounded meta query or an equivalent core query abstraction. Translation applies only
to the displayed label, never by duplicating translated status text inside Project.

### Publish gate

Core perlu memeriksa secara konseptual sebelum publish:

1. Nama, status, dan lokasi minimum tersedia.
2. Primary Branch tepat satu dan memiliki Primary Public WhatsApp valid, atau
   approved central fallback tersedia.
3. Location hierarchy valid.
4. Unit → House Type, bila ada, menunjuk Project yang sama.
5. Availability mode tidak conflict.
6. Translation relation tidak membuat English menjadi item independen.

Theme hanya menampilkan Project yang lolos public data contract.

---

## 9. House Type Architecture

### Recommendation

House Type memakai **dedicated non-public Custom Post Type** yang diregistrasikan dan
dikelola oleh `marison-core`. Setiap House Type memiliki tepat satu owning Project.
Frontend tetap merender House Type di dalam Project Detail; tidak ada standalone
House Type discovery, archive, atau detail URL publik pada V1.

### Alternatives

| Alternative | Evaluation |
|---|---|
| Separate non-public CPT | Stable identity, revisions, media, translation relation, dan Unit reference kuat; memerlukan admin UI dan relation validation. **Dipilih.** |
| Structured child/repeater data | Lebih sederhana secara concept, tetapi identity/revision/reference dapat rapuh ketika editor mengubah urutan Project content. Tidak dipilih. |
| Native blocks sebagai source | Terlalu bebas dan menyulitkan Unit relationship query. |

### Rules

- Satu House Type dimiliki tepat satu Project melalui relation yang tervalidasi.
- Nama sama lintas Project bukan identity yang sama.
- Type name, dimensions, room counts, floors, dan media/floor-plan reference adalah
  structured fields.
- Description adalah translatable editorial field.
- Unit hanya boleh merujuk House Type dari Project yang sama.
- House Type publicly queryable, public archive, dan public standalone URL semuanya
  non-public; public rendering selalu berada di Project Detail.
- Inactive lebih aman daripada delete bila masih direferensikan Unit.
- CPT revisions/history dapat dipakai untuk perubahan structured content yang relevan.

---

## 10. Unit Architecture

### 10.1 Decision

**Rekomendasi V1: Housing Unit memakai dedicated custom database table yang dikelola
oleh `marison-core`, dengan admin UI khusus dan public output yang disanitasi.**

### 10.2 Option comparison

| Kriteria | CPT + post meta | Custom table |
|---|---|---|
| 30+ Project | Mudah dimulai | Mudah dengan UI khusus |
| Ribuan/puluhan ribu Unit | Meta joins/admin list dapat berat | Query terarah dan batch lebih cocok |
| Frequent status update | Native revisions nyaman, overhead tinggi | Row update efisien |
| Project/status/type filtering | Native, tetapi meta query dapat mahal | Relational query khusus |
| Bulk editing | Tetap perlu custom tooling | Dapat dirancang sejak awal |
| Future siteplan | Bisa, kurang ideal untuk inventory query | Stable rows/coordinates cocok |
| Admin usability | Baik setelah banyak kustomisasi | Wajib dedicated screen; tidak raw table |
| Import/export | Tetap perlu importer | Tetap perlu importer, preview validation |
| Translation | Bisa diterjemahkan, tetapi Unit bukan editorial | Language-neutral; tidak duplicate rows |
| Revision/history | Native | Operational timestamp/log perlu dirancang |
| Portability | Lebih native | Lebih rendah, diimbangi export/migration contract |
| Complexity | Rendah awal, dapat meningkat | Sedang sejak awal |

Option B dipilih karena target pertumbuhan dan frequent status updates, bukan semata
karena volume saat ini. CPT dapat dievaluasi ulang bila data nyata menunjukkan
inventory kecil dan tidak memerlukan bulk/siteplan, tetapi bukan baseline V1.

### 10.3 Conceptual Unit data

- stable internal identity;
- exactly one Project;
- optional reference ke canonical House Type identity dari Project yang sama;
- unit/block/lot reference;
- controlled status value: `available`, `booked`, atau `sold`;
- optional coordinates/siteplan reference;
- timestamps dan operational update metadata;
- no owner/buyer personal data;
- optional import/source key untuk safe upsert.

### 10.4 Table lifecycle

`marison-core` bertanggung jawab secara konseptual untuk versioned migration,
idempotent upgrade, stable keys, relationship validation, paginated admin query,
bulk operations, export, cache invalidation, backup guidance, dan post-migration
integrity checks. Administrator tidak mengeksekusi raw SQL untuk upgrade normal.

### 10.5 Revision/history trade-off

Unit bukan editorial content, sehingga native revision setiap status tidak diwajibkan.
Minimal operational history tetap menyimpan updated timestamp/actor, import failure
summary, dan opsi lightweight status-change history bila kebutuhan audit disetujui.
Tidak ada data pembeli untuk memenuhi kebutuhan history.

---

## 11. Availability Architecture

### 11.1 Controlled status values

Unit status disimpan sebagai stable language-independent values:

- `available` → **Tersedia**;
- `booked` → **Terbooking**;
- `sold` → **Terjual**.

Project Status memakai domain yang berbeda: `upcoming`, `ongoing`, dan `completed`,
yang ditampilkan sebagai **Akan Datang**, **Sedang Berjalan**, dan **Selesai**.
Translated status text tidak disimpan per Project atau Unit.

### 11.2 Source modes

Setiap Project memiliki tepat satu mode aktif:

1. **Individual inventory** — Unit rows adalah source of truth; totals derived.
2. **Manual fallback** — dipakai bila individual inventory belum digital; totals
   manual dan diberi label fallback.
3. **Unavailable** — tidak ada angka ditampilkan.

Jika Unit individual ada, hitung `available`, `booked`, dan `sold` dari Unit valid.
Jangan menyimpan competing totals. Derived values dapat dicache pada object/page
fragment cache, tetapi cache bukan source of truth dan harus diinvalidasi setelah
Unit/status/relationship/mode/import berubah.

Manual fields hanya valid ketika `availability_mode=manual`. Core harus mencegah
manual dan individual mode aktif bersamaan. Transition manual → individual harus
memvalidasi Unit, membandingkan totals untuk review, lalu mengaktifkan derived mode
secara eksplisit.

Jika tidak ada source availability, jangan menampilkan angka nol implisit atau angka
perkiraan; tampilkan notice jujur dan contact valid bila tersedia.

---

## 12. Branch Architecture

### Recommendation

Branch Office memakai **non-public Custom Post Type** dengan structured metadata dan
admin screen sederhana. Branch tidak memiliki standalone public URL pada V1.

### Data and behavior

- branch identity, service/location information, address;
- exactly one Primary Public WhatsApp;
- optional public telephone;
- optional internal routing information yang tidak public;
- Project memiliki exactly one Primary Branch relation;
- banyak Project dapat merujuk Branch yang sama;
- public Project contact selalu resolve melalui current Branch data.

Branch bukan singleton, sehingga Options atau satu Page tidak cocok. Branch juga
bukan otomatis public hanya karena memiliki alamat dan nomor publik.

### Safety

- Project tidak boleh publish dengan CTA valid jika Branch tidak memenuhi contact
  requirement, kecuali approved central fallback telah dikonfigurasi.
- Jangan silent reroute ke Branch lain.
- Perubahan nomor Branch memengaruhi semua Project terkait dan perlu preview/log
  ringan agar tidak menjadi perubahan yang tidak disadari.

---

## 13. Marketing Architecture

### Recommendation

Marketing Person/Team adalah **non-public managed Custom Post Type**, bukan WordPress
User secara default. Tidak semua person memerlukan login; memakai User untuk semuanya
akan memperbesar account, password, dan permission surface tanpa kebutuhan produk.

### Assignment

Assignment adalah internal many-to-many relation dengan status active, inactive,
atau previous. Admin harus dapat:

- memberi beberapa assignment pada satu Project;
- menghubungkan satu person/team ke banyak Project;
- mengakhiri assignment tanpa menghapus sejarah yang berguna;
- menjaga public CTA tetap menuju Branch;
- mencegah relation internal keluar melalui public REST/template.

Untuk volume internal saat ini, `marison-core` menyediakan controlled relationship
model antara Project dan Marketing Person/Team. Assignment tetap internal, dapat
memiliki active/inactive/previous state, dan relation history dapat dipertahankan.
Relation table hanya dipertimbangkan bila query/history membutuhkannya. Tidak ada
lead rotation, sales pipeline, commission tracking, atau CRM dashboard V1.

---

## 14. Lead Architecture

### 14.1 Privacy decision

**Rekomendasi: dedicated private custom database table untuk Lead, dengan admin UI
terbatas dan lifecycle hooks untuk export, delete, dan retention cleanup.**

### 14.2 Comparison

| Kriteria | Private CPT + meta | Dedicated Lead table |
|---|---|---|
| Setup/native editor | Mudah | Perlu admin screen |
| Public URL exposure | Harus dikunci teliti | Private by design |
| Revisions/autosave | Perlu diatur | Tidak ada overhead editorial |
| Retention/export/delete | Bisa melalui hooks, object tersebar | Lifecycle purge/export lebih terarah |
| Query | Native untuk volume kecil | Batch/query lebih jelas |
| Permissions | Tetap perlu capability khusus | Tetap perlu capability khusus |
| Future CRM export | Bisa | Natural sebagai export boundary |
| Portability | Lebih native | Perlu migration/export contract |
| Complexity | Rendah | Sedang |

Lead bukan editorial content, tidak memerlukan public URL atau revision history, dan
memerlukan privacy lifecycle yang belum final. Karena itu private table lebih tepat
sebagai data boundary. Keputusan ini tidak mengasumsikan volume Lead tertentu.

### 14.3 Lead fields V1

- Name;
- WhatsApp/telephone;
- source/interested Project;
- consent dan metadata consent yang disetujui;
- optional Message;
- timestamps dan delivery state yang tidak berisi data berlebihan.

Jangan menyimpan NIK, salary, SLIK, employment data, financial history, buyer data,
atau qualification panjang.

### 14.4 Lead behavior

- Source Project wajib dan tidak boleh hilang.
- Branch penerima di-resolve dari source Project saat processing.
- Lead tidak memiliki public route atau public REST response.
- Akses, export, dan delete memakai capability check.
- Content Editor dan Project/Inventory Manager tidak otomatis mendapat Lead access.
- Retention duration tetap TO BE DEFINED dan harus dipasang sebelum production form.
- Log tidak boleh menulis nomor telepon atau message secara plaintext.

### 14.5 Spam and delivery

Lead ingestion kelak harus memiliki validation, nonce, rate limiting yang sesuai,
spam protection yang dapat diganti, dan delivery-failure handling. Provider CAPTCHA
belum dipilih dan bukan dependency architecture saat ini.

---

## 15. KPR Architecture

KPR Scheme memakai **Custom Post Type + structured metadata**. Public default
selection memakai satu restricted Settings/Option pointer ke satu scheme.

Options-only tidak cukup untuk multiple historical schemes, effective date, active
state, dan revision context. Sebaliknya, default selection memang singleton dan
cocok sebagai option pointer.

### Rules

- Banyak Scheme dapat tersimpan.
- Hanya satu eligible active Scheme boleh menjadi PUBLIC DEFAULT.
- Inactive Scheme tidak boleh menjadi default.
- Tanpa valid default, `/kpr/` tetap menyediakan edukasi tetapi simulator unavailable.
- Historical/inactive schemes tidak memiliki public promotional route.
- Numeric parameters, tenure, DP assumption, effective date, dan disclaimer memiliki
  validation dan translation policy masing-masing.
- Formula, sumber bunga, rounding, dan scenario belum ditentukan dokumen ini.

### Default lifecycle

1. Authorized admin membuat/mengedit scheme.
2. Scheme lolos validation dan active/eligible.
3. Action “set public default” mengecek uniqueness.
4. Default sebelumnya dilepas secara atomic/conceptual transaction.
5. Public cache/output diinvalidasi.
6. Perubahan penting masuk lightweight log.

---

## 16. Article Architecture

Article memakai **native WordPress Posts** dan Block Editor. Ini memanfaatkan native
revision, editorial status, scheduled publishing, categories, dan archive behavior.

Satu Article boleh memiliki nol, satu, atau banyak Project. Content Article tidak
diduplicate ke Project. Untuk V1, relation dikelola sebagai structured relationship
field di `marison-core` dengan selector Project dan validasi IDs. Relation adalah
shared structured data dan tetap merujuk Project canonical ketika Article dilihat
dalam English.

Jika volume relation tumbuh sampai membutuhkan query berat, relation storage dapat
dipindahkan ke table khusus tanpa mengubah Article content atau URL.

### Categories

Gunakan native `category` terlebih dahulu. Term list harus curated agar tidak menjadi
taxonomy sprawl atau arsip tipis. Custom taxonomy baru hanya jika kebutuhan editorial
nyata tidak dapat dipenuhi native category.

### Canonical behavior

Article tetap memiliki satu canonical URL `/artikel/[article]/`. Related Article di
Project hanya menautkan URL tersebut, bukan membuat duplicate route.

---

## 17. Career Architecture

Career Vacancy memakai **Custom Post Type public** dengan controlled active/closed
state dan structured application destination.

Mendukung listing active di `/karier/`, detail `/karier/[vacancy]/`, closed state
yang dikeluarkan dari listing aktif, application instructions, recruitment email,
atau external URL. Editorial fields dapat diterjemahkan; destination operational
yang shared tidak dibuat dua kali.

V1 tidak menyimpan applicant records, CV, candidate pipeline, applicant portal,
atau HR management. Closed Vacancy boleh dipertahankan sebagai detail bila berguna,
tetapi application CTA harus nonaktif dan status harus jujur.

---

## 18. Location Architecture

### 18.1 Comparison

| Model | Kelebihan | Kekurangan |
|---|---|---|
| Satu hierarchical taxonomy | Parent-child alami, reusable, ancestor query, satu vocabulary | Parent salah tetap mungkin tanpa guardrail |
| Separate Province + City taxonomies | Query sederhana per level | Hubungan dan mismatch perlu storage/validation kedua |
| Managed entities/CPT | Rich metadata dan workflow | Overhead tinggi, URL/archive risk |
| Free text meta | Mudah dibuat | Typo, duplikasi, filter buruk, no hierarchy |

### 18.2 Recommendation

Gunakan **satu custom hierarchical Location taxonomy** dengan Country → Province →
City/Regency. Country ada untuk future expansion; Indonesia tidak perlu menjadi menu
public tambahan.

### 18.3 Guardrails

- Project memilih City/Regency melalui dependent selector, bukan label bebas.
- Core memvalidasi Province sebagai ancestor City yang dipilih.
- Labels, stable geographic identifier, dan translation metadata dikelola sebagai
  reference data.
- Taxonomy admin tidak otomatis membuat halaman publik.
- Province/City page hanya indexable bila memenuhi conditional content threshold.
- Query dapat memakai City direct atau Province descendants.
- Duplicate city names memerlukan stable code/identity, bukan display label saja.

### 18.4 Public location pages

Location terms adalah reference data, bukan otomatis sitemap. Context page hanya
dirender untuk lokasi yang memiliki Project relevan dan/atau editorial context
bermakna. Empty/thin state tidak indexable.

---

## 19. Facility Architecture

Facility memakai **custom taxonomy** sebagai reusable reference. Project memilih
Facility terms dan dapat menyimpan Project-specific context/description terpisah.

Rules:

- Jangan menginvent nilai fasilitas baru.
- Common Facility term dapat digunakan banyak Project.
- Project context tidak mengubah shared label global.
- Facility label/description yang dibaca publik dapat diterjemahkan.
- Icon/media reference bukan sumber business meaning.
- Facility tidak otomatis menjadi standalone public page.

Jika context per Project menjadi kompleks, relation record khusus dapat ditambahkan
tanpa mengubah reusable term model.

---

## 20. Multilingual Architecture

### 20.1 Approved behavior

- Indonesian adalah canonical/source di `/`.
- English adalah linked translation di `/en/`.
- Tidak ada `/id/` pada V1.
- Translation bukan website kedua yang berdiri sendiri.
- Shared structured data hanya memiliki satu source.

### 20.2 Evaluated solutions

| Solution | Strengths | Trade-offs |
|---|---|---|
| Polylang Pro | Linked WordPress translations, multilingual CPT/taxonomy, Site Editor/navigation workflow, shared/translated field synchronization, URL-slug options, dan future REST/multilingual integration boundary | Commercial license/procurement; custom table perlu adapter dan field policy |
| WPML | Translation workflow dan configuration surface kuat untuk CPT/taxonomy/custom fields | Commercial dependency dan admin surface lebih besar; tier/license harus dipilih |
| Custom bilingual layer | Kontrol penuh | Harus membangun relation, URL, editor, hreflang, dan fallback sendiri; tidak dipilih |

### 20.3 Recommendation

**Primary production architecture: Polylang Pro**, karena Controlled Block Theme/Site
Editor workflow membutuhkan multilingual CPT/taxonomy, linked navigation, URL-slug
options, content synchronization, dan future REST/multilingual integration yang lebih
kuat. Polylang Pro adalah desain target, bukan persetujuan pembelian.

**Fallback: WPML**, bila workflow translation terpadu, vendor support, atau feature
coverage lebih sesuai setelah evaluasi license tier.

Tidak ada plugin di-install oleh pekerjaan ini. Pembelian Polylang Pro adalah
**PRE-MULTILINGUAL-IMPLEMENTATION PROCUREMENT DECISION**. Procurement bukan
architecture blocker. Namun, bila workflow implementation yang dipilih memerlukan
feature Pro, license approval menjadi blocker untuk multilingual production
implementation.

### 20.4 Field policy

| Data | Policy |
|---|---|
| Project/House Type description | Translate pada linked English content |
| House Type identity | Indonesian House Type CPT record is canonical; English may link to its translated House Type record |
| Article/Vacancy body | Translate sebagai linked content |
| Facility label/description | Translate bila dibaca publik |
| Project/Unit status | Value shared; label output translated |
| Dimensions, rooms, floors, progress percentage | Shared/copy; satu source |
| Coordinates, unit reference, IDs, relationships | Shared; jangan translation-specific |
| Public phone/WhatsApp | Shared; source dari Branch |
| Lead data | Internal, language-neutral; submitted language optional metadata |
| KPR numeric parameters | Shared; public disclaimer/copy translated |

Unit dan Lead custom tables tidak digandakan per bahasa. English Project membaca
Unit yang sama, dan Unit tetap merujuk canonical House Type identity. Presentation
English dapat resolve linked English House Type content bila tersedia.
`marison-core` menjadi adapter bila multilingual plugin tidak
memahami custom table; adapter tidak menyalin rows.

### 20.5 Integrity

- English item selalu linked ke Indonesian canonical.
- Language switcher menuju halaman yang sama bila translation tersedia.
- Jika belum tersedia, fallback jujur ke Indonesian context, bukan English Home kosong.
- Slug, canonical, hreflang, dan sitemap berasal dari multilingual integration.
- Translation relationship tidak boleh hilang karena theme change.

---

## 21. Custom Fields Strategy

### 21.1 Evaluation

| Approach | Evaluation |
|---|---|
| Native meta + custom admin UI | Portable, no required plugin, explicit type/validation; UI work lebih besar |
| ACF | Repeater/group UI dan local JSON Git workflow kuat; plugin/license/translation dependency |
| Framework lain | Convenience, tetapi dependency baru tanpa alasan kuat |
| Mixed | Native business storage + framework editorial; fleksibel tetapi governance lebih rumit |

### 21.2 Recommendation

**Primary: Native registered post meta/term meta + custom admin interfaces in
`marison-core`.** Block Editor dipakai untuk editorial copy; business source of truth
tetap typed dan tervalidasi.

Alasan:

- Tidak ada ACF dependency wajib agar business data dapat dibaca.
- Field definitions, defaults, validation, dan relationships berada di Git-managed
  plugin source.
- Translation policy dapat ditetapkan eksplisit per field.
- Raw technical fields dapat disembunyikan dari staff melalui custom screens.
- Cocok untuk AI/developer karena contract dapat ditulis dan diuji secara eksplisit.

### 21.3 ACF position

ACF **tidak required pada V1**. ACF memiliki nilai nyata untuk repeater/group UI dan
local JSON sync, sehingga dapat menjadi fallback setelah spike admin UX dan explicit
approval. Jika dipilih:

- field groups berada di plugin, bukan theme;
- JSON/PHP definitions Git-managed;
- license/tier dan production sync disetujui;
- disabling ACF tidak menghapus data;
- Unit/Lead custom tables tidak bergantung pada ACF;
- translation behavior setiap field diuji.

### 21.4 Field governance

Setiap business field memiliki owner, purpose, storage/default, validation, visibility,
translation policy, revision/audit expectation, migration behavior, dan editor role.

---

## 22. Editor Experience

| Kebutuhan | Editing surface |
|---|---|
| Article | Native Block Editor, categories, curated Project relation |
| Career Vacancy | Structured Vacancy editor + editorial content |
| Project copy/media | Project editor, structured fields, locked presentation |
| House Type | Non-public CPT admin UI with Project relation |
| Unit status/identity | Dedicated inventory screen + approved bulk operations |
| Branch/contact | Dedicated Branch screen + format validation |
| Facilities/Locations | Curated reference management |
| Marketing assignment | Restricted operations screen |
| Leads | Restricted Lead screen; no public post editor |
| KPR | Restricted Scheme editor + explicit default action |
| Corporate settings | Restricted Settings screen |
| Header/Footer/layout | Administrator/developer-controlled theme source/Site Editor |

Project layout, Directory, Header/Footer, dan availability presentation bukan blank
canvas. Content Editor mendapat freedom pada copy, image, Article, dan Vacancy;
bukan pada business invariants atau global styles.

---

## 23. Admin Menu Architecture

Hindari menjadikan setiap technical object sebagai top-level menu. Gunakan satu
Marison operations area yang mengikuti pekerjaan staf.

```text
Marison
├── Perumahan
│   ├── Projects
│   ├── House Types
│   └── Unit Inventory
├── Operasional
│   ├── Branches
│   └── Marketing
├── Leads                 (authorized only)
├── KPR
├── Artikel
├── Karier
├── Lokasi
└── Marison Settings      (restricted configuration)
```

House Types memiliki menu admin tersendiri karena merupakan non-public CPT yang
memerlukan stable identity dan references, tetapi tetap tidak memiliki public archive
atau discovery. Jika inventory menjadi besar, submenu import/export/status boleh
ditambahkan tanpa membuat global public Unit archive. Menu hanya tampil kepada role
yang relevan; capability tetap menjadi security boundary.

Menu visibility bukan security boundary; screen, direct URL, REST route, export,
dan action tetap memeriksa capability.

---

## 24. Roles & Capabilities

### Minimum useful separation

1. **Administrator** — system configuration, users, migrations, integrations,
   theme/editor controls, KPR authorization, dan Lead policy configuration.
2. **Content Editor** — Articles, Career editorial content, approved Project copy/
   media, translation work; tanpa raw Unit, Lead, Marketing, atau KPR configuration.
3. **Project / Inventory Manager** — Project operational fields, House Types, Unit
   status, Branch assignment, availability mode, dan approved relationships.

Marketing assignment dan KPR dapat diberikan kepada Administrator atau authorized
subset melalui capability boundaries minimal. Exact capability names tidak difinalkan.

Content Editor dan Project/Inventory Manager tidak otomatis mendapat Lead access.
Akses Lead harus eksplisit kepada personel yang berwenang. Semua Lead read/export/
delete path memakai capability check. KPR activation dan public-default change juga
restricted.

Tidak dibuat enterprise permission system puluhan level, approval engine, atau
per-user workflow V1.

---

## 25. Data Integrity

| Rule | Conceptual enforcement |
|---|---|
| Unit tepat satu Project | Unit contract, admin form, importer, public query guard |
| Unit House Type dari Project sama | Core relationship validator pada save/import |
| Project tepat satu Primary Branch | Project editor validation dan publish gate |
| Public contact dari Branch | Core routing/data contract; theme tidak memilih nomor sendiri |
| Derived/manual tidak bersamaan | Availability state machine, save validation, render guard |
| Tepat satu public-default KPR | Restricted action + uniqueness check + option pointer validation |
| Inactive KPR tidak default | Validation sebelum save/default action |
| Lead mempertahankan source Project | Ingestion wajib source; relation immutable kecuali correction berwenang |
| Translation tetap linked | Multilingual adapter, source/translation validation |
| Shared data tidak diduplikasi | Field translation policy dan language-neutral tables |
| Marketing internal tidak public | Non-public registration, capability, output allowlist |
| Location parent valid | Dependent selector dan ancestor validation |
| Project/Unit status values fixed | Project meta allows only `upcoming`/`ongoing`/`completed`; Unit table allows only `available`/`booked`/`sold`; importer validation, no free labels |
| Public Project minimum valid | Pre-publish check dan public query filter |

Validation harus ada pada admin UI, save/service, import, REST write, dan migration;
validasi UI saja tidak cukup.

---

## 26. Public vs Internal Data

### 26.1 Publicly queryable

- Published Project dan sanitized relationships.
- Published Article dan curated categories.
- Published Career Vacancy sesuai active/closed policy.
- Conditional Location context yang lolos content threshold.
- Branch public name/address/telephone/WhatsApp hanya melalui approved context.
- Eligible default KPR output dan disclaimer.
- Derived/manual availability summary dan Unit reference/status yang disetujui.

### 26.2 Internal only

- Lead name, phone, consent, message, delivery state, retention metadata.
- Marketing Person/Team, assignment, internal routing history.
- Raw Unit fields, import keys, audit fields, operational notes.
- Branch internal contacts/routing details.
- Inactive/historical KPR administration records.
- Settings, migration state, logs, schema diagnostics.

### 26.3 REST/API principles

- Jangan expose internal objects otomatis dengan mengaktifkan `show_in_rest`.
- Public routes adalah allowlist sanitized read models, bukan mirror semua table/meta.
- Internal writes memerlukan authentication, capability, nonce bila relevan, dan
  schema validation.
- Registered meta public hanya bila exposure dan schema memang intentional.
- Public availability tidak boleh membocorkan buyer/owner, internal note, Marketing,
  import, atau identifier database yang tidak diperlukan.
- Unit raw table dan Lead table tidak memiliki unauthenticated endpoint.

---

## 27. Security

Implementation kelak wajib menerapkan:

1. Capability checks pada screen, direct action, REST, export, import, Lead read,
   Lead delete, dan settings.
2. Nonce protection untuk state-changing admin/form actions.
3. Input validation untuk type, allowed values, relationship, numeric range, URL,
   email, phone, dan source/translation IDs.
4. Context-appropriate sanitization saat save.
5. Output escaping untuk HTML, attributes, URL, JSON, dan email.
6. Prepared queries untuk custom tables; tanpa string-concatenated SQL.
7. Safe file upload: capability, mime/type allowlist, size, filename, media path,
   dan no executable upload.
8. Spam protection, rate limiting, duplicate-submission handling, dan delivery
   failure handling untuk forms; provider belum dipilih.
9. Secrets hanya di environment/hosting secret configuration.
10. Tidak memodifikasi WordPress core.
11. Tidak menaruh Lead data di logs, URLs, analytics event, HTML source, atau public cache.
12. Cache mengecualikan authenticated/admin/private responses.
13. Outdated WordPress/PHP/plugin versions ditangani sebelum production.
14. Backup dan restore test sebelum schema migration atau data-impacting release.

Security architecture tidak memilih provider atau mengklaim compliance legal tertentu.

---

## 28. Privacy

### 28.1 Lead privacy boundary

Lead table harus mendukung export per authorized request, deletion per record/batch,
retention cleanup setelah durasi ditetapkan, access review, consent metadata,
source Project preservation, dan deletion/redaction tanpa menghapus Project atau
Unit data.

### 28.2 WordPress privacy tools

Jika praktis, `marison-core` mengintegrasikan WordPress personal-data exporter/eraser
hooks. Karena Lead berada di custom table, hooks harus secara eksplisit membaca,
memetakan, dan menghapus record yang cocok; WordPress tidak diasumsikan menemukan
custom rows otomatis.

### 28.3 No invented policy

Durasi retention, detailed access policy, deletion approval, consent notice, dan
privacy governance tetap **TO BE DEFINED** dan **BEFORE LAUNCH**. Storage choice
memungkinkan keputusan tersebut tanpa mengubah Lead model besar-besaran. Ini bukan
architecture-document blocker, tetapi merupakan **PRE-LAUNCH PRIVACY / GOVERNANCE
BLOCKER** sebelum production Lead collection.

### 28.4 Test data

Local/staging fixtures tidak boleh berisi real name, phone, lead, buyer, NIK, atau
property personal data. Gunakan data fiktif yang jelas.

---

## 29. Performance

### 29.1 Hostinger Business posture

Arsitektur compatible dengan LiteSpeed/PHP/MySQL environment dan tidak menjadikan
satu caching plugin sebagai syarat correctness. Page/object cache boleh dipakai bila
tersedia, tetapi query dan invalidation tetap benar tanpa cache.

### 29.2 Performance categories

| Category | Rule konseptual |
|---|---|
| Server/database | Query terarah, pagination, indexes sesuai access pattern, hindari unbounded meta query |
| HTML/CSS | Theme ringan, token terpusat, no page-builder output |
| JavaScript | Progressive enhancement; hanya discovery/simulator/sticky interactions yang perlu |
| Images | Responsive sizes, crop tepat, alt text, WebP/AVIF bila platform mendukung, lazy load sesuai context |
| Fonts | Subset/loading strategy diverifikasi; jangan load font berlebihan |
| Third-party | Minimum scripts; provider integration replaceable/deferred |
| Cache | Compatible dengan Host/LiteSpeed; private/authenticated responses excluded; invalidation jelas |
| Admin | Bulk Unit operations batch/paginated; tidak load seluruh inventory |
| API | Sanitized response, pagination, field allowlist, no table dump |

### 29.3 Query strategy

- Project directory memakai native CPT/taxonomy query yang terukur.
- Unit counts/query memakai custom table access pattern, bukan loop post per Unit.
- Related Articles dibatasi/paginated bila besar.
- Location page tidak query semua taxonomy tanpa kebutuhan.
- Derived availability dapat dicache dengan invalidation pada Unit/relationship/mode.

Target angka performance belum disetujui. Implementation harus menetapkan budget
dan measurement untuk response/database, page weight, images, JS/CSS, third-party,
dan Core Web Vitals tanpa mengarang target di dokumen ini.

---

## 30. SEO

Arsitektur mendukung:

- Project indexable bila published, valid, memiliki content minimum, dan URL stabil.
- Article archive/detail native.
- Career active detail dan conditional closed detail.
- Province/City pages hanya conditional bila bernilai.
- Filter states noindex/non-indexable; tidak membuat URL kombinasi massal.
- Indonesian canonical root dan English `/en/` linked translations.
- Canonical, hreflang, translated slugs, sitemap, metadata, dan schema capability
  melalui integration boundary.
- Stable slugs dan redirect policy sebagai release discipline.

SEO plugin belum dipilih sebagai core dependency. Jika disetujui, ia replaceable;
business data, URL intent, indexability, dan relationships tidak bergantung pada
satu vendor.

---

## 31. Theme / Plugin Dependency

`marison` boleh membaca data dari `marison-core`. `marison-core` tidak boleh membaca
template, class, asset, atau CSS dari `marison` untuk mempertahankan data.

- Theme disabled: data ada; core/admin tetap dapat bekerja.
- Core disabled: theme memakai safe unavailable state, bukan fatal error/data loss;
  production tetap menganggap core REQUIRED.
- Multilingual integration disabled: core data tetap ada; translation display dapat
  turun ke canonical mode dengan maintenance notice.
- Cache integration disabled: correctness sama, performa mungkin berubah.

Business logic tidak boleh ditempatkan di SEO, cache, form, atau multilingual plugin
sehingga vendor replacement memerlukan migrasi data besar.

---

## 32. Repository / Git Strategy

### 32.1 Git contents

```text
wp-content/
├── themes/
│   └── marison/
├── plugins/
│   └── marison-core/
docs/
sample-data/
```

Git menyimpan theme/plugin source, docs, tests/tooling bila disetujui, anonymized
fixtures, migration definitions, dan lockfiles bila dependency manager kelak dipakai.

### 32.2 Never commit

- WordPress core;
- `wp-config.php`, `.env`, credentials, API keys, private keys;
- database dump, SQL export, local database;
- `uploads/`, cache, backups, generated runtime files, production logs;
- real Lead, customer, buyer, phone, atau property personal data;
- production-generated configuration yang bukan source of truth.

### 32.3 Composer/npm policy

Tidak memperkenalkan Composer atau npm untuk architecture task. Jika kelak perlu,
harus ada alasan dependency jelas, lockfile, reproducible build, CI/local version
policy, dan release procedure. Dependency tidak menggantikan native WordPress tanpa
benefit yang terukur.

---

## 33. Two-Computer Workflow

- Home dan Office memiliki local WordPress dan database masing-masing.
- GitHub adalah source of truth untuk code dan docs.
- Pull `develop` sebelum branch task.
- Satu task memakai satu `feat/*`/`fix/*` branch.
- Database local tidak diasumsikan identik atau di-commit.
- Safe sample data direpresentasikan sebagai anonymized JSON/CSV/fixture setelah
  importer secara eksplisit disetujui.
- Local seed harus idempotent dan memakai stable fixture keys, bukan production IDs.
- Real production content tidak disalin ke laptop tanpa policy dan sanitization.
- Code berpindah melalui GitHub; content changes melalui WordPress environment workflow.

Reproducibility berarti developer dapat menyiapkan WordPress, mengaktifkan code dari
Git, dan memuat sample data tanpa production dump atau real PII.

---

## 34. Environment Strategy

### LOCAL

Development, tests, admin workflow, safe fixtures, accessibility/responsive checks.
Tidak ada real personal data.

### STAGING

Integration, translation, content acceptance, performance smoke, security checks,
dan release-candidate validation. Data berasal dari safe fixture atau controlled
content copy; database staging tidak diasumsikan aman untuk dipublish balik.

### PRODUCTION

`marison.id`. Hanya release yang tervalidasi dan disetujui. Tidak ada feature
development langsung di Production. Live content diperlakukan sebagai data bernilai.

### Environment parity

PHP/WordPress versions, extensions, rewrite, image processing, cron, mail, file
permissions, dan LiteSpeed/cache behavior diverifikasi antar environment. Secrets
dan production contacts tidak berada di Git/fixtures.

---

## 35. Hostinger Deployment Strategy

### 35.1 Core rule

**Pisahkan code deployment dari database/content changes.** Hostinger staging Publish
dapat mengganti files dan database. Karena Production dapat memiliki content lebih
baru, full staging database publish bukan release default.

### 35.2 Recommended workflow

```text
Local → feature branch → GitHub review/merge
      → controlled Staging code deployment
      → validation
      → controlled Production code release
```

Content normal dikelola melalui WordPress pada environment pemilik content, bukan
overwrite Production dengan staging database lama.

### 35.3 Code release

- Deploy versioned code dari GitHub melalui supported Git deployment atau SSH setelah
  capability account diverifikasi.
- Prefer commit/tag reference daripada edit file Production manual.
- Theme dan `marison-core` dirilis bersama bila contract berubah.
- Cache dipurge/invalidasi sesuai release plan.
- Code release tidak menghapus atau mengganti Production content.

### 35.4 Database/content release

- Editorial content berubah melalui WordPress admin pada environment yang ditentukan.
- Schema migrations berjalan melalui plugin upgrade setelah backup, bukan raw SQL.
- Reference seed memakai idempotent importer/migration dan stable keys.
- Perubahan besar memakai diff, validation, approval, dan backup; bukan full DB push.

### 35.5 Staging Publish guardrail

Jika Publish files+database tidak dapat dipisahkan:

1. Jangan gunakan untuk release rutin setelah Production memiliki content baru.
2. Gunakan hanya saat content freeze dan replacement disetujui eksplisit.
3. Ambil dan verifikasi backup Production terlebih dahulu.
4. Catat database/content version sebelum publish.
5. Perlakukan sebagai migration event dengan approval, bukan deployment biasa.

Git deployment, SSH, staging, backups, restore, LiteSpeed cache, cron, dan file
permissions Hostinger Business harus diverifikasi pada account sebelum runbook final.
Ini adalah **PRE-DEPLOYMENT VALIDATION**, bukan architecture blocker. Tidak ada
deployment dilakukan dalam pekerjaan ini.

---

## 36. Database Migration Strategy

Jika `marison-core` memakai Unit/Lead tables, migrations, atau seeded references:

1. Plugin memiliki schema version yang dapat dibaca dan dinaikkan berurutan.
2. Migration idempotent, scoped, observable, dan resumable setelah interruption.
3. Upgrade berjalan melalui plugin process; admin tidak menjalankan raw SQL normal.
4. Table change memakai WordPress-compatible migration mechanism yang dipilih kelak.
5. Preflight memeriksa version, permission, storage, backup, row count, dan impact.
6. Post-check memeriksa row counts, relationships, status values, availability,
   dan public query smoke checks.
7. Failure dicatat dan menghentikan langkah berikutnya dengan safe error state.
8. Roll-forward/rollback strategy ditulis per migration; backup restore fallback.
9. Seed references memakai stable business keys dan aman untuk rerun.
10. Destructive data change memerlukan explicit decision dan backup.

---

## 37. Logging

Gunakan lightweight bounded logging untuk:

- Lead delivery/notification failure;
- Unit import validation dan bulk update failure;
- migration/schema failure;
- KPR default change atau invalid configuration;
- privacy export/delete failure;
- cache invalidation failure yang memengaruhi public correctness.

Log tidak boleh berisi Lead phone/message, credentials, atau secrets. Simpan event
type, timestamp, safe reference/actor, status, dan error category secukupnya. Hindari
giant audit platform; log retention dan Lead retention adalah dua hal berbeda.

---

## 38. Import / Export

Unit import/export menjadi **early post-launch operational requirement**, bukan
blocker architecture foundation atau kewajiban UI launch bila initial inventory
dapat dimasukkan aman melalui admin workflow.

Storage sejak V1 harus punya contract untuk:

1. CSV template dengan stable Project key, Unit reference, House Type key, status,
   dan fields yang disetujui.
2. Authorized Inventory Manager only.
3. Validation preview/dry-run sebelum write.
4. Row-level error report tanpa partial silent success.
5. Safe upsert dengan stable key, bukan row position.
6. Duplicate/conflicting references yang memerlukan explicit resolution.
7. Ownership validation untuk Project/House Type.
8. Confirmation untuk mass status updates.
9. Batch processing agar tidak timeout pada Hostinger.
10. Export yang menghilangkan internal fields yang tidak diperlukan.
11. Retry/recovery dan import failure log tanpa personal data.

Lead export berbeda: restricted, privacy-aware, auditable, dan tidak memakai Unit
import tooling yang sama.

---

## 39. Testing Strategy

### PHP/unit logic

Fixed statuses, relationships, one-default KPR, availability modes, translation
policy, sanitization, dan migration transitions.

### WordPress integration

Registration, admin save/publish gates, capabilities, direct URL access, revisions,
REST permission, privacy exporter/eraser, dan cache invalidation.

### Data integrity

Unit–Project, Unit–House Type same Project, deterministic Branch routing, derived/
manual exclusivity, KPR default, Lead source preservation, translation linkage.

### Admin workflows

Project edit, House Type management, Unit single/bulk update, Branch contact,
Article relation, Career close/reopen, KPR default, restricted Lead, import preview.

### Frontend

Home, Directory, Project, Article, Career, KPR, location; missing media, no Unit,
manual fallback, unavailable contact, no default KPR, closed Vacancy, missing English.

### Accessibility/responsive

Keyboard/focus, WCAG AA contrast, non-color status, labels/errors/consent, mobile
390px-class, desktop 1440px-class, no overflow, reduced motion, sticky safety.

### Operations/performance

Representative Unit counts, batch import limits, cache hit/miss/invalidation,
responsive images, Core Web Vitals after targets are approved, backup/restore, and
migration rehearsal.

### Staging acceptance

Approved sample content, Indonesian/English paths, public/internal visibility,
security smoke test, contact routing, no production overwrite, release/rollback runbook.

---

## 40. Dependency Policy

| Dependency | Purpose | Required? | Alternative | Risk | Approval status |
|---|---|---|---|---|---|
| `marison-core` | Business data/logic | **CORE** | None for supported site | Boundary errors/disabled core | Approved boundary |
| Polylang Pro | Linked ID/EN content, multilingual Site Editor workflow | Primary production design target; not installed | WPML fallback | Procurement/license, custom-table adapter | **PRE-MULTILINGUAL-IMPLEMENTATION PROCUREMENT DECISION** |
| WPML | Multilingual fallback | Optional | Polylang | Commercial dependency/admin surface | Not primary |
| SEO integration | Metadata/schema/sitemap | Optional | Replaceable adapter | Lock-in/duplicate metadata | Not selected |
| Cache integration | Page/object cache | Optional | Host/LiteSpeed/native cache | Stale private data/lock-in | Environment validation |
| ACF | Field/repeater UI | Not required | Native meta + custom UI | Plugin/license/translation coupling | Not approved; later spike possible |
| Form plugin | Form/delivery | Not required baseline | Core-controlled form boundary | Spam/privacy/recipient leakage | Not selected |
| Security plugin | Additional hardening | Optional | Focused core/host controls | Duplicate rules/overhead | Not selected |
| Page builder | Freeform layout | **AVOID** | Locked Block Theme patterns | Layout chaos/performance | Rejected |
| Composer/npm framework | Build dependencies | Not required | Native PHP/CSS/JS | Supply-chain/build complexity | Do not introduce without reason |
| CAPTCHA provider | Spam | Not selected | Rate limiting/provider later | Privacy/cost/lock-in | Open future decision |
| Map provider | Map display | Not selected | Address/coordinates | API/privacy/performance | Open future decision |

Default posture: minimal dependencies. A dependency perlu memberi manfaat durable
yang lebih besar daripada update, licensing, privacy, performance, dan replacement cost.

---

## 41. Plugin Allowlist

### CORE / REQUIRED

- `marison-core` — business data, rules, admin, privacy, integration boundary.
- Polylang Pro adalah primary production design target; WPML adalah fallback. Hanya
  satu multilingual authority yang boleh digunakan dalam satu Production install.
  Procurement/license approval terpisah dari architecture approval.

### OPTIONAL / REPLACEABLE

- SEO integration setelah requirement review.
- Cache/object-cache setelah Hostinger validation.
- Security hardening bila ada gap konkret.
- Form/delivery integration bila core tetap menjadi privacy/data boundary.

### AVOID

- Elementor dan page builder lain.
- Plugin yang menyimpan business data hanya di theme.
- Multiple overlapping SEO/cache/form/security/multilingual plugins.
- Plugin yang expose internal objects ke public REST tanpa allowlist.
- Plugin dengan remote tracking/data transfer yang belum direview.

Tidak ada plugin di-install dalam pekerjaan architecture ini.

---

## 42. Architecture Decision Records

### ADR-WP-01 — Theme type

- **DECISION:** Custom Block Theme terkontrol; business logic di `marison-core`.
- **ALTERNATIVES:** Classic theme; unrestricted Block Theme; page builder.
- **REASON:** Native editing dan design system dengan layout safety.
- **TRADEOFF:** Perlu template lock/content-only dan custom admin UI.
- **REVERSIBILITY:** Sedang. Theme dapat diganti karena data berada di core.

### ADR-WP-02 — Unit storage

- **DECISION:** Dedicated custom table dengan dedicated admin UI.
- **ALTERNATIVES:** CPT + meta; external inventory system.
- **REASON:** Query/filter/status/bulk/import pada ribuan hingga puluhan ribu Unit.
- **TRADEOFF:** Migration, admin, revision/history, dan portability harus dirancang.
- **REVERSIBILITY:** Sedang–rendah setelah data besar; stable IDs/export mengurangi lock-in.

### ADR-WP-03 — Lead storage

- **DECISION:** Dedicated private Lead table.
- **ALTERNATIVES:** Private CPT + meta; external CRM.
- **REASON:** Sensitive non-editorial records tanpa public URL/revision, dengan targeted
  retention/export/delete.
- **TRADEOFF:** Custom privacy hooks, migration, dan admin screen.
- **REVERSIBILITY:** Sedang melalui export schema.

### ADR-WP-04 — Location model

- **DECISION:** Satu hierarchical Location taxonomy Country → Province → City/Regency.
- **ALTERNATIVES:** Separate taxonomies; CPT entities; free text.
- **REASON:** Menjaga hierarchy dan reusable filtering dengan overhead rendah.
- **TRADEOFF:** Parent validation dan duplicate-name handling perlu custom UI.
- **REVERSIBILITY:** Sedang dengan stable geographic IDs.

### ADR-WP-05 — Multilingual solution

- **DECISION:** Polylang Pro sebagai primary production design target, WPML fallback;
  custom bilingual layer ditolak untuk V1.
- **ALTERNATIVES:** WPML primary; custom layer; single language.
- **REASON:** Controlled Block Theme/Site Editor membutuhkan multilingual CPT,
  taxonomy, navigation, URL-slug, synchronization, dan future integration support.
- **TRADEOFF:** Procurement/license, custom table adapter, translation QA.
- **REVERSIBILITY:** Sedang jika translation IDs dan content contract diekspor.

### ADR-WP-06 — Custom fields

- **DECISION:** Native registered meta/term meta + custom admin UI; ACF optional only
  after explicit approval.
- **ALTERNATIVES:** ACF required; framework lain; raw Block Editor meta.
- **REASON:** Minimal dependency, Git-managed definitions, explicit validation.
- **TRADEOFF:** Lebih banyak implementation work untuk repeater/editor UX.
- **REVERSIBILITY:** Sedang; storage contracts dapat dipetakan kemudian.

### ADR-WP-07 — Deployment

- **DECISION:** Git/code release dipisah dari content/database changes; tidak ada
  routine full staging database publish ke Production.
- **ALTERNATIVES:** Full staging clone publish; manual Production edits.
- **REASON:** Staging Publish dapat menimpa content live yang lebih baru.
- **TRADEOFF:** Perlu release/runbook, migration, backup, dan environment discipline.
- **REVERSIBILITY:** Tinggi untuk code; database rollback bergantung backup/migration.

### ADR-WP-08 — Project Status

- **DECISION:** Controlled registered post meta / enum-like value dengan tiga stable
  values: `upcoming`, `ongoing`, `completed`.
- **ALTERNATIVES:** Custom taxonomy; unrestricted taxonomy; free text.
- **REASON:** Project Status adalah workflow/state, bukan content classification; tidak
  ada arbitrary terms dan current Project scale tidak memerlukan taxonomy filter.
- **TRADEOFF:** Filtering memakai bounded meta query/core abstraction dan membutuhkan
  value validation.
- **REVERSIBILITY:** Tinggi melalui stable values dan explicit migration mapping.

### ADR-WP-09 — House Type storage

- **DECISION:** Dedicated non-public Custom Post Type dengan tepat satu Project relation.
- **ALTERNATIVES:** Structured child/repeater data; native blocks; public CPT.
- **REASON:** Stable identity untuk Unit references, structured numeric/media fields,
  linked translation, dan revision/history tanpa membuat public discovery.
- **TRADEOFF:** Memerlukan admin UI, relation validation, dan orphan cleanup policy.
- **REVERSIBILITY:** Sedang; public rendering contract tetap berada di Project Detail.

### ADR-WP-10 — Marketing record storage

- **DECISION:** Non-public managed Custom Post Type; assignment memakai controlled
  internal relationship model.
- **ALTERNATIVES:** WordPress Users; freeform Project meta; external CRM.
- **REASON:** Tidak semua Marketing person/team membutuhkan login; record dapat
  dipertahankan sebagai sejarah dan mudah dikelola administrator.
- **TRADEOFF:** Internal relationship/history UI diperlukan; tidak boleh melebar menjadi CRM.
- **REVERSIBILITY:** Sedang melalui stable record IDs dan relation export.

### ADR-WP-11 — KPR scheme

- **DECISION:** KPR CPT + restricted public-default option pointer.
- **ALTERNATIVES:** Options-only; single Page; external financing service.
- **REASON:** History/multiple scheme butuh records; default adalah singleton.
- **TRADEOFF:** Dua storage boundary harus divalidasi bersama.
- **REVERSIBILITY:** Tinggi sebelum external formula/service.

---

## 43. Risks

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Custom Unit table terlalu kompleks | Inventory tidak terkelola | Dedicated UI, CSV preview, scale testing |
| Unit volume ternyata kecil | Overengineering | Stable abstraction; evaluasi dengan data nyata |
| Admin field UI terlambat | Staff mengedit raw data | Prioritaskan Project/Unit/Branch screens |
| Translation tier tidak cukup | English workflow tertahan | Confirm tier; WPML fallback; integration tests |
| Table relation mismatch lintas bahasa | Duplicate/missing context | Language-neutral tables + custom adapter |
| Lead retention belum diputuskan | Privacy risk | Restricted table/hooks; policy gate before launch |
| Staging DB overwrite Production | Kehilangan live content | Code/content separation, backup, no blind publish |
| Branch contact stale | Salah routing/unavailable | Validation, publish gate, health check, invalidation |
| Manual/derived availability conflict | Angka menyesatkan | Exclusive mode, render guard, transition review |
| Theme owns business logic | Data hilang saat theme change | Core ownership, theme-disabled test |
| Plugin stack terlalu besar | Performance/security/upgrade risk | Allowlist and replacement policy |
| Location pages thin | SEO quality turun | Conditional publishing, no mass URLs |
| Native admin UI mahal | Implementation delay | Incremental UI; ACF only with approval |
| Data owner/cadence belum ada | Content stale | Governance question before launch |
| Hostinger capability berbeda | Runbook gagal | Account-specific staging verification |

---

## 44. Open Architecture Questions

Pertanyaan ini benar-benar memerlukan human approval; rekomendasi teknis tetap dibuat
di bagian lain dan tidak dihindari karena open questions.

### OA-Q01 — Polylang Pro procurement/license

- **RECOMMENDED DEFAULT:** Polylang Pro sebagai primary production design target.
- **ALTERNATIVES:** WPML; menunda multilingual production implementation.
- **WHY:** Controlled Block Theme/Site Editor workflow membutuhkan feature coverage
  yang ditargetkan oleh Polylang Pro.
- **IMPACT:** Procurement/license approval, deployment dependency, translation QA.
- **CLASSIFICATION:** **PRE-MULTILINGUAL-IMPLEMENTATION PROCUREMENT DECISION**.
- **BLOCKING ARCHITECTURE?** **NO**.
- **BLOCKING MULTILINGUAL PRODUCTION IMPLEMENTATION?** **YES** bila workflow yang
  dipilih memerlukan feature Pro dan belum ada license approval.

### OA-Q02 — Lead retention dan access policy

- **RECOMMENDED DEFAULT:** Tetapkan retention, authorized role, export/delete process,
  dan consent notice sebelum production form aktif; durasi tidak diinventkan.
- **ALTERNATIVES:** Policy legal/internal lain yang terdokumentasi.
- **WHY:** Durasi dan siapa yang boleh mengakses adalah keputusan Marison/legal; storage
  sudah mendukung policy yang configurable.
- **IMPACT:** Privacy hooks, admin access, cleanup schedule, training.
- **CLASSIFICATION:** **PRE-LAUNCH PRIVACY / GOVERNANCE BLOCKER**.
- **BLOCKING ARCHITECTURE?** **NO**.
- **BLOCKING LAUNCH?** **YES** sebelum production Lead collection.

### OA-Q03 — Unit scale dan import cadence

- **RECOMMENDED DEFAULT:** Tetap custom table; ukur Unit per Project, update frequency,
  dan CSV kebutuhan pada staging/sample.
- **ALTERNATIVES:** CPT + meta bila inventory kecil dan no bulk workflow.
- **WHY:** Table baseline melayani growth, tetapi UI/index/batch perlu data nyata.
- **IMPACT:** Admin scope, import priority, performance tests.
- **CLASSIFICATION:** Operational validation.
- **BLOCKING ARCHITECTURE?** **NO**.
- **IMPACT BEFORE IMPORTER UX:** Menentukan batch limits, preview behavior, dan
  performance tuning.

### OA-Q04 — Data ownership dan approval workflow

- **RECOMMENDED DEFAULT:** Administrator untuk system; Content Editor untuk editorial;
  Project/Inventory Manager untuk Project/Unit; authorized subset untuk Lead/KPR.
- **ALTERNATIVES:** Owner per Branch/Project atau approval workflow yang lebih spesifik.
- **WHY:** PRD belum menetapkan owner/frequency.
- **IMPACT:** Exact capabilities, training, notifications, publish gate.
- **CLASSIFICATION:** Operational governance question.
- **BLOCKING ARCHITECTURE?** **NO**.
- **IMPACT:** Menentukan exact roles, approval workflow, training, dan publish gate.

### OA-Q05 — Hostinger account deployment capability

- **RECOMMENDED DEFAULT:** Git/SSH code deployment dan separate content/database;
  staging Publish files+DB hanya exceptional migration.
- **ALTERNATIVES:** Files-only artifact release; frozen-content full publish.
- **WHY:** Account capability belum diverifikasi dan staging publish berisiko overwrite.
- **IMPACT:** Final runbook, permissions, backup, timing, dan release mechanism.
- **CLASSIFICATION:** **PRE-DEPLOYMENT VALIDATION**.
- **BLOCKING ARCHITECTURE?** **NO**.
- **BLOCKING FIRST DEPLOYMENT?** **YES** sampai behavior account terverifikasi.

### OA-Q06 — Corporate contact/fallback

- **RECOMMENDED DEFAULT:** Central contact di restricted settings; fallback hanya bila
  explicit; jangan silent Branch reroute.
- **ALTERNATIVES:** Approved contact hierarchy lain.
- **WHY:** Exact phone/email belum disetujui, tetapi recovery principle sudah jelas.
- **IMPACT:** Unavailable state, publish gate, form routing.
- **BLOCKING ARCHITECTURE?** **NO**.
- **BLOCKING LAUNCH OF FALLBACK CONTACT BEHAVIOR?** **YES** sampai contact disetujui.

### OA-Q07 — Map provider/coordinates

- **RECOMMENDED DEFAULT:** Provider-independent address/coordinates; map hanya setelah
  provider/privacy/performance policy disetujui.
- **ALTERNATIVES:** Provider tertentu; address-only V1.
- **WHY:** Approved sources belum memilih provider.
- **IMPACT:** API keys, privacy, page weight, map CTA.
- **CLASSIFICATION:** Operational/integration decision; provider harus replaceable.
- **BLOCKING ARCHITECTURE?** **NO**.
- **BLOCKING MAP INTEGRATION?** **YES** sampai provider disetujui.

### OA-Q08 — Public pricing activation

- **RECOMMENDED DEFAULT:** Price bukan V1 requirement; siapkan extension point tanpa
  menampilkan data yang belum approved.
- **ALTERNATIVES:** Project/Unit pricing model setelah business decision.
- **WHY:** PRD secara eksplisit tidak mewajibkan public price.
- **IMPACT:** Future fields, filters, KPR input, ownership.
- **CLASSIFICATION:** Future business decision.
- **BLOCKING ARCHITECTURE?** **NO**.

---

## 45. Acceptance Criteria

Architecture v1 dapat diterima bila semua pernyataan berikut “ya” atau memiliki
keputusan tertulis:

- [ ] Business data Project, Unit, Branch, Lead, KPR, Career, dan relationships tidak
      hilang ketika theme berubah/dinonaktifkan.
- [ ] Tidak ada Elementor atau page builder dependency.
- [ ] Staff dapat mengedit copy/media/structured data tanpa coding.
- [ ] Project, Directory, Header/Footer, dan availability layout tetap terkontrol.
- [ ] Project adalah Custom Post Type milik `marison-core`; presentation tetap milik
      `marison` theme.
- [ ] Project Status memakai stable post-meta values `upcoming`, `ongoing`, dan
      `completed`, dengan filtering tetap tersedia dan label translation tidak disimpan
      per Project.
- [ ] House Type adalah non-public Custom Post Type dengan tepat satu Project owner,
      tetapi tetap dirender hanya di dalam Project Detail.
- [ ] 30+ Project manageable dengan storage/query/admin konsisten.
- [ ] Unit memiliki strategi scalable untuk bulk/filter/import/siteplan masa depan.
- [ ] Unit merujuk canonical House Type identity bila dipakai, tanpa duplicate Unit
      inventory per bahasa.
- [ ] Branch routing deterministic dan context Project tetap melekat.
- [ ] Leads internal, restricted, privacy-lifecycle-ready, tanpa field terlarang.
- [ ] KPR mendukung history/multiple schemes dan satu eligible public default.
- [ ] Indonesian/English linked; shared fields tidak diduplikasi secara manual.
- [ ] Polylang Pro menjadi primary production design target tanpa menganggap procurement
      license telah disetujui.
- [ ] Theme/plugin boundaries jelas dan dapat diuji dengan theme disabled.
- [ ] Code/docs bekerja dengan dua komputer Git workflow.
- [ ] Production content tidak casually overwritten oleh staging.
- [ ] Privacy export/delete/retention dapat ditambahkan sebelum production form.
- [ ] Dependencies minimal dan replacement boundaries tersedia.
- [ ] Hostinger Business/LiteSpeed compatibility diperlakukan sebagai constraint yang
      perlu diverifikasi, bukan asumsi deployment.
- [ ] Tidak diperlukan Production implementation untuk memahami design ini.

---

## 46. Conceptual Architecture Diagram

```text
                         GitHub source of truth
                    ┌────────────────────────────┐
                    │ docs/                       │
                    │ themes/marison/             │
                    │ plugins/marison-core/       │
                    │ sample-data/                │
                    └──────────────┬─────────────┘
                                   │ code release
             ┌─────────────────────┼─────────────────────┐
             ▼                     ▼                     ▼
          LOCAL                 STAGING              PRODUCTION
       safe fixtures       integration/review        marison.id
       separate DB         controlled content        live content
             │                     │                     │
             └────────────── code validation ────────────┘
                                   │
                      no routine full DB overwrite

┌─────────────────────────────────────────────────────────────────────┐
│ WordPress Core                                                       │
│ Pages · native Posts · Block Editor · Media · Users · REST allowlist │
└───────────────────────────────┬─────────────────────────────────────┘
                                │
          ┌─────────────────────┴─────────────────────┐
          ▼                                           ▼
┌──────────────────────┐                  ┌──────────────────────────┐
│ marison theme        │                  │ marison-core              │
│ theme.json/templates │                  │ Project CPT               │
│ locked patterns      │◄── data contract ─►│ Status/Location/Facility │
│ accessible views     │                  │ Branch/Marketing         │
│ responsive assets    │                  │ House Type structure      │
│ public presentation  │                  │ Unit custom table         │
└──────────┬───────────┘                  │ Lead custom table         │
           │                              │ KPR/Career                │
           ▼                              │ validation/privacy        │
┌──────────────────────┐                  │ migrations/import         │
│ public experience    │                  │ routing/derived values    │
│ / /perumahan/ /en/   │                  └──────────────┬───────────┘
│ /artikel/ /karier/   │                                 │
│ /kpr/ /lokasi/       │                                 ▼
└──────────────────────┘                    ┌─────────────────────────┐
                                            │ Shared business rules   │
                                            │ Unit → availability     │
                                            │ Project → Branch        │
                                            │ KPR → one default       │
                                            │ Lead → source Project   │
                                            │ ID → EN linked content  │
                                            └─────────────────────────┘

Internal only: Lead records · Marketing assignments · raw Unit admin ·
inactive KPR admin · internal settings · migration/log data
```

Dokumen ini berhenti pada architecture/planning boundary. PHP, SQL, registration,
plugin installation, theme files, deployment, dan production access menunggu human
review serta implementation approval.
