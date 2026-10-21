# Visual Direction Core Marison ID v1

## 1. Document Information

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Dokumen | Visual Direction / High-Fidelity Design Spec v1 |
| Status | Final — Visual Direction v1 disetujui human review |
| Branch | `feat/core-visual-direction-v1` |
| Tanggal | 22 Oktober 2026 |
| Bahasa dokumen | Bahasa Indonesia |
| Sumber | `docs/PRD.md`, `docs/CONTENT-MODEL.md`, `docs/INFORMATION-ARCHITECTURE.md`, `docs/USER-FLOWS.md`, `docs/DESIGN-SYSTEM.md`, `docs/WIREFRAMES-CORE.md`, `docs/PROJECT-RULES.md` |
| Cakupan | Homepage, `/perumahan/`, `/perumahan/[project]/` |

Dokumen ini menerjemahkan wireframe low-fidelity dan Design System Marison menjadi
arah visual high-fidelity konseptual. Dokumen ini menjelaskan mood, hierarchy,
surface, grid, typography, image direction, state, responsive behavior, dan
micro-interaction.

Dokumen ini **bukan** mockup final, copy final, CSS, HTML, PHP, template WordPress,
komponen production, library, asset production, atau keputusan implementasi teknis.
Ukuran dan rentang yang ditulis adalah arahan visual untuk tahap berikutnya, bukan
production CSS variable.

---

## 2. Purpose

Visual Direction v1 harus membuat tiga halaman inti terasa sebagai satu produk Marison
yang:

- modern, approachable, trustworthy, optimistic, dan sedikit playful;
- cocok untuk pembeli rumah pertama dan audiens KPR/subsidi;
- membantu pengguna menemukan Project sebelum diminta mengirim data pribadi;
- membuat foto, lokasi, status, availability, dan contact mudah dipahami;
- terlihat established tanpa menjadi luxury-only, bank dashboard, atau template property
  generik.

### Tujuan visual

1. Menetapkan satu fondasi visual yang konsisten untuk Home, Directory, dan Project
   Detail.
2. Menerjemahkan Green identity tanpa membuat seluruh halaman menjadi dark green.
3. Memberi Project photography peran penting tanpa mengarang foto atau data.
4. Menjaga CTA hierarchy tetap calm dan satu primary action per konteks.
5. Menjelaskan perbedaan Project Status dan Unit Status secara visual serta tekstual.
6. Menentukan perilaku visual desktop dan mobile yang dapat diteruskan ke tahap
   architecture tanpa membuat keputusan besar baru.

### Review decisions yang disetujui

- Homepage memakai **split editorial Hero**: content dan housing discovery berada di
  samping authentic Project photography.
- Project Card tetap photography-first dan memakai anatomy yang sama pada Homepage dan
  Directory, dengan Directory hanya sedikit lebih dense.
- Project Detail Hero memakai Project photography beside Project identity/content.
- Availability harus prominent tetapi calm; Tersedia green, Terbooking amber, dan
  Terjual neutral gray dengan label yang terbaca.
- Open Visual Questions terkait asset dan sample content tetap non-blocking untuk Visual
  Direction; validasi lanjut dilakukan saat prototype/implementation.

### Non-goals

- tidak membuat visual mockup pixel-perfect;
- tidak membuat final marketing copy;
- tidak memilih logo variant atau photo asset yang belum disediakan;
- tidak menentukan database, field, plugin, theme API, atau template WordPress;
- tidak menambahkan price, sorting, filter, global Unit page, standalone House Type
  page, atau fitur Phase 2;
- tidak membuat autoplay hero carousel, giant animation, glassmorphism, glow, atau
  decorative pattern tanpa fungsi.

---

## 3. Core Visual Concept

### **Warm discovery, confident green**

Marison dipresentasikan sebagai pengembang yang sudah memiliki rekam jejak nyata,
tetapi tetap terasa dekat dengan orang yang sedang mencari rumah pertama. Visual utama
memadukan:

- Warm Cream sebagai ruang editorial yang tenang;
- White sebagai permukaan keputusan yang bersih;
- fotografi Project nyata sebagai bukti dan orientasi;
- Primary Green sebagai anchor action dan identitas;
- Soft Sage sebagai jeda yang optimistis;
- Deep Green hanya pada momen yang membutuhkan kontras dan kedalaman.

Konsep ini membuat pengguna merasa sedang menjelajahi pilihan rumah yang nyata,
bukan masuk ke campaign landing page atau aplikasi finansial.

### Prinsip visual inti

1. **Foto memberi konteks, bukan dekorasi kosong.** Foto harus membantu memahami
   Project, lingkungan, progres, atau rasa tempat.
2. **Green menandai keputusan.** Green dipakai untuk brand anchor, CTA utama, selected
   state, atau highlight kecil; bukan untuk semua teks dan semua surface.
3. **Ruang putih memberi kepercayaan.** Whitespace menjadi alat untuk membuat status,
   lokasi, dan CTA dapat dipindai.
4. **Konten memperoleh emphasis.** Data yang membantu keputusan lebih menonjol daripada
   slogan atau ornament.
5. **Satu produk, tiga density.** Home terasa editorial, Directory terasa fokus dan
   utilitarian, Project Detail terasa informatif dan conversion-ready; ketiganya tetap
   memakai fondasi yang sama.

---

## 4. Visual Mood

### Mood yang harus terasa

| Kesan | Cara visual mencapainya |
|---|---|
| Modern | Grid rapi, Plus Jakarta Sans, control sederhana, crop foto konsisten |
| Approachable | Warm Cream, radius moderat, copy placeholder yang jelas, kontras nyaman |
| Trustworthy | Status eksplisit, whitespace, foto nyata, no fake urgency, contact context |
| Optimistic | Fresh Green sebagai aksen kecil, langit/cahaya alami, Soft Sage |
| Slightly playful | Shape marker sederhana, ilustrasi kecil bila berguna, tidak childish |
| Established | Reuse komponen, ritme spacing, hierarchy tenang, Deep Green terukur |
| Accessible | Body type terbaca, focus jelas, status tidak bergantung pada warna |

### Yang harus terasa quiet

- supporting copy;
- Article card dibanding Project card;
- Careers entry;
- metadata sekunder;
- related content;
- filter reset dan navigasi tertiary;
- Deep Green surface yang bukan CTA utama.

### Yang boleh terasa prominent

- `Cari Rumah` pada Home dan Header;
- Project photography yang relevan;
- nama Project, City/Regency, dan Project Status;
- `Chat WhatsApp` pada Project Detail;
- availability summary setelah House Types;
- current filter context pada Directory.

### Yang harus dihindari

- luxury black/gold atau marble property language;
- giant display type yang menghabiskan mobile viewport;
- dark-green page penuh;
- neon green, glow, atau gradient raksasa;
- dashboard dengan banyak widget kecil;
- card di dalam card tanpa alasan hierarchy;
- animation yang membuat pengguna menunggu atau kehilangan konteks.

---

## 5. Color Application

### Palette V1

| Warna | Nilai | Peran visual utama |
|---|---|---|
| Primary Green | `#1F6B45` | Primary button, active state, link penting, brand anchor |
| Deep Green | `#123D2A` | Heading kuat, selected dark surface, footer, contrast moment |
| Fresh Green | `#64B94F` | Aksen kecil, positive highlight, detail playful; bukan body text kecil |
| Soft Sage | `#DDEBDD` | Supporting section, selected filter context, calm highlight |
| Warm Cream | `#F7F4EC` | Main editorial/page background |
| Charcoal | `#20251F` | Heading, body text, high-contrast content |
| Muted Gray | `#6E756D` | Metadata dan supporting text setelah contrast verification |
| White | `#FFFFFF` | Card, form, filter panel, focused decision surface |

### Aturan penerapan

- Primary Green adalah identitas utama, tetapi jangan dipakai untuk semua heading,
  badge, border, dan background sekaligus.
- Deep Green digunakan sebagai anchor yang jarang: footer, final brand moment, atau
  surface CTA tertentu; bukan default background semua halaman.
- Fresh Green dipakai sebagai highlight kecil atau aksen ilustratif. Jangan memakai
  Fresh Green sebagai body text di atas White.
- Soft Sage digunakan untuk grouping dan breathing room, bukan sebagai pengganti semua
  border.
- Warm Cream menjadi default editorial surface ketika halaman perlu terasa hangat.
- White menjadi surface untuk keputusan: cards, filter, form, availability, dan contact.
- Corporate blue, bila terdapat pada official logo, tetap terutama berada di asset logo.
  Blue tidak menjadi competing UI color.
- Semua pasangan warna teks/surface harus menjalani contrast verification pada tahap
  implementasi. Nilai palette bukan bukti otomatis WCAG AA.

### Semantic colors yang tidak menggantikan brand palette

