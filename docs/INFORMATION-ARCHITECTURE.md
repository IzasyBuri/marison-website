# Information Architecture Marison ID v1

## 1. Informasi Dokumen

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Domain | `marison.id` |
| Dokumen | Information Architecture and Sitemap v1 |
| Status | Final v1 — IA decisions approved |
| Branch | `feat/information-architecture-v1` |
| Tanggal | 22 Oktober 2026 |
| Bahasa dokumen | Bahasa Indonesia |
| Sumber | `docs/PRD.md`, `docs/CONTENT-MODEL.md`, `docs/PROJECT-RULES.md` |

Dokumen ini adalah rancangan IA konseptual. Rekomendasi di dalamnya bukan
keputusan bisnis final dan tidak menetapkan implementasi teknis, routing akhir,
struktur WordPress, plugin, atau cara penyimpanan data.

---

## 2. Tujuan

IA v1 bertujuan membuat struktur publik Marison ID yang mudah dipahami dan
membantu pengguna menemukan rumah yang relevan.

Tujuan utamanya adalah:

1. Menempatkan penemuan perumahan sebagai pengalaman publik utama.
2. Membuat jalur singkat dari lokasi ke proyek, lalu ke branch office yang tepat.
3. Menyediakan konteks yang cukup untuk status proyek, tipe rumah, dan
   ketersediaan unit tanpa menjadikan setiap entitas sebagai halaman publik.
4. Menempatkan KPR, artikel, karier, informasi korporat, dan kontak pada tempat
   yang mudah ditemukan tanpa mengganggu tujuan pembeli rumah.
5. Menentukan batas antara halaman publik, halaman yang hanya dibuat bila memenuhi
   syarat, dan data internal.
6. Menyiapkan struktur yang dapat berkembang di luar Jawa tanpa membuat halaman
   lokasi tipis atau duplikatif.

### Non-goals

Dokumen ini tidak membuat UI, visual mockup, CSS, template, PHP, Custom Post
Type, plugin, konfigurasi SEO, formula finansial, atau keputusan routing teknis.

---

## 3. Prinsip IA

1. **Pengguna mencari rumah terlebih dahulu.** Pengunjung tidak perlu membaca
   halaman profil perusahaan sebelum menemukan proyek.
2. **Proyek adalah pusat perjalanan pembelian.** Lokasi mengarah ke proyek;
   proyek menjelaskan pilihan dan mengarah ke branch office.
3. **Sitemap bukan salinan Content Model.** Entitas internal atau informasi yang
   hanya berguna di dalam proyek tidak otomatis menjadi URL publik.
4. **Satu halaman yang kuat lebih baik daripada banyak halaman tipis.** Konten
   hanya diberi halaman mandiri bila memiliki tujuan pengguna yang jelas.
5. **Discovery dan SEO harus saling mendukung.** Filter membantu pencarian, tetapi
   tidak semua kombinasi filter menjadi halaman yang dapat diindeks.
6. **Kontak publik mengikuti konteks proyek.** Jalur normal adalah Project →
   Primary Branch Office → Primary Public WhatsApp.
7. **Informasi internal tetap internal.** Marketing assignment, lead, dan data
   operasional tidak menjadi navigasi atau halaman publik.
8. **Status dan ketersediaan harus jujur.** Data yang belum tersedia tidak
   ditampilkan seolah-olah ada.
9. **Bahasa Indonesia adalah canonical.** Bahasa Inggris adalah terjemahan yang
   terhubung, bukan situs terpisah.
10. **Mobile-first secara informasi.** Informasi yang membantu keputusan dan
    kontak harus mudah ditemukan pada layar kecil.
11. **Preservasi dengan konteks.** Proyek selesai, unit terjual, dan lowongan
    tertutup dapat dipertahankan bila masih berguna, tetapi statusnya harus jelas.

---

## 4. Prioritas Audiens

| Prioritas | Audiens | Kebutuhan IA utama |
|---|---|---|
| 1 | Pembeli rumah pertama | Menemukan proyek yang sesuai lokasi dan memahami langkah berikutnya |
| 2 | Keluarga muda | Membandingkan konteks proyek, status, tipe rumah, dan ketersediaan dengan cepat |
| 3 | Pekerja/karyawan | Menemukan perumahan yang relevan dan menghubungi branch office melalui ponsel |
| 4 | Prospek KPR subsidi | Memahami KPR, memakai simulasi, dan menemukan proyek yang relevan |
| 5 | Pencari kerja | Melihat lowongan aktif, detail, dan cara melamar |
| 6 | Mitra bisnis | Memahami Marison dan jalur kontak korporat |
| 7 | Peneliti Marison Group | Menemukan cerita, kehadiran, dan rekam jejak perusahaan |

Prioritas audiens tidak berarti audiens sekunder dihilangkan. Artinya, struktur
utama, urutan beranda, dan CTA utama harus tetap melayani calon pembeli rumah.

---

## 5. Proposed Sitemap

### 5.1 Struktur publik V1

```text
Home
├── /perumahan/                         Direktori Perumahan
│   └── /perumahan/[project]/            Detail Project
│       ├── Tipe Rumah (contained)
│       ├── Ketersediaan Unit (contained)
│       ├── Lokasi dan Peta
│       ├── Artikel terkait
│       └── Kontak Primary Branch Office
├── /lokasi/                            Discovery lokasi kontekstual
│   ├── /lokasi/[provinsi]/              Province [conditional]
│   └── /lokasi/[provinsi]/[kota-kabupaten]/  City/Regency [conditional]
├── /kpr/                               Edukasi + simulator dalam satu halaman
├── /artikel/
│   └── /artikel/[article]/              Detail Artikel
├── /tentang-kami/                       Tentang Kami + rekam jejak ringkas
├── /karier/
│   └── /karier/[vacancy]/               Detail Lowongan
├── /kontak/                             Kontak umum/korporat
├── /kebijakan-privasi/
├── /syarat-ketentuan/                   [jika disetujui secara legal]
└── /en/                                 Linked English public content
```

