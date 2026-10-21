# User Flows Marison ID v1

## 1. Informasi Dokumen

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Domain | `marison.id` |
| Dokumen | User Flow v1 |
| Status | Final v1 — UX decisions resolved; development details remain |
| Branch | `feat/user-flow-v1` |
| Tanggal | 22 Oktober 2026 |
| Sumber | `docs/PRD.md`, `docs/CONTENT-MODEL.md`, `docs/INFORMATION-ARCHITECTURE.md`, `docs/PROJECT-RULES.md` |
| Bahasa dokumen | Bahasa Indonesia |

Dokumen ini mendeskripsikan alur interaksi dan keputusan pengguna secara
konseptual. Dokumen ini tidak menentukan UI, wireframe, visual design, template,
CSS, PHP, struktur database, plugin, atau implementasi WordPress.

---

## 2. Purpose

User Flow v1 bertujuan menjelaskan bagaimana pengguna mencapai tujuan publik
Marison ID dengan langkah yang singkat dan dapat dipahami.

Tujuan utama:

1. Membantu pengguna menemukan Project yang relevan tanpa mengirim data pribadi
   terlebih dahulu.
2. Menjelaskan keputusan pengguna dari Home atau discovery sampai Project Detail.
3. Memastikan Project context tetap ada ketika pengguna menghubungi branch.
4. Menjelaskan perbedaan inquiry Project dan inquiry korporat.
5. Menyediakan recovery path yang jujur untuk data kosong, tidak tersedia, atau
   tidak valid.
6. Menjadi dasar untuk desain interaksi berikutnya tanpa berubah menjadi desain UI.

### Primary outcome

```text
Home
  → Housing discovery
    → Relevant Project
      → Understand Project
        → Check availability
          → Contact relevant Branch
```

Tidak ada account creation, forced registration, atau lead form sebelum pengguna
dapat memahami Project.

---

## 3. User Flow Principles

1. **Discovery sebelum data pribadi.** Pengguna dapat mencari dan membaca Project
   sebelum diminta menghubungi atau mengisi lead.
2. **Project adalah konteks utama.** Lokasi, House Type, availability, KPR entry
   point, dan branch contact dipahami dari Project yang dipilih.
3. **Langkah sesingkat mungkin.** Jangan menambahkan About, account, atau form
   sebagai prasyarat menemukan rumah.
4. **Lokasi membantu, bukan menghambat.** Pengguna yang sudah tahu City/Regency
   tidak harus melalui Province secara berurutan.
5. **Status Project bukan status Unit.** Akan Datang, Sedang Berjalan, dan Selesai
   tidak otomatis berarti Tersedia, Terbooking, atau Terjual.
6. **Availability harus mempunyai satu sumber aktif.** Derived summary dari Unit
   individual dan manual fallback tidak boleh bertentangan.
7. **Kontak mengikuti routing yang benar.** Project → Primary Branch Office →
   Primary Public WhatsApp; Marketing assignment tetap internal.
8. **Tidak ada janji yang tidak didukung data.** Jangan mengarang gambar, Unit,
   harga, availability, hasil KPR, atau contact details.
9. **KPR adalah estimasi.** Simulator tidak boleh dipahami sebagai persetujuan
   bank atau jaminan pembiayaan.
10. **Content tetap berguna tanpa conversion.** Artikel dan About tidak dipaksa
    menjadi sales funnel.
11. **Preservasi dengan status jelas.** Project selesai dan Vacancy closed dapat
    tetap berguna tanpa memberi CTA yang menyesatkan.
12. **Mobile-critical actions tetap dekat.** Cari Rumah, lokasi, status,
    availability, KPR, dan WhatsApp tidak boleh hilang dalam langkah berulang.
13. **Recovery selalu jujur.** Empty state memberikan langkah berikutnya yang
    benar, bukan konten palsu.

---

## 4. Flow Overview

| Flow | Entry point | Tujuan pengguna | Hasil utama |
|---|---|---|---|
| 1. Find Home from Homepage | Home | Menemukan Project relevan | Project Detail terbuka tanpa lead awal |
| 2. Housing Directory | `/perumahan/` | Menyaring Project dengan kontrol lokasi/status | Hasil relevan atau recovery state |
| 3. Location Discovery | Home, Directory, location context | Menemukan Project berdasarkan Province/City | Project atau pilihan lokasi lain |
| 4. Project Detail | Project URL/discovery | Memahami Project dan keputusan berikutnya | Availability, KPR, atau contact branch |
| 5. Unit Availability | Project Detail | Memahami status Unit | Summary/individual availability yang konsisten |
| 6. Project → WhatsApp | Project CTA | Menghubungi branch yang benar | Inquiry berisi konteks Project |
| 7. General Corporate Contact | `/kontak/` | Menghubungi Marison secara umum | Inquiry ke central/corporate admin |
| 8. KPR Education + Simulation | `/kpr/` | Memahami KPR dan menghitung estimasi | Hasil estimasi dengan disclaimer |
| 9. Article → Housing | Search, social, Article | Membaca dan melanjutkan bila relevan | Article tetap berguna; Project optional |
| 10. Careers | `/karier/` | Menemukan dan melamar Vacancy | Instruksi/email/external URL |
| 11. About / Trust | Home, Project, footer | Menilai kredibilitas Marison | Kembali ke Directory atau Contact |
| 12. Language Switching | Root atau `/en/` | Membaca konteks yang sama dalam bahasa lain | Linked translation atau fallback Indonesia |
| 13. Mobile Journey | Smartphone entry point | Menyelesaikan task inti tanpa backtracking berlebih | Discovery/contact/KPR dapat dicapai dengan efisien |
| 14. Return / Recovery | Any failed state | Melanjutkan dari data kosong/error | Next action yang aman dan jujur |
| 15. Project Status Behavior | Project Detail | Menafsirkan status Project dengan benar | CTA sesuai status, tanpa asumsi availability |

