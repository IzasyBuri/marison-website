# Wireframes Core Marison ID v1

## 1. Informasi Dokumen

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Domain | `marison.id` |
| Dokumen | Core Public Wireframes v1 |
| Status | Final — human review selesai |
| Branch | `feat/core-wireframes-v1` |
| Tanggal | 22 Oktober 2026 |
| Sumber | `docs/PRD.md`, `docs/CONTENT-MODEL.md`, `docs/INFORMATION-ARCHITECTURE.md`, `docs/USER-FLOWS.md`, `docs/DESIGN-SYSTEM.md`, `docs/PROJECT-RULES.md` |
| Bahasa dokumen | Bahasa Indonesia |
| Cakupan | Homepage, `/perumahan/`, `/perumahan/[project]/` |

Dokumen ini mendeskripsikan struktur low-fidelity untuk tiga pengalaman publik inti.
Diagram menggunakan ASCII untuk menjelaskan urutan dan grouping informasi, bukan
ukuran pixel, visual final, CSS, HTML, PHP, template WordPress, atau implementasi
komponen produksi.

Semua copy contoh yang ditulis di antara `[kurung siku]` adalah **PLACEHOLDER COPY**,
bukan copy marketing Marison yang telah disetujui.

---

## 2. Purpose

Wireframe v1 harus membantu human reviewer menjawab:

- informasi apa yang muncul;
- urutan informasi yang paling membantu keputusan;
- action utama pada setiap konteks;
- perubahan struktur pada smartphone;
- perilaku ketika data kosong, belum digital, atau tidak tersedia;
- cara pengguna berpindah dari discovery ke Project dan Branch contact.

### Tujuan pengguna utama

```text
Home / Perumahan
  → pilih City/Regency atau Province opsional
    → lihat Project yang relevan
      → pahami Project, status, House Type, dan availability
        → lanjut ke KPR, cek Unit, atau hubungi Branch
```

### Non-goals wireframe

- tidak membuat visual mockup polished;
- tidak menentukan ukuran final, warna final, spacing final, atau animasi;
- tidak membuat halaman About, KPR, Article, Career, atau Contact secara penuh;
- tidak membuat global Unit directory atau standalone House Type page;
- tidak menambahkan filter harga, kamar, luas, gaji, atau financing;
- tidak membuat lead form sebagai entry point utama Homepage;
- tidak membuat fitur Phase 2 seperti favorit, akun, comparison, atau site plan interaktif.

---

## 3. Wireframe Principles

1. **Discovery before personal data.** Pengguna dapat mencari dan membaca Project
   sebelum mengirim lead.
2. **Project sebagai konteks pembelian.** House Type, Unit, KPR entry, lokasi, dan
   contact dibaca dalam konteks Project, bukan sebagai katalog yang terpisah.
3. **City/Regency dapat dipilih langsung.** Province adalah pilihan opsional dan
   tidak menjadi gerbang wajib.
4. **Satu primary action per konteks.** `Cari Rumah` menjadi CTA global; `Chat
   WhatsApp` menjadi conversion CTA pada Project.
5. **Project Status bukan Unit Status.** Tahap Project dan availability Unit selalu
   diberi label serta treatment yang berbeda.
6. **Availability harus jujur.** Derived summary dari Unit individual dan manual
   fallback tidak pernah ditampilkan sebagai dua sumber yang bersaing.
7. **Tidak ada harga publik sebagai syarat.** Card dan detail tetap berguna tanpa
   harga.
8. **Contact mengikuti Branch.** Jalur publik adalah Project → Primary Branch Office
   → Primary Public WhatsApp; individual Marketing tidak ditampilkan.
9. **Mobile-first secara informasi.** Lokasi, status, availability, dan contact
   tetap mudah ditemukan tanpa kembali ke Homepage.
10. **State lebih penting daripada dekorasi.** Empty, unavailable, loading, dan
    error state menjelaskan kondisi dan next action.
11. **Fotografi nyata diutamakan.** Real Project photography digunakan bila ada;
    neutral fallback dipakai bila perlu, bukan foto generik yang menyesatkan.
12. **Low fidelity tetap content-aware.** Wireframe tidak boleh menyembunyikan
    kebutuhan teks panjang, terjemahan English, atau data yang tidak lengkap.

### Status vocabulary

| Konteks | Nilai yang boleh digunakan | Makna |
|---|---|---|
| Project Status | Akan Datang, Sedang Berjalan, Selesai | Tahap atau lifecycle Project |
| Unit Status | Tersedia, Terbooking, Terjual | Kondisi Unit atau ringkasan availability |

Project Status dan Unit Status tidak boleh saling mengisi ketika salah satunya tidak
tersedia. `Sedang Berjalan` tidak berarti `Tersedia`; `Selesai` tidak berarti
`Terjual` atau otomatis tidak memiliki Unit.

---

## 4. Shared Structure

### 4.1 Shared desktop header

```text
+--------------------------------------------------------------------------------+
| LOGO / HOME | Perumahan | KPR | Artikel | Tentang Kami | Karier | [EN] | Cari Rumah |
+--------------------------------------------------------------------------------+
```

**PURPOSE:** Menyediakan jalur global yang ringkas dan entry point discovery.

**PRIMARY USER QUESTION:** "Saya bisa mulai mencari rumah dari mana?"

**PRIMARY ACTION:** `Cari Rumah` → `/perumahan/`.

**DATA SOURCE:** IA Main Navigation; Design System Header, Button, Text Link.

**EMPTY STATE:** Tidak ada empty state pada navigasi; language fallback harus jujur
  bila halaman English belum tersedia.

**MOBILE NOTE:** Header dipadatkan menjadi Logo, menu trigger, language switcher
  konseptual, dan `Cari Rumah` sebagai action yang tetap mudah ditemukan. Detail menu
  animation tidak ditentukan.

### 4.2 Shared mobile header

```text
+--------------------------------------+
| LOGO                    [Cari Rumah] |
|                         [Menu]       |
+--------------------------------------+
```

Menu konseptual berisi Perumahan, KPR, Artikel, Tentang Kami, Karier, dan bahasa.
Lokasi tidak menjadi item navigation baru; lokasi tetap berada di dalam discovery.

### 4.3 Shared footer

```text
+--------------------------------------------------+
| Temukan Rumah | Pelajari | Hubungi | Legal/Bahasa |
| Perumahan     | KPR      | Kontak  | Privasi      |
| Cari Rumah    | Artikel  |         | English      |
|               | Tentang  |         |              |
|               | Karier   |         |              |
+--------------------------------------------------+
```

Footer bukan tempat untuk Marketing assignment, nomor individual Marketing, Lead,
atau struktur internal Branch.

### 4.4 Shared CTA hierarchy

| Konteks | Primary | Secondary | Tertiary |
|---|---|---|---|
| Global/Home | Cari Rumah | Jelajahi berdasarkan lokasi | Baca artikel / Tentang Kami |
| Directory | Lihat detail Project pada setiap card | Pilih lokasi / filter | Clear filter / kembali |
| Project | Chat WhatsApp | Lihat Ketersediaan; Buka KPR; telepon/form bila relevan | Artikel terkait / kembali ke daftar |

Tidak semua action ditampilkan sebagai button utama. Tidak ada flashing CTA, fake
scarcity, countdown, atau forced registration.

### 4.5 Shared wireframe annotation key

Setiap blok utama di bawah memakai enam field berikut:

- **PURPOSE:** fungsi blok dalam perjalanan pengguna;
- **PRIMARY USER QUESTION:** pertanyaan yang harus dijawab;
- **PRIMARY ACTION:** action utama yang didukung;
- **DATA SOURCE:** konten atau keputusan sumber;
- **EMPTY STATE:** perilaku bila data tidak ada;
- **MOBILE NOTE:** perubahan prioritas atau bentuk pada smartphone.

### 4.6 Shared content rules

- Nama Project, City/Regency, Project Status, dan action detail menjadi minimum
  scanning pada Project Card.
- Public price tidak wajib dan tidak boleh menjadi ruang kosong yang dipalsukan.
- Internal Branch staff dan Marketing assignment tidak tampil.
- Konten Indonesia adalah canonical; English menjadi translation terhubung.
- Judul dan label boleh wrap; jangan mengandalkan fixed-height copy.
- Gambar tanpa source nyata menggunakan neutral fallback atau tidak ditampilkan.
- Struktur mengikuti target aksesibilitas WCAG AA dari Design System: status/error
  tidak hanya dibedakan warna, focus dan label tetap dipertimbangkan, serta body copy
  nyaman dibaca pada smartphone.
- Type scale dan ruang harus menampung Bahasa Indonesia serta English yang dapat lebih
  panjang; jangan mengunci tombol atau status pada copy satu bahasa.

---

## 5. Homepage — Desktop

### 5.1 Homepage purpose dan keputusan urutan

Homepage bukan halaman company-profile tradisional. Urutan yang dipakai adalah:

1. Header dan Hero discovery.
2. Featured/relevant Projects.
3. Location discovery.
4. Credibility + Why Marison sebagai satu blok ringkas.
5. KPR education entry.
6. Article entry.
7. Career entry ringkas.
8. Contact/final CTA yang tidak menjadi form besar.
9. Footer.