| State | Foreground konseptual | Surface konseptual | Perlakuan |
|---|---|---|---|
| Tersedia | `#17643E` | `#E8F4EC` | Text + marker positif; hanya untuk Unit Status |
| Terbooking | `#8A4A00` | `#FFF4DD` | Text + marker pending; tidak terlihat seperti Tersedia |
| Terjual | `#59615B` | `#EEF0ED` | Text + marker netral; bukan merah/error |
| Error | `#A61B1B` | `#FDECEA` | Hanya error yang perlu diperbaiki |
| Informational | `#0B4F71` | `#E8F3FA` | Notice informasi; bukan brand primary |

Project Status tetap memakai soft/outline treatment yang berbeda dari Unit Status.
Status selalu ditulis sebagai teks dan didukung marker, bentuk, posisi, atau prefix
konteks.

---

## 6. Surface Rhythm

Surface tidak berganti warna secara mekanis di setiap section. Perubahan surface hanya
dilakukan ketika membantu pengguna memahami perubahan tujuan informasi.

### Surface roles

| Surface | Peran | Contoh lokasi |
|---|---|---|
| Warm Cream | Base editorial yang hangat dan lapang | Home hero, Home body, Directory background |
| White | Focused decision surface | Project Card, filter, form, availability, contact |
| Soft Sage | Supporting grouping atau pause | Location discovery, KPR entry, selected filter band |
| Deep Green | Contrast/brand moment terbatas | Footer, final Marison statement, optional contact anchor |
| Photography | Evidence dan emotional context | Home hero, Project hero, gallery, Project card |

### Rhythm per halaman

**Homepage**

- Warm Cream sebagai base;
- hero memakai Warm Cream + satu foto besar;
- Featured Projects memakai White card di atas Warm Cream;
- Location Discovery memakai Soft Sage secara compact;
- Credibility tetap ringan, dapat memakai White/photography tanpa full dark panel;
- KPR memakai Soft Sage atau White dengan aksen Primary Green;
- Articles dan Careers kembali tenang ke Warm Cream;
- footer boleh Deep Green.

**Housing Directory**

- Warm Cream sebagai background utama agar tidak terasa seperti dashboard;
- filter menggunakan White surface atau White bar dengan border ringan;
- active filter memakai Soft Sage/outline;
- hasil tetap memakai White Project Card;
- Empty State memakai White atau Soft Sage yang menenangkan, bukan Error Red;
- pagination tidak diberi surface besar sendiri.

**Project Detail**

- hero memakai Warm Cream + White content panel dan foto;
- overview/gallery memakai White atau Warm Cream tanpa border berlebihan;
- House Types dapat memakai White surface;
- Availability memakai Soft Sage sebagai emphasis yang tenang;
- Facilities dan Progress kembali ke White/Warm Cream;
- Contact dapat memakai Soft Sage atau Deep Green yang terukur, tetapi tidak menjadi
  aggressive sales banner;
- footer mengikuti shared Deep Green treatment bila asset/logo mendukung.

### Aturan transisi

- Jangan membuat setiap section memiliki background baru hanya agar halaman terlihat
  panjang.
- Beri minimal satu visual pause sebelum mengganti tujuan informasi besar.
- Surface yang berubah harus diikuti heading atau grouping yang jelas.
- Full-bleed color hanya dipakai jika meningkatkan orientation atau brand emphasis.

---

## 7. Typography Application

### Font direction

Default V1:

```text
Plus Jakarta Sans → Inter → system sans-serif
```

Satu keluarga sans-serif dipakai untuk display, body, metadata, dan angka agar produk
terasa koheren. Typeface official Marison dapat menggantikan default setelah disetujui,
tanpa mengubah hierarchy yang dijelaskan di sini.

### Hierarchy konseptual

| Role | Desktop range | Mobile range | Weight | Peran |
|---|---:|---:|---|---|
| Hero Display | 56–72px | 36–48px | Bold | Headline utama Home; maksimal beberapa baris |
| H1 | 40–56px | 32–40px | Bold | Page title atau Project title |
| H2 | 32–44px | 28–36px | Bold | Section title dan major decision group |
| H3 | 24–32px | 22–28px | Semibold | Subsection, House Type group, result group |
| H4 | 20–24px | 18–22px | Semibold | Card title atau detail group |
| Lead paragraph | 18–20px | 17–19px | Regular/Medium | Supporting intro dan hero explanation |
| Body | 16–18px | 16–18px | Regular | Default readable content |
| Small | 14–15px | 14–15px | Regular/Medium | Helper, secondary metadata |
| Label | 12–14px | 12–14px | Medium | Field, filter, status context |
| Caption | 12–13px | 12–13px | Regular/Medium | Photo caption dan provenance |
| Button | 14–16px | 14–16px | Medium/Semibold | Action text dengan ruang wrap yang aman |

### Prinsip penggunaan

- Hero Display tidak boleh mendorong housing discovery keluar dari viewport mobile.
- H1 hanya satu primary page heading dalam satu halaman.
- H2/H3 mengelompokkan tujuan; jangan menjadikan semua card title seberat H2.
- Body tidak diperkecil untuk memasukkan lebih banyak metadata.
- Nama Project dan label status boleh wrap; jangan memakai fixed-height text box.
- Angka availability, progress, dan dimensi harus memiliki digit yang jelas dan tidak
  terlalu condensed.
- Bahasa Indonesia dan English memiliki panjang berbeda; button dan badge harus dapat
  membesar secara natural.
- Letter spacing tetap tenang; hierarchy terutama berasal dari ukuran, weight, warna,
  dan whitespace, bukan all-caps berlebihan.

### Editorial feel

Rasa editorial muncul dari kombinasi headline yang tegas, paragraph reading width
terkendali, foto dengan crop tenang, dan whitespace. Jangan menggunakan font dekoratif
atau luxury serif sebagai solusi untuk membuat halaman terlihat premium.

---

## 8. Layout / Grid

### Dimensi konseptual

| Area | Rekomendasi konseptual |
|---|---:|
| Max content width | Sekitar 1120–1280px |
| Reading width | Sekitar 65–75 karakter per baris |
| Desktop gutter | 32–48px |
| Tablet gutter | 24–32px |
| Mobile gutter | 16–20px |
| Section spacing desktop | 64–96px, 128px hanya untuk editorial pause tertentu |
| Section spacing mobile | 40–64px sesuai density |
| Component spacing | 12–24px |
| Grid gap | 20–32px sesuai content |

### Grid concept

- Desktop: 12-column flexible grid; split hero dapat memakai 5/7 atau 6/6 columns.
- Tablet: 6-column flexible grid; major split dapat turun menjadi stacked layout.
- Mobile: satu column dengan media, copy, controls, dan CTA mengikuti urutan baca.
- Project Card dan Article Card boleh memiliki grid berbeda, tetapi alignment kiri,
  gutter, dan vertical rhythm harus sama.
- Gallery dapat memakai area lebih lebar dari reading column.
- Full-bleed hanya digunakan untuk media atau Deep Green moment yang memang perlu
  edge-to-edge treatment.

### Alignment rule

Header, hero content, page intro, filter bar, card grid, detail sections, dan footer
harus memiliki garis alignment container yang konsisten. Jangan membuat setiap section
memiliki max-width berbeda tanpa alasan content.

---

## 9. Shared Header & Navigation

### Desktop direction

Header bersifat clean dan stabil, bukan hero banner kedua.

- background White atau Warm Cream sesuai surface halaman;
- logo official berada di kiri dan kembali ke Home;
- navigasi: `Perumahan`, `KPR`, `Artikel`, `Tentang Kami`, `Karier`;
- language switcher berada sebagai control sekunder;
- `Cari Rumah` menjadi satu Primary Green CTA di sisi kanan;
- header memiliki bottom divider ringan atau whitespace, bukan shadow berat;
- `Lokasi` dan `Kontak` tidak menjadi main-navigation item baru;
- header tidak memakai Corporate blue sebagai UI accent selain logo asset.

### Mobile direction

- logo dan `Cari Rumah` tetap mudah ditemukan;
- menu trigger membuka Perumahan, KPR, Artikel, Tentang Kami, Karier, dan bahasa;
- menu surface White dengan overlay netral, bukan full-screen dark campaign panel;
- `Cari Rumah` dapat berupa compact button yang tetap memenuhi touch target;
- tidak ada bottom navigation baru;
- pada Project Detail, contact tidak bergantung pada menu karena tersedia melalui hero,
  normal flow, dan contextual sticky action.

### Shared navigation states

Hover hanya enhancement. Focus-visible harus memiliki outline/ring yang jelas. Active
navigation dapat memakai Primary Green text/underline atau soft surface, tetapi tidak
perlu membuat semua item menjadi filled button.

---

## 10. Homepage Visual Direction

Homepage adalah curated discovery page, bukan archive dan bukan company profile panjang.
Visual harus mengantar pengguna dari brand promise ke Project discovery dengan ritme
yang ringan.

### Visual sequence