---

## 5. Find Home from Homepage

### Entry point

Pengguna tiba di Home melalui direct visit, search engine, social link, atau link
dari sumber lain.

### User goal

Menemukan Project perumahan yang sesuai lokasi atau kebutuhan tanpa membuat akun
dan tanpa menyerahkan data pribadi di awal.

### Main flow

```text
Home
  → Cari Rumah / housing discovery
    → pilih atau cari lokasi bila perlu
      → Housing Directory results
        → pilih Project
          → Project Detail
```

### Steps

1. Pengguna memahami secara singkat bahwa Marison menyediakan perumahan.
2. Pengguna memilih `Cari Rumah` atau entry point housing discovery.
3. Pengguna memilih City/Regency secara langsung bila sudah mengetahui lokasinya;
   Province tetap dapat dipakai sebagai filter atau level browsing opsional.
4. Pengguna menilai nama Project, lokasi, dan Project Status.
5. Pengguna membuka Project Detail.
6. Pengguna membaca overview, House Types, fasilitas, progress, dan availability
   bila tersedia.
7. Pengguna memilih langkah berikutnya: memeriksa Unit, membuka KPR, atau kontak
   branch.

### Decision points

- Apakah pengguna sudah mengetahui City/Regency atau membutuhkan browsing berdasarkan
  Province?
- Apakah hasil perlu disaring berdasarkan Project Status?
- Apakah Project memiliki informasi House Type dan availability yang cukup?
- Apakah pengguna siap menghubungi branch atau masih membutuhkan edukasi?

### Success state

Pengguna dapat menjawab:

- Project berada di mana;
- status Project apa;
- House Type apa yang tersedia untuk dipahami;
- apakah informasi Unit tersedia;
- bagaimana menghubungi Marison melalui branch yang tepat.

### Failure / empty states

- Tidak ada hasil: tampilkan alasan dan pilihan memperluas lokasi atau menghapus
  filter.
- Project belum memiliki Unit digital: jelaskan keterbatasan dan arahkan ke branch.
- Project belum memiliki gallery: lanjutkan dengan informasi yang tersedia.
- Project tidak memiliki jalur contact valid: jangan mengarahkan ke branch lain;
  tandai sebagai masalah data dan gunakan fallback contact yang disetujui bila ada.

### UX risks

- CTA Home terlalu cepat meminta data pribadi.
- Pengguna mengira semua Project memiliki harga atau Unit individual.
- Featured Project mengalahkan kebutuhan pencarian bebas.
- Lokasi dipahami sebagai navigasi terpisah, bukan bagian dari discovery.

---

## 6. Housing Directory

### Entry point

`/perumahan/`, CTA `Cari Rumah`, Home, Article, atau link kontekstual dari About.

### Initial state

Initial state harus membantu pengguna memulai tanpa membuat asumsi yang belum
diketahui. Pengguna dapat:

- melihat Project yang tersedia;
- memilih City/Regency;
- memilih Province sebagai filter, level browsing, atau grouping opsional;
- memilih Project Status: Akan Datang, Sedang Berjalan, atau Selesai.

Harga bukan filter wajib V1. Tidak ada filter gaji, luas, jumlah kamar, atau
kriteria lain yang belum disetujui.

### Filtered state

```text
Directory
  → pilih City/Regency secara langsung, atau Province secara opsional,
    dan/atau Project Status
    → lihat hasil yang sesuai
      → pilih Project
```

State filter membantu pencarian pengguna. State tersebut bukan halaman SEO
standalone dan tidak perlu menjadi URL indexable.

### Clear-filter behavior

Pengguna dapat menghapus satu pilihan atau mengembalikan semua kontrol ke kondisi
awal. Menghapus filter tidak boleh membawa pengguna ke halaman yang kehilangan
konteks secara tidak terduga.

### No-result state

Jika tidak ada Project yang cocok:

1. Jelaskan bahwa tidak ada Project dengan kombinasi pilihan tersebut.
2. Tawarkan hapus filter.
3. Tawarkan memilih City/Regency lain, memperluas ke Province, atau melihat semua
   Project.
4. Jangan mengisi hasil dengan Project yang tidak sesuai.
5. Jangan membuat halaman indexable dari kombinasi kosong tersebut.

### Selecting a Project

Pengguna memilih Project berdasarkan minimal nama, lokasi, dan status. Hasil tidak
boleh menyembunyikan status yang penting atau menampilkan availability yang tidak
memiliki sumber jelas.

---

## 7. Location Discovery

Location discovery adalah bagian dari housing journey, bukan primary navigation
item.

### Path A — Home to City

```text
Home → Cari Rumah / housing search → pilih City/Regency → Project results
```

Pengguna yang sudah tahu City/Regency dapat memilihnya secara langsung dan tidak
dipaksa memilih Province terlebih dahulu. Province tetap dapat digunakan sebagai
filter, level browsing, atau grouping.

### Path B — Directory to Province to City

```text
Perumahan → pilih Province → pilih City/Regency → Project results
```

Path ini membantu pengguna yang baru mengetahui area yang lebih luas.

### Path C — Location landing to Project

```text
Location landing → konteks lokasi → relevant Projects → Project Detail
```

Location landing hanya tersedia sebagai halaman publik/indexable bila memiliki
Project relevan, konteks lokasi, atau navigasi yang bermakna.

### Location with many Projects