### 5.2 Halaman yang sengaja tidak dibuat

- Tidak ada direktori global `/units/`.
- Tidak ada katalog global `/house-types/`.
- Tidak ada halaman publik untuk Marketing Person/Team atau assignment.
- Tidak ada arsip publik untuk Leads.
- Tidak ada halaman publik untuk KPR Scheme inactive atau konfigurasi admin.
- Tidak ada halaman branch mandiri pada V1.
- Tidak ada halaman untuk setiap kombinasi filter.
- Tidak ada halaman lokasi tanpa proyek relevan atau konten lokasi yang berguna.
- Tidak ada halaman portfolio mandiri; Direktori Perumahan adalah portfolio utama.

---

## 6. Page Purpose Matrix

| Halaman | Audiens utama | Tujuan | CTA utama | CTA sekunder | Indexability | Main navigation? | Key source content |
|---|---|---|---|---|---|---|---|
| Home | Semua, terutama pembeli rumah | Memahami Marison dan memulai discovery | Cari Rumah | Jelajahi berdasarkan lokasi | INDEXABLE | Logo/Home, bukan item terpisah | Proposisi brand, Project, Location, Article, KPR, About, Career |
| Direktori Perumahan | Pembeli rumah, keluarga muda, pekerja | Menemukan dan menyaring proyek | Lihat detail proyek | Pilih lokasi | INDEXABLE | Ya: Cari Rumah | Project, status, Province, City/Regency |
| Hub Lokasi | Pembeli rumah | Memilih wilayah discovery di dalam perjalanan Perumahan | Pilih provinsi/kota | Lihat semua proyek | CONDITIONAL INDEXABLE | Tidak; contextual dalam Perumahan | Location reference, Project |
| Halaman Provinsi | Pembeli rumah dan pencari organik | Memberi konteks area dan daftar proyek yang benar-benar ada | Lihat proyek di provinsi | Pilih kota/kabupaten | CONDITIONAL INDEXABLE | Tidak | Province, curated content, Project terkait |
| Halaman Kota/Kabupaten | Pembeli rumah dengan intent lokasi tinggi | Menampilkan proyek relevan pada area spesifik | Lihat proyek | Ubah lokasi | CONDITIONAL INDEXABLE | Tidak | City/Regency, curated content, Project terkait |
| Detail Project | Pembeli rumah | Menjelaskan proyek dan membantu kontak branch yang tepat | Chat WhatsApp | Lihat ketersediaan unit atau buka KPR | INDEXABLE | Tidak; dicapai dari discovery | Project, House Type, Housing Unit, Facility, Gallery, Branch Office, Article |
| KPR | Prospek KPR dan pembeli rumah | Mengajarkan KPR, menyediakan simulator, menjelaskan hasil, dan memberi disclaimer | Buka simulator di halaman KPR | Baca artikel KPR / Cari Rumah | INDEXABLE | Ya | Public default KPR Scheme, simulator, editorial KPR, Article |
| Arsip Artikel | Pembaca, prospek rumah, pengguna organik | Menemukan konten edukasi, berita, dan update | Baca artikel | Cari Rumah / KPR | INDEXABLE | Ya | Article yang published |
| Detail Artikel | Pembaca | Memberi satu URL canonical untuk sebuah artikel | Baca proyek/KPR terkait | Cari Rumah atau Artikel lain | INDEXABLE bila bernilai dan published | Tidak | Article, optional Project relationship |
| Tentang Kami | Peneliti Marison, mitra, pengunjung umum | Menjelaskan cerita, nilai, kehadiran, dan kredibilitas | Lihat proyek | Kontak / Karier | INDEXABLE | Ya | Company story, values, operating presence, completed Project/status Selesai |
| Kontak | Mitra, pengunjung umum, pemilik intent korporat | Menjelaskan kontak korporat dan perbedaan inquiry umum vs project | Hubungi Marison central/corporate admin | Cari Rumah | INDEXABLE | Tidak; secondary/footer/contextual | Approved corporate contact guidance; Project/Branch context |
| Karier | Pencari kerja | Menjelaskan bekerja di Marison dan menampilkan lowongan | Lihat lowongan | Pelajari Marison | INDEXABLE | Ya | Career content, published Career Vacancy |
| Detail Lowongan | Pencari kerja | Menjelaskan satu posisi dan metode lamaran | Ikuti instruksi lamaran | Lihat lowongan lain | INDEXABLE bila aktif; CONDITIONAL bila closed | Tidak | Career Vacancy, status, instructions/email/external URL |
| Kebijakan Privasi | Semua pengguna formulir | Menjelaskan pemrosesan data dan hak pengguna | Baca kebijakan | Kembali ke halaman asal | INDEXABLE; footer-only | Tidak | Approved privacy policy |
| Syarat dan Ketentuan | Pengguna bila dibutuhkan secara legal | Menjelaskan ketentuan penggunaan | Baca ketentuan | Kembali ke halaman asal | CONDITIONAL INDEXABLE; footer-only | Tidak | Approved legal content |

`Project`, `House Type`, `Housing Unit`, dan `Branch Office` di atas adalah
sumber konten, bukan berarti semuanya memiliki archive/detail URL publik mandiri.

### 6.1 Klasifikasi penempatan halaman

| Kategori penempatan | Halaman/konsep | Alasan |
|---|---|---|
| **A — Main navigation** | Perumahan, KPR, Artikel, Tentang Kami, Karier | Mewakili kebutuhan publik yang berulang dan jalur utama audiens masing-masing |
| **B — Secondary navigation** | Kontak, language switcher, legal links | Penting, tetapi tidak perlu mengambil ruang navigasi utama |
| **C — Contextual page/section** | Cari Rumah sebagai CTA, Hub Lokasi, Detail Project, halaman Province, halaman City/Regency, Detail Artikel, Detail Lowongan, unit, House Type, artikel terkait, rekam jejak | Dicapai dari Home, parent page, atau perjalanan Perumahan; konteks parent membuat informasinya lebih berguna |
| **D — Footer-only** | Kebijakan Privasi, Syarat dan Ketentuan bila diperlukan | Wajib/berguna sebagai referensi publik, tetapi bukan tujuan discovery utama |
| **E — No standalone public page** | Leads, Marketing assignment, Branch internal staff, inactive KPR Scheme, raw Unit archive, global House Type archive | Informasi internal, administratif, atau terlalu bergantung pada parent Project untuk menjadi halaman yang berguna |