1. Header yang stabil.
2. Hero editorial dengan discovery yang jelas.
3. Featured Projects sekitar 3–6 card.
4. Compact Location Discovery.
5. Credibility + Why Marison sebagai satu trust block.
6. Calm KPR entry.
7. Sekitar 3 Article dengan treatment editorial yang lebih ringan.
8. Careers entry ringkas.
9. Final CTA yang kembali mengarahkan ke housing discovery.
10. Footer.

### Density direction

- Hero adalah satu-satunya visual focal point besar pada awal halaman.
- Featured Projects mendapat emphasis terbesar setelah hero.
- Location, KPR, dan Articles memakai section yang lebih ringan, bukan tiga campaign
  banner berturut-turut.
- Credibility tidak menjadi dashboard angka.
- Careers tidak menjadi portal recruitment di Homepage.
- Section yang tidak memiliki data valid dapat dihilangkan tanpa meninggalkan ruang
  kosong palsu.

### Desktop vs mobile

**Desktop:** editorial whitespace, split media/copy, grid Project 3–4 columns sesuai
content, dan section grouping yang mudah dipindai.

**Mobile:** Hero content dan discovery muncul lebih awal daripada foto dekoratif besar;
Project card stack satu kolom; Location, KPR, Article, Careers dipadatkan; primary
discovery tetap mudah disentuh tanpa sticky promotion banner.

---

## 11. Homepage Hero

### Rekomendasi: A — split editorial layout

Gunakan split editorial layout:

- sisi kiri: eyebrow/short positioning, headline, supporting copy, dan housing
  discovery;
- sisi kanan: satu foto Project Marison besar dengan crop yang tenang;
- kedua sisi berada dalam container Warm Cream, bukan text overlay di atas foto;
- discovery control memakai White surface yang duduk dekat dengan copy, bukan giant
  lead form.

### Mengapa arah ini dipilih

- menjaga headline dan input tetap terbaca tanpa overlay kontras yang rumit;
- membuat foto terasa penting tanpa menutupi informasi;
- mendukung discovery before personal data;
- mudah turun menjadi stack mobile tanpa kehilangan urutan;
- lebih approachable daripada campaign hero full dark;
- lebih ringan dan mudah dipelihara daripada hero carousel atau masonry kompleks.

### Desktop composition

```text
+---------------------------------------------------------------+
| Header                                                        |
+---------------------------------------------------------------+
| [eyebrow]                 | [REAL MARISON PROJECT PHOTO]    |
| [PLACEHOLDER COPY]        |                               |
| Supporting copy           |                               |
|                           |                               |
| [Housing discovery]       |                               |
| [Cari Rumah]              |                               |
+---------------------------------------------------------------+
```

- split sekitar 5/7 atau 6/6 grid, tergantung panjang copy dan focal point foto;
- foto landscape 3:2 atau 16:9 dengan focal point aman untuk crop;
- headline cukup kuat tetapi tidak memenuhi seluruh vertical viewport;
- discovery panel White dengan radius Medium atau Large moderat dan shadow minimal;
- jangan memakai blur, glass overlay, giant gradient, atau autoplay carousel;
- gunakan `PLACEHOLDER COPY` untuk headline dan supporting copy sampai copy disetujui.

### Mobile composition

Urutan mobile:

1. Header.
2. Short headline.
3. Supporting copy.
4. City/Regency discovery.
5. Optional Province/Status.
6. `Cari Rumah`.
7. Project photography yang tidak mengambil seluruh layar.

Urutan identity/headline → housing discovery → Project photography menjaga keputusan
awal tetap terlihat tanpa membuat first screen terlalu tinggi. Foto tidak boleh
mendorong City/Regency dan CTA keluar dari jalur awal. Jangan memakai vertical hero
100vh.

---

## 12. Housing Discovery

Housing discovery adalah visual bridge antara Hero dan Directory. City/Regency harus
terasa sebagai starting point paling mudah.

### Desktop treatment

- White panel di dalam hero, bukan form full-page;
- label persisten `City / Regency` dengan field utama paling lebar;
- Province dan Project Status berada sebagai optional supporting controls;
- `Cari Rumah` memakai Primary Green dan menjadi satu primary button;
- helper text menjelaskan pilihan tanpa membuat paragraph panjang;
- control memiliki border ringan, radius Small/Medium, dan focus ring jelas;
- jangan menambahkan Price, Bedrooms, Luas, Salary, atau Financing filter.

Conceptual arrangement:

```text
City / Regency [field utama] | Province (optional) | Project Status (optional)
                                                              [Cari Rumah]
```

### Mobile treatment

- White surface dengan satu column;
- City/Regency field tampil pertama dan memiliki emphasis terbesar;
- Province dan Project Status berada di bawahnya sebagai optional controls yang tidak
  menghalangi jalur utama;
- CTA full-width atau near-full-width dengan touch target nyaman;
- jangan memaksa Province sebelum City/Regency;
- bila kontrol tambahan dipadatkan, label optional dan active state tetap terlihat;
- submit membawa pengguna ke Directory dengan konteks filter yang dapat dibaca.

Technical autocomplete behavior tidak ditentukan oleh visual spec ini.

---

## 13. Featured Projects

### Primary Project Card pattern

**Approved V1:** Project Card tetap photography-first dan anatomy intinya sama pada
Homepage serta Directory.

Gunakan satu pola Project Card utama pada Homepage dan Directory:

1. authentic Project photography atau neutral fallback;
2. Project Status sebagai soft/outline badge dengan konteks jelas;
3. nama Project;
4. City / Regency;
5. satu supporting context bila tersedia;
6. satu detail action.

Tidak ada public price requirement, full House Type list, internal contact, atau fake
availability pada card.

### Image direction

- rekomendasi rasio landscape sekitar 4:3 atau 3:2;
- radius Medium pada card utama, tidak terlalu rounded;
- crop memperlihatkan rumah/lingkungan, bukan hanya langit atau texture;
- focal point harus aman untuk desktop dan mobile;
- fallback memakai Warm Cream/Soft Sage dan label yang jujur bila diperlukan;
- jangan menampilkan stock image seolah-olah Project Marison.

### Card surface

- White card di atas Warm Cream;
- border halus atau perbedaan surface, bukan heavy shadow;
- content padding 20–24px desktop dan 16–20px mobile;
- status dan nama memiliki hierarchy lebih tinggi daripada supporting context;
- action dapat berupa text link atau secondary button sesuai density, bukan button besar
  pada setiap metadata.

### Content limit

Homepage menampilkan sekitar 3–6 curated Project sesuai content valid dan responsive
layout. `Lihat Semua Perumahan` berada dekat blok tetapi tidak mengambil hierarchy
lebih besar daripada Project Card.

### Mobile

Card menjadi satu column dan tetap memiliki satu destination. Image tetap cukup besar
untuk orientasi, tetapi tidak menghabiskan seluruh screen. Status → nama → lokasi →
supporting context → detail dibaca dalam satu scan.

---

## 14. Location Discovery

### Rekomendasi: curated location cards

Gunakan compact curated Location Card/list, bukan giant map, tag cloud, atau daftar
semua province/city.

### Desktop direction

- section Soft Sage yang lebih pendek dari hero;
- 3–4 City/Regency atau grouping lokasi yang benar-benar memiliki Project/context;
- card memakai nama area, short contextual phrase atau jumlah Project hanya bila valid,
  dan text link `Jelajahi lokasi`;
- foto lokasi boleh digunakan bila real dan relevan, tetapi tidak wajib pada setiap
  card;
- gunakan 3-column grid atau horizontal editorial row sesuai jumlah data;
- `Lihat semua perumahan` tetap menjadi fallback, bukan card tambahan.

### Mobile direction

- tampilkan 2–3 pilihan curated dalam stack/compact row;
- jangan membuat horizontal carousel sebagai satu-satunya akses;
- setiap pilihan memiliki touch target jelas dan label yang wrap aman;
- area kosong atau lokasi tanpa Project tidak dipromosikan sebagai card publik;
- pilihan lokasi tetap mengantar ke discovery context, bukan memaksa halaman tipis.

### Mengapa bukan map

Map provider belum disetujui dan map besar tidak selalu membantu first-home buyer
memulai discovery. Map tetap dapat muncul di Project Detail sebagai konteks alamat,
tetapi Home memakai pilihan area yang lebih ringan dan dapat dipahami.

---

## 15. Credibility

### Trust block direction

Gabungkan Credibility dan Why Marison dalam satu editorial trust block:

- satu angka yang sudah dikonfirmasi: **30+ Projects**;
- short statement menggunakan `PLACEHOLDER COPY` bila copy belum disetujui;
- satu foto real Project selesai/berjalan bila tersedia;
- link `Tentang Kami` sebagai jalur yang lebih lengkap;
- optional completed Project proof melalui Project Card kecil atau text link, tanpa
  membuat Portfolio standalone.