1. Pengguna memilih atau memasukkan City/Regency.
2. Sistem menampilkan beberapa Project yang relevan.
3. Pengguna dapat mempersempit dengan Project Status.
4. Pengguna memilih Project berdasarkan lokasi, status, dan informasi yang tersedia.

Jangan memaksa pengguna membaca satu halaman panjang berisi semua Project tanpa
cara mempersempit hasil.

### Location with one Project

Tampilkan konteks lokasi secara singkat dan arahkan langsung ke satu Project.
Jangan menciptakan langkah Province tambahan bila City/Regency sudah diketahui.

### Location with no Projects

Tampilkan empty state yang menawarkan:

- hapus pilihan City/Regency;
- melihat Province yang lebih luas;
- memilih lokasi lain;
- melihat semua Project.

### Thin or non-public location

Location record tanpa Project relevan atau konten yang membantu tetap dapat dipakai
sebagai data/filter internal discovery, tetapi tidak dipromosikan sebagai landing
page publik indexable.

---

## 8. Project Detail

### Entry point

Project dipilih dari Home, Directory, location landing, Article terkait, atau link
lain yang mempertahankan Project context.

### Logical information sequence

Urutan logis, bukan urutan layout visual:

1. Identitas Project: nama, lokasi, dan Project Status.
2. Ringkasan: apa Project ini dan untuk siapa konteksnya berguna.
3. House Types: tipe rumah yang dimiliki Project, spesifikasi, dan denah/gambar
   bila tersedia.
4. Facilities: fasilitas yang benar-benar terkait dengan Project.
5. Current progress: persentase dan deskripsi singkat bila tersedia.
6. Availability: summary atau individual availability dengan sumber yang jelas.
7. Lokasi dan map information: alamat dan konteks area.
8. Related Articles/Project updates: hanya Article canonical yang terkait.
9. KPR entry point: menuju `/kpr/` untuk edukasi dan simulator.
10. Branch contact: Primary Branch Office, Primary Public WhatsApp, dan telepon
    publik bila tersedia.

### User decisions

Pengguna dapat memutuskan:

- apakah lokasi Project sesuai;
- apakah status Project sesuai ekspektasi;
- apakah House Type cukup relevan untuk dipelajari;
- apakah Unit availability perlu dikonfirmasi;
- apakah perlu memahami KPR;
- apakah siap menghubungi branch.

### Project to next action

```text
Project overview
  → House Types / Facilities / Progress
    → Availability
      → KPR bila pembiayaan belum dipahami
      → Chat WhatsApp / telephone / form bila siap kontak
```

Tidak ada langkah wajib menuju lead form sebelum pengguna dapat membaca informasi
Project.

---

## 9. Unit Availability

Unit availability selalu berada dalam Project context. Tidak ada global Unit search
atau required standalone Unit URL V1.

### Case A — Individual Unit data exists

```text
Project Detail
  → derived availability summary
    → individual availability bila berguna
      → konfirmasi melalui Branch
```

Pengguna dapat melihat:

- ringkasan per status Tersedia, Terbooking, Terjual;
- individual Unit reference/status bila memang layak ditampilkan;
- pesan bahwa status dapat memerlukan konfirmasi lanjutan.

Summary harus dihitung dari Individual Housing Unit sebagai source of truth. Tidak
boleh ada angka manual kedua yang berbeda dari hasil turunan.

### Case B — Individual Unit inventory belum terdigitalisasi

```text
Project Detail
  → temporary manual availability summary bila tersedia
    → labeli sebagai fallback
      → Branch contact untuk konfirmasi
```

Jika manual summary tidak tersedia, jangan menampilkan angka yang dibuat-buat.
Tampilkan bahwa detail Unit belum terdigitalisasi atau belum tersedia dan arahkan
ke branch bila contact valid.

### User interpretation

Project Status dan Unit Status berbeda:

- Project `Akan Datang` tidak otomatis berarti Unit `Tersedia`.
- Project `Sedang Berjalan` tidak otomatis berarti masih ada Unit.
- Project `Selesai` tidak otomatis berarti tidak ada Unit, tetapi juga tidak boleh
  dipromosikan sebagai availability tanpa data Unit/konfirmasi.

### V1 boundary

Interactive siteplan adalah kemungkinan fase berikutnya. V1 tidak memerlukan
perjalanan global dari Unit ke Project.

---

## 10. Project Contact / WhatsApp

### Critical conversion flow

```text
Visitor
  → Project
    → Primary Branch Office
      → Primary Public WhatsApp
        → Branch Admin
          → Internal Marketing routing
```

Pengunjung tidak memilih Marketing Person/Team dan tidak melihat assignment.

### WhatsApp CTA behavior

1. Pengguna membaca Project context.
2. Pengguna memilih `Chat WhatsApp`.
3. Tujuan yang dibuka adalah Primary Public WhatsApp dari Primary Branch Office
   Project tersebut.
4. Project context harus dapat diteruskan ke Branch Admin agar asal inquiry jelas.
5. Branch Admin melakukan routing internal ke Marketing Person/Team yang sesuai.

Mekanisme dan exact message text belum ditetapkan. Prinsipnya, konteks Project
tidak boleh hilang dari proses contact.

### If Branch WhatsApp is unavailable

- Jangan diam-diam mengarahkan pengguna ke Branch proyek lain.
- Jika public telephone Branch valid, gunakan telephone sebagai alternatif utama.
- Jika telephone tidak valid, gunakan central/corporate fallback hanya jika telah
  dikonfigurasi dan disetujui secara eksplisit.
- Jika tidak ada contact valid atau fallback terkonfigurasi, jelaskan bahwa contact
  Project belum tersedia melalui honest contact-unavailable state.