Progress Project tidak dibuat sebagai section promosi mandiri; update yang relevan
masuk ke Project Card atau Article entry. Company profile panjang dipindah ke
`Tentang Kami`, bukan ditumpuk di Home.

### 5.2 Desktop structural wireframe

```text
+--------------------------------------------------------------------------------+
| HEADER: Logo | Perumahan | KPR | Artikel | Tentang Kami | Karier | Cari Rumah |
+--------------------------------------------------------------------------------+
| HERO / DISCOVERY                                                               |
| [PLACEHOLDER COPY: Temukan rumah yang sesuai untuk langkah berikutnya]         |
| [Supporting copy singkat tentang Marison dan perumahan]                       |
|                                                                                |
| [REAL MARISON PROJECT PHOTO / neutral fallback]                               |
|                                                                                |
| Cari rumah berdasarkan lokasi                                                  |
| [City / Regency langsung] [Province opsional] [Project Status opsional]        |
| [Cari Rumah]                                                                   |
+--------------------------------------------------------------------------------+
| FEATURED / RELEVANT PROJECTS                                                   |
| [Project Card]       [Project Card]       [Project Card]                       |
| image | status       image | status       image | status                       |
| name  | location     name  | location     name  | location                     |
| [Lihat detail]       [Lihat detail]       [Lihat detail]                       |
| [hingga 3–6 curated Projects sesuai content dan responsive layout]             |
| [Lihat semua perumahan]                                                        |
+--------------------------------------------------------------------------------+
| LOCATION DISCOVERY                                                             |
| Pilih area untuk memulai                                                       |
| [City / Regency choices]                                                       |
| [Jelajahi berdasarkan lokasi]                                                  |
+--------------------------------------------------------------------------------+
| CREDIBILITY + WHY MARISON                                                     |
| 30+ Projects | [operating regions: hanya bila tersedia] | [TO BE DEFINED]       |
| [Why Marison: copy singkat, bukti yang dapat diverifikasi, bukan slogan]       |
| [Tentang Kami]                                                                 |
+--------------------------------------------------------------------------------+
| KPR ENTRY                                                                      |
| [PLACEHOLDER COPY: Pahami KPR sebelum memilih rumah]                          |
| Edukasi + simulator tersedia di /kpr/; hasil adalah estimasi.                  |
| [Pelajari KPR] [Coba Simulasi]                                                 |
+--------------------------------------------------------------------------------+
| ARTICLES                                                                        |
| [Article Card]                  [Article Card]                  [Article Card]  |
| [Baca artikel]                                                                  |
+--------------------------------------------------------------------------------+
| CAREER ENTRY (RINGKAS)                                                         |
| [Temukan peluang kerja di Marison] [Lihat Karier]                              |
+--------------------------------------------------------------------------------+
| FINAL CTA / CONTACT                                                            |
| Belum memilih Project? [Cari Rumah]  | Inquiry umum? [Kontak]                 |
+--------------------------------------------------------------------------------+
| FOOTER                                                                         |
+--------------------------------------------------------------------------------+
```

### 5.3 Hero / housing discovery

**PURPOSE:** Menjelaskan Marison secara singkat dan langsung membuka pencarian
  rumah tanpa lead form.

**PRIMARY USER QUESTION:** "Apakah Marison menyediakan perumahan yang relevan
  bagi saya, dan bagaimana saya mulai mencari?"

**PRIMARY ACTION:** Pilih City/Regency langsung lalu `Cari Rumah`.

**DATA SOURCE:** Project, Location Province, Location City/Regency, Project Status;
  PRD, IA Home hierarchy, User Flow direct location discovery.

**EMPTY STATE:** Jika lokasi belum memiliki Project, tetap izinkan pengguna ke
  Directory umum dan tampilkan recovery setelah submit; jangan mengarang hasil.

**MOBILE NOTE:** Copy headline dipendekkan tetapi tidak dipotong secara fixed.
  Input City/Regency menjadi jalur pertama; Province dan Status dapat berada pada
  kontrol tambahan yang tetap terlihat sebagai opsional.

Hero tidak boleh berisi Name, WhatsApp, Interested Project, consent, atau message.
Lead form baru relevan setelah pengguna memahami Project dan memilih contact path.

### 5.4 Featured / relevant Projects

**PURPOSE:** Memberi contoh jalur cepat ke Project tanpa mengubah featured list
  menjadi seluruh katalog.

**PRIMARY USER QUESTION:** "Project mana yang layak saya buka dan di mana lokasinya?"

**PRIMARY ACTION:** Buka Detail Project dari satu Project Card.

**DATA SOURCE:** Project name, real image, City/Regency, Project Status, dan satu
  supporting context yang benar-benar tersedia.

**EMPTY STATE:** Bila tidak ada Project yang layak dipilih sebagai featured, hilangkan
  blok featured atau arahkan langsung ke Directory; jangan membuat card kosong.

**MOBILE NOTE:** Cards menjadi satu kolom; default wireframe adalah stack vertikal
  dengan `Lihat semua` tidak jauh dari blok.

Guideline content: tampilkan kira-kira **3–6 Project** yang memiliki content valid,
disesuaikan dengan responsive layout dan ketersediaan content. Ini bukan batas teknis
yang mengubah Directory. Homepage tetap curated dan tidak menampilkan seluruh katalog.

### 5.5 Location discovery

**PURPOSE:** Menjadikan lokasi bagian dari housing discovery, bukan main navigation
  terpisah.

**PRIMARY USER QUESTION:** "Area mana yang memiliki Project relevan?"

**PRIMARY ACTION:** Pilih City/Regency langsung atau browse Province secara opsional.

**DATA SOURCE:** Location references dan Project yang benar-benar ada.

**EMPTY STATE:** Jangan tampilkan lokasi sebagai card publik bila tidak memiliki
  Project atau konteks bermakna; pengguna dapat kembali ke semua perumahan.

**MOBILE NOTE:** Tampilkan beberapa pilihan bermakna saja; jangan membuat layar
  berisi daftar semua lokasi.

### 5.6 Credibility + Why Marison

**PURPOSE:** Menjawab kebutuhan trust setelah user memahami jalur housing, tanpa
  mengambil alih Homepage.

**PRIMARY USER QUESTION:** "Mengapa saya dapat mempercayai Marison?"

**PRIMARY ACTION:** Lihat ringkasan bukti atau `Tentang Kami`.

**DATA SOURCE:** Fakta yang disetujui: Marison memiliki lebih dari 30 Project;
  completed/current Projects atau operating regions hanya bila datanya tersedia.

**EMPTY STATE:** Metrik yang belum dikonfirmasi ditulis `TO BE DEFINED` pada
  dokumentasi, atau tidak ditampilkan dalam produk. Jangan mengarang awards, angka
  pelanggan, luas lahan, atau tingkat keberhasilan.

**MOBILE NOTE:** Gabungkan angka/fakta dengan copy singkat; hindari dashboard metrik
  atau deretan angka yang memindahkan discovery terlalu jauh.

### 5.7 KPR entry

**PURPOSE:** Memberi edukasi awal dan jalur ke `/kpr/` tanpa mengubah Home menjadi
  simulator finansial.

**PRIMARY USER QUESTION:** "Apa yang perlu saya pahami sebelum mempertimbangkan KPR?"

**PRIMARY ACTION:** `Pelajari KPR` atau `Coba Simulasi` menuju `/kpr/`.

**DATA SOURCE:** KPR education, PUBLIC DEFAULT SCHEME bila aktif, disclaimer.

**EMPTY STATE:** Jika simulator tidak tersedia atau tidak ada active default scheme,
  pertahankan entry edukasi dan jelaskan simulator unavailable; jangan menampilkan
  hasil angka palsu.

**MOBILE NOTE:** Jadikan entry singkat dan link jelas; jangan menanamkan seluruh
  calculator di Homepage.

### 5.8 Articles, Careers, dan final CTA

**PURPOSE:** Menyediakan jalur sekunder bagi pembaca artikel, pencari kerja, dan
  inquiry umum tanpa mengganggu tujuan housing.

**PRIMARY USER QUESTION:** "Apakah ada informasi lain yang relevan bagi tujuan saya?"

**PRIMARY ACTION:** Baca Article, buka Karier, atau kembali ke `Cari Rumah` sesuai
  konteks.

**DATA SOURCE:** Published Article, active Career Vacancy, dan approved corporate
  contact guidance.

**EMPTY STATE:** Tidak ada Article published → hilangkan atau tampilkan entry yang
  tidak menyesatkan. Tidak ada active Vacancy → jelaskan bahwa belum ada lowongan
  aktif. Contact umum tidak boleh menggunakan nomor Project atau Marketing.

**MOBILE NOTE:** Career cukup satu entry ringkas; Article dibatasi pada pilihan
  yang benar-benar membantu. Final CTA tidak menjadi form besar.

Guideline content: tampilkan kira-kira **3 Article** terbaru atau paling relevan,
diikuti `Lihat Semua Artikel` atau navigasi kontekstual yang setara. Careers tetap
menjadi entry ringan satu blok; daftar lowongan lengkap tetap berada di `/karier/`.

---

## 6. Homepage — Mobile

### 6.1 Mobile structural wireframe