Kategori di atas adalah keputusan penempatan IA V1. `Cari Rumah` adalah CTA
utama menuju pengalaman Perumahan, bukan item tambahan pada main navigation.
`Lokasi` tetap contextual dalam discovery Perumahan.

---

## 7. Main Navigation

### 7.1 Desktop — approved

Main navigation V1:

1. **Perumahan** — menuju housing discovery dan Direktori Perumahan.
2. **KPR** — menuju edukasi dan simulator pada satu halaman.
3. **Artikel** — menuju arsip editorial.
4. **Tentang Kami** — menuju profil dan kredibilitas.
5. **Karier** — menuju lowongan.

Primary CTA: **Cari Rumah**.

`Cari Rumah` mengarah ke pengalaman housing discovery/Direktori Perumahan.
`Lokasi` bukan item main navigation V1; lokasi ditemukan melalui Home, Perumahan,
kontrol discovery, dan link kontekstual. `Hubungi Kami` bukan global primary CTA.
Kontak tersedia melalui footer, Tentang Kami, dan CTA kontekstual.

### 7.2 Prinsip navigasi desktop

- Logo kembali ke Home.
- `Cari Rumah` adalah CTA entry point paling jelas untuk tujuan utama.
- `Tentang Kami` tidak ditempatkan sebelum `Perumahan`/`Cari Rumah` dalam prioritas.
- Detail Project dicapai dari Home, Perumahan, lokasi kontekstual, Artikel, dan pencarian.
- Bahasa Indonesia/English tersedia sebagai language switcher konseptual.
- Tidak semua halaman footer atau internal dimasukkan ke main navigation.

---

## 8. Mobile Navigation

Mobile navigation mempertahankan hierarki inti yang sama:

1. Perumahan
2. KPR
3. Artikel
4. Tentang Kami
5. Karier
6. Pilihan bahasa

`Cari Rumah` harus mudah diakses sebagai CTA dalam atau menuju Perumahan. Tidak
ada item mobile-only tambahan untuk Lokasi atau Kontak.

Pada Detail Project, kontak project/WhatsApp harus tetap mudah dijangkau tanpa
mengharuskan pengguna kembali ke menu. Ini adalah prioritas informasi, bukan
keputusan komponen visual tertentu.

Menu mobile tidak perlu menyalin seluruh footer. Link legal tetap berada di
footer atau area informasi sekunder.

---

## 9. Footer Navigation

Footer direkomendasikan memuat kelompok berikut:

### Temukan Rumah

- Perumahan
- Cari Rumah
- Link lokasi atau proyek yang memang memiliki konten

### Pelajari

- KPR
- Artikel
- Tentang Kami
- Karier

### Hubungi

- Kontak
- Kontak project ditampilkan di konteks project, bukan sebagai daftar nomor
  Marketing global

### Legal dan bahasa

- Kebijakan Privasi
- Syarat dan Ketentuan bila telah disetujui
- Bahasa Indonesia / English

Footer tidak boleh menjadi tempat untuk mengekspos Lead, Marketing assignment,
admin branch internal, atau data operasional.

---

## 10. Home Information Hierarchy

Home memiliki fungsi mengantar pengguna ke discovery, bukan menjadi formulir lead
besar. Urutan prioritas konten:

1. **Proposisi brand:** Marison sebagai pengembang perumahan yang dapat dipahami
   dan dipercaya.
2. **Housing discovery:** jalan paling jelas menuju `Cari Rumah`.
3. **Location discovery:** pilihan provinsi/kota yang tersedia dan bermakna.
4. **Featured/relevant projects:** beberapa proyek terpilih, bukan seluruh katalog.
5. **Credibility:** bukti faktual dan ringkas mengenai Marison.
6. **KPR education/simulator:** edukasi singkat dan entry point simulasi.
7. **Articles:** artikel yang membantu keputusan atau memberi konteks proyek.
8. **Careers:** entry point ringkas bagi pencari kerja.
9. **Contact:** jalur kontak umum dan pengingat bahwa project contact tersedia.

**CTA utama:** `Cari Rumah`.

**CTA sekunder:** `Jelajahi berdasarkan lokasi`.

CTA contact dapat muncul setelah konteks discovery tersedia. Formulir besar tidak
boleh mendominasi layar pertama atau meminta data sebelum pengguna menemukan
proyek.

---

## 11. Housing Directory

### Tujuan

Direktori adalah pusat discovery proyek dan harus dapat dipahami tanpa
pengetahuan internal mengenai struktur Marison.

### Kontrol pencarian/filter V1

Filter yang direkomendasikan:

- Province;
- City / Regency;
- Project Status: Akan Datang, Sedang Berjalan, Selesai.

Harga tidak menjadi filter wajib V1. Country tetap ada di model agar ekspansi
dimungkinkan, tetapi Indonesia tidak perlu menjadi langkah navigasi tambahan selama
belum memberi nilai discovery nyata.

### Search/filter control vs SEO indexable page

| Konsep | Fungsi |
|---|---|
| Filter kontrol | Membantu pengguna menyaring hasil secara cepat dalam direktori |
| Halaman lokasi | Halaman editorial/discovery yang dipilih secara sengaja dan hanya dibuat bila bernilai |
| Kombinasi filter | State pencarian; bukan otomatis halaman SEO |

Default-nya, kombinasi filter tidak menjadi halaman indexable. Mesin pencari
diarahkan pada direktori atau landing page lokasi yang dikurasi, bukan ribuan URL
duplikat berdasarkan status dan kombinasi pilihan pengguna.

### Hasil direktori