- Tandai kondisi tersebut sebagai masalah data/configuration serius untuk diperbaiki.

### If Project has no valid Branch assignment

Project tidak seharusnya dipublikasikan dengan CTA contact yang tampak valid.
Jika kondisi ditemukan setelah publikasi, jangan memilih Branch terdekat atau
Branch acak. Ikuti urutan recovery: telephone publik Branch bila valid,
central/corporate fallback bila dikonfigurasi dan disetujui, atau honest
contact-unavailable state; lalu eskalasi ke pemilik konten.

### If user chooses telephone

Panggilan tetap menuju telephone publik Primary Branch Office. Project context
ditampilkan sebelum langkah tersebut dan pengguna dapat menyebutkan Project kepada
Branch Admin. Tidak ada routing ke nomor personal Marketing sebagai default.

### Form fallback

Jika pengguna tidak memakai WhatsApp, formulir Project dapat digunakan dengan data
minimum PRD. Formulir tidak meminta salary, NIK, SLIK, employment data, atau
financial history.

---

## 11. General Contact

### Distinction

| Jenis kebutuhan | Jalur |
|---|---|
| Project question | Project → Primary Branch Office → Primary Public WhatsApp/telephone/form |
| General corporate question | `/kontak/` → central/corporate telephone, email, atau general form |

### Flow

```text
/kontak/
  → pengguna mengenali bahwa ini jalur umum/korporat
    → memilih central/corporate telephone, email, atau general contact form
      → central/corporate admin menangani inquiry
```

Kombinasi channel yang didukung adalah central/corporate telephone, general
corporate email, dan general contact form. Exact phone number dan email address
masih TO BE DEFINED. Form general tidak meminta Project context sebagai syarat.
User Flow tidak mengarang detail contact tersebut.

### Preventing confusion

- `/kontak/` menjelaskan bahwa pertanyaan mengenai Project sebaiknya dimulai dari
  Project yang relevan.
- Project CTA tidak diarahkan ke general Contact bila Primary Branch valid.
- General inquiry tidak otomatis diberi Project atau Branch yang tidak dipilih.
- General form tidak mewajibkan pengguna memilih atau menyebutkan Project.
- Calon pembeli yang belum memilih Project dapat kembali ke `Cari Rumah`.

---

## 12. KPR Education & Simulation

### Flow

```text
/kpr/
  → memahami konsep dasar KPR
    → membaca input dan batasan
      → mengisi simulator
        → menerima estimated result
          → membaca disclaimer
            → Cari Rumah atau Contact bila perlu
```

KPR education dan simulator berada dalam satu halaman `/kpr/`. Anchor seperti
`/kpr/#simulasi` hanya contoh konseptual, bukan keputusan frontend.

### Conceptual inputs

Pengguna dapat diminta memasukkan:

- estimasi harga properti;
- uang muka;
- jangka waktu/tenor;
- parameter scheme yang berlaku bila ditampilkan.

IA dan User Flow tidak menentukan formula, bunga, pembulatan, atau sumber bank.

### Result understanding

Setelah kalkulasi berhasil, pengguna harus memahami:

- hasil adalah estimasi;
- hasil bukan persetujuan atau jaminan bank;
- kondisi aktual dapat berbeda;
- pengguna dapat melanjutkan ke Project discovery atau Contact.

### Error states

- **Incomplete input:** jelaskan input mana yang belum tersedia dan izinkan
  pengguna melengkapinya tanpa kehilangan konteks halaman.
- **Invalid numeric value:** minta nilai yang masuk akal secara umum tanpa
  menetapkan formula atau threshold bisnis yang belum disetujui.
- **No active PUBLIC DEFAULT SCHEME:** jangan menghasilkan angka palsu; tampilkan
  bahwa simulasi sementara tidak tersedia, pertahankan edukasi KPR, dan berikan
  akses ke Cari Rumah atau General Contact bila relevan.
- **Unexpected calculation failure:** jelaskan hasil tidak dapat dihitung saat ini;
  jangan tampilkan angka parsial sebagai hasil final.

---

## 13. Articles

### Entry paths

```text
Search engine / social / Home / Artikel / Project context
  → Article Detail
```

### Article with zero Project relationships

Artikel edukasi umum, KPR education, atau homeowner information tetap selesai
sebagai pengalaman membaca. Tautan berikutnya hanya ditawarkan bila relevan,
misalnya KPR atau Cari Rumah.

### Article with one Project relationship

```text
Article → related Project → Project Detail → availability/contact
```

Relasi tersebut membantu pembaca yang memang membutuhkan konteks Project, tetapi
tidak mengubah Article menjadi forced sales funnel.

### Article with multiple Project relationships

Artikel regional atau company update dapat mengarahkan pengguna ke beberapa
Project relevan. Pengguna tetap memilih Project secara sadar; jangan mengarahkan
otomatis ke satu Project tanpa alasan.

### Canonical rule

Article memiliki satu URL canonical `/artikel/[article]/`. Saat ditampilkan pada
Project Detail sebagai update terkait, pengguna tetap menuju URL Article yang sama.
Tidak ada duplicate Article URL di bawah Project.

---

## 14. Careers

### Active vacancy flow

```text
Karier
  → active Vacancy listing
    → Vacancy Detail
      → instructions / recruitment email / external URL
```

V1 tidak menyimpan applicant records, CV, candidate dashboard, atau candidate
portal.

### No active Vacancies

Karier tetap menjelaskan konteks bekerja di Marison dan menyatakan bahwa saat ini
tidak ada lowongan aktif. Jika ada, arahkan ke informasi Karier atau jalur lain
yang memang disetujui; jangan menampilkan Vacancy palsu.