```text
+--------------------------------------+
| LOGO                    [Cari Rumah] |
|                         [Menu]       |
+--------------------------------------+
| HERO                                |
| [Headline pendek]                    |
| [Supporting copy 2–3 baris]          |
| [Foto Project nyata / fallback]      |
| Cari rumah berdasarkan lokasi        |
| [City / Regency]                     |
| [Province opsional]                  |
| [Project Status opsional]            |
| [Cari Rumah]                         |
+--------------------------------------+
| PROJECT PILIHAN / RELEVAN            |
| [Project Card stack]                 |
| image                                |
| Status Project                       |
| Nama + City/Regency                  |
| [Lihat detail]                       |
| [Lihat semua perumahan]              |
+--------------------------------------+
| PILIH AREA                           |
| [City/Regency choice]                |
| [Jelajahi lokasi]                    |
+--------------------------------------+
| MENGAPA MARISON                      |
| 30+ Projects                         |
| [bukti singkat]                      |
| [Tentang Kami]                       |
+--------------------------------------+
| KPR                                  |
| [copy singkat + disclaimer context]  |
| [Pelajari KPR]                       |
+--------------------------------------+
| ARTIKEL PILIHAN                      |
| [3 Article Card terbaru/relevan]     |
| [Lihat Semua Artikel]                |
+--------------------------------------+
| KARIER                               |
| [entry singkat] [Lihat Karier]       |
+--------------------------------------+
| CTA                                  |
| [Cari Rumah] [Kontak]                |
+--------------------------------------+
| FOOTER                               |
+--------------------------------------+
```

### 6.2 Mobile priorities

1. Header tidak mengambil banyak vertical space.
2. Headline dan supporting copy menjelaskan tujuan sebelum foto dekoratif.
3. City/Regency terlihat tanpa membuka Province terlebih dahulu.
4. `Cari Rumah` dapat disentuh dengan nyaman dan tidak bersaing dengan contact CTA.
5. Project Card menampilkan image, status, nama, lokasi, dan detail; metadata lain
   ditunda.
6. Credibility, KPR, Article, dan Karier tidak boleh menghalangi kembali ke
   discovery.
7. Tidak ada sticky promotion banner yang menutup konten.

### 6.3 Homepage mobile annotation

**PURPOSE:** Mengubah Homepage menjadi jalur discovery yang singkat pada smartphone.

**PRIMARY USER QUESTION:** "Bagaimana saya menemukan Project tanpa membaca halaman
  panjang atau mengisi data pribadi?"

**PRIMARY ACTION:** Isi/pilih City/Regency dan tekan `Cari Rumah`.

**DATA SOURCE:** Sama dengan Homepage Desktop; tidak ada data mobile-only baru.

**EMPTY STATE:** Recovery dilakukan di Directory dengan filter yang masih terlihat;
  pengguna tidak dikembalikan ke Home untuk memperbaiki pencarian.

**MOBILE NOTE:** Struktur mobile bukan desktop yang hanya ditumpuk. Section optional
  dapat dihilangkan atau dipendekkan sebelum mengurangi ruang untuk discovery,
  Project identity, status, dan contact.

---

## 7. Homepage Section Audit

### 7.1 Keputusan KEEP / MERGE / MOVE / REMOVE

| Kandidat section | Keputusan | Alasan UX |
|---|---|---|
| Hero + housing discovery | KEEP | Entry paling cepat untuk tujuan utama dan tidak meminta data pribadi |
| Featured/relevant Projects | KEEP | Memberi jalur langsung bagi user yang belum menentukan lokasi |
| Location discovery | KEEP | Lokasi adalah cara utama menemukan Project; Province tidak dipaksakan |
| Marison credibility | MERGE dengan Why Marison | Satu blok trust ringkas mencegah dua section company-profile yang berulang |
| Why Marison | MERGE dengan Credibility | Bukti dan alasan harus singkat serta faktual |
| KPR education/simulator | KEEP sebagai entry | Home hanya memberi orientasi; detail berada di `/kpr/` |
| Recent Project progress | MOVE/MERGE | Update lebih berguna di Project Detail atau Article terkait daripada section global |
| Articles | KEEP secara curated | Sekitar 3 Article terbaru/relevan; detail archive tetap di `/artikel/` |
| Careers | KEEP ringkas | Karier adalah scope V1, tetapi bukan primary audience Home |
| Final Contact | MERGE sebagai CTA ringan | Jangan membuat lead form besar setelah discovery section yang panjang |
| Large company profile | REMOVE dari Home | Detail cerita dan nilai memiliki halaman `Tentang Kami` |
| Semua lokasi | REMOVE | Daftar besar menambah density dan tidak membantu discovery cepat |
| Public price promotion | REMOVE | Harga bukan launch requirement dan dapat membuat hierarchy palsu |

### 7.2 Homepage density decision

Homepage tetap dapat terasa panjang bila semua blok tampil penuh. Default wireframe
adalah delapan tujuan informasi dengan beberapa blok digabung, bukan kumpulan banner.
Featured Projects dibatasi secara editorial sekitar 3–6 item dan Articles sekitar 3
item; keduanya bukan archive penuh:

```text
Discovery → Project → Lokasi → Trust → KPR → Editorial → Karier → Next action
```

Jika data atau konten tidak cukup kuat, section dihilangkan. Kekosongan tidak diisi
dengan card placeholder, stock image, atau angka yang tidak dikonfirmasi.

## 8. Housing Directory — Desktop

### 8.1 Directory purpose

Direktori adalah pusat discovery bagi pengguna yang sudah menyatakan intent housing.
Karena itu, halaman tidak memerlukan Hero dekoratif besar atau company introduction
panjang.

### 8.2 Desktop structural wireframe

```text
+--------------------------------------------------------------------------------+
| HEADER: Logo | Perumahan | KPR | Artikel | Tentang Kami | Karier | Cari Rumah |
+--------------------------------------------------------------------------------+
| BREADCRUMB: Home / Perumahan                                                   |
| H1: Perumahan                                                                  |
| [PLACEHOLDER COPY: Temukan Project berdasarkan lokasi dan status]              |
+--------------------------------------------------------------------------------+
| DISCOVERY CONTROLS                                                             |
| Cari lokasi                                                                    |
| [Search City / Regency langsung]                                               |
| [Province opsional] [Project Status]                                           |
| [Terapkan / lihat hasil] [Clear filter]                                        |
+--------------------------------------------------------------------------------+
| ACTIVE FILTERS                                                                 |
| City/Regency: [x]   Province: [x]   Status: [x]   [Hapus semua]                |
| [Loading / result count: TO BE DEFINED based on actual result]                 |
+--------------------------------------------------------------------------------+
| RESULTS                                                                        |
| [Project Card]          [Project Card]          [Project Card]                 |
| [Project Card]          [Project Card]          [Project Card]                 |
+--------------------------------------------------------------------------------+
| PAGINATION / NEXT RESULTS                                                      |
| [Sebelumnya] [1] [2] [3] [Berikutnya]                                          |
+--------------------------------------------------------------------------------+
| FOOTER                                                                         |
+--------------------------------------------------------------------------------+
```

### 8.3 Directory annotation

**PURPOSE:** Membantu pengguna menyaring Project dengan cepat dan memilih detail
  Project yang relevan.

**PRIMARY USER QUESTION:** "Project Marison mana yang cocok dengan area atau tahap
  yang saya cari?"

**PRIMARY ACTION:** Pilih City/Regency langsung, optional Province/Status, lalu buka
  Project Card.

**DATA SOURCE:** Project, Province, City/Regency, Project Status; User Flow
  Directory; Design System Search Field dan Filter.

**EMPTY STATE:** No results mempertahankan filter dan menawarkan clear filter,
  lokasi lain, perluasan Province, atau semua Project.

**MOBILE NOTE:** Kontrol filter tidak selalu terlihat sebagai panel besar; gunakan
  trigger `Filter` → focused controls → `Terapkan` → result list.

### 8.4 Discovery controls

- **City/Regency:** jalur langsung; pengguna tidak harus memilih Province dulu.
- **Province:** optional untuk browsing area lebih luas atau grouping.
- **Project Status:** Akan Datang, Sedang Berjalan, Selesai.
- **Tidak termasuk:** price, bedrooms, financing, salary, luas, atau filter lanjutan
  yang belum disetujui.

Result count boleh ditampilkan bila dapat dihitung dari hasil aktual. Jika angka
belum tersedia, gunakan copy netral seperti `Project yang sesuai pilihan Anda`,
bukan angka yang dibuat-buat.

### 8.5 Desktop results

Default struktur hasil adalah grid Project Card yang mudah dipindai. List view tidak
diperlukan pada wireframe V1 kecuali data card menjadi terlalu padat. Setiap card
memiliki satu destination utama menuju Project Detail.

**Pagination adalah pola navigasi yang disetujui untuk V1:**

```text
[Sebelumnya] [1] [2] [3] ... [Berikutnya]
```

Pagination dipilih karena predictable, lebih mudah diakses dan dipulihkan, menjaga
orientasi, serta lebih sesuai untuk Directory Project daripada infinite scrolling.
Infinite scrolling tidak digunakan pada V1. Load More dapat dipertimbangkan kemudian
bila analytics memberi alasan kuat; detail implementasinya belum ditentukan.

---

## 9. Housing Directory — Mobile