### Desktop

Gunakan komposisi dua area:

- area trust: `30+ Projects` dengan angka besar tetapi tidak dashboard-like;
- area proof: foto/caption atau short factual statement;
- background White atau Warm Cream, dengan satu Fresh Green accent kecil;
- jangan memakai deretan 4–6 metric cards.

### Mobile

- angka dan statement berada dalam satu compact block;
- foto dapat turun di bawah copy dengan crop pendek;
- `Tentang Kami` tetap tertiary/secondary, bukan mengalahkan `Cari Rumah`;
- jika metric lain belum dikonfirmasi, jangan tampilkan placeholder angka di produk.
  `TO BE DEFINED` hanya untuk dokumentasi, bukan public metric.

Tidak boleh mengarang customer totals, years of experience, houses delivered, awards,
success rate, luas lahan, atau testimonial.

---

## 16. KPR Entry

### Visual direction

KPR entry adalah calm educational bridge, bukan calculator dashboard dan bukan banking
hero.

- gunakan Soft Sage atau White surface;
- satu short explanation dengan `PLACEHOLDER COPY` bila diperlukan;
- gunakan diagram/illustration sederhana hanya jika tersedia dan membantu memahami
  langkah, bukan decorative finance graphic;
- CTA utama konteks: `Pelajari KPR` atau `Coba Simulasi` menuju `/kpr/`;
- disclaimer bahwa hasil simulator adalah estimasi dapat terlihat sebagai supporting
  note, bukan footnote tersembunyi;
- jangan menampilkan fake installment numbers, interest rate, price, atau scheme yang
  belum disetujui;
- jangan menanamkan full calculator pada Home.

### Desktop dan mobile

Desktop dapat memakai split copy + calm illustration/photography. Mobile menjadi satu
column dengan copy pendek, CTA, dan disclaimer tepat di dekat action. KPR section tidak
boleh memiliki lebih banyak visual weight daripada Featured Projects.

---

## 17. Articles & Careers

### Article Cards

Article memiliki bahasa visual lebih editorial dan lebih ringan daripada Project Card:

- image 16:9 atau 3:2;
- optional topic/category label dengan accent yang tenang;
- judul yang jelas;
- tanggal/excerpt hanya bila membantu scanning;
- text link `Baca artikel` atau `Lihat Semua Artikel`;
- tidak memakai green success badge atau urgency treatment;
- related Project bersifat optional dan tidak membuat setiap article menjadi sales card.

Homepage menampilkan sekitar 3 Article terbaru/relevan. Article section tidak boleh
mengalahkan Project discovery dalam ukuran heading, image, atau CTA color.

### Careers

Careers menjadi compact inline entry:

- satu short statement menggunakan `PLACEHOLDER COPY`;
- optional small supporting image atau plain text treatment;
- satu link `Lihat Karier`;
- tidak menampilkan job listing grid, vacancy filters, atau applicant form di Home;
- jika tidak ada vacancy aktif, tetap dapat menjelaskan konteks Careers dengan jujur.

### Mobile

Article cards stack atau menjadi compact two-up hanya bila text tetap terbaca; default
yang aman adalah stack satu column. Careers cukup satu row/compact block setelah Article
atau sebelum final CTA.

---

## 18. Housing Directory

Directory harus terasa utilitarian, fokus, dan tetap membawa warmth Marison tanpa
meniru Home hero.

### Page composition

1. Shared Header.
2. Breadcrumb/back context.
3. H1 `Perumahan` dan supporting intro singkat.
4. Discovery/filter bar.
5. Active filter context dan result header.
6. Project Card grid.
7. Pagination.
8. Shared Footer.

### Surface and hierarchy

- Warm Cream base;
- H1 Charcoal, cukup kuat tetapi tidak Display-size;
- filter White surface dengan border ringan;
- Project Card White;
- result count/context memakai Small/Body, bukan giant metric;
- no decorative hero photography yang menunda hasil;
- Primary Green hanya untuk action/filter selected yang perlu perhatian.

### Desktop

Desktop memakai container lebar dengan intro yang singkat dan filter bar yang mudah
dipindai sebelum grid. Filter dapat horizontal bila ruang cukup, tetapi tidak memaksa
semua field menjadi compact sampai label sulit dibaca.

### Mobile

Mobile memperlihatkan H1, result context, active filters, dan satu `Filter` trigger.
Filter panel menjadi focused surface sementara; hasil kembali terlihat setelah apply.
Project Card tidak berubah menjadi carousel.

---

## 19. Directory Filters

### Input hierarchy

1. **City / Regency:** field atau control utama dan first-class discovery path.
2. **Province:** optional, untuk browsing area lebih luas atau grouping.
3. **Project Status:** optional, menggunakan tiga status yang disetujui.

Tidak ada Price, Bedrooms, Luas, Gaji, Financing, atau filter lain yang belum disetujui.

### Desktop filter bar

- White bar/panel dengan padding 20–24px;
- City/Regency mendapat width dan visual emphasis terbesar;
- Province dan Status menjadi secondary controls;
- `Terapkan`/result action dapat Primary Green jika submit diperlukan;
- `Clear filter` menjadi text/tertiary action;
- labels persistent dan visible;
- selected state memakai Soft Sage atau outline yang jelas;
- jangan memakai dark-green filled field untuk semua control.

### Active filters

- tampil dekat result header;
- chip/token memiliki label lengkap, misalnya `City/Regency: [PLACEHOLDER]`;
- setiap chip memiliki remove action yang jelas dan touch target nyaman;
- `Hapus semua` menjadi tertiary action yang tidak bersaing dengan result;
- chip tidak mengandalkan warna saja untuk selected state.

### Mobile trigger dan panel

- `Filter` adalah compact secondary button atau outlined control dekat H1/result;
- active filter count/context tetap terlihat sebelum panel dibuka;
- panel/focused view memakai White surface dengan heading `Filter Perumahan`;
- City/Regency muncul pertama;
- Province dan Status berada setelahnya;
- `Terapkan` berada jelas di akhir panel, `Reset` menjadi secondary/tertiary;
- panel tidak perlu selalu menutup seluruh layar bila tidak diperlukan;
- setelah apply, result list dan active summary kembali menjadi focal point.

Visual spec ini tidak menetapkan autocomplete, URL query, atau implementasi panel.

---

## 20. Directory Project Cards

### Reuse decision

Directory memakai **anatomy Project Card yang sama** dengan Homepage: foto, Project
Status, nama, City/Regency, satu supporting context, dan satu detail action.

Directory dapat memakai variasi density ringan:

- padding content sedikit lebih rapat;
- supporting context dapat dihilangkan bila grid menjadi padat;
- gap antar-card lebih utilitarian;
- image ratio dan status treatment tetap sama.

Jangan membuat dua card language yang terasa berasal dari produk berbeda.

### Desktop grid

- default: 3 columns pada desktop ketika content dan width mendukung;
- 4 columns hanya bila image, title, status, dan action tetap nyaman dibaca;
- card height tidak boleh dipaksa sama jika copy berbeda panjang;
- satu primary destination per card.

### Tablet

- default: 2 columns;
- image tetap landscape dengan crop aman;
- filter dan result header dapat turun menjadi dua baris tanpa mengecilkan label.

### Mobile

- 1 column;
- image cukup untuk identifikasi, bukan hero;
- urutan scan: image → Project Status → nama → lokasi → supporting context → detail;
- tidak ada nested House Type, Unit list, internal Branch, atau price requirement;
- text wrap aman dan action mudah disentuh.

---

## 21. Directory States & Pagination

### Result header

Result header memuat:

- active location/status context;
- result count hanya bila berasal dari actual result;
- filter trigger/clear action sesuai viewport;
- tidak ada sort control pada V1 karena tidak ada kebutuhan sorting yang disetujui.

Jika jumlah tidak tersedia, gunakan neutral context seperti `Project yang sesuai
pilihan Anda`, bukan angka perkiraan.

### Loading

- pertahankan posisi intro, filter summary, dan result area;
- gunakan reserved space atau quiet loading indicator;
- jangan membuat skeleton yang terlihat seperti data faktual bila bentuk content belum
  diketahui;
- jangan menghapus seluruh filter context saat loading.

### No results

No Results harus memakai White/Soft Sage surface netral, bukan Error Red. Tampilkan:

- penjelasan bahwa kombinasi pilihan belum memiliki Project;
- pilihan `Hapus semua filter`;
- `Pilih City/Regency lain`;
- `Perluas ke Province`;
- `Lihat semua Project`.

Jangan mengisi area dengan Project yang “mirip” secara otomatis dan jangan membuat
empty state terasa sebagai kesalahan pengguna.

### Pagination

V1 memakai pagination, bukan infinite scrolling atau Load More sebagai default.

```text
[Sebelumnya] [1] [2] [3] ... [Berikutnya]
```