### Closed Vacancy

1. Hilangkan Vacancy dari active listing.
2. Jika halaman dipertahankan, tampilkan status **Lowongan Ditutup** atau label
   setara dengan jelas.
3. Hapus atau nonaktifkan application CTA dan jangan izinkan application baru.
4. Tawarkan kembali ke Karier atau Vacancy aktif lain.
5. Perlakuan SEO final untuk halaman closed ditentukan pada SEO planning.

### Application method

Pengguna mengikuti salah satu metode yang tersedia: instruksi, recruitment email,
atau external application URL. Tidak ada form applicant lokal yang menjadi syarat
User Flow V1.

---

## 15. About / Trust

### Flow

```text
Home atau Project
  → Tentang Kami
    → company story / values / operating presence / track record ringkas
      → Perumahan atau Kontak
```

### Purpose

Journey ini melayani pengguna yang ingin menilai kredibilitas Marison, bukan
prasyarat untuk menemukan rumah.

### Track record

Tidak ada Portfolio standalone. Completed Projects dapat mendukung trust melalui
Project Directory dan status `Selesai`, sementara rekam jejak korporat dapat
diringkas di `Tentang Kami`.

### Success state

Pengguna memahami Marison secukupnya dan dapat:

- kembali mencari Project;
- menghubungi Marison untuk inquiry umum;
- melanjutkan ke Karier bila tujuan mereka adalah pekerjaan.

---

## 16. Language Switching

### Ideal flow

```text
Indonesian Home/Project/Article
  → language switcher
    → corresponding English translation under /en/
```

Contoh:

```text
Indonesian Project A → English translation of Project A
```

Bukan:

```text
Indonesian Project A → English Home
```

kecuali translation Project A memang belum tersedia.

### Shared data

Status Project, status Unit, dimensi, koordinat, relationships, dan public contact
numbers tetap shared structured data. Data tersebut tidak diduplikasi hanya karena
pengguna berpindah bahasa.

### Translation unavailable

Jika translation halaman tidak ada:

1. Jelaskan bahwa versi English belum tersedia.
2. Tetap di atau kembali ke konten Bahasa Indonesia yang bersesuaian.
3. Pertahankan Project, Article, atau page context saat fallback.
4. Jangan mengirim pengguna ke English Home.
5. Jangan membuat copy terjemahan yang belum disetujui.

Exact translated English slugs dan multilingual implementation tidak ditentukan
oleh User Flow ini.

---

## 17. Mobile Journey

### Critical mobile sequence

```text
Mobile Home
  → Cari Rumah / Perumahan
    → search/filter Province, City/Regency, Status
      → Project Detail
        → location/status/availability
          → Chat WhatsApp
```

### Mobile information priorities

Urutan interaksi harus memungkinkan pengguna menemukan:

1. `Cari Rumah` atau Perumahan;
2. search/filter yang relevan;
3. Project location;
4. Project Status;
5. availability;
6. WhatsApp branch;
7. `/kpr/` dan simulator dalam halaman yang sama.

### Backtracking risks

- Setelah memilih City/Regency atau Province, pengguna tidak seharusnya kehilangan
  hasil saat mengubah satu filter.
- Setelah membaca Project, pengguna tidak seharusnya kembali ke Home hanya untuk
  menemukan WhatsApp.
- Dari KPR, pengguna dapat kembali ke Cari Rumah atau General Contact tanpa
  mengulang seluruh discovery.
- Dari Article terkait, pengguna dapat kembali ke Project canonical.

Tidak ada bottom navigation atau komponen mobile tertentu yang ditetapkan di sini.

---

## 18. Project Status Behavior

Project Status dan Unit Availability adalah dua konsep yang terpisah.

| Project Status | Ekspektasi informasi | CTA yang dapat diprioritaskan | Yang tidak boleh diasumsikan |
|---|---|---|---|
| Akan Datang | Identitas, lokasi, konteks, rencana informasi yang benar-benar tersedia | Pelajari Project, simpan konteks secara informal, atau hubungi branch bila contact valid | Tidak boleh diasumsikan sudah ada Unit Tersedia |
| Sedang Berjalan | Overview, progress, House Types, availability bila ada | Lihat Ketersediaan, Chat WhatsApp, buka KPR | Tidak boleh diasumsikan semua Unit masih tersedia |
| Selesai | Rekam jejak, Project context, status historis, availability hanya bila datanya valid | Pelajari Project atau contact bila masih relevan | Tidak boleh diasumsikan tidak ada Unit atau ada penjualan aktif |

### Status interpretation rule

- Project Status menjelaskan tahap Project.
- Unit Status menjelaskan kondisi Unit individual atau summary.
- Contact dapat diperlukan untuk konfirmasi pada semua status.
- Satu status tidak boleh mengisi kekosongan status lain.

---

## 19. Empty / Recovery States