### 9.1 Mobile structural wireframe

```text
+--------------------------------------+
| LOGO                    [Cari Rumah] |
|                         [Menu]       |
+--------------------------------------+
| [Breadcrumb/back context]            |
| H1: Perumahan                        |
| [Supporting explanation 2–3 baris]   |
| [Filter] [Clear jika aktif]          |
+--------------------------------------+
| ACTIVE FILTER SUMMARY                |
| City/Regency [x]  Status [x]         |
+--------------------------------------+
| RESULT CONTEXT                       |
| [Loading / result count / no result] |
+--------------------------------------+
| PROJECT RESULTS                      |
| [Project Card]                       |
| image                                |
| Status Project                       |
| Nama Project                         |
| City / Regency                       |
| [Lihat detail]                       |
| [Project Card] ...                   |
+--------------------------------------+
| [Sebelumnya] [1] [2] [3] ... [Next]  |
+--------------------------------------+
| FOOTER                               |
+--------------------------------------+
```

### 9.2 Mobile filter interaction

```text
Directory result list
  → [Filter]
    → focused filter controls
      → City/Regency direct OR Province optional
      → Project Status optional
        → [Terapkan]
          → result list dengan filter summary yang terlihat
```

**PURPOSE:** Menghemat ruang layar tanpa menghilangkan kendali filter.

**PRIMARY USER QUESTION:** "Filter apa yang sedang aktif, dan bagaimana saya
  mengubahnya tanpa kehilangan hasil?"

**PRIMARY ACTION:** Buka filter, ubah pilihan, terapkan, dan kembali ke list yang
  telah diperbarui.

**DATA SOURCE:** Filter Directory yang sama dengan desktop.

**EMPTY STATE:** Tampil di area result dengan pilihan recovery langsung; jangan
  memaksa kembali ke Homepage.

**MOBILE NOTE:** Focused filter controls dapat menempati satu layar sementara secara
  konseptual. Filter summary setelah apply selalu terlihat dan dapat dihapus satu
  per satu.

### 9.3 Mobile density rules

- Jangan menampilkan semua metadata Project pada card.
- Jangan membuat filter selalu memakan setengah layar hasil.
- Jangan memaksa urutan Province → City/Regency bila City sudah diketahui.
- Jangan memakai horizontal card carousel sebagai satu-satunya cara melihat hasil.
- Pagination dengan Previous/page numbers/Next harus tetap dapat dipahami dengan satu tangan.

---

## 10. Directory States

### 10.1 Initial state

```text
Perumahan
Temukan Project berdasarkan lokasi dan status.

[City / Regency] [Province optional] [Project Status optional]

Project yang tersedia
[Project Card] [Project Card] ...
```

Tidak ada Province-first gate. Pengguna boleh langsung melihat Project yang tersedia
atau mulai dengan City/Regency.

### 10.2 Filtered state

```text
Filter aktif: City/Regency [x]  Province [x]  Status [x]
Hasil: [actual result context]
[Project Cards yang sesuai]
[Hapus filter]
```

Filter state adalah state pencarian, bukan halaman SEO baru atau URL otomatis untuk
setiap kombinasi.

### 10.3 Loading state

Pertahankan posisi heading, filter summary, dan area hasil. Loading tidak boleh
mengganti semua hasil dengan copy fiktif. Setelah selesai, result list atau error
yang jujur muncul di area yang sama.

### 10.4 No-result state

```text
+----------------------------------------------+
| Tidak ada Project yang sesuai dengan pilihan |
| City/Regency: [selected]                     |
| Status: [selected]                           |
|                                              |
| Coba langkah berikut:                        |
| [Hapus semua filter]                         |
| [Pilih City/Regency lain]                    |
| [Perluas ke Province]                        |
| [Lihat semua Project]                        |
+----------------------------------------------+
```

**PURPOSE:** Membantu pengguna pulih dari hasil kosong tanpa menyalahkan atau
  mengarang Project.

**PRIMARY USER QUESTION:** "Apakah data tidak ada, atau pilihan saya terlalu sempit?"

**PRIMARY ACTION:** Hapus filter atau perluas discovery.

**DATA SOURCE:** Selected filter state dan actual Project query result.

**EMPTY STATE:** State ini sendiri; tidak diisi Project mirip yang tidak cocok.

**MOBILE NOTE:** Recovery actions berada dekat dengan pesan, bukan jauh di footer.

### 10.5 Project data incomplete

Project dengan image, supporting context, atau availability yang tidak ada tetap
dapat muncul selama minimum nama, lokasi, dan Project Status valid. Jangan membuat
placeholder yang tampak seperti fakta. Card boleh memakai neutral fallback image atau
tidak menampilkan image bila image tidak tersedia.

---

## 11. Project Card

### 11.1 Low-fidelity card structure

```text
+----------------------------------------+
| [Real Project image / neutral fallback]|
| [Status Project]                       |
| Nama Project                           |
| City / Regency                         |
| [Satu supporting context bila tersedia]|
|                                        |
| [Lihat detail Project]                 |
+----------------------------------------+
```

### 11.2 Card annotation

**PURPOSE:** Memungkinkan scanning dan pemilihan Project dari Homepage atau
  Directory.

**PRIMARY USER QUESTION:** "Project apa ini, berada di mana, dan apa statusnya?"

**PRIMARY ACTION:** `Lihat detail Project`.

**DATA SOURCE:** Project image, Project name, City/Regency, Project Status, satu
  supporting context yang valid.

**EMPTY STATE:** Tidak ada card bila Project tidak memiliki minimum public identity
  dan location/status yang diperlukan. Missing image memakai fallback netral, bukan
  foto generik yang menyamar sebagai Project.

**MOBILE NOTE:** Urutan wajib image → Project Status → nama → lokasi → context →
  detail. Price, internal contact, seluruh House Type, dan Unit-level detail tidak
  masuk card.

### 11.3 Card content boundaries

| Tampil pada default card | Tidak tampil pada default card |
|---|---|
| Real/fallback image | Individual Marketing contact |
| Project Status | Internal Branch data |
| Nama Project | Semua House Type specification |
| City / Regency | Full Unit inventory |
| Supporting context bila ada | Public price requirement |
| One detail action | Fake availability atau urgency |

Project Status memakai treatment yang berbeda dari Unit Status. Card tidak boleh
menampilkan `Tersedia` hanya karena Project `Sedang Berjalan`.

---

## 12. Project Detail — Desktop

### 12.1 Recommended information sequence

Urutan ini mempertahankan identity dan keputusan awal, lalu memprioritaskan House
Type dan availability sebelum supporting context yang lebih sekunder:

1. Breadcrumb/context.
2. Project hero: nama, Project Status, City/Regency, image, short positioning,
   `Chat WhatsApp`, `Lihat Ketersediaan`.
3. Quick decision summary: lokasi, status, availability source note bila ada.
4. Project overview + gallery.
5. House Types.
6. Unit Availability.
7. Facilities.
8. Current Project progress.
9. Location / Map placeholder.
10. Related Project Update Articles bila relevan.
11. KPR entry ke `/kpr/`.
12. Primary Branch contact dan final CTA.

Availability diletakkan segera setelah House Types karena itu pertanyaan conversion
yang kuat. Facilities, progress, dan related content tetap penting tetapi tidak boleh
mengubur availability atau contact.

### 12.2 Desktop structural wireframe

```text
+--------------------------------------------------------------------------------+
| HEADER                                                                         |
+--------------------------------------------------------------------------------+
| BREADCRUMB: Home / Perumahan / [Project]                                      |
+--------------------------------------------------------------------------------+
| PROJECT HERO                                                                  |
| [REAL PROJECT PHOTO / neutral fallback] | Nama Project                       |
|                                        | [Status Project]                    |
|                                        | City / Regency                      |
|                                        | [Short positioning / description]   |
|                                        | [Chat WhatsApp] [Lihat Ketersediaan]|
+--------------------------------------------------------------------------------+
| QUICK DECISION SUMMARY                                                        |
| Status Project | Lokasi | Availability source / confirmation note              |
+--------------------------------------------------------------------------------+
| OVERVIEW + GALLERY                                                            |
| [Project description]        [Gallery / main image / caption]                 |
+--------------------------------------------------------------------------------+
| HOUSE TYPES                                                                   |
| [House Type Summary] [House Type Summary]                                     |
| type | dimensions | rooms | image/floor plan | description                   |
+--------------------------------------------------------------------------------+
| UNIT AVAILABILITY                                                             |
| [Availability Summary: Tersedia | Terbooking | Terjual]                      |
| [Individual Unit list bila data tersedia]                                    |
| [Manual fallback / belum digital notice bila data tidak tersedia]             |
| [Konfirmasi melalui Branch]                                                   |
+--------------------------------------------------------------------------------+
| FACILITIES                                                                    |
| [Facility] [Facility] [Facility] — hanya yang benar-benar tersedia            |
+--------------------------------------------------------------------------------+
| PROJECT PROGRESS                                                              |
| [percentage bila actual data exists] [short description]                      |
| [Project Update Article link bila tersedia]                                   |
+--------------------------------------------------------------------------------+
| LOCATION / MAP                                                                |
| Address/context                                                               |
| [Map / Location placeholder — provider belum diasumsikan]                    |
+--------------------------------------------------------------------------------+
| RELATED PROJECT UPDATES                                                       |
| [Article Card] [Article Card] — hanya Article canonical yang relevan          |
+--------------------------------------------------------------------------------+
| KPR ENTRY                                                                     |
| [Pelajari KPR] [Coba Simulasi di /kpr/] + estimate disclaimer context         |
+--------------------------------------------------------------------------------+
| PRIMARY BRANCH CONTACT                                                        |
| Project context preserved                                                     |
| Branch public WhatsApp / telephone bila valid                                |
| [Chat WhatsApp] [Telepon] [Form singkat bila diperlukan]                      |
| [Contact unavailable state bila tidak ada jalur valid]                        |
+--------------------------------------------------------------------------------+
| FOOTER                                                                         |
+--------------------------------------------------------------------------------+
```