Setiap kartu/hasil proyek perlu mengantar pengguna memahami minimal nama proyek,
lokasi, status, dan langkah ke detail. Informasi yang tidak tersedia tidak boleh
diisi dengan placeholder yang seolah-olah faktual.

---

## 12. Project Detail

Project Detail adalah halaman terpenting setelah discovery. Hierarki informasi
konseptualnya:

1. **Identitas proyek:** nama, status proyek, lokasi utama.
2. **Keputusan awal:** status, konteks lokasi, CTA kontak branch.
3. **Ringkasan proyek:** deskripsi dan proposisi proyek.
4. **Gallery:** gambar utama dan galeri bila tersedia.
5. **Tipe rumah:** spesifikasi, gambar/denah, dan deskripsi yang dimiliki proyek.
6. **Fasilitas:** fasilitas umum atau khusus proyek dengan konteks yang jelas.
7. **Progress:** current progress percentage dan deskripsi singkat bila tersedia.
8. **Ketersediaan unit:** ringkasan atau daftar unit sesuai sumber data.
9. **Lokasi dan peta:** alamat, konteks area, dan informasi map yang tersedia.
10. **Artikel/update terkait:** artikel canonical yang memiliki relasi Project.
11. **KPR entry point:** tautan ke edukasi atau simulasi, tanpa mengubah halaman
    proyek menjadi halaman finansial.
12. **Kontak branch:** Primary Branch Office, Primary Public WhatsApp, dan telepon
    publik bila ada.

### Jalur kontak

```text
Project
  → tepat satu Primary Branch Office
    → satu Primary Public WhatsApp publik
      → routing internal oleh branch ke Marketing Person/Team
```

Nomor individual Marketing tidak ditampilkan sebagai CTA default. Konteks proyek
harus tetap melekat ketika pengguna menghubungi atau mengirim formulir.

### CTA

- CTA utama: `Chat WhatsApp` melalui Primary Public WhatsApp branch.
- CTA sekunder: `Lihat Ketersediaan` atau `Buka KPR` sesuai konteks.
- Formulir singkat boleh tersedia, dengan field sesuai PRD dan consent yang jelas.

---

## 13. Unit Availability

### Rekomendasi

Availability terutama berada di dalam Detail Project. Tidak dibuat global
`/units/` karena pengguna memilih rumah berdasarkan proyek dan lokasi, bukan
berdasarkan inventaris lintas proyek tanpa konteks.

### Cara tampil publik

Project dapat menampilkan, sesuai kesiapan data:

1. ringkasan status Tersedia, Terbooking, dan Terjual;
2. daftar unit individual yang relevan;
3. site plan interaktif sebagai pengembangan berikutnya.

Jika Individual Housing Unit tersedia, ringkasan harus berasal dari data tersebut.
Jika belum ada inventaris unit digital, ringkasan manual sementara dapat menjadi
fallback yang diberi konteks jelas. Derived summary dan manual summary tidak boleh
bersaing sebagai dua sumber angka untuk inventory yang sama.

Status availability harus disertai pemahaman bahwa konfirmasi lebih lanjut melalui
branch mungkin diperlukan. Data pemilik/pembeli tidak pernah menjadi informasi
publik.

### URL

Unit tidak memerlukan URL standalone V1. Jika detail individual ditampilkan,
detail tersebut tetap berada dalam pengalaman Project, bukan direktori global.

---

## 14. Location Discovery

### Struktur konseptual

```text
Indonesia (konteks saat ini; bukan halaman navigasi wajib)
└── Province
    └── City / Regency
        └── Project
```

Country dipertahankan di model untuk ekspansi, tetapi halaman Country atau menu
`Indonesia` tidak memberi nilai tambahan saat ini.

### Rekomendasi province vs city/regency

Keduanya dapat memiliki landing page, tetapi **hanya secara conditional**:

- Province page berguna untuk discovery area yang lebih luas dan mengelompokkan
  beberapa kota/proyek.
- City/Regency page biasanya lebih dekat dengan intent mencari rumah dan dapat
  mengarahkan langsung ke proyek relevan.
- Halaman hanya indexable bila memiliki proyek yang relevan dan/atau konten lokasi
  yang bermakna, bukan sekadar judul dan daftar kosong.
- Kota tanpa proyek tidak otomatis mendapat halaman indexable.
- Province tanpa proyek atau konten editorial yang memadai juga tidak otomatis
  mendapat halaman indexable.

### Aturan kualitas

Landing lokasi yang dipublikasikan harus memiliki kombinasi yang bermakna dari:

- konteks area yang benar-benar membantu pengguna;
- proyek relevan;
- status atau pilihan proyek yang dapat dipahami;
- tautan ke langkah berikutnya.

Jika tidak memenuhi syarat, lokasi tetap dapat menjadi pilihan filter kontrol tanpa
menjadi URL SEO publik. Jangan membuat mass-generated thin location pages.

---

## 15. KPR

### Struktur V1 — approved

Edukasi KPR dan simulator berada pada **satu halaman utama**:

- `/kpr/` memuat pengantar/edukasi KPR;
- simulator menjadi section atau entry point in-page pada halaman yang sama;
- `/kpr/#simulasi` adalah contoh konseptual anchor, bukan keputusan frontend;
- halaman dapat memuat penjelasan hasil, disclaimer, FAQ/content yang relevan,
  dan artikel terkait.

Tidak ada `/kpr/simulasi/` sebagai halaman wajib V1. Artikel KPR tetap berada di
`/artikel/[article]/` dan dapat ditautkan dari `/kpr/`.

Simulator menggunakan tepat satu PUBLIC DEFAULT SCHEME yang aktif. Scheme inactive
atau konfigurasi historis tidak menjadi halaman publik. Hasil simulasi adalah
estimasi, bukan persetujuan bank. Rumus, bunga, pembulatan, dan skenario tidak
ditetapkan oleh IA ini.

---

## 16. Articles

### Struktur publik

- **Article archive:** `/artikel/` untuk menemukan editorial yang diterbitkan.
- **Article detail:** `/artikel/[article]/` sebagai satu URL canonical per artikel.