| Kondisi | Recovery behavior | Next action |
|---|---|---|
| Filter tidak menghasilkan Project | Jelaskan hasil kosong dan pertahankan pilihan pengguna | Hapus filter, perluas lokasi, atau lihat semua Project |
| Location tidak memiliki Project | Jangan membuat halaman SEO kosong | Pilih lokasi lain atau kembali ke Directory |
| Project selesai | Tampilkan status Selesai tanpa CTA aktif yang tidak didukung | Baca rekam jejak atau contact bila masih relevan |
| Unit belum terdigitalisasi | Labeli manual summary sebagai fallback atau nyatakan belum tersedia | Hubungi Branch untuk konfirmasi |
| Branch WhatsApp unavailable | Jangan pindah diam-diam ke Branch lain | Branch public telephone → approved central/corporate fallback bila configured → contact-unavailable state |
| Project tidak punya Branch assignment valid | Jangan tampilkan contact palsu | Ikuti urutan telephone/fallback/unavailable dan tandai masalah konfigurasi |
| KPR tidak dapat menghitung | Jangan tampilkan angka parsial/palsu | Pertahankan edukasi; simulator unavailable; Cari Rumah atau General Contact |
| Tidak ada active Vacancy | Nyatakan tidak ada lowongan aktif | Baca Karier atau kembali ke Home |
| Vacancy closed | Tampilkan Lowongan Ditutup dan hentikan application CTA | Lowongan aktif lain atau Karier |
| English translation unavailable | Nyatakan translation belum tersedia dan pertahankan context | Tetap di/kembali ke konten Indonesia yang bersesuaian |
| Article tidak punya Project | Biarkan Article selesai sebagai konten mandiri | KPR, Cari Rumah, atau Article lain bila relevan |
| Gallery/progress tidak tersedia | Hilangkan asumsi dan jangan membuat data visual palsu | Lanjutkan ke overview, lokasi, status, atau contact valid |

Tidak ada empty state yang membuat informasi fiktif untuk mengisi ruang kosong.

---

## 20. Conversion Principles

1. **Discovery before personal data:** pengguna melihat Project sebelum form.
2. **Project-context contact:** setiap Project inquiry mempertahankan Project.
3. **Short lead form:** hanya Name, WhatsApp/telephone, Interested Project, consent;
   message optional.
4. **Clear WhatsApp destination:** CTA menuju Primary Public WhatsApp Branch,
   bukan Marketing Person.
5. **No deceptive urgency:** jangan memakai Unit/status untuk tekanan palsu.
6. **No fake availability:** jangan menampilkan angka atau status tanpa source.
7. **No forced registration:** account tidak dibutuhkan untuk discovery atau contact.
8. **No misleading KPR guarantee:** hasil selalu dijelaskan sebagai estimasi.
9. **No unnecessary steps:** About, KPR, atau form bukan prasyarat Project.
10. **Context survives transitions:** dari Article, Location, dan Project, pengguna
    tahu konteks halaman dan langkah berikutnya.
11. **Contact choice remains understandable:** WhatsApp, telephone, dan form tidak
    diam-diam menuju recipient yang berbeda dari yang dijelaskan.

---

## 21. Privacy Principles

### Approved minimum for main Project lead form

- Name;
- WhatsApp / telephone;
- Interested Project;
- consent pemrosesan data pribadi;
- message optional.

### Explicitly excluded from initial public flow

- salary;
- NIK;
- SLIK;
- employment data;
- financial history;
- qualification panjang;
- buyer ownership data.

Lead adalah internal/private setelah dikirim. Source Project dan jalur Branch tetap
dipertahankan untuk routing, tetapi Marketing assignments dan internal routing
history tidak ditampilkan kepada pengunjung.

Form besar tidak muncul sebelum discovery. Detail retention, access policy,
deletion, dan privacy governance berada di luar keputusan User Flow dan harus
diselesaikan sebelum production form digunakan.

---

## 22. Flow Decision Matrix

| Flow | Entry point | User goal | Main steps | Primary success | Fallback | Conversion point | Sensitive data involved? | Open decision? |
|---|---|---|---|---|---|---|---|---|
| Find Home from Homepage | Home | Menemukan Project | Home → Cari Rumah → lokasi/filter → Project | Project Detail dipahami | Empty results/recovery | Project CTA atau lanjut discovery | Tidak pada discovery | Tidak |
| Housing Directory | `/perumahan/` | Menyaring hasil | Initial → Province/City/Status → results → Project | Hasil relevan dipilih | Clear filter/expand location | Project selection | Tidak | Tidak |
| Location Discovery | Home/Directory/location context | Menemukan Project berdasarkan area | City direct, atau Province opsional → City → Project | Project di area dipilih | Lokasi lain/Directory | Project selection | Tidak | UX04 later: minimum content location governance |
| Project Detail | Project URL | Memahami Project | Identity → overview → House Type → availability → contact/KPR | Keputusan next action jelas | Missing content/contact fallback | WhatsApp/telephone/form | Tidak sampai contact | Tidak |
| Unit Availability | Project Detail | Memahami Unit | Summary → individual/fallback → confirmation | Status tidak kontradiktif | Belum digital/branch | Branch confirmation | Tidak | Tidak |
| Project → WhatsApp | Project CTA | Menghubungi branch | Project → Branch → WhatsApp → Admin routing | Inquiry context preserved | Telephone → approved central fallback if configured → unavailable state | WhatsApp/telephone | Setelah submit: approved lead fields bila form digunakan | Development detail: exact message mechanism |
| General Contact | `/kontak/` | Inquiry korporat | Contact → telephone/email/general form → central/corporate admin | User distinguishes corporate route | Channel detail TBD; no Project context required | Central contact | Tergantung metode final | Exact phone/email details TBD |
| KPR | `/kpr/` | Memahami dan menghitung | Education → inputs → estimate → disclaimer | Estimate understood correctly | Invalid input or unavailable simulator; education remains | Cari Rumah/General Contact | Input finansial estimasi, bukan lead otomatis | Development detail: scheme eligibility |
| Article → Housing | Search/social/Article | Membaca, lalu discover bila relevan | Article → related Project optional | Article useful with/without Project | Standalone reading | Related Project/KPR | Tidak kecuali user chooses contact | Tidak |
| Careers | `/karier/` | Melamar Vacancy | Listing → Detail → instructions/email/external URL | Application path clear | No active; closed detail marked Lowongan Ditutup with no application CTA | External/email/instructions | Applicant data outside V1 | Closed SEO later |
| About / Trust | Home/Project/footer | Menilai kredibilitas | Tentang Kami → track record → Directory/Contact | Trust context understood | Return to Home | Directory/contact | Tidak | Tidak |
| Language Switching | Root/`/en/` | Menjaga konteks bahasa | Current page → linked translation | Same page translated | Contextual Indonesian fallback with notice | Same contextual CTA | Tidak | Development detail: exact implementation |
| Mobile Journey | Smartphone | Menyelesaikan task inti | Cari Rumah → direct location/filter → Project → status/availability → WhatsApp | No excessive backtracking | Recovery in same journey | Project WhatsApp/KPR | Tidak sebelum contact | Tidak |
| Return / Recovery | Any error/empty state | Melanjutkan task | Error explanation → next action | User can continue or safely stop | Broader discovery/contact | Contextual next action | Tidak unless contact | Copy/detail later |
| Project Status Behavior | Project Detail | Menafsirkan status | Status → relevant information → CTA by state | No status/availability confusion | Contact for confirmation | CTA appropriate to state | Tidak | Tidak |