- current page memiliki selected state yang jelas secara visual dan accessible name;
- Previous/Next memiliki disabled state ketika tidak relevan;
- angka page tidak terlalu kecil dan tidak menjadi giant button row;
- pagination memakai border/outline atau text control dengan focus state jelas;
- active filter context harus tetap dapat dipahami setelah berpindah page;
- label `Sebelumnya` dan `Berikutnya` lebih jelas daripada icon saja;
- mobile dapat menampilkan subset page numbers dengan ellipsis, tetapi current page,
  Previous, dan Next tetap mudah dijangkau;
- tidak memakai color-only current state.

### Other states

Missing image memakai neutral fallback; missing optional metadata dihilangkan; data
invalid tidak diisi dengan placeholder yang tampak faktual.

---

## 22. Project Detail

Project Detail adalah primary conversion experience, tetapi conversion tetap calm.
Halaman harus terasa seperti editorial product information, bukan dashboard inventory.

### Visual sequence

1. Breadcrumb/context.
2. Project Hero.
3. Quick decision summary.
4. Overview + Gallery.
5. House Types.
6. Unit Availability.
7. Facilities.
8. Project Progress.
9. Location / Map placeholder.
10. Related Articles/Project Updates.
11. KPR entry.
12. Primary Branch Contact.
13. Footer.

Availability tetap terlihat cukup awal setelah House Types. Gallery dan supporting
content tidak boleh mengubur availability atau contact.

### Surface direction

- Hero: Warm Cream + White information surface + photography;
- Overview/Gallery: White/Warm Cream editorial grouping;
- House Types: White cards/rows dengan border ringan bila diperlukan;
- Availability: Soft Sage emphasis dengan White internal surface;
- Facilities/Progress: calm White/Warm Cream, no dashboard tiles;
- Contact: Soft Sage atau Deep Green accent yang tenang;
- Footer: shared footer, bukan third conversion banner.

### CTA hierarchy

- Primary: `Chat WhatsApp` melalui Primary Branch Office;
- Secondary: `Lihat Ketersediaan`;
- supporting: `Pelajari KPR`, telephone, form, related article;
- tidak ada individual Marketing contact;
- sticky action adalah contextual access, bukan CTA layer baru yang dominan.

---

## 23. Project Hero

### Rekomendasi: B — photography beside content

**Approved V1:** arah desktop utama adalah Project photography beside Project identity
dan content.

Gunakan layout dua kolom dengan foto kuat di satu sisi dan content panel di sisi lain.
Jangan menaruh seluruh copy di atas foto.

```text
+---------------------------------------------------------------+
| [PROJECT PHOTO 3:2 / 16:9] | [Status Project]                |
|                             | [Nama Project]                  |
|                             | [City / Regency]                |
|                             | [Short positioning]             |
|                             | [Chat WhatsApp] [Availability]  |
+---------------------------------------------------------------+
```

### Desktop

- foto memakai landscape sekitar 3:2 atau 16:9 dengan focal point aman;
- content side memakai White atau Warm Cream, bukan opaque overlay di photo;
- Project Status berada dekat nama tetapi memakai soft/outline treatment;
- City/Regency terbaca sebelum short positioning;
- `Chat WhatsApp` Primary Green;
- `Lihat Ketersediaan` secondary outline/soft surface;
- breadcrumb berada di atas dalam ukuran Small;
- jangan menambahkan 12 metadata atau price panel di hero.

### Mobile

Urutan mobile:

1. Breadcrumb/back context.
2. Foto dengan crop aman dan tinggi terkontrol.
3. Project Status.
4. Nama Project.
5. City/Regency.
6. Short positioning.
7. `Chat WhatsApp` dan `Lihat Ketersediaan`.

Foto tidak menjadi full-screen background. Informasi identity dan CTA tidak ditempatkan
di area crop yang sulit dibaca.

### Fallback

Jika foto tidak tersedia, gunakan Warm Cream/Soft Sage neutral fallback, pertahankan
nama/status/lokasi, dan jangan mengganti dengan stock image yang tampak seperti foto
Project.

---

## 24. Overview & Gallery

### Overview direction

Overview harus terasa editorial:

- satu short description dengan reading width sekitar 65–75 karakter per baris;
- optional key location/context line;
- selected highlights hanya bila datanya valid;
- jangan membuat grid 12 statistic cards;
- tidak mengulang full description pada setiap section.

### Gallery pattern

Rekomendasi praktis: **satu featured image + dua supporting thumbnails**.

- featured image lebih besar dan memiliki caption bila berguna;
- dua thumbnail menunjukkan variasi ruang/lingkungan/progres bila tersedia;
- seluruh gallery dapat turun menjadi vertical stack pada mobile;
- campuran landscape/portrait boleh, tetapi crop dan metadata harus konsisten;
- jika hanya ada satu image, tampilkan satu image dengan caption, bukan placeholder
  berulang;
- jika tidak ada image, hilangkan gallery dan biarkan overview tetap kuat;
- lightbox/carousel detail tidak ditentukan; tidak boleh menjadi satu-satunya cara
  memahami Project.

### Mobile

Featured image tetap cukup terlihat untuk identity tetapi tidak mendorong House Types
dan Availability terlalu jauh. Supporting thumbnails dapat menjadi compact stack atau
horizontal row dengan akses yang tidak bergantung pada swipe saja.

---

## 25. House Types

House Type tetap contained di Project Detail. Tidak ada standalone House Type page atau
global catalog.

### Desktop direction

- section heading dan short intro;
- dua atau tiga summary dalam grid/row sesuai jumlah dan content;
- setiap summary memakai White surface atau open row dengan border ringan;
- image/floor plan berada di sisi atas atau kiri;
- type name paling menonjol;
- LB, LT, bedrooms, bathrooms, dan floors menjadi metadata yang mudah dipindai;
- short description secukupnya;
- `Lihat detail` dapat menjadi text link pada desktop bila detail sudah terlihat;
- jangan membuat card di dalam card atau comparison table horizontal yang rapuh.

### Mobile direction

House Type menjadi compact summary:

```text
[Type name]
[Image / floor plan bila ada]
LB | LT
Bedrooms | Bathrooms | Floors
[Lihat Detail]
```

- optional description/specification muncul setelah `Lihat Detail` bila berguna;
- image/floor plan tidak wajib bila source tidak ada;
- summary memakai satu surface ringan dan tidak memuat semua optional field di awal;
- semua label persistent dan boleh wrap;
- availability tetap berada setelah House Types, bukan tersembunyi di dalam expansion.

### Visual metadata

Gunakan label yang jelas seperti `Luas Bangunan`, `Luas Tanah`, `Kamar Tidur`, `Kamar
Mandi`, dan `Lantai` bila ruang memungkinkan. Singkatan LB/LT dapat dipakai hanya bila
label/konteks cukup jelas bagi audiens umum.

---

## 26. Unit Availability

Availability adalah decision surface yang harus mudah ditemukan tanpa terlihat seperti
analytics dashboard.

### Summary direction

**Approved V1:** Availability harus **prominent tetapi calm**. Treatment-nya bukan
analytics dashboard, stock-trading interface, atau admin table.

- Soft Sage section atau White panel dengan heading `Ketersediaan Unit`;
- source note terlihat dekat summary: derived dari Unit individual atau manual fallback;
- tiga status memakai text, marker, dan semantic treatment:
  - `Tersedia` — green;
  - `Terbooking` — amber;
  - `Terjual` — neutral gray;
- angka hanya ditampilkan bila source valid;
- `Konfirmasi melalui Branch` menjadi supporting note/action;
- jangan memakai chart, KPI tile wall, progress ring, atau urgency counter.

### Desktop

Tiga status dapat ditampilkan sebagai satu horizontal summary row dalam panel yang sama,
dengan angka yang readable dan label lengkap. Unit list berada di bawahnya sebagai
compact rows bila layak ditampilkan.

### Mobile

- status summary menjadi vertical stack atau 3-column compact row hanya jika label tetap
  terbaca;
- source/fallback label berada dekat angka;
- Unit list tidak menjadi spreadsheet horizontal;
- setiap row hanya memuat Unit/block identifier, Type bila berguna, dan Unit Status;
- list dapat diringkas atau dihilangkan bila terlalu panjang, tanpa menghilangkan
  summary dan Branch confirmation path.

### Source integrity

- derived totals dan manual totals tidak tampil bersamaan;
- no data memakai honest notice, bukan angka `0` implisit;
- Project Status tidak pernah mengisi Unit Status;
- data owner/buyer, internal note, atau marketing assignment tidak ditampilkan.

---

## 27. Facilities & Progress

### Facilities

Fasilitas dipresentasikan sebagai lightweight supporting content:

- list atau small icon/text row;
- maksimal density yang masih mudah dipindai;
- icon outlined/single-style hanya bila genuinely membantu recognition;
- label dan short context lebih penting daripada decorative illustration;
- fasilitas yang tidak tersedia tidak memiliki placeholder card;
- jangan membuat puluhan individual cards dengan shadow.