Artikel dapat membahas edukasi perumahan, KPR, berita perusahaan, project update,
atau informasi pemilik rumah. Taxonomy final tidak dipaksakan oleh IA; label atau
pengelompokan hanya ditambahkan bila membantu pengguna menemukan konten.

### Relasi dengan Project

Relasi Project bersifat opsional dan dapat berjumlah nol, satu, atau beberapa.

- Artikel edukasi umum dapat berdiri sendiri.
- Project update dapat terkait dengan satu Project.
- Berita regional/perusahaan dapat terkait dengan beberapa Project.

Pada Project Detail, artikel terkait tampil sebagai konteks atau daftar update.
Artikel tetap memakai URL canonical `/artikel/[article]/`; jangan membuat salinan
URL kedua di bawah Project untuk artikel yang sama.

Jika artikel tidak memiliki relasi Project, artikel tetap valid sebagai artikel
mandiri dan diarahkan ke Cari Rumah, KPR, atau artikel relevan bila konteksnya
mendukung.

---

## 17. Careers

### Struktur

- `/karier/` — cerita singkat tentang bekerja di Marison dan daftar lowongan aktif.
- `/karier/[vacancy]/` — detail satu lowongan.

Detail lowongan memuat status, deskripsi yang disetujui, dan salah satu atau lebih
dari application instructions, recruitment email, atau external application URL.

Lowongan tertutup dapat dipertahankan bila masih membantu pencari kerja atau
sejarah konten, tetapi statusnya harus jelas dan CTA lamaran tidak boleh berpura-
pura aktif. Tidak ada applicant dashboard, CV upload system, candidate portal,
atau applicant records pada V1.

---

## 18. About / Tentang Kami / Corporate Information

### Isi Tentang Kami — approved

`Tentang Kami` sebaiknya memuat:

- cerita perusahaan;
- nilai dan cara Marison bekerja;
- kehadiran operasional secara ringkas;
- kredibilitas dan rekam jejak yang dapat dibuktikan;
- tautan ke proyek yang relevan;
- jalur Kontak dan Karier.

Internal staff structure, Marketing assignment, dan hirarki operasional tidak perlu
ditampilkan.

### Portfolio / track record — resolved

Tidak ada halaman Portfolio mandiri pada V1. Direktori Perumahan adalah portfolio
utama. Project yang telah selesai tetap dapat ditemukan dengan status **Selesai**.

Kredibilitas dan rekam jejak korporat dapat diringkas dalam `Tentang Kami` dan
menautkan ke Detail Project canonical. Portfolio mandiri dapat dipertimbangkan
lagi hanya bila muncul kebutuhan bisnis yang berbeda dan nyata.

### Branch Office

Branch Office tidak otomatis mendapat halaman standalone. Informasinya muncul:

- di Detail Project sebagai kontak yang relevan;
- di Kontak/About bila informasi cabang diperlukan untuk konteks umum.

Tidak ada halaman Branch Office standalone V1. Halaman tersebut hanya dapat
dipertimbangkan kembali bila muncul kebutuhan pengguna atau local-SEO yang nyata.

---

## 19. Contact

### Project inquiry

Inquiry yang berasal dari Detail Project mempertahankan konteks:

```text
Project → Primary Branch Office → Primary Public WhatsApp / telephone / form
```

Formulir project menggunakan field minimum PRD: nama, nomor WhatsApp/telepon,
proyek, consent, dan pesan opsional. Assignment Marketing setelah itu tetap
internal.

### General corporate inquiry

`Kontak` melayani pertanyaan umum perusahaan, mitra, atau pengunjung yang belum
memilih proyek. Halaman ini tidak boleh diam-diam mengirim inquiry umum ke branch
project yang salah atau mengekspos nomor personal.

General corporate inquiry diarahkan ke **Marison central / corporate admin contact**.
Nomor telepon, email, dan penanggung jawab korporat masih TO BE DEFINED dan tidak
diinventasikan di dokumen ini. Hal tersebut tidak memblokir struktur IA.

Calon pembeli yang belum memilih proyek diarahkan kembali ke `Cari Rumah`.

---

## 20. Bilingual Structure

### Struktur URL bahasa — approved

Bahasa Indonesia adalah canonical dan tetap berada di root `/`. Bahasa Inggris
berada di bawah `/en/` sebagai linked translation.

- `/` adalah canonical/source experience Bahasa Indonesia.
- `/en/` adalah root pengalaman English yang tertaut ke konten Indonesia.
- Tidak membuat `/id/` pada V1.
- Exact translated English slugs tidak ditetapkan dalam tugas ini. Contoh `/en/...`
  hanya menunjukkan language root.
- Shared structured data seperti status, dimensi, koordinat, relasi, dan nomor
  kontak tetap satu sumber; tidak dipelihara dua kali.

Dokumen ini tidak memilih mekanisme multilingual, redirect teknis, atau plugin.

### Fallback translation

Jika English belum tersedia, jangan membuat copy seolah-olah telah diterjemahkan.
Tampilkan pesan yang jujur dan tautan ke versi Bahasa Indonesia. Language switcher
tidak boleh membawa pengguna ke halaman English kosong atau URL yang tidak ada.

---

## 21. URL Proposal

Proposal berikut adalah contoh struktur human-readable, bukan keputusan routing
final. URL yang sudah diterbitkan harus diperlakukan sebagai aset yang dijaga.