---

## 23. Friction Audit

| Friction | Severity | Risiko | Rekomendasi |
|---|---|---|---|
| Form muncul sebelum Project dipahami | HIGH | Discovery dan trust turun; privacy burden terlalu awal | Tunda form sampai Project/contact intent jelas |
| Lokasi memaksa Province sebelum City yang sudah diketahui | HIGH | Pengguna mobile melakukan langkah tambahan yang tidak perlu | Izinkan direct City/Regency discovery; Province tetap opsional |
| `Lokasi` menjadi primary nav terpisah | MEDIUM | Main navigation terpecah dan discovery terasa duplikatif | Pertahankan lokasi dalam Perumahan |
| Filter state dibuat sebagai halaman SEO mandiri | MEDIUM | Duplicate/thin pages dan context tidak jelas | Perlakukan sebagai search state, bukan SEO page |
| Project Status dianggap sebagai Unit availability | HIGH | Pengguna dapat mengambil keputusan berdasarkan asumsi salah | Tampilkan dan jelaskan dua status secara terpisah |
| Derived dan manual summary tampil bersamaan | HIGH | Angka availability kontradiktif | Satu active source; label fallback jelas |
| WhatsApp menuju Marketing personal | HIGH | Salah routing, privasi, dan ketergantungan operasional | Selalu resolve ke Primary Branch WhatsApp |
| Branch invalid dialihkan ke Branch lain diam-diam | HIGH | Inquiry Project salah tujuan | Telephone Branch valid → approved central fallback bila configured → contact-unavailable; jangan silent reroute |
| Project context hilang saat contact | HIGH | Branch Admin tidak tahu Project yang ditanyakan | Pertahankan source Project sepanjang contact flow |
| General Contact terlihat seperti Project inquiry | MEDIUM | Lead korporat dan lead Project tercampur | Jelaskan dua jenis kebutuhan; sediakan telephone, email, dan general form tanpa Project context wajib |
| KPR result tidak disertai disclaimer | HIGH | Estimasi dianggap persetujuan bank | Disclaimer menjadi bagian wajib dari result flow |
| KPR tidak punya active default scheme | HIGH | Angka palsu atau pengalaman buntu | Pertahankan edukasi; simulator unavailable; beri Cari Rumah atau General Contact |
| Article selalu diarahkan menjual Project | MEDIUM | Konten editorial kehilangan nilai | Related Project bersifat optional dan relevan |
| Vacancy closed masih tampak apply-able | HIGH | Kandidat mengirim lamaran yang tidak diproses | Labeli Lowongan Ditutup, keluarkan dari listing aktif, dan nonaktifkan application CTA |
| English switch mengarah ke Home | MEDIUM | Pengguna kehilangan context dan trust | Tetap di/kembali ke konten Indonesia bersesuaian dengan pemberitahuan |
| Mobile harus bolak-balik Home untuk WhatsApp | HIGH | Conversion drop dan context hilang | CTA Project tetap mudah dicapai tanpa kembali ke Home |
| Completed Project terlihat seperti active sales | HIGH | Status historis disalahartikan | Bedakan status Selesai dan Unit availability |

---

## 24. Open UX Questions

Human review telah menyelesaikan keputusan UX utama. Rekomendasi yang sebelumnya
tercantum di bagian ini kini dicatat sebagai keputusan atau aturan implementasi,
bukan sebagai blocker baru.

### UX-Q01 — RESOLVED — Direct City/Regency discovery

Pengguna yang sudah mengetahui City/Regency dapat memilihnya secara langsung.
Province tidak mandatory dan hanya menjadi filter, level browsing, atau grouping
opsional.

### UX-Q02 — DEVELOPMENT DETAIL / CONFIGURATION RULE

Jika Primary Branch WhatsApp tidak tersedia, gunakan urutan berikut:

1. Branch public telephone bila valid.
2. Central/corporate fallback hanya bila dikonfigurasi dan disetujui secara
   eksplisit.
3. Honest contact-unavailable state bila keduanya tidak tersedia.

Inquiry tidak boleh dialihkan secara diam-diam ke Branch lain. Exact fallback
configuration dan contact details tetap menjadi keputusan development/configuration.

### UX-Q03 — RESOLVED — No active Public Default KPR Scheme

`/kpr/` tetap tersedia dan konten edukasi tetap dapat dibaca. Simulator dibuat
unavailable atau disabled dengan penjelasan yang jelas. Tidak ada perhitungan
dengan asumsi finansial palsu/default. Next action dapat berupa `Cari Rumah` atau
General Contact bila relevan.