Desktop dapat memakai 3-column list atau horizontal grouping. Mobile memakai one-column
list/compact rows dengan icon kecil dan label yang wrap aman.

### Progress

V1 hanya menampilkan current percentage dan optional short description:

- gunakan simple horizontal progress track atau percentage label;
- track dapat memakai Deep/Muted neutral dengan filled Primary/Fresh Green setelah
  contrast verification;
- tampilkan label `Progress Project` agar tidak disalahpahami sebagai Unit Status;
- description berada dekat percentage;
- jangan membuat milestone timeline, construction certification, atau detail history;
- progress tidak boleh mengalahkan availability.

Mobile memakai progress row yang singkat dan tidak menambah dashboard tile. Jika
percentage tidak tersedia, section dihilangkan atau menampilkan notice yang jujur bila
block tersebut penting untuk context.

---

## 28. Location & Related Content

### Location

Map provider belum disetujui. Gunakan visual placeholder yang tetap berguna:

- readable address atau City/Regency context;
- optional area description;
- rectangular `Map / Location` placeholder yang tidak mengklaim provider;
- optional `Buka arah`/external action hanya bila detail dan implementasinya disetujui;
- map tidak menjadi satu-satunya sumber lokasi.

Desktop dapat memakai split address + map placeholder. Mobile menempatkan address
sebelum map dan menjaga map height tetap proporsional.

### Related Articles

- gunakan Article Card yang lebih kecil/ringan daripada Project Card;
- tampilkan hanya Article canonical yang benar-benar terkait;
- section berada setelah Location dan supporting context;
- tidak memakai CTA warna yang lebih kuat daripada Project contact;
- maksimal beberapa Article relevan, bukan archive kedua;
- Article tanpa relasi Project tidak dipaksakan masuk ke halaman.

---

## 29. Project Contact

### Contact direction

Contact harus terasa trustworthy dan contextual, bukan aggressive sales banner.

```text
Project
  → Primary Branch Office
    → Primary Public WhatsApp
```

### Visual treatment

- dedicated section dengan Soft Sage atau Deep Green yang terukur;
- Project context ditulis jelas sebelum CTA;
- Primary: `Chat WhatsApp`;
- Secondary: telephone Branch bila tersedia;
- form singkat hanya bila contact intent sudah jelas;
- field form: Name, WhatsApp/telephone, Interested Project, consent, optional message;
- persistent labels, no qualification fields;
- tidak menampilkan individual Marketing name/number/assignment;
- contact unavailable memakai neutral notice dan approved fallback, bukan green success.

### Desktop dan mobile

Desktop dapat memakai two-column contact summary + action/form. Mobile menjadi one
column dengan Project context, primary button, telephone, lalu form bila memang
diperlukan. CTA hierarchy tidak berubah menjadi beberapa Primary buttons.

---

## 30. Mobile Sticky Actions

### Approved visual pattern

Sticky action muncul **setelah pengguna melewati Hero**, bukan pada initial page load.
Pattern ini adalah compact contextual bar:

- surface White;
- top border halus dan subtle shadow/elevation yang cukup memisahkan dari content;
- `Chat WhatsApp` sebagai Primary Green button;
- `Lihat Ketersediaan` sebagai secondary outline/soft control;
- safe-area padding di bawah;
- tinggi visual rendah dan tidak menjadi hero kedua;
- tidak menutup status, House Type, availability, location, atau form.

### Proportion

Secara konseptual, Primary mendapat area lebih besar daripada Secondary, tetapi kedua
label harus terbaca. Jangan memakai dua button dengan treatment Primary yang sama.

### Appearance/disappearance

- tidak tampil pada initial load ketika Hero masih menjadi identity area;
- dapat muncul dengan short fade/slide setelah Hero keluar dari viewport;
- tidak menggunakan bounce, pulse, glow, atau persistent animation;
- menghilang atau beradaptasi ketika dedicated Project Contact section tercapai;
- tidak membuat third visually dominant contact layer bersama Hero dan Contact.

### Mobile safety

- menghormati safe area dan keyboard/form state;
- tidak menutupi content atau fixed footer;
- touch target nyaman dan focus order logis;
- bila sticky tidak dapat ditempatkan aman, normal-flow CTA tetap menjadi fallback.

Behavior ini adalah visual/interaction direction, bukan implementasi observer, scroll
logic, atau CSS.

---

## 31. Project Status Variants

Project Status memakai soft/outline informational family dan selalu berbeda dari Unit
availability. Status text, prefix `Status Project`, dan placement tetap konsisten.

### Akan Datang

- treatment informational/quiet, misalnya muted purple/neutral soft outline sesuai
  Design System semantic direction;
- identity, lokasi, dan overview lebih prominent daripada availability;
- CTA utama dapat berupa `Pelajari Project` atau contact bila jalur valid;
- availability diberi notice `belum tersedia`/`belum dapat dikonfirmasi` bila benar;
- jangan tampilkan green Unit Status tanpa source.

### Sedang Berjalan

- treatment teal/greenish informational soft outline, bukan badge `Tersedia`;
- progress dan availability bila source tersedia lebih mudah ditemukan;
- `Chat WhatsApp` dan `Lihat Ketersediaan` dapat lebih prominent;
- tetap tidak menyiratkan semua Unit tersedia.

### Selesai

- treatment neutral historical soft outline;
- track-record/overview menjadi emphasis;
- availability hanya ditampilkan bila data valid;
- contact tetap boleh ada bila relevan, tetapi tidak memakai urgency;
- jangan mengasumsikan semua Unit Terjual atau semua Unit tersedia.

### Cross-state rule

Perubahan Project Status tidak otomatis mengubah Unit Status visual, angka, CTA, atau
source. Unit Status selalu berasal dari source availability yang terpisah.

---

## 32. Responsive Behavior

### Shared behavior table

| Area | Desktop | Mobile |
|---|---|---|
| Header | Full nav + Cari Rumah CTA | Logo, menu, language, Cari Rumah compact |
| Typography | Display/H1 lebih lapang | Scale turun, wrap aman, tidak memenuhi viewport |
| Images | Landscape dengan focal point aman | Crop terkontrol, tidak full-screen tanpa alasan |
| Project Cards | 3-column default, 2 bila width/content meminta | 1-column, satu scan dan satu destination |
| Filters | Horizontal/contained bar | Trigger → focused panel → apply → result |
| Pagination | Full Previous/numbers/Next | Compact numbers, current/Previous/Next tetap jelas |
| Gallery | Featured + supporting images | Stack/compact row, no swipe-only dependency |
| House Types | Summary grid/row | Compact summary + `Lihat Detail` |
| Availability | Horizontal status summary + rows | Vertical/compact summary + rows, no spreadsheet |
| Facilities | Lightweight multi-column/list | One-column compact list |
| Contact | Split summary/action/form | One column, primary action first |
| Sticky action | Tidak berlaku sebagai default | Contextual setelah Hero pada Project Detail |

### Homepage

Desktop split hero dan card grid turun menjadi one-column mobile. Optional Location,
Credibility detail, Articles, dan Careers dapat dipendekkan; discovery dan Project
identity tidak boleh dikorbankan.

### Directory

Desktop filter bar dan grid 3 columns turun menjadi focused filter + result stack. Filter
state tetap terlihat setelah apply. Tidak ada horizontal scrolling.

### Project Detail

Desktop hero split dan content grouping turun menjadi media → identity → CTA → sections.
Availability tetap setelah House Types dan tidak ditunda oleh gallery besar. Sticky
action hanya pada mobile sesuai pola approved.

### Breakpoint philosophy

Gunakan sedikit behavioral ranges: small smartphone, large smartphone, tablet,
laptop/desktop, wide desktop. Breakpoint akhir ditentukan dari perubahan layout nyata,
bukan daftar device. Tidak ada kebutuhan untuk menulis setiap breakpoint di visual spec.

---

## 33. Micro-interactions

Semua motion harus subtle, membantu orientation/feedback, dan tidak menjadi attraction.

### Button

- hover pointer: perubahan tonal kecil atau elevation minimal;
- focus-visible: ring/outline jelas dengan offset yang kontras;
- pressed: sedikit perubahan surface/position tanpa bounce;
- disabled: muted treatment dengan label tetap terbaca;
- loading: pertahankan label/context dan cegah double-submit secara informatif.

### Project Card

- hover: image scale sangat kecil atau border/elevation berubah halus;
- jangan membuat card melompat atau seluruh surface menjadi green;
- focus pada link/card action tetap terlihat;
- motion bukan satu-satunya cara menunjukkan clickable state.

### Filter

- selected state muncul melalui surface/outline + text/marker;
- remove chip memiliki feedback singkat tanpa menggeser seluruh layout secara mengejutkan;
- loading mempertahankan result context;
- reset tidak menghilangkan konteks tanpa feedback.