| Konteks | Proposal konseptual | Catatan |
|---|---|---|
| Home Indonesia | `/` | Canonical utama |
| Home English | `/en/` | Linked translation |
| Direktori perumahan | `/perumahan/` | Satu direktori utama |
| Detail project | `/perumahan/[project]/` | Slug manusiawi, tanpa internal ID |
| Hub lokasi | `/lokasi/` | Discovery kontekstual dalam Perumahan; dapat conditional indexable |
| Province | `/lokasi/[provinsi]/` | Hanya bila memiliki nilai nyata |
| City/Regency | `/lokasi/[provinsi]/[kota-kabupaten]/` | Dua tingkat lokasi; hindari nested lebih dalam |
| KPR | `/kpr/` | Edukasi dan entry point |
| Arsip artikel | `/artikel/` | Satu archive |
| Detail artikel | `/artikel/[article]/` | URL canonical tunggal |
| Tentang Kami | `/tentang-kami/` | Cerita, nilai, presence, track record ringkas |
| Portfolio mandiri | Tidak dibuat pada V1 | Direktori Perumahan menjadi portfolio utama |
| Karier | `/karier/` | Landing dan lowongan |
| Detail lowongan | `/karier/[vacancy]/` | Slug posisi, tanpa applicant data |
| Kontak | `/kontak/` | Corporate/general contact |
| Kebijakan Privasi | `/kebijakan-privasi/` | Footer-only |
| Syarat dan Ketentuan | `/syarat-ketentuan/` | Hanya bila legal content disetujui |

Filter direktori dapat memakai state pencarian, tetapi kombinasi filter tidak
otomatis mendapat URL SEO indexable. Internal IDs tidak muncul pada URL publik.
Tidak ada URL duplikat untuk Article yang tampil sebagai Project update.

English mirrors relevant public content under `/en/`; exact translated slugs tidak
ditetapkan dalam tugas ini.

---

## 22. SEO Indexability

### Klasifikasi

| Page/content type | Klasifikasi | Aturan konseptual |
|---|---|---|
| Home | INDEXABLE | Halaman brand dan discovery utama |
| Housing Directory | INDEXABLE | Memiliki tujuan discovery yang nyata |
| Project Detail | INDEXABLE | Halaman project publik yang diterbitkan dan memiliki informasi serta jalur kontak yang valid |
| Location hub | CONDITIONAL INDEXABLE | Hanya bila menjadi discovery yang bernilai, bukan daftar kosong |
| Province landing | CONDITIONAL INDEXABLE | Hanya bila memiliki Project relevan, konteks, atau navigasi yang bermakna |
| City/Regency landing | CONDITIONAL INDEXABLE | Hanya bila memiliki Project relevan, konteks, atau navigasi yang bermakna |
| Filtered search states | NOINDEX / NON-INDEXABLE PUBLIC STATE | State kontrol; bukan halaman SEO otomatis |
| Article archive | INDEXABLE | Arsip editorial yang benar-benar berisi konten published |
| Article detail | INDEXABLE | Bila artikel substantial, published, dan canonical |
| Careers landing | INDEXABLE | Portal publik pencari kerja |
| Active Vacancy detail | INDEXABLE | Lowongan aktif yang memiliki detail dan instruksi lamaran |
| Closed Vacancy detail | CONDITIONAL INDEXABLE | Dapat dipertahankan bila berguna; perlakuan SEO final ditetapkan pada SEO planning |
| KPR | INDEXABLE | Edukasi, simulator, hasil, disclaimer, FAQ, dan artikel terkait dalam satu halaman |
| About / Tentang Kami | INDEXABLE | Informasi resmi perusahaan dan rekam jejak ringkas |
| Portfolio standalone | NOT PUBLIC V1 | Tidak dibuat; Housing Directory dan status Selesai menjadi portfolio utama |
| Contact | INDEXABLE | Halaman publik resmi, bukan landing SEO massal |
| Privacy policy | INDEXABLE | Transparansi publik; footer-only |
| Terms | CONDITIONAL INDEXABLE | Sesuai kebutuhan legal dan konten yang disetujui |
| Thin/empty location states | NOINDEX / NON-INDEXABLE PUBLIC STATE | Jangan mass-generate halaman kosong atau tipis |
| Internal Lead data | NOT PUBLIC | Hanya staf berwenang |
| Marketing assignments | NOT PUBLIC | Tidak ada archive/detail publik atau kontak personal default |
| Branch internal staff information | NOT PUBLIC | Tidak ditampilkan sebagai struktur staf |
| Inactive KPR Scheme management records | NOT PUBLIC | Tidak menjadi public default atau halaman promosi |
| Raw internal Unit management pages | NOT PUBLIC | Tidak ada global Unit directory; public availability berada di Project |
| House Type standalone archive/detail | NOT PUBLIC V1 | Informasi contained di Project |

Indexability adalah keputusan konseptual per tipe halaman. Halaman yang
`CONDITIONAL INDEXABLE` harus melewati pemeriksaan kualitas konten sebelum
dipublikasikan atau diindeks.

---

## 23. Public vs Internal Content

### Publik bila diterbitkan dan relevan

- Project name, status, location, description, gallery, facility, progress;
- House Type information di dalam Project;
- unit reference/status atau availability summary sesuai kebijakan tampilan;
- Branch Office name, address, public telephone, Primary Public WhatsApp;
- informasi KPR dari PUBLIC DEFAULT SCHEME dan disclaimer;
- Article;
- Career Vacancy;
- About, Contact, legal content yang disetujui;
- linked English translation bila tersedia.

### Tidak otomatis menjadi public page

- Leads: nama, nomor, consent, message, source Project, dan routing history;
- Marketing Person/Team dan seluruh assignment internal;
- Branch Admin internal notification atau struktur personel branch;
- KPR Scheme inactive, historical admin configuration, atau parameter yang tidak
  menjadi public default;
- raw Housing Unit management records sebagai archive global;
- data pemilik/pembeli, yang memang tidak termasuk informasi publik;
- approval workflow, access policy, retention data, dan admin records.

Keberadaan konsep dalam Content Model hanya berarti informasi perlu dikelola atau
dirujuk; bukan berarti konsep tersebut harus memiliki sitemap entry.

---

## 24. User Journeys

### 1. Find a home by location

```text
Home atau Perumahan → pilih lokasi melalui discovery → lihat proyek relevan → Detail Project
```

Tidak perlu melewati About atau mengisi lead sebelum melihat proyek.

### 2. Discover Project from Home

```text
Home → Cari Rumah → pilih/filtrasi proyek → Detail Project
```

Featured Project di Home boleh mengantar langsung ke Detail Project.

### 3. View Project and contact Branch