### UX-Q04 — NON-BLOCKING / LATER — Location landing content threshold

Jangan mempublikasikan thin atau empty location pages. Threshold editorial yang
lebih rinci dapat ditentukan kemudian dan tidak memblokir User Flow, Design System,
atau Wireframe inti.

### UX-Q05 — RESOLVED — Closed Vacancy presentation

Closed Vacancy boleh mempertahankan public detail page bila masih berguna, tetapi
harus dikeluarkan dari active listing, diberi label **Lowongan Ditutup** atau
setara, dan tidak memiliki application CTA atau jalur application baru. SEO final
untuk halaman closed tetap menjadi keputusan SEO berikutnya.

### UX-Q06 — DEVELOPMENT DETAIL / CONFIGURATION RULE

Jika contextual English translation tidak tersedia, jangan redirect ke English
Home. Tetap di atau kembali ke konten Bahasa Indonesia yang bersesuaian, pertahankan
context, dan informasikan bahwa translation English belum tersedia. Exact
implementation dapat ditentukan kemudian.

### UX-Q07 — RESOLVED — General corporate Contact

`/kontak/` mendukung central/corporate telephone, general corporate email, dan
general contact form. Exact phone number dan email address tetap **TO BE DEFINED**.
General form tidak mewajibkan Project context. Jalur ini berbeda dari Project →
Primary Branch Office → Branch public contact.

Dengan keputusan tersebut, tidak ada User Flow blocker yang tersisa.

---

## 25. Acceptance Criteria

User Flow v1 memenuhi acceptance criteria berikut:

- [x] Pengguna dapat menemukan Project tanpa mengirim personal information.
- [x] Pengguna dapat memilih City/Regency secara langsung; Province bersifat opsional.
- [x] Pengguna dapat mencari dengan Province, City/Regency, dan Project Status.
- [x] Pengguna dapat memulihkan diri dari zero search results.
- [x] Project context dipertahankan melalui contact flow.
- [x] Project inquiry mengikuti Project → Primary Branch Office → Primary Public
      WhatsApp.
- [x] Marketing staff tidak diekspos sebagai default public contact.
- [x] Unit availability tidak menampilkan dua source aktif yang kontradiktif.
- [x] Individual Unit dan manual fallback dibedakan dengan jelas.
- [x] KPR simulator berada di `/kpr/` dan tidak menyiratkan bank approval.
- [x] KPR tetap menyediakan edukasi dan next action saat simulator unavailable.
- [x] Error KPR mencakup incomplete input, invalid value, dan no active scheme.
- [x] Article tetap berfungsi dengan zero, one, atau multiple Project relationships.
- [x] Article update tidak membuat duplicate Article URL.
- [x] Career flow tidak menyimpan applicant record lokal V1.
- [x] No-active dan closed Vacancy memiliki recovery yang jelas.
- [x] Closed Vacancy tidak tampil sebagai Vacancy aktif atau memiliki application CTA.
- [x] Language switching mempertahankan context bila translation tersedia.
- [x] Translation unavailable kembali ke halaman Indonesia yang sama dengan notice.
- [x] Mobile flow memberi akses efisien ke Cari Rumah, status, availability,
      WhatsApp, dan KPR.
- [x] Mobile Project users dapat mengakses contact tanpa kembali ke Home.
- [x] Completed Project tidak secara otomatis dianggap memiliki Unit tersedia.
- [x] General corporate inquiry dibedakan dari Project inquiry.
- [x] General Contact tidak mewajibkan Project context.
- [x] Tidak ada account creation, forced registration, atau UI decision dalam
      dokumen ini.

---

## 26. Conceptual Flow Diagrams

### Primary housing flow

```text
Home
  → Cari Rumah / Perumahan
    → direct City/Regency atau Province opsional, Status bila diperlukan
      → Project results
        → Project Detail
          → House Types / Facilities / Progress
            → Availability
              → KPR atau Project Contact
```

### Project conversion flow

```text
Project Detail
  → Primary Branch Office
    ├── Primary Public WhatsApp → Branch Admin → internal Marketing routing
    ├── public telephone bila WhatsApp unavailable
    ├── approved central/corporate fallback bila configured
    └── honest contact-unavailable state bila tidak ada contact valid
```

### Availability source flow

```text
Individual Unit data exists
  → derived summary
    → individual availability bila relevan
      → Branch confirmation

Individual Unit data belum terdigitalisasi
  → manual summary fallback bila tersedia
    → label perlu konfirmasi
      → Branch confirmation
```

### KPR flow

```text
/kpr/
  → education
    → simulator inputs
      ├── eligible active scheme → estimated result → disclaimer
      └── no active scheme → simulator unavailable → education → Cari Rumah /
          General Contact
```

### Article flow

```text
Search / Social / Artikel / Project
  → Article canonical
    ├── no Project relation → Article remains useful
    ├── one Project relation → related Project Detail
    └── multiple relations → user chooses relevant Project
```

### Careers flow

```text
/karier/
  → active Vacancy listing
    → Vacancy Detail
      → instructions / recruitment email / external URL

Closed Vacancy
  → public detail bila dipertahankan
    → Lowongan Ditutup
      → no application CTA → Karier / active Vacancy lain
```

### Language flow

```text
Indonesian page
  → linked English translation under /en/
    ├── available → same contextual page in English
    └── unavailable → explain + return to same Indonesian page
```

Diagram-diagram ini menjelaskan urutan informasi dan keputusan pengguna. Diagram
ini tidak menetapkan layout, component, visual treatment, atau implementasi teknis.