### 12.3 Project Detail annotation

**PURPOSE:** Membantu pengguna memahami Project dan mengambil langkah berikutnya
  tanpa kehilangan konteks.

**PRIMARY USER QUESTION:** "Project apa ini, berada di mana, statusnya apa, pilihan
  rumah dan availability-nya bagaimana, lalu siapa yang dapat saya hubungi?"

**PRIMARY ACTION:** `Chat WhatsApp` melalui Primary Branch Office.

**DATA SOURCE:** Project, Location, House Type, Housing Unit atau manual fallback,
  Facility, progress, gallery, Article, Primary Branch Office.

**EMPTY STATE:** Hilangkan blok tanpa data dan jelaskan data penting yang belum ada;
  jangan mengisi dengan nilai buatan. Contact mengikuti telephone/fallback/
  unavailable sequence bila WhatsApp tidak valid.

**MOBILE NOTE:** CTA muncul pada hero; restrained contextual sticky action dapat
  muncul setelah Hero dan beradaptasi atau menghilang pada dedicated Contact section.
  Contact dan availability tetap tersedia dalam normal flow; pengguna tidak harus
  kembali ke Homepage.

### 12.4 Hero / quick decision summary

**PURPOSE:** Menjawab keputusan awal sebelum pengguna membaca seluruh halaman.

**PRIMARY USER QUESTION:** "Apakah Project dan lokasinya relevan bagi saya?"

**PRIMARY ACTION:** `Chat WhatsApp`; `Lihat Ketersediaan` menjadi secondary action.

**DATA SOURCE:** Project name, Project Status, City/Regency, main image, short
  description, valid Project → Branch relationship.

**EMPTY STATE:** Project tidak boleh dipublikasikan dengan identity/status/lokasi
  yang tidak cukup. Missing photo memakai neutral fallback; missing contact memakai
  honest unavailable state atau fallback yang disetujui.

**MOBILE NOTE:** Nama, status, lokasi, dan CTA berada sebelum gallery panjang. Hero
  tidak boleh menjadi layar foto besar yang menunda informasi.

### 12.5 Overview, gallery, facilities, progress

**PURPOSE:** Memberi konteks yang cukup tanpa membuat detail menjadi katalog padat.

**PRIMARY USER QUESTION:** "Seperti apa Project ini, apa yang tersedia, dan bagaimana
  tahap pembangunannya?"

**PRIMARY ACTION:** Lanjut ke House Type atau Availability.

**DATA SOURCE:** Project description, Gallery, Facilities, current progress percentage
  dan optional short progress description, Article updates.

**EMPTY STATE:** Gallery, facility, atau progress yang tidak tersedia dihilangkan;
  Article update hanya muncul bila relasi dan konten published benar-benar ada.

**MOBILE NOTE:** Gallery tidak boleh mendorong availability terlalu jauh. Progress
  ditulis sederhana sebagai nilai saat ini plus deskripsi singkat bila tersedia,
  bukan milestone-management UI.

## 13. Project Detail — Mobile

### 13.1 Mobile structural wireframe

```text
+--------------------------------------+
| LOGO                    [Cari Rumah] |
|                         [Menu]       |
+--------------------------------------+
| [Back/Breadcrumb context]            |
| [Project image / fallback]           |
| Nama Project                         |
| [Status Project]                     |
| City / Regency                       |
| [Short description]                  |
| [Chat WhatsApp]                      |
| [Lihat Ketersediaan]                 |
+--------------------------------------+
| CONTEXTUAL ACTION — setelah Hero    |
| [Chat WhatsApp] [Lihat Ketersediaan] |
| muncul setelah scroll melewati Hero  |
| hilang saat mencapai Branch Contact  |
+--------------------------------------+
| QUICK SUMMARY                        |
| Status | Lokasi | Data availability |
+--------------------------------------+
| OVERVIEW                             |
| [Short description]                  |
| [Gallery, if available]              |
+--------------------------------------+
| HOUSE TYPES                          |
| [Type summary 1]                    |
| [Type summary 2]                    |
+--------------------------------------+
| AVAILABILITY                         |
| Tersedia | Terbooking | Terjual     |
| [Unit list OR manual fallback]       |
| [Konfirmasi ke Branch]               |
| [Chat WhatsApp]                      |
+--------------------------------------+
| FACILITIES                           |
| [Only available facilities]           |
+--------------------------------------+
| PROGRESS                             |
| [current % + short description]      |
+--------------------------------------+
| LOCATION / MAP                       |
| [Address + Map/Location placeholder] |
+--------------------------------------+
| RELATED ARTICLES (optional)          |
| [Article Card]                       |
+--------------------------------------+
| KPR ENTRY                            |
| [Pelajari KPR]                       |
+--------------------------------------+
| BRANCH CONTACT                       |
| Project context                      |
| [Chat WhatsApp] [Telepon]            |
| [Short form if needed]               |
+--------------------------------------+
| FOOTER                               |
+--------------------------------------+
```

### 13.2 Mobile contact pattern recommendation

**Approved V1:** gunakan restrained contextual sticky action pada mobile. Sticky
action tidak muncul pada initial page load. Hero tetap menjadi area identity yang
jelas terlebih dahulu.

1. Setelah user scroll melewati Hero, sticky action dapat muncul secara kontekstual.
2. Primary sticky action adalah `Chat WhatsApp`.
3. Secondary sticky action adalah `Lihat Ketersediaan`.
4. Sticky action tidak boleh menutupi House Type, status, availability, location,
   atau content penting dan tidak boleh menjadi visual dominan.
5. Saat user mencapai dedicated Project Contact section, sticky action beradaptasi
   atau menghilang agar tidak menciptakan duplicate CTA yang bersaing.
6. Hero tetap memiliki CTA normal, dan Primary Branch contact tetap hadir di normal
   flow. Sticky bukan jalur contact baru.

Public WhatsApp tetap mengikuti Project → Primary Branch Office → Primary Public
WhatsApp. Individual Marketing contact tidak pernah dimasukkan.

### 13.3 Mobile Project Detail annotation

**PURPOSE:** Memastikan pengguna mobile dapat memahami Project, memeriksa
  availability, dan menghubungi Branch tanpa excessive backtracking.

**PRIMARY USER QUESTION:** "Apakah Project ini relevan, Unit-nya bagaimana, dan
  bagaimana saya menghubungi pihak yang benar?"

**PRIMARY ACTION:** `Chat WhatsApp` pada hero atau contact context.

**DATA SOURCE:** Sama dengan desktop; tidak ada ringkasan mobile yang boleh berbeda
  dari source Project.

**EMPTY STATE:** Section yang tidak memiliki data dihilangkan atau diganti notice
  jujur; availability tetap menampilkan source note/fallback.

**MOBILE NOTE:** Hero dipadatkan, House Type tidak memuat semua detail sekaligus,
  availability diberi ruang yang mudah dipindai, dan contextual sticky action hanya
  muncul setelah Hero serta menghilang/beradaptasi di dedicated Contact section.

---

## 14. Project Status Variants

Project Status selalu tampil dekat identity Project dan memakai treatment yang
berbeda dari Unit Status. Variant berikut mengubah emphasis dan CTA, bukan membuat
status baru.

### 14.1 Akan Datang

```text
Nama Project
[Status Project: Akan Datang]
City / Regency
Overview dan informasi yang sudah tersedia

Availability: belum tersedia / belum dapat dikonfirmasi
[Pelajari Project] [Tertarik? Hubungi Branch bila contact valid]
```

**PURPOSE:** Menjaga Project tetap berguna walau data Unit belum lengkap.

**PRIMARY USER QUESTION:** "Apa Project ini dan bagaimana saya dapat mengetahui
  perkembangannya?"

**PRIMARY ACTION:** Pelajari Project atau contact Branch bila jalur valid.

**DATA SOURCE:** Project identity, location, status, available overview, optional
  contact.

**EMPTY STATE:** Jangan menampilkan `Tersedia` atau angka Unit yang tidak ada.

**MOBILE NOTE:** Status dan notice keterbatasan data harus terlihat sebelum section
  panjang.

### 14.2 Sedang Berjalan

```text
Nama Project
[Status Project: Sedang Berjalan]
Progress: [percentage bila tersedia] + short description
House Types / Availability bila source tersedia
[Chat WhatsApp] [Lihat Ketersediaan]
```

**PURPOSE:** Menjelaskan tahap pembangunan dan langkah keputusan yang aktif.