### Gallery

- image transition sederhana bila ada carousel/lightbox di tahap implementasi;
- caption/focus tidak hilang secara tiba-tiba;
- tidak autoplay dan tidak memaksa scroll hijack.

### Status changes

- state change dapat memakai short fade atau highlight sekali;
- status text tetap tersedia tanpa motion;
- jangan memakai pulse/countdown untuk availability.

### Sticky CTA

- muncul sekali dengan short fade/slide setelah Hero dilewati;
- hilang/beradaptasi di Contact dengan perubahan yang tidak mengejutkan;
- tidak bounce, pulse, glow, atau repeatedly re-enter saat scroll kecil.

### Detail expansion

- `Lihat Detail` House Type dapat memakai expand/collapse singkat;
- focus dan reading order tetap logis;
- reduced motion menghapus atau memendekkan transition;
- expansion tidak mendorong availability ke kondisi sulit ditemukan tanpa context.

### Reduced motion

Semua state dan hierarchy harus tetap dapat dipahami tanpa animation. Tidak ada scroll
hijacking, parallax overload, autoplay video, cinematic intro, atau infinite animation.

---

## 34. Visual Accessibility

Target minimum konseptual: **WCAG AA**.

### Contrast

- Charcoal pada Warm Cream/White menjadi default body/heading pairing;
- Muted Gray hanya untuk supporting text setelah contrast test pada ukuran aktual;
- Fresh Green tidak dipakai sebagai text kecil di atas White;
- Primary Green + White button text harus diverifikasi pada implementasi;
- text di atas photography memerlukan surface separation atau overlay yang diuji;
- status surfaces menggunakan text dan marker, bukan hue saja;
- contrast final dengan official logo, actual photo, dan translated copy masih perlu
  diuji.

### Focus dan keyboard

- semua button, link, filter, pagination, accordion, gallery control, dan sticky action
  memiliki visible focus-visible state;
- focus ring tidak boleh hilang di atas Deep Green, foto, atau Soft Sage;
- focus order mengikuti visual/reading order;
- current page pagination dan selected filter memiliki accessible state selain warna.

### Type dan layout

- body minimum praktis sekitar 16px pada mobile;
- text boleh wrap dan tidak terpotong fixed-height;
- reading width dibatasi;
- heading hierarchy mencerminkan struktur, bukan hanya display size;
- no horizontal scroll untuk membaca status, form, filter, atau contact;
- long Indonesian/English labels diuji dalam component states.

### Touch

- target praktis sekitar 44px atau lebih untuk button, filter remove, pagination,
  accordion, dan sticky controls;
- spacing antar-target mencegah accidental activation;
- mobile filter dan sticky bar tidak menutup content atau keyboard.

### Status dan feedback

- `Akan Datang`, `Sedang Berjalan`, `Selesai` selalu text + context;
- `Tersedia`, `Terbooking`, `Terjual` selalu text + marker/shape/surface;
- empty, error, unavailable, closed, success, dan loading states memiliki next action;
- form errors berada dekat field dan tidak hanya memakai border merah;
- consent tidak pre-checked dan label/tujuannya jelas.

### Implementation-time verification flags

1. Contrast Primary Green/White pada semua button size.
2. Contrast Muted Gray pada caption/label kecil.
3. Text overlay jika photo digunakan pada variasi crop aktual.
4. Logo clear-space dan contrast pada light/dark surface.
5. Focus ring pada Sticky CTA dan mobile filter panel.
6. Reduced-motion behavior pada gallery, card, dan sticky appearance.

Seluruh item di atas adalah implementation validation items, bukan Visual Direction
blocker. Visual foundation tetap menggunakan target WCAG AA dan harus diverifikasi
dengan asset, content, dan viewport nyata saat prototype/implementation.

---

## 35. Visual Consistency Matrix

| Elemen | Homepage | Housing Directory | Project Detail | Shared rule |
|---|---|---|---|---|
| Header | Brand/discovery entry | Compact utility | Context-preserving utility | Satu Header, satu `Cari Rumah` primary |
| Typography | Editorial display + lead | H1/focused result hierarchy | Project identity + detail hierarchy | Plus Jakarta Sans → Inter/system |
| Project Card | Curated 3–6, richer breathing room | Same anatomy, slightly denser | Tidak menjadi default detail container | Foto, status, nama, lokasi, satu action |
| Buttons | `Cari Rumah` primary | Filter/apply and card detail | `Chat WhatsApp` primary | One primary per context |
| Project Status | Card soft/outline | Card soft/outline | Hero identity soft/outline | Tidak memakai Unit colors |
| Unit Status | Tidak default | Tidak default | Availability only | Green/amber/neutral + text/marker |
| Spacing | Editorial 64–96px | Tighter 48–72px | Grouped 48–96px | Rhythm 4-based, no arbitrary values |
| Background | Cream base, Sage pauses | Cream base, White controls | Cream/White, Sage availability | No mechanical section alternation |
| Image treatment | Hero + Project cards | Card images | Hero + editorial gallery | Real photography first, honest fallback |
| Forms/filters | Housing discovery | Main filter system | Optional contact form | Persistent labels, no unapproved fields |
| CTA treatment | Calm discovery | Selection/navigation | Calm conversion + Branch context | No fake urgency or competing primaries |
| Mobile | Stack, discovery first | Trigger → panel → result | Hero → detail + contextual sticky | No horizontal scroll, safe touch targets |
| Empty state | Omit weak sections | Helpful recovery | Honest data/contact fallback | Explain condition + next action |
| Footer | Shared corporate context | Shared footer | Shared footer | No Marketing/internal data |

### Coherence test

Jika sebuah screenshot dilepas dari URL-nya, pengguna tetap harus dapat mengenali
Marison melalui kombinasi Warm Cream, green anchor, typography, radius moderat, foto
nyata, dan status treatment—bukan melalui layout yang identik secara mekanis.

---

## 36. Visual Anti-patterns

Dokumen ini secara eksplisit menolak:

Daftar ini dikonfirmasi sebagai guardrail Visual Direction v1 dan dipertahankan setelah
human review. Secara khusus, jangan mengubah Warm Cream/White/Sage rhythm menjadi
excessive dark-green, jangan menambah competing CTA colors, dan jangan mengubah Home,
Directory, atau Project Detail menjadi dashboard, luxury-property campaign, atau
aggressive sales banner.

1. Homepage yang terdiri dari banyak banner campaign tanpa editorial rhythm.
2. Full-screen dark-green hero yang memaksa semua content memakai contrast surface.
3. Hero overlay glassmorphism atau blur yang menyulitkan text/photo.
4. Autoplay carousel untuk hero atau Project gallery.
5. Gradient besar, neon green, glow, atau pattern dekoratif berulang.
6. Black/gold luxury property treatment yang tidak relevan dengan first-home buyer.
7. Generic stock photo yang disajikan sebagai Project Marison.
8. Generic SaaS dashboard dengan banyak KPI tile, border, dan shadow.
9. Excessive nested cards, terutama House Type card di dalam Project card.
10. Project Status yang memakai green `Tersedia` treatment.
11. Unit Status yang hanya dibedakan dari hue tanpa label.
12. Project card dengan price, full House Type list, Unit inventory, atau internal contact.
13. Filter mobile yang selalu memakan setengah layar hasil.
14. Infinite scrolling pada Directory V1.
15. Giant pagination row yang lebih menonjol daripada result.
16. KPR section yang membuat website terasa seperti banking dashboard.
17. Credibility metrics yang mengarang customer totals, awards, rate, atau delivery count.
18. Sticky CTA yang muncul saat initial load, menutupi content, atau memakai pulse/glow.
19. Contact panel yang menampilkan individual Marketing personnel.
20. Decorative icon yang menggantikan label status atau action.
21. Fixed-height copy yang memotong Bahasa Indonesia atau English.
22. Scroll hijacking, parallax overload, cinematic intro, dan animation tanpa purpose.

---

## 37. Open Visual Questions

Pertanyaan di bawah hanya mencakup hal yang materially memengaruhi asset production atau
fine-tuning visual. Tidak ada yang membuka kembali keputusan Design System, IA, User
Flow, atau Wireframe yang sudah disetujui.

### VD-Q01 — Official logo variants dan clear-space

**STATUS:** OPEN / NON-BLOCKING.

**RECOMMENDED DEFAULT:** gunakan official logo asset pada light surface; siapkan dark
surface variant hanya bila asset resmi tersedia. Jangan menggambar ulang logo atau
mengarang compact mark.

**IMPACT:** menentukan final header/footer contrast, minimum clear-space, dan alignment.

**BLOCKING?** NO untuk Visual Direction. Final asset handoff tetap memakai official
asset bila implementation dimulai.

### VD-Q02 — Final Project photography library dan orientasi

**STATUS:** OPEN / NON-BLOCKING.