```text
Detail Project → pahami status/lokasi/unit → WhatsApp/telepon/form → Primary Branch
```

Branch menerima konteks project dan melakukan routing internal. Pengguna tidak
perlu memilih Marketing Person.

### 4. Understand KPR and try simulation

```text
KPR atau Detail Project → buka `/kpr/` → edukasi + simulator → baca disclaimer → hasil estimasi
```

Simulator tidak boleh menyiratkan persetujuan bank.

### 5. Read Article → discover relevant Project

```text
Search/Home/Artikel → Detail Artikel → related Project → Detail Project → kontak branch
```

Artikel yang tidak memiliki Project tetap memiliki jalur ke Cari Rumah atau KPR
bila relevan.

### 6. Find a job and apply

```text
Home/Footer/Karier → daftar lowongan → Detail Lowongan → instruksi/email/external URL
```

Tidak ada candidate portal atau upload CV internal V1.

### 7. Learn about Marison

```text
Home/Footer → Tentang Kami → cerita/nilai/rekam jejak → proyek atau Kontak
```

Jalur ini tersedia untuk pengguna yang ingin meneliti perusahaan, tetapi tidak
menjadi prasyarat untuk menemukan rumah.

---

## 25. Mobile Priorities

Informasi berikut harus tetap mudah ditemukan pada perangkat mobile:

1. **Housing search:** `Cari Rumah` dan `Perumahan` menjadi entry point yang jelas.
2. **Project location:** lokasi, alamat, dan peta tidak tersembunyi setelah konten
   yang tidak membantu keputusan.
3. **Project status:** Akan Datang, Sedang Berjalan, atau Selesai harus mudah
   dikenali.
4. **Unit availability:** ringkasan/list status tampil dengan konteks sumber dan
   kebutuhan konfirmasi.
5. **WhatsApp:** CTA menuju Primary Public WhatsApp branch harus mudah dijangkau
   dari Detail Project.
6. **KPR simulator:** simulator harus mudah ditemukan di halaman `/kpr/` dan
   dapat dirujuk dari Project bila relevan; tidak ada halaman simulator terpisah.
7. **Navigation:** menu, language switcher, dan jalur kembali ke discovery tidak
   boleh mengharuskan zoom atau horizontal scrolling.

Prioritas ini menentukan urutan dan akses informasi, bukan desain visual atau
komponen tertentu.

---

## 26. Empty / Fallback States

| Kondisi | Perilaku konseptual |
|---|---|
| Project belum memiliki data Unit terdigitalisasi | Tampilkan availability summary manual bila disediakan dan labeli sebagai informasi yang perlu dikonfirmasi; jika tidak ada, jelaskan bahwa detail unit belum tersedia dan arahkan ke branch |
| Project belum memiliki gallery | Jangan membuat gallery kosong; tampilkan overview dan informasi tersedia tanpa foto palsu |
| Tidak ada Project pada lokasi terpilih | Tampilkan pesan jujur, opsi memperluas ke Province/City lain, hapus filter, dan link ke semua perumahan; jangan membuat halaman SEO kosong |
| Vacancy sudah closed | Tampilkan status closed; sembunyikan CTA lamaran yang tidak aktif; tawarkan lowongan lain atau halaman Karier |
| Article tidak memiliki relasi Project | Tampilkan sebagai artikel mandiri dan tautkan ke KPR/Cari Rumah hanya bila relevan |
| English translation belum tersedia | Jelaskan bahwa konten belum tersedia dalam English dan sediakan link ke versi Indonesia; jangan membuat terjemahan palsu atau halaman kosong |
| Project tidak memiliki gallery, unit, atau progress | Jangan mengarang nilai; gunakan bagian yang tersedia dan tetap prioritaskan status, lokasi, dan kontak yang valid |
| Project tidak memiliki jalur kontak publik yang valid | Jangan menjanjikan CTA WhatsApp yang salah; tandai sebagai masalah publikasi/data dan sediakan fallback kontak yang telah disetujui bila ada |

Fallback harus membantu langkah berikutnya tanpa menyamarkan kekurangan data.

---

## 27. IA Decisions Required — Resolved

Semua keputusan IA yang sebelumnya ditandai unresolved telah diselesaikan melalui
human review dan berlaku untuk V1.

### IA-01 — Portfolio / track record — RESOLVED

Tidak ada Portfolio standalone pada V1. Direktori Perumahan adalah portfolio utama;
Project yang telah selesai tetap dapat ditemukan dengan status **Selesai**.
Rekam jejak korporat diringkas dalam `Tentang Kami` dan menautkan ke Detail
Project canonical.

### IA-02 — URL language strategy — RESOLVED

Bahasa Indonesia canonical berada di `/`. Bahasa Inggris berada di `/en/` sebagai
linked translation. Tidak ada `/id/` pada V1; exact translated English slugs belum
ditetapkan dalam tugas ini.

### IA-03 — Province vs City/Regency landing pages — RESOLVED

Province dan City/Regency landing pages dapat ada secara conditional bila memberi
nilai pengguna. Tidak ada mass-generated location pages; empty/thin states tidak
menjadi indexable.

### IA-04 — Branch Office standalone pages — RESOLVED

Tidak ada Branch Office standalone page V1. Branch muncul dalam Project context,
`Kontak`, atau corporate context bila sesuai. Standalone page hanya dapat
dipertimbangkan kembali jika ada kebutuhan pengguna atau local-SEO yang nyata.

### IA-05 — KPR calculator page structure — RESOLVED

Edukasi KPR dan simulator berada pada satu halaman `/kpr/`. `/kpr/simulasi/`
bukan halaman wajib V1; in-page section atau anchor dapat dipertimbangkan tanpa
menetapkan implementasi frontend.

### IA-06 — General Contact routing — RESOLVED

Project inquiry mengikuti Project → Primary Branch Office → Primary Public
WhatsApp. General corporate inquiry menuju Marison central/corporate admin.
Nomor, email, dan penanggung jawab corporate masih TO BE DEFINED; detail tersebut
tidak memblokir IA.