**PRIMARY USER QUESTION:** "Bagaimana perkembangan Project dan apakah ada Unit yang
  dapat saya tanyakan?"

**PRIMARY ACTION:** `Lihat Ketersediaan` atau `Chat WhatsApp`.

**DATA SOURCE:** Project Status, current progress, House Type, derived Unit summary
  atau manual fallback.

**EMPTY STATE:** Progress dan Unit yang tidak tersedia tidak dibuat-buat; Project
  tetap dapat menampilkan overview, location, dan contact valid.

**MOBILE NOTE:** Progress tidak mengalahkan availability dan CTA.

### 14.3 Selesai

```text
Nama Project
[Status Project: Selesai]
City / Regency
Rekam jejak / overview historis

Unit availability: hanya bila data valid
[Pelajari Project] [Contact bila masih relevan]
```

**PURPOSE:** Mempertahankan Project sebagai track record tanpa memberi kesan sales
  aktif yang tidak didukung data.

**PRIMARY USER QUESTION:** "Apa nilai informasi Project ini dan apakah ada alasan
  untuk menghubungi Marison?"

**PRIMARY ACTION:** Pelajari Project; contact hanya bila jalur dan kebutuhan valid.

**DATA SOURCE:** Project Status Selesai, Project content, valid Unit/Branch data.

**EMPTY STATE:** Jangan mengasumsikan Unit habis, dan jangan menampilkan CTA
  availability aktif bila tidak ada source.

**MOBILE NOTE:** Label Selesai harus terbaca sebelum CTA agar tidak tertukar dengan
  Project yang sedang dipasarkan.

---

## 15. House Type Presentation

House Type tetap contained di Project Detail. Tidak ada standalone House Type page
atau global catalog V1.

### 15.1 Desktop structure

```text
+--------------------------------------------------------------+
| HOUSE TYPES                                                   |
| [Type Summary]                                                |
| Type name | building area | land area | bedrooms | bathrooms |
| floors | image/floor plan | short description | [Lihat detail]|
|                                                              |
| [Type Summary] ...                                           |
+--------------------------------------------------------------+
```

### 15.2 Mobile structure

```text
HOUSE TYPES
[Type name]
[Image / floor plan bila ada]
Luas bangunan | Luas tanah
Kamar tidur | Kamar mandi | Lantai
[Lihat Detail]
[Additional description/specifications bila berguna]
```

### 15.3 House Type annotation

**PURPOSE:** Membantu pengguna membandingkan pilihan tipe rumah dalam satu Project
  tanpa berpindah halaman.

**PRIMARY USER QUESTION:** "Tipe rumah apa yang tersedia di Project ini, dan apakah
  spesifikasinya sesuai kebutuhan saya?"

**PRIMARY ACTION:** Baca ringkasan tipe lalu lanjut ke Availability atau contact.

**DATA SOURCE:** House Type yang dimiliki Project: nama, luas bangunan, luas tanah,
  bedrooms, bathrooms, floors, image/floor plan, short description.

**EMPTY STATE:** Bila Project belum memiliki House Type, tampilkan notice bahwa detail
  tipe belum tersedia dan arahkan ke overview/contact bila valid. Jangan membuat
  tipe default.

**MOBILE NOTE:** Prioritaskan compact summary: Type name, building area, land area,
  bedrooms, bathrooms, number of floors, dan image/floor plan bila berguna. Jangan
  menampilkan semua optional specification atau description pada initial view.
  Gunakan `House Type Summary → Lihat Detail` untuk reveal tambahan bila berguna;
  hindari nested-card complexity dan standalone House Type page.

House Type tidak memerlukan harga publik. Unit yang mereferensikan House Type harus
berasal dari Project yang sama, tetapi aturan data tersebut tidak dijadikan detail
teknis di wireframe.

---

## 16. Unit Availability

Availability selalu berada dalam Project context. Setiap status memakai teks
terbaca dan marker non-color sesuai Design System:

- **Tersedia:** Green;
- **Terbooking:** Amber / warm orange;
- **Terjual:** Neutral Gray, bukan red/error.

### 16.1 Case A — Individual Unit data exists

```text
+----------------------------------------------------------------+
| KETERSEDIAAN UNIT — data berasal dari Unit individual          |
| Status Unit:                                                   |
| [Green] Tersedia: [derived total]                              |
| [Amber] Terbooking: [derived total]                            |
| [Gray] Terjual: [derived total]                                |
|                                                                |
| Unit yang layak ditampilkan:                                  |
| [Unit reference] [House Type] [Status Unit]                    |
| [Unit reference] [House Type] [Status Unit]                    |
|                                                                |
| Status dapat memerlukan konfirmasi melalui Primary Branch.     |
| [Chat WhatsApp]                                                |
+----------------------------------------------------------------+
```

**PURPOSE:** Menunjukkan availability yang diturunkan dari sumber Unit individual.

**PRIMARY USER QUESTION:** "Berapa atau Unit mana yang tercatat tersedia, terbooking,
  atau terjual?"

**PRIMARY ACTION:** Konfirmasi melalui Branch, bukan menganggap status sebagai
  booking/pembayaran otomatis.

**DATA SOURCE:** Housing Unit individual sebagai source of truth; summary derived.

**EMPTY STATE:** Jika Unit individual ada tetapi belum layak ditampilkan satu per
  satu, tampilkan derived summary saja dan note konfirmasi.

**MOBILE NOTE:** Summary tiga status tampil sebelum list; list Unit dapat diringkas
  atau dihilangkan bila terlalu panjang. Tidak ada global Unit directory.

Derived totals dan manual totals tidak boleh tampil bersamaan.

### 16.2 Case B — Unit inventory belum terdigitalisasi

```text
+----------------------------------------------------------------+
| KETERSEDIAAN UNIT                                              |
| Informasi Unit individual belum terdigitalisasi.               |
|                                                                |
| [Manual availability summary bila tersedia]                    |
| Tersedia: [manual value] | Terbooking: [manual value]          |
| Terjual: [manual value]                                        |
| Label: RINGKASAN MANUAL — PERLU KONFIRMASI                     |
|                                                                |
| [Chat WhatsApp] untuk konfirmasi ke Primary Branch              |
+----------------------------------------------------------------+
```

**PURPOSE:** Menyediakan informasi sementara tanpa menyamar sebagai inventory
  individual.

**PRIMARY USER QUESTION:** "Apakah ada ringkasan availability, dan seberapa yakin
  saya dapat menggunakannya?"

**PRIMARY ACTION:** Hubungi Branch untuk konfirmasi.

**DATA SOURCE:** Temporary manual availability summary yang dikelola sebagai fallback.

**EMPTY STATE:** Jika fallback manual juga tidak ada, tulis bahwa detail Unit belum
  tersedia dan arahkan ke contact valid; jangan menampilkan angka `0` secara implisit.

**MOBILE NOTE:** Label manual/fallback diletakkan dekat angka, bukan di footnote
  jauh dari summary.

### 16.3 Availability state rules

| Situasi | Tampilkan | Jangan tampilkan |
|---|---|---|
| Unit individual tersedia | Derived summary dan Unit detail bila layak | Manual summary kedua |
| Unit belum digital, manual summary tersedia | Manual summary dengan label fallback/konfirmasi | Derived total atau klaim individual inventory |
| Tidak ada source availability | Notice no data + contact valid bila ada | Angka nol, angka perkiraan, atau status palsu |
| Project Selesai | Availability hanya bila source valid | Asumsi semua Unit Terjual atau semua tersedia |
| Project Akan Datang | Informasi yang benar-benar tersedia | Klaim Tersedia tanpa source |

---

## 17. Project Contact

### 17.1 Contact route

```text
Project Detail
  → Chat WhatsApp
    → Project's Primary Branch Office
      → Primary Public WhatsApp
        → Branch Admin
          → internal Marketing routing
```

### 17.2 Contact block structure

```text
+--------------------------------------------------------------+
| HUBUNGI BRANCH UNTUK PROJECT INI                              |
| Project context: [Nama Project]                               |
| Primary Branch Office: [public branch name bila tersedia]     |
| [Chat WhatsApp] [Telepon]                                     |
|                                                                |
| Jika menggunakan form:                                        |
| [Name]                                                         |
| [WhatsApp / telephone]                                         |
| [Interested Project: preselected, tetap dapat dipahami]       |
| [Optional Message]                                             |
| [Consent checkbox]                                             |
| [Kirim inquiry]                                                |
+--------------------------------------------------------------+
```

### 17.3 Contact annotation

**PURPOSE:** Menghubungkan user dengan pihak yang benar sambil mempertahankan
  Project context.

**PRIMARY USER QUESTION:** "Siapa yang akan menerima pertanyaan saya tentang Project
  ini?"

**PRIMARY ACTION:** `Chat WhatsApp` melalui Primary Branch Office.

**DATA SOURCE:** Project → exactly one Primary Branch Office → Primary Public
  WhatsApp; telephone publik optional; lead fields dari PRD bila form digunakan.

**EMPTY STATE:** WhatsApp invalid → telephone Branch valid → approved central/corporate
  fallback bila dikonfigurasi → honest contact-unavailable state. Jangan silent reroute
  ke Branch lain.