**RECOMMENDED DEFAULT:** gunakan real Marison Project photography. Exact asset selection
terjadi saat content/prototype work; kemudian prioritaskan real development/progress atau
housing environment photography, crop-safe landscape 3:2/16:9 untuk hero, dan 4:3/3:2
untuk card. Gunakan neutral fallback bila perlu.

**IMPACT:** menentukan focal point crop, jumlah image gallery, dan apakah split Hero
tetap kuat pada seluruh Project.

**BLOCKING?** NO untuk Visual Direction. Exact asset selection dan focal-point QA
divalidasi saat content/prototype work.

### VD-Q03 — Official brand guideline di luar palette V1

**STATUS:** OPEN / NON-BLOCKING.

**RECOMMENDED DEFAULT:** pertahankan palette dan restraint rules dalam dokumen ini
sebagai working direction; sampai guideline resmi disediakan, `docs/DESIGN-SYSTEM.md`
dan `docs/VISUAL-DIRECTION-CORE.md` menjadi approved website visual baseline. Corporate
blue tetap logo-only/highly restrained.

**IMPACT:** dapat memengaruhi logo usage, tone, atau refinement kecil pada color
application, tetapi tidak perlu mengubah layout, status semantics, atau CTA hierarchy.

**BLOCKING?** NO untuk Visual Direction. Review diperlukan sebelum asset final diproduksi
bila guideline resmi berbeda.

### VD-Q04 — Actual content density dan panjang copy Project

**STATUS:** VALIDATE DURING PROTOTYPE / IMPLEMENTATION.

**RECOMMENDED DEFAULT:** gunakan placeholder yang dapat wrap, tampilkan satu supporting
context pada card, dan hilangkan optional block bila data tidak valid atau terlalu padat.

Gunakan realistic sample Project content untuk menguji text wrapping, jumlah House Type,
jumlah gallery, dan panjang deskripsi Project. Jangan merombak information architecture
hanya karena test data belum lengkap.

**IMPACT:** dapat mengubah card height, gallery crop, mobile House Type expansion, dan
section spacing setelah sample content nyata tersedia.

**BLOCKING?** NO untuk Visual Direction. Validasi dilakukan saat prototype/implementation.

### VD-Q05 — Actual public availability sample

**STATUS:** VALIDATE DURING PROTOTYPE / IMPLEMENTATION.

**RECOMMENDED DEFAULT:** design untuk dua keadaan: derived individual Unit summary dan
manual fallback berlabel jelas; gunakan no-data notice bila keduanya tidak tersedia.

Gunakan safe sample Unit data selama development. Jangan memakai real buyer/customer
personal data.

**IMPACT:** menentukan panjang Unit rows, source note, dan mobile summary density.

**BLOCKING?** NO untuk Visual Direction. Validasi dilakukan saat prototype/implementation
sebelum availability UI dianggap production-ready.

---

## 38. Acceptance Criteria

### Shared product direction

- [ ] Homepage, Housing Directory, dan Project Detail terasa sebagai satu produk.
- [ ] Marison green identity recognizable tanpa memenuhi semua surface.
- [ ] Warm Cream, White, Soft Sage, Deep Green, dan photography memiliki peran yang
      disengaja, bukan alternation mekanis.
- [ ] Plus Jakarta Sans → Inter → system sans-serif dan responsive hierarchy diterapkan
      secara konseptual.
- [ ] Layout memakai max-width, gutter, reading width, dan grid yang konsisten.
- [ ] Tidak ada production CSS variable, HTML, PHP, React, WordPress, library, atau
      production asset dalam dokumen.

### Homepage

- [ ] Hero memakai split editorial direction: content/discovery di satu sisi dan real
      Project photography di sisi lain.
- [ ] Hero tidak memakai giant form, full dark-green campaign surface, overlay glass,
      autoplay carousel, atau giant animation.
- [ ] City/Regency menjadi starting point discovery dan Province/Status tetap optional.
- [ ] `Cari Rumah` adalah global primary CTA.
- [ ] Featured Projects sekitar 3–6 item dan curated, bukan archive.
- [ ] Project Card memuat image/fallback, Project Status, nama, lokasi, supporting
      context terbatas, dan satu detail action.
- [ ] Location Discovery compact, curated, dan tidak membutuhkan giant map atau tag cloud.
- [ ] Credibility hanya memakai 30+ Projects dan fakta yang dikonfirmasi.
- [ ] KPR entry mengarah ke `/kpr/`, tidak menampilkan angka cicilan palsu, dan tidak
      menjadi full calculator.
- [ ] Articles sekitar 3 item dan secara visual lebih ringan daripada Projects.
- [ ] Careers tetap ringan dan tidak menjadi recruitment portal di Homepage.
- [ ] Final CTA kembali memprioritaskan housing discovery tanpa sales pressure.

### Housing Directory

- [ ] Directory tidak memakai oversized Homepage-style hero.
- [ ] Filter hanya City/Regency, Province optional, dan Project Status.
- [ ] City/Regency direct path tidak terhalang Province-first gate.
- [ ] Filter desktop, active filter, clear/reset, mobile trigger, dan focused panel
      memiliki visual hierarchy yang jelas.
- [ ] Result header tidak mengarang count dan tidak menambahkan sort requirement V1.
- [ ] Directory memakai anatomy Project Card yang sama dengan Homepage.
- [ ] Grid default adalah 3 kolom desktop, 2 tablet, 1 mobile bila content mendukung.
- [ ] Pagination memiliki Previous, page numbers, Next, current-page state, focus, dan
      disabled state yang jelas.
- [ ] Infinite scrolling dan Load More bukan default V1.
- [ ] No Results terasa membantu, tidak seperti error, dan menawarkan recovery yang
      disetujui.

### Project Detail

- [ ] Project Hero memakai photography beside content, bukan text berat di atas foto.
- [ ] Hero memuat nama, City/Regency, Project Status, positioning, Chat WhatsApp, dan
      Lihat Ketersediaan dengan hierarchy yang benar.
- [ ] Project Status memakai soft/outline informational family dan berbeda dari Unit
      Status.
- [ ] Overview terasa editorial dan tidak menjadi dashboard statistic cards.
- [ ] Gallery memakai featured image + supporting thumbnails dengan fallback jujur.
- [ ] House Type tetap contained, tidak memiliki standalone page, dan mobile memakai
      compact summary + `Lihat Detail` bila perlu.
- [ ] Availability mudah ditemukan setelah House Types, memakai Tersedia green,
      Terbooking amber, Terjual neutral gray, text, dan non-color cue.
- [ ] Derived summary dan manual fallback tidak tampil bersamaan.
- [ ] Unit list compact dan tidak menjadi spreadsheet pada mobile.
- [ ] Facilities memakai lightweight list/icon treatment, bukan puluhan decorative cards.
- [ ] Progress hanya percentage + optional description dan tidak menyiratkan certification.
- [ ] Location memiliki readable address/context dan map placeholder provider-independent.
- [ ] Related Articles tetap secondary dan canonical.
- [ ] Contact mengikuti Project → Primary Branch Office → Primary Public WhatsApp;
      individual Marketing tidak ditampilkan.
- [ ] Mobile sticky action muncul setelah Hero, tidak pada initial load, restrained,
      safe-area aware, dan menghilang/beradaptasi di Contact.
- [ ] Variant Akan Datang, Sedang Berjalan, dan Selesai tidak menginfer Unit availability.

### Responsive, interaction, accessibility

- [ ] Ketiga halaman memiliki desktop dan mobile visual behavior eksplisit.
- [ ] Card, image, typography, filter, form, pagination, dan contact tidak menyebabkan
      horizontal scrolling atau fixed-height clipping.
- [ ] Button, card, filter, gallery, status, sticky action, dan detail expansion memiliki
      restrained interaction direction.
- [ ] Reduced motion dihormati; tidak ada scroll hijacking atau autoplay motion.
- [ ] WCAG AA menjadi target; contrast final ditandai untuk verification implementation.
- [ ] Focus-visible, touch target, label persistent, status non-color, dan empty state
      guidance terdokumentasi.
- [ ] Visual direction tidak mengarang prices, rates, guarantees, addresses, Project
      names, customer totals, testimonials, awards, contact details, atau availability.

### Handoff readiness

- [ ] Visual decisions utama tidak memerlukan implementer untuk menebak surface,
      typography, card, CTA, status, gallery, filter, pagination, atau mobile behavior.
- [ ] Open Visual Questions hanya berisi asset/content questions dan masing-masing
      memiliki RECOMMENDED DEFAULT, IMPACT, serta BLOCKING status.
- [ ] Dokumen approved sources tetap tidak dimodifikasi.

---

Dokumen ini berhenti pada visual direction dan high-fidelity design specification.
Tahap berikutnya dapat memvalidasi arah ini dengan official logo, sample Project
photography, sample content, dan contrast testing tanpa mengubah prinsip produk secara
diam-diam.