### IA-07 — Main navigation split for Lokasi — RESOLVED

Lokasi bukan main-navigation item V1. Lokasi ditemukan melalui Home, Perumahan,
kontrol discovery, dan link kontekstual.

### Ringkasan status

| Keputusan | Status |
|---|---|
| Portfolio structure | RESOLVED |
| URL language strategy | RESOLVED |
| Province vs City/Regency landing concept | RESOLVED |
| Branch Office standalone pages | RESOLVED |
| KPR simulator page structure | RESOLVED |
| General Contact routing concept | RESOLVED; detail kontak belum diisi |
| Location main-navigation placement | RESOLVED |

Tidak ada IA decision blocker yang tersisa untuk V1.

---

## 28. Open Questions

Pertanyaan berikut masih relevan terhadap IA publik, tetapi tidak memblokir V1:

1. Apa kriteria editorial minimum dan proses persetujuan agar Province atau
   City/Regency page dianggap meaningful dan conditional indexable?
2. Pada tahap SEO planning, bagaimana perlakuan akhir untuk halaman Vacancy yang
   sudah closed tetapi tetap dipertahankan?
3. Apakah nanti muncul kebutuhan pengguna atau local-SEO yang cukup kuat untuk
   membuat Branch Office page standalone?
4. Apakah kebutuhan bisnis masa depan membuat Portfolio, House Type, atau Unit
   memerlukan discovery mandiri yang belum dibutuhkan pada V1?

### Detail non-IA yang dicatat di dokumen lain

Pertanyaan berikut tidak mengubah sitemap atau navigasi V1 dan bukan IA blocker:

- pemilik dan frekuensi pembaruan Project/Unit;
- detail admin permissions dan approval workflow;
- lead retention, access policy, dan privacy governance;
- KPR permissions dan pengelolaan parameter;
- editorial workflow dan kepemilikan terjemahan;
- nomor telepon, email, dan penanggung jawab corporate contact;
- public pricing, target metrics, map provider, dan brand final.

---

## 29. Acceptance Criteria

IA v1 final memenuhi checklist berikut:

- [ ] Satu jalur utama Home → discovery → Project → Branch contact dijelaskan.
- [ ] Main navigation V1 adalah Perumahan, KPR, Artikel, Tentang Kami, dan Karier.
- [ ] `Cari Rumah` adalah primary CTA dan `Lokasi` bukan main-navigation item.
- [ ] Public pages dibedakan dari entity/data internal.
- [ ] Housing directory menggunakan Province, City/Regency, dan Project Status
      sebagai konsep filter tanpa menjadikan harga filter wajib.
- [ ] Filter control dibedakan dari SEO indexable landing page.
- [ ] Project Detail memiliki hierarki identitas, status, lokasi, detail proyek,
      availability, dan kontak branch.
- [ ] Unit berada terutama di Project dan tidak memiliki global `/units/`.
- [ ] House Type berada di Project dan tidak memiliki katalog global.
- [ ] Location pages bersifat conditional dan tidak menghasilkan thin pages massal.
- [ ] Country dipertahankan secara konseptual tanpa menjadi navigasi Indonesia yang
      tidak perlu.
- [ ] Tidak ada Portfolio standalone; Direktori Perumahan dan status Selesai menjadi
      portfolio utama, dengan ringkasan kredibilitas di Tentang Kami.
- [ ] KPR memiliki edukasi, simulator, penjelasan hasil, disclaimer, dan content
      terkait dalam satu halaman `/kpr/`.
- [ ] Article archive/detail dan relasi Article–Project tidak membuat duplicate URL.
- [ ] Careers landing/listing/detail mendukung instruksi/email/external URL tanpa
      applicant portal.
- [ ] About tidak mengekspos struktur internal dan Branch standalone tidak dibuat
      tanpa alasan pengguna.
- [ ] General Contact dibedakan dari Project contact dan diarahkan ke Marison
      central/corporate admin tanpa mengarang detail kontak.
- [ ] Bilingual strategy menetapkan canonical Indonesia di `/` dan English di `/en/`.
- [ ] URL proposal manusiawi, tidak memakai internal ID, dan tidak dianggap routing
      final.
- [ ] Indexability diklasifikasikan untuk page type utama dan data internal.
- [ ] User journeys, mobile priorities, dan fallback states terdokumentasi.
- [ ] Tidak ada keputusan implementasi WordPress, PHP, template, plugin, UI, atau
      CSS di dalam dokumen ini.

---

## 30. Conceptual Sitemap Diagram

```text
marison.id/
├── /                                  Home — INDEXABLE
├── /perumahan/                        Perumahan / Housing Directory — INDEXABLE
│   └── /perumahan/[project]/          Project Detail — INDEXABLE
├── /lokasi/                           Location discovery contextual — CONDITIONAL
│   ├── /lokasi/[provinsi]/            Province — CONDITIONAL INDEXABLE
│   └── /lokasi/[provinsi]/[kota-kabupaten]/  City/Regency — CONDITIONAL INDEXABLE
├── /kpr/                              KPR education + simulator — INDEXABLE
├── /artikel/                          Article archive — INDEXABLE
│   └── /artikel/[article]/             Article Detail — INDEXABLE bila bernilai
├── /tentang-kami/                     Tentang Kami — INDEXABLE
│   └── [rekam jejak ringkas]          Section; bukan Portfolio standalone
├── /karier/                           Careers — INDEXABLE
│   └── /karier/[vacancy]/             Active Vacancy — INDEXABLE
├── /kontak/                           General Contact — INDEXABLE
├── /kebijakan-privasi/                Privacy — footer-only
├── /syarat-ketentuan/                 Conditional legal — footer-only
└── /en/                               English linked translation
    └── [translated equivalents]

Internal only / no public archive:
  Leads · Marketing assignments · Branch internal staff · inactive KPR Schemes
  raw Unit management records · applicant records · admin configuration
```

Diagram ini adalah struktur informasi dan hubungan discovery. Diagram ini tidak
menentukan implementasi teknis routing.