**MOBILE NOTE:** Contact CTA tersedia pada hero dan setelah Availability dalam normal
  flow; contextual sticky action hanya menyediakan `Chat WhatsApp` dan `Lihat
  Ketersediaan` setelah Hero, lalu menghilang atau beradaptasi di Contact section.
  Form menggunakan persistent labels dan tidak menambahkan qualification fields.

Individual Marketing name, number, assignment, dan routing history tidak ditampilkan.
Form hanya muncul setelah contact intent jelas, bukan pada Hero Homepage.

### 17.4 Contact unavailable

```text
Kontak Project belum tersedia saat ini.
Kami belum dapat mengonfirmasi jalur Branch untuk Project ini.

[Telepon Branch bila valid]
[Hubungi Marison secara umum bila approved fallback tersedia]
[Kembali ke Perumahan]
```

Pesan tidak boleh menyamarkan kondisi unavailable sebagai success atau mengarahkan
ke Branch yang tidak berkaitan.

## 18. Reusable Components

Komponen berikut diambil dari vocabulary Design System. Ini adalah identifikasi
struktur untuk tahap berikutnya, bukan implementasi.

| Wireframe block | Reusable component | Klasifikasi | Penggunaan |
|---|---|---|---|
| Global top navigation | Header | NAVIGATION | Semua tiga halaman |
| Smartphone menu | Mobile Navigation | NAVIGATION | Semua tiga halaman mobile |
| Context trail | Breadcrumb | NAVIGATION | Directory dan Project Detail bila membantu |
| Global bottom navigation | Footer | NAVIGATION | Semua tiga halaman |
| Main/secondary action | Button | FOUNDATIONAL | CTA discovery, contact, availability, KPR |
| Inline route | Text Link | FOUNDATIONAL | Article, About, recovery, secondary navigation |
| Status marker | Badge | FOUNDATIONAL | Project Status, Unit Status |
| Hero discovery | Search Field | FORM | Homepage dan Directory |
| Location/status controls | Filter | FORM | Directory dan Home discovery |
| Contact form | Form Field, Select, Checkbox | FORM | Project contact setelah intent |
| Housing result | Project Card | CONTENT | Homepage dan Directory |
| House choice | House Type Summary | CONTENT | Project Detail |
| Availability block | Availability Summary | CONTENT | Project Detail |
| Unit row/status | Unit Status | CONTENT | Project Detail bila Unit data layak |
| Project images | Gallery | CONTENT | Project Detail; optional jika source ada |
| Educational entry | CTA Section | CONTENT | KPR, contact, recovery, Homepage |
| Article teaser | Article Card | CONTENT | Homepage dan Project Detail optional |
| Location choice | Location Card | CONTENT | Homepage bila lokasi bermakna |
| User recovery | Empty State | FEEDBACK | Directory, availability, contact |
| Data warning | Alert / Notice | FEEDBACK | Manual fallback, unavailable, missing data |
| Progress estimate | KPR Result vocabulary only for `/kpr/` | FEEDBACK | Homepage/Project hanya link; tidak embed calculator |

### Reuse boundaries

- Reuse tidak berarti setiap blok harus dibungkus nested card.
- Project Card tidak dipakai untuk menggantikan House Type Summary atau Availability
  Summary.
- Badge `Project Status` dan `Unit Status` tidak boleh berbagi semantics hanya karena
  keduanya bernama badge.
- Gallery boleh tidak dirender bila image source tidak ada.
- Empty State selalu menyebut kondisi dan next action.

---

## 19. Content Density Audit

### 19.1 Homepage

| Level | Content |
|---|---|
| ESSENTIAL | Hero/discovery, curated 3–6 Project entry, location discovery, CTA `Cari Rumah`, header/footer |
| SUPPORTING | Credibility + Why Marison, KPR entry, curated Article entry sekitar 3 item |
| OPTIONAL | Career entry, final general contact reminder, related progress/update teaser |

**Density risk:** Homepage menjadi landing page panjang dengan banyak banner. **Mitigasi:**
merge trust blocks, tampilkan sekitar 3–6 Project dan 3 Article, move detailed progress
to Project/Article, keep Careers lightweight, omit weak optional blocks, dan jangan
menampilkan semua lokasi atau semua Project.

### 19.2 Housing Directory

| Level | Content |
|---|---|
| ESSENTIAL | Heading, short explanation, City/Regency, optional Province, Project Status, active filters, Project Cards, recovery |
| SUPPORTING | Result count, pagination, Breadcrumb |
| OPTIONAL | Intro location context atau curated location entry bila benar-benar membantu |

**Density risk:** Filter terlalu banyak dan card terlalu padat. **Mitigasi:** hanya
tiga filter approved, satu destination per card, dan filter mobile di focused view.

### 19.3 Project Detail

| Level | Content |
|---|---|
| ESSENTIAL | Identity, Project Status, location, overview, House Types bila ada, availability state, Branch contact |
| SUPPORTING | Gallery, facilities, progress, map/location, KPR entry |
| OPTIONAL | Related Articles/Project Updates, extended gallery, extra specifications |

**Density risk:** Detail menjadi katalog panjang atau card di dalam card. **Mitigasi:**
availability diletakkan setelah House Types, supporting content boleh dihilangkan,
dan detail tidak mengulang full description pada setiap section.

### 19.4 Section-count rule

Section bukan target jumlah. Setiap section harus memiliki pertanyaan pengguna dan
next action yang jelas. Jika hanya berisi dekorasi, slogan, atau data yang belum ada,
section tidak masuk wireframe final.

---

## 20. Mobile Priority Audit

### 20.1 Ringkasan lintas halaman

| Halaman | Scroll length | CTA access | Filter usability | Information priority | Image/content density | Touch/text risk |
|---|---|---|---|---|---|---|
| Homepage | Medium; optional blocks dapat dihilangkan | `Cari Rumah` di header, hero, final context | Discovery ringkas; direct City/Regency | Discovery → Project → location → trust | Satu image utama, card terbatas | Headline panjang dan section sekunder |
| Directory | Long bila Project banyak; hasil dapat dipaginasi | Filter dan detail card tetap dekat | Trigger → focused controls → apply | Filter state → Project identity/status/location | Project Card tidak memuat semua metadata | Filter panel terlalu tinggi, card text rapat |
| Project Detail | Long karena informasi lengkap | Chat WhatsApp hero + contextual sticky setelah Hero + Contact section | Tidak ada filter global; availability mudah dipindai | Identity → status/location → House Type → availability → contact | Gallery tidak boleh mengubur availability | Sticky harus restrained, House Type terlalu teknis |

### 20.2 Homepage mobile

- **Scroll length:** jaga medium; Career dan final Contact dapat dipadatkan.
- **CTA access:** `Cari Rumah` terlihat sebelum scroll panjang.
- **Filter usability:** City/Regency langsung; optional controls tidak memblokir.
- **Information priority:** hero dan Project discovery di atas trust/editorial.
- **Image size:** foto membantu trust tetapi tidak menghabiskan layar sebelum input.
- **Content density:** maksimal satu supporting context per Project Card.
- **Text length:** headline boleh wrap; placeholder copy tidak menjadi final copy.
- **Touch interaction:** input dan button nyaman disentuh; tidak ada precision target kecil.

### 20.3 Directory mobile

- **Scroll length:** result list dapat panjang; pagination menjaga orientasi.
- **CTA access:** Filter trigger dan `Lihat detail` tidak tersembunyi.
- **Filter usability:** apply mengembalikan user ke hasil dengan active summary.
- **Information priority:** Project Status dan City/Regency sebelum metadata lain.
- **Image size:** image card cukup untuk identifikasi, bukan hero dekoratif.
- **Content density:** satu Project Card per blok baca; no nested card.
- **Text length:** nama Project dan lokasi wrap dengan aman.
- **Touch interaction:** chip/filter dapat dihapus satu per satu; clear action jelas.

### 20.4 Project Detail mobile

- **Scroll length:** panjang diterima karena detail, tetapi optional gallery/article
  tidak boleh menunda availability dan contact secara tidak wajar.
- **CTA access:** Chat WhatsApp pada hero, contextual sticky setelah Hero, dan Contact section.
- **Filter usability:** bukan fokus utama; Unit Status ditampilkan sebagai summary
  yang mudah dipindai.
- **Information priority:** identity, Project Status, location, House Type,
  availability, Branch.
- **Image size:** real photo mendukung identity; crop/fallback tidak menghapus label.
- **Content density:** House Type memakai compact summary dengan `Lihat Detail`;
  optional specifications, facilities, dan articles dapat dipendekkan.
- **Text length:** notice manual fallback, unavailable, dan disclaimer harus terbaca.
- **Touch interaction:** WhatsApp, telephone, anchor availability, dan form field
  memiliki target nyaman.

### 20.5 Mobile risk priority

Risiko tertinggi adalah Project Detail yang menaruh semua contact hanya di hero atau
footer, dan Directory yang menjadikan filter layar penuh secara permanen. Default
wireframe mengatasi keduanya dengan contextual sticky action yang restrained setelah
Hero, dedicated Contact section, dan focused filter pattern.

---

## 21. Friction Audit

| Friction | Rating | Risiko | Mitigasi wireframe |
|---|---|---|---|
| Hero Homepage langsung meminta data pribadi | HIGH | User berhenti sebelum memahami produk | Hero hanya discovery; form setelah Project/contact intent |
| Province mandatory sebelum City/Regency | HIGH | Langkah mobile tidak perlu dan intent lokasi terhambat | City/Regency direct; Province optional |
| Homepage terlalu panjang | HIGH | Discovery dan CTA utama terkubur | Merge trust, move detailed updates, omit weak optional blocks |
| Project Status disamakan dengan Unit Status | HIGH | User mengira Project berjalan berarti Unit tersedia | Prefix/context, treatment, dan section terpisah |
| Derived dan manual availability tampil bersamaan | HIGH | Angka kontradiktif dan trust turun | Satu active source dengan source note |
| WhatsApp menuju Marketing individual | HIGH | Salah routing dan melanggar public contact rule | Resolve via Primary Branch Public WhatsApp |
| Branch invalid silent reroute | HIGH | Inquiry Project masuk ke Branch yang salah | Telephone → approved central fallback → unavailable |
| Project context hilang saat contact | HIGH | Branch Admin tidak tahu pertanyaan asal | Context Project tampil sebelum WhatsApp/form |
| Contact hanya berada paling atas di mobile | HIGH | User harus backtrack setelah membaca detail | Repeat CTA setelah availability dan contact section normal flow |
| Completed Project terlihat sebagai active sales | HIGH | Status historis salah dipahami | Status Selesai jelas; availability hanya bila valid |
| Filter memenuhi setengah layar mobile | MEDIUM | Hasil sulit dilihat dan backtracking meningkat | Trigger → focused controls → apply → result |
| Project Card terlalu padat | MEDIUM | Scanning gagal terutama di smartphone | Nama, lokasi, status, context tunggal, detail |
| Gallery besar mengubur availability | MEDIUM | User sulit mengambil keputusan | Gallery optional dan diposisikan sebelum/sekitar detail tanpa mengalahkan availability |
| Semua location ditampilkan di Home | MEDIUM | Pilihan berlebihan dan page length bertambah | Curated meaningful locations; Directory sebagai fallback |
| KPR calculator ditanam penuh di Home/Project | MEDIUM | Produk terasa seperti financial dashboard | Entry ke `/kpr/`; simulator tetap satu halaman KPR |
| Article selalu menjadi sales banner | LOW | Nilai editorial hilang | Related Article optional dan canonical |
| Sticky CTA menutupi content | MEDIUM | Membaca status/spec menjadi sulit | Muncul setelah Hero, restrained, tidak menutup content, dan hilang/beradaptasi di Contact |

---

## 22. Open Wireframe Questions

**NONE.** Keputusan material untuk wireframe inti telah diselesaikan melalui human
review:

- mobile Project sticky action menggunakan pola contextual yang restrained;
- Housing Directory V1 menggunakan pagination, bukan infinite scrolling;
- House Type mobile menggunakan compact summary dengan `Lihat Detail`;
- Homepage menampilkan sekitar 3–6 Project dan sekitar 3 Article secara curated.

Map provider, exact copy, source ownership, contact details, dan data update cadence
tetap mengikuti status open atau `TO BE DEFINED` pada dokumen sumber, tetapi tidak
mengubah struktur tiga wireframe inti.

---

## 23. Acceptance Criteria

### Homepage

- [ ] Housing discovery terlihat pada first-screen structure.
- [ ] Homepage menjelaskan siapa Marison secara singkat tanpa menjadi company-profile
      page tradisional.
- [ ] City/Regency dapat dipilih langsung.
- [ ] Province tidak menjadi mandatory first step.
- [ ] Project Status dapat menjadi filter opsional tanpa menambah price filter.
- [ ] Hero tidak meminta Name, WhatsApp, consent, atau lead form besar.
- [ ] `Cari Rumah` adalah primary CTA global.
- [ ] Featured Project card berisi image/source, nama, lokasi, status, supporting
      context terbatas, dan action detail.
- [ ] Credibility hanya memakai angka yang dikonfirmasi; unknown ditandai
      `TO BE DEFINED` dan tidak dibuat-buat.
- [ ] KPR hanya menjadi entry ke `/kpr/`, dengan estimasi/disclaimer context.
- [ ] Featured Projects dibatasi secara curated sekitar 3–6 item, bukan seluruh katalog.
- [ ] Articles dibatasi sekitar 3 item dengan `Lihat Semua Artikel` atau navigasi setara.
- [ ] Careers tetap menjadi entry ringan dan tidak menambah section Homepage baru.
- [ ] Homepage section count diaudit dan tidak menjadi kumpulan banner marketing.
- [ ] Mobile Homepage memiliki struktur yang diprioritaskan, bukan desktop stack tanpa
      keputusan ulang.

### Housing Directory

- [ ] Heading dan explanation ringkas, tanpa oversized decorative Hero.
- [ ] Filter hanya City/Regency, Province optional, dan Project Status.
- [ ] Direct City/Regency selection dapat dilakukan tanpa Province gate.
- [ ] Active filter, clear filter, result context, dan Project Card terlihat.
- [ ] Project Card tidak memuat individual Marketing, internal Branch, atau public
      price requirement.
- [ ] Project Status terbaca dan tidak disamakan dengan Unit Status.
- [ ] No-result state menjelaskan kondisi dan menyediakan clear/expand recovery.
- [ ] Empty result tidak diisi Project yang tidak cocok.
- [ ] Mobile filter mengikuti pola trigger → focused controls → apply → result list.
- [ ] Pagination menjadi pola navigasi Directory V1; infinite scrolling tidak digunakan.
- [ ] Load More hanya menjadi alternatif masa depan berbasis analytics, bukan keputusan V1.

### Project Detail

- [ ] Nama Project, City/Regency, Project Status, image/fallback, dan CTA mudah
      dipahami pada awal halaman.
- [ ] `Chat WhatsApp` adalah primary Project conversion CTA.
- [ ] `Lihat Ketersediaan` adalah secondary Project action.
- [ ] Public contact resolve ke Project → Primary Branch Office → Primary Public
      WhatsApp.
- [ ] Individual Marketing contact tidak ditampilkan.
- [ ] Logical order menjelaskan overview, House Type, availability, facilities,
      progress, location, related content, KPR, dan Branch contact tanpa menutup
      keputusan inti.
- [ ] House Type tetap contained di Project Detail dan memakai field minimum yang
      disetujui.
- [ ] Mobile House Type memprioritaskan compact summary: nama, luas bangunan, luas
      tanah, bedrooms, bathrooms, floors, dan image/floor plan bila berguna.
- [ ] Additional House Type detail hanya muncul melalui `Lihat Detail` bila berguna;
      tidak ada standalone House Type page atau nested-card complexity.
- [ ] Case A individual Unit menunjukkan derived Tersedia, Terbooking, Terjual.
- [ ] Case B manual fallback diberi label dan tidak bersamaan dengan derived totals.
- [ ] Tersedia green, Terbooking amber, Terjual neutral gray; status tidak bergantung
      pada color saja.
- [ ] Project Status Akan Datang, Sedang Berjalan, dan Selesai dipisahkan dari Unit
      Status secara visual dan konseptual.
- [ ] Progress V1 hanya percentage + optional short description.
- [ ] Map memakai placeholder generic dan tidak mengasumsikan provider.
- [ ] Completed Project tidak otomatis terlihat memiliki Unit tersedia.
- [ ] Upcoming Project tetap berguna tanpa inventing availability.
- [ ] Related Article hanya muncul bila relasi dan content relevan tersedia.
- [ ] KPR mengarah ke `/kpr/` dan tidak menjadi large embedded calculator.
- [ ] Mobile contextual sticky action muncul setelah Hero, berisi `Chat WhatsApp`
      sebagai primary dan `Lihat Ketersediaan` sebagai secondary.
- [ ] Sticky action tidak muncul pada initial load, tidak menutupi content, tidak
      dominan, dan menghilang/beradaptasi saat dedicated Contact section tercapai.

### Global

- [ ] Semua tiga halaman mobile-first dan memiliki desktop/mobile structural variant.
- [ ] Semua major block memiliki PURPOSE, PRIMARY USER QUESTION, PRIMARY ACTION,
      DATA SOURCE, EMPTY STATE, dan MOBILE NOTE.
- [ ] Design System component vocabulary digunakan tanpa implementasi.
- [ ] Green identity, calm CTA, real photography, moderate density, dan no-color-only
      status mengikuti `docs/DESIGN-SYSTEM.md`.
- [ ] Tidak ada public price requirement, forced registration, fake urgency, atau
      Phase 2 feature yang diam-diam ditambahkan.
- [ ] Tidak ada HTML, CSS, PHP, React, WordPress implementation, library, asset, atau
      production component yang dibuat oleh dokumen ini.
- [ ] Informasi yang tidak tersedia dinyatakan jujur; tidak ada angka, lokasi, harga,
      awards, rate, contact, atau availability yang diinventasi.
- [ ] Dokumen dapat menjadi input untuk human review sebelum visual design dimulai.

---

Dokumen ini berhenti pada struktur low-fidelity. Visual design berikutnya harus
mempertahankan urutan informasi, recovery state, CTA hierarchy, dan mobile priorities
yang telah ditulis di sini kecuali perubahan disetujui dan dicatat.
