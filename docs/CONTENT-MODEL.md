# Product Content Model v1

## 1. Informasi Dokumen

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Versi | 1.0 |
| Status | Final untuk human review |
| Sumber utama | PRD Marison ID v1.0, commit `b0f18dc` |
| Branch kerja | `feat/content-model-v1` |
| Bahasa dokumen | Bahasa Indonesia |

Dokumen ini adalah model konseptual produk. Dokumen ini bukan database schema dan
tidak memilih Custom Post Type, taxonomy, custom field, plugin, framework, atau
struktur WordPress tertentu.

## 2. Tujuan

Dokumen ini menjelaskan informasi yang dikelola Marison, hubungan antarinformasi,
informasi yang dapat digunakan kembali, informasi yang diterjemahkan, informasi
publik dan internal, serta nilai yang dimasukkan manual atau dihitung otomatis.

Model ini harus mudah dipahami oleh pemilik bisnis, staf marketing, editor,
designer, developer, dan AI coding agent tanpa pengetahuan database.

## 3. Prinsip Pemodelan

1. **Pisahkan data bisnis dari tampilan.** Model ini menjelaskan informasi bisnis,
   bukan layout website.
2. **Gunakan sumber kebenaran tunggal.** Nilai yang dapat dihitung tidak boleh
   dipelihara sebagai salinan manual yang berpotensi berbeda.
3. **Bedakan kemampuan data dan tampilan publik.** Data unit individual dapat
   menjadi sumber kebenaran walaupun publik hanya melihat ringkasan.
4. **Gunakan data referensi bersama jika memang berulang.** Lokasi, fasilitas
   umum, dan kontak internal tidak perlu disalin tanpa alasan.
5. **Jangan mengekspos struktur internal.** Pengunjung berhubungan dengan branch
   office yang relevan; assignment marketing adalah proses internal.
6. **Indonesian adalah sumber canonical.** English adalah terjemahan yang terhubung,
   bukan website kedua yang berdiri sendiri.
7. **Preservasi lebih diutamakan daripada penghapusan.** Status selesai, terjual,
   tidak aktif, atau ditutup tidak otomatis berarti data harus dihapus.
8. **Jangan mengarang kebutuhan bisnis.** Hal yang belum didukung PRD dicatat
   sebagai open question.
9. **Jaga model tetap sederhana.** Tambahkan konsep baru hanya jika ada alasan
   produk yang jelas.

## 4. Ikhtisar Konten

| Kelompok | Informasi utama | Sifat utama |
|---|---|---|
| Perumahan | Project, House Type, Housing Unit | Konten bisnis publik |
| Lokasi | Country, Province, City/Regency | Referensi yang dapat digunakan ulang |
| Operasional kontak | Branch Office, Branch Admin Contact, Marketing assignment | Publik sebagian; internal sebagian |
| Fasilitas | Fasilitas umum dan fasilitas khusus proyek | Referensi dengan konteks proyek |
| Leads | Kontak awal dan konteks proyek | Internal dan sensitif |
| Pembiayaan | KPR Scheme dan hasil simulasi | Scheme dapat dikelola; hasil dihitung |
| Editorial | Article dan Career Vacancy | Konten publik yang dapat diterjemahkan |

## 5. Matriks Keputusan Entitas

Kategori yang digunakan:

- **A — Independent managed content:** dikelola sebagai item bisnis tersendiri.
- **B — Reusable reference data:** dapat dipakai ulang oleh banyak item.
- **C — Contained information:** berada sebagai bagian dari item induk.
- **D — Derived/calculated information:** dihitung dari sumber lain.
- **E — Not needed:** tidak diperlukan sebagai konsep produk.

| Konsep | Keputusan | Penjelasan konseptual |
|---|---|---|
| Project | A | Setiap proyek perlu dikelola, dicari, ditampilkan, dan memiliki status serta hubungan bisnis sendiri. |
| House Type | C | Tipe rumah dimiliki oleh satu Project karena nama komersial yang sama tidak menjamin spesifikasinya sama di proyek lain. |
| Housing Unit | A | Unit individual perlu dikelola sebagai sumber availability, tetapi selalu berada di bawah satu Project. |
| Country | B | Referensi lokasi tingkat atas yang menjaga model tidak terbatas pada Indonesia selamanya. |
| Province | B | Referensi lokasi yang dapat dipakai oleh Project dan Branch Office. |
| City / Regency | B | Referensi lokasi yang membantu pencarian dan menghindari penulisan nama berulang. |
| Branch Office | A | Entitas operasional penting yang menangani banyak proyek dan menjadi jalur kontak publik. |
| Branch Admin Contact | C | Untuk V1, kontak publik admin berada langsung di Branch Office agar sederhana. |
| Marketing Person / Team | B | Referensi internal yang dapat diberi assignment ke banyak proyek, tanpa menjadi CTA publik utama. |
| Facility | B | Fasilitas umum dapat digunakan ulang, sementara fasilitas unik dapat dibuat khusus untuk proyek. |
| Lead | A | Lead perlu disimpan sebagai catatan kontak awal internal dengan source Project. |
| KPR Scheme | A | Scheme perlu dikelola, diaktifkan, dinonaktifkan, dan dikembangkan menjadi lebih dari satu scheme. |
| Article | A | Artikel memiliki siklus editorial sendiri dan dapat berdiri sendiri atau terkait proyek. |
| Career Vacancy | A | Lowongan memiliki listing, detail, status, dan siklus publikasi sendiri. |

## 6. Project

Project adalah pusat informasi setiap kawasan/perumahan Marison. Project dapat
memiliki:

- nama dan status: Akan Datang, Sedang Berjalan, atau Selesai;
- hubungan lokasi;
- alamat dan informasi koordinat/peta yang provider-independent;
- deskripsi, gambar utama, dan galeri;
- fasilitas;
- satu atau lebih House Type;
- current progress percentage;
- optional short progress/status description;
- site plan sebagai informasi proyek;
- tepat satu Primary Branch Office untuk public routing V1;
- kontak publik Branch Office;
- assignment Marketing internal;
- Housing Unit.

Harga publik tidak menjadi kebutuhan V1. Model tidak boleh mengharuskan harga,
tetapi keputusan bisnis di masa depan tetap dapat menambahkan informasi harga.

Progress V1 tetap sederhana: persentase saat ini dan deskripsi singkat opsional.
Milestone konstruksi terstruktur tidak termasuk V1. Sejarah atau pembaruan
konstruksi yang lebih rinci direpresentasikan melalui Article atau Project Update
yang terkait dengan Project.

### Kemampuan admin

Staf berwenang perlu dapat menambah dan mengedit Project, mengubah status,
menghubungkan lokasi, memilih Branch Office, mengelola House Type, memperbarui
konten proyek, serta mengelola hubungan fasilitas dan unit.

## 7. Location

### Tingkatan lokasi

Model menggunakan tingkatan yang cukup untuk kebutuhan produk:

```text
Country
└── Province
    └── City / Regency
        └── Project atau Branch Office
```

Country tetap dipertimbangkan karena Marison dapat berkembang di luar Indonesia,
meskipun operasi saat ini berada di Jawa. Tidak ada tingkatan tambahan yang
diperlukan pada tahap ini.

### Aturan lokasi

1. Project dapat ditemukan berdasarkan Province dan City/Regency.
2. Branch Office juga dapat memiliki lokasi dan service area.
3. Nama lokasi tidak boleh diketik ulang tanpa hubungan ke referensi lokasi bila
   hubungan tersebut sudah tersedia.
4. Alamat dapat menjadi informasi spesifik Project atau Branch Office.
5. Koordinat/map information bersifat provider-independent.
6. Map provider belum dipilih dan tidak menjadi bagian dari model konseptual.

## 8. Branch Office

Branch Office adalah jalur kontak publik dan unit operasional yang relevan untuk
Project. Satu Branch Office dapat menangani banyak Project. Setiap Project wajib
memiliki tepat satu Primary Branch Office untuk routing publik pada V1.

Secara konseptual Branch Office dapat memiliki:

- nama branch;
- lokasi atau service area;
- alamat;
- satu Primary Public WhatsApp;
- optional public telephone;
- informasi kontak publik lain jika memang dibutuhkan.

### Branch Admin Contact

Untuk V1, Branch Admin Contact berada langsung di dalam informasi Branch Office.
Konsep kontak terpisah tidak diperlukan karena setiap Branch Office memiliki satu
Primary Public WhatsApp dan belum ada kebutuhan yang disetujui untuk banyak kontak
WhatsApp admin publik per branch. Telephone publik bersifat opsional.

Kontak publik Project diselesaikan melalui Branch Office terkait. Jika kontak
branch berubah, informasi publik saat ini diperbarui tanpa mengubah Project yang
pernah menggunakan branch tersebut.

### Alur publik

```text
Visitor
  → Project yang dipilih
    → Branch Office terkait
      → Branch Admin Contact
        → Internal Marketing assignment
```

Nomor WhatsApp personel marketing tidak menjadi CTA publik default.

## 9. Marketing

Marketing Person/Team adalah konsep internal untuk assignment operasional. Model
harus memungkinkan:

- satu Project ditangani lebih dari satu personel atau tim;
- satu personel atau tim menangani lebih dari satu Project;
- assignment Project berubah tanpa mengubah public Branch Office contact;
- Branch Admin melakukan routing internal setelah menerima lead.

Marketing assignment tidak menjadi informasi publik utama. Model ini tidak
mencakup lead rotation, otomatisasi sales, pipeline CRM, atau aturan distribusi
lead.

Assignment dapat berstatus aktif, inactive, atau previous. Assignment yang tidak
lagi aktif tidak dihapus otomatis agar sejarah bisnis yang berguna tetap tersedia.

## 10. House Type

Satu Project dapat memiliki lebih dari satu House Type. House Type secara
konseptual dimiliki oleh tepat satu Project. House Type tidak otomatis digunakan
bersama oleh Project lain walaupun nama komersialnya sama, karena spesifikasi dua
proyek dapat berbeda.

Informasi minimum:

- nama tipe rumah;
- luas bangunan;
- luas tanah;
- jumlah kamar tidur;
- jumlah kamar mandi;
- jumlah lantai;
- gambar utama dan/atau floor plan;
- deskripsi singkat.

Spesifikasi tambahan boleh ada sebagai informasi opsional. Jika suatu unit
memiliki House Type, House Type tersebut harus berasal dari Project yang sama.

House Type adalah project-owned information, bukan katalog global yang diasumsikan
identik lintas proyek.

## 11. Housing Unit

Housing Unit adalah unit rumah individual yang menjadi sumber kebenaran pilihan
availability ketika datanya sudah tersedia.

Setiap Housing Unit wajib:

- berada di tepat satu Project;
- dapat terkait dengan satu House Type bila relevan;
- memiliki identitas unit/block/lot yang dapat dikenali;
- memiliki status Tersedia, Terbooking, atau Terjual;
- tidak menyimpan data pemilik atau pembeli.

### Cara publik menampilkan unit

Project dapat menampilkan:

1. daftar unit individual;
2. ringkasan jumlah per status yang dihitung dari unit individual;
3. site plan interaktif pada pengembangan berikutnya.

Project yang belum memiliki inventaris individual terdigitalisasi dapat memakai
ringkasan manual sementara. Ringkasan manual harus ditandai sebagai fallback
operasional, tidak boleh dianggap sebagai jumlah yang berasal dari unit individual,
dan harus berhenti menjadi sumber publik ketika inventory individual tersedia.
Untuk satu Project dan inventory yang sama, derived summary dan manual summary
tidak boleh aktif bersamaan atau bersaing sebagai dua sumber angka.

Tidak ada konsep buyer ownership, riwayat pembayaran, atau data pribadi pembeli di
dalam Housing Unit.

## 12. Facilities

Facility adalah informasi yang dapat digunakan oleh banyak Project bila fasilitas
tersebut merupakan konsep umum Marison. Contoh ilustratif dari PRD adalah
playground, mosque, security, green area, dan commercial area; contoh ini bukan
daftar fasilitas final Marison.

Model konseptual yang disarankan:

- Facility umum dapat dipilih untuk sebuah Project;
- Project dapat memberi konteks atau penjelasan khusus untuk fasilitas tersebut;
- Project dapat memiliki fasilitas unik yang hanya digunakan oleh Project itu;
- deskripsi atau label yang dibaca manusia dapat diterjemahkan;
- hubungan fasilitas yang sama tidak perlu dibuat ulang sebagai item global yang
  berbeda setiap kali digunakan.

## 13. Lead

Lead adalah catatan kontak awal yang disimpan secara internal. Lead hanya dapat
diakses oleh staf Marison yang berwenang. Lead minimal berisi:

- nama;
- nomor WhatsApp/telephone;
- Project yang diminati;
- consent pemrosesan data pribadi;
- message opsional.

Source Project wajib dipertahankan. Dari Project tersebut, Branch Office yang
relevan dapat ditentukan. Branch Office/admin menerima notifikasi dan melakukan
routing internal ke Marketing Person/Team yang sesuai.

```text
Lead
  → source Project
    → relevant Branch Office
      → Branch Admin notification
        → internal Marketing routing
```

Lead tidak mencakup qualification panjang, financial history, identity number,
salary, SLIK data, atau CRM pipeline stage.

Durasi retensi, kebijakan penghapusan, dan rincian permission masih **TO BE
DEFINED** sebelum production launch. Hal tersebut adalah keputusan privasi dan
governance yang non-blocking untuk Content Model; dokumen ini tidak mengarang
durasi retensi.

## 14. KPR Scheme

KPR Scheme adalah konfigurasi pembiayaan yang dapat dikelola dan dapat berjumlah
lebih dari satu. Secara konseptual sebuah scheme dapat memiliki:

- nama scheme;
- annual interest rate;
- pilihan tenure;
- asumsi uang muka minimum atau default;
- effective date;
- status aktif/nonaktif;
- disclaimer.

V1 dapat memiliki banyak KPR Scheme, tetapi tepat satu scheme dapat ditetapkan
sebagai **PUBLIC DEFAULT SCHEME** pada satu waktu. Scheme lain boleh tersimpan
tanpa otomatis digunakan kalkulator publik. Scheme inactive tidak boleh menjadi
public default.

Hasil simulasi adalah nilai **derived**, bukan scheme baru dan bukan persetujuan
bank. Formula, sumber bunga, pembulatan, dan skenario finansial harus
didokumentasikan sebelum implementasi. Model ini tidak memilih formula atau data
bank tertentu.

Admin yang berwenang pada akhirnya dapat mengubah parameter. Rincian nama role dan
permission ditetapkan dalam perencanaan admin/access, bukan dalam model konseptual
ini.

## 15. Articles

Article adalah konten editorial yang dikelola secara mandiri. Article dapat
membahas edukasi perumahan, edukasi KPR, berita perusahaan, pembaruan Project,
atau informasi yang berguna bagi pemilik rumah.

Article dapat berdiri sendiri. Article yang merupakan pembaruan proyek sebaiknya
dapat memiliki hubungan opsional dengan Project, agar pembaca dapat menemukan
konteks proyek terkait dan Project dapat menampilkan artikel yang relevan.

Satu Article dapat terkait dengan nol, satu, atau beberapa Project sesuai
konteksnya. General KPR education dapat berdiri sendiri, construction update dapat
terkait satu Project, dan regional/company update dapat terkait beberapa Project.

Kategori artikel tidak ditetapkan sebagai daftar final dalam dokumen ini. Contoh
di atas berasal dari PRD dan dapat menjadi arah editorial.

## 16. Careers

Career Vacancy adalah konten mandiri untuk:

- daftar lowongan;
- detail lowongan;
- status lowongan yang masih tersedia atau sudah ditutup;
- informasi editorial yang dibutuhkan pencari kerja;
- application instructions, recruitment email, atau external application URL.

V1 tidak menyimpan job applicant records. Internal applicant form, CV storage,
candidate tracking, dan HR management system tidak diperlukan. Vacancy harus tetap
memiliki tujuan/metode lamaran yang cukup fleksibel agar pilihan instruksi, email,
atau URL eksternal tidak memerlukan perubahan konsep Vacancy.

V1 tidak membangun HR management system, candidate pipeline, screening, atau
approval recruitment yang kompleks.

## 17. Model Bahasa dan Translation

Bahasa Indonesia adalah canonical/source content. Bahasa Inggris adalah linked
translation dari konten Indonesia.

### Translatable Content

Informasi yang kemungkinan dibaca dan diterjemahkan sebagai editorial:

- Project description;
- House Type description;
- Facility label atau description;
- Article;
- Career Vacancy content;
- CTA atau editorial copy.

### Shared Structured Data

Informasi berikut sebaiknya memiliki satu sumber bersama dan tidak dipelihara dua
kali hanya karena ada dua bahasa:

- coordinates;
- dimensions;
- unit number atau block/lot reference;
- unit status;
- project progress jika berupa nilai terstruktur;
- relationships;
- public contact numbers;
- Branch Office relation;
- Marketing assignment internal.

Konten editorial yang diterjemahkan tetap harus terhubung ke item canonical
Bahasa Indonesia. Plugin atau mekanisme WordPress untuk translation belum dipilih.

## 18. Relationships

Hubungan utama dalam bahasa sederhana:

- Satu Country dapat memiliki banyak Province.
- Satu Province dapat memiliki banyak City/Regency.
- Satu City/Regency dapat memiliki banyak Project.
- Satu Branch Office dapat menangani banyak Project.
- Setiap Project memiliki tepat satu Primary Branch Office untuk public routing V1.
- Satu Project dapat memiliki banyak House Type.
- Satu House Type dimiliki satu Project.
- Satu Project dapat memiliki banyak Housing Unit.
- Satu Housing Unit berada di satu Project.
- Satu Housing Unit dapat terkait dengan House Type dari Project yang sama bila
  relevan.
- Satu Facility umum dapat digunakan banyak Project.
- Satu Project dapat menggunakan banyak Facility dan memiliki Facility unik.
- Satu Project dapat memiliki banyak Marketing assignment internal yang dapat aktif
  atau previous.
- Satu Marketing Person/Team dapat menangani banyak Project.
- Satu Lead memiliki satu source Project.
- Branch Office Lead ditentukan melalui source Project.
- Satu Article dapat terkait dengan nol, satu, atau banyak Project.
- Tepat satu KPR Scheme dapat menjadi PUBLIC DEFAULT SCHEME pada satu waktu, dengan
  kemungkinan adanya scheme lain yang tidak menjadi default.
- Satu konten canonical Bahasa Indonesia dapat memiliki linked English translation.

Jika suatu hubungan tidak tercantum di sini, hubungan tersebut belum boleh
dianggap sebagai kebutuhan bisnis yang disetujui.

## 19. Derived vs Manually Managed Data

| Nilai | Klasifikasi | Penjelasan |
|---|---|---|
| Project name, status, description | MANUALLY MANAGED | Diisi dan diperbarui staf sesuai proses konten. |
| House Type specifications | MANUALLY MANAGED | Dikelola sebagai informasi milik Project. |
| Housing Unit status | MANUALLY MANAGED | Status unit diperbarui administrator. |
| Project progress percentage | MANUALLY MANAGED | Persentase saat ini diperbarui sebagai informasi sederhana V1. |
| Project progress description | TRANSLATABLE, MANUALLY MANAGED | Deskripsi singkat opsional dapat diterjemahkan. |
| Detailed construction history | TRANSLATABLE | Diwakili Article/Project Update, bukan milestone terstruktur V1. |
| Availability totals | DERIVED | Dihitung dari status Housing Unit bila unit individual tersedia. |
| Temporary availability summary | MANUALLY MANAGED | Fallback saja; tidak aktif bersamaan dengan derived summary. |
| Project → Branch Office route | SHARED / DERIVED FOR ROUTING | Project menyimpan hubungan branch; tujuan notifikasi publik ditentukan dari hubungan tersebut. |
| Branch public WhatsApp/telephone | SHARED, MANUALLY MANAGED | Satu kontak publik branch dipakai oleh Project terkait. |
| Marketing assignment | INTERNAL ONLY, MANUALLY MANAGED | Assignment aktif/previous, bukan CTA publik dan bukan automatic rotation. |
| Lead source Project | MANUALLY MANAGED AT CREATION | Dipilih dari konteks form dan tidak boleh hilang. |
| Lead Branch Office | DERIVED | Ditentukan dari source Project. |
| KPR simulation result | DERIVED | Dihitung dari input pengguna dan active scheme setelah formula disetujui. |
| KPR Scheme parameters | MANUALLY MANAGED | Diubah admin berwenang dan dapat memiliki status aktif/nonaktif. |
| Public default KPR Scheme | DERIVED FROM ADMIN DESIGNATION | Kalkulator publik menggunakan tepat satu scheme yang ditetapkan sebagai default. |
| Coordinates and dimensions | SHARED STRUCTURED DATA | Tidak perlu diduplikasi antarbahasa. |
| Project/Unit relationships | SHARED STRUCTURED DATA | Hubungan yang sama dipakai oleh pengalaman Indonesia dan Inggris. |
| Description, Article, Vacancy editorial content | TRANSLATABLE | Bahasa Inggris terhubung dengan canonical Bahasa Indonesia. |
| KPR disclaimer | TRANSLATABLE EDITORIAL CONTENT | Pesan publik dapat memiliki translation. |

## 20. Informasi Publik vs Internal

| Informasi | Visibilitas konseptual |
|---|---|
| Project name, status, location, description | Public |
| House Type information | Public, jika dipublikasikan untuk Project |
| Unit reference dan status availability | Public sesuai keputusan tampilan Project |
| Availability summary | Public, derived atau fallback yang jelas |
| Facility dan gallery | Public |
| Branch Office name, address, public telephone, public WhatsApp | Public |
| Lead name, number, consent, message | Internal/private; authorized staff only |
| Lead source Project | Internal dan digunakan untuk routing |
| Branch Admin notification | Internal operational information |
| Marketing Person/Team assignment | Internal only |
| Internal routing history | Internal only |
| KPR Scheme public parameters dan disclaimer | Public hanya untuk PUBLIC DEFAULT SCHEME |
| KPR administrative configuration | Internal editing, sebagian hasilnya public |
| Article dan Career Vacancy | Public bila diterbitkan |
| Translation relationship | Internal content relationship |

Public website tidak boleh menampilkan struktur personel marketing atau assignment
internal hanya karena data tersebut ada untuk kebutuhan operasional.

## 21. Lifecycle dan Archive Behavior

Model memilih perubahan status atau archive daripada penghapusan langsung jika
informasi masih berguna untuk sejarah bisnis.

| Situasi | Perlakuan konseptual |
|---|---|
| Project menjadi Selesai | Tetap dapat dipertahankan sebagai Project dengan status Selesai dan portofolio historis. |
| Housing Unit menjadi Terjual | Pertahankan unit dan status Terjual agar summary/history tidak rusak. Jangan tambahkan data pembeli. |
| Marketing Person/Team berhenti menangani Project | Jadikan assignment inactive/previous; jangan hapus person/team atau sejarah assignment yang berguna. |
| Branch public contact berubah | Perbarui kontak aktif Branch Office; Project tetap terkait dengan branch tersebut. |
| KPR Scheme tidak berlaku | Jadikan inactive, lepaskan dari public default secara sengaja, dan pertahankan record untuk sejarah bila sesuai. |
| Career Vacancy ditutup | Hentikan listing aktif dan pertahankan konten sebagai closed/archive bila diperlukan; jangan menyimpan applicant record V1. |
| Article tidak lagi dipublikasikan | Gunakan status editorial yang sesuai; jangan menghapus hubungan Project tanpa alasan. |

Tidak ada aturan legal retention yang dibuat dalam dokumen ini. Retensi Lead dan
aksesnya masih mengikuti keputusan privasi yang belum ditetapkan.

## 22. Tanggung Jawab Admin

| Konsep | Kemampuan yang wajar untuk staf |
|---|---|
| Project | Add, edit, ubah status, pilih lokasi, assign Branch Office, kelola House Type dan informasi publik |
| House Type | Add untuk Project, edit spesifikasi, gambar, denah, dan deskripsi |
| Housing Unit | Add, edit reference, ubah availability status, hubungkan House Type yang benar |
| Branch Office | Add/edit lokasi, public telephone, public WhatsApp, dan informasi publik |
| Marketing assignment | Menambah atau mengakhiri assignment internal tanpa mengubah CTA publik |
| Facility | Mengelola fasilitas umum dan konteks fasilitas pada Project |
| Lead | Melihat lead sesuai otorisasi, mengetahui source Project, dan memproses routing internal |
| KPR Scheme | Mengelola parameter scheme sesuai otorisasi; mengaktifkan/nonaktifkan secara sengaja |
| Article | Membuat, mengedit, menghubungkan Project bila relevan, dan menerbitkan |
| Career Vacancy | Membuat, mengedit, menerbitkan, menutup, dan mengubah instruksi lamaran |

Detail role dan approval workflow berada di luar model konseptual ini. Kebijakan
akses Lead serta retensi Lead tetap mengikuti keputusan privasi yang ditandai pada
Open Questions.

## 23. Aturan Integritas Data

1. **Availability tidak boleh bertentangan.** Jika Housing Unit individual
   tersedia, total per status berasal dari unit tersebut.
2. **Fallback harus jelas.** Manual summary hanya digunakan jika inventory
   individual belum terdigitalisasi dan tidak boleh disajikan seolah-olah derived.
3. **Satu sumber aktif untuk summary.** Derived summary dan manual summary untuk
   inventory yang sama tidak boleh aktif atau bersaing secara bersamaan.
4. **Public contact mengikuti branch.** WhatsApp dan telephone publik Project
   harus resolve melalui Primary Branch Office terkait.
5. **Project wajib dipertahankan pada Lead.** Lead tanpa source Project tidak
   memenuhi model lead V1.
6. **Branch ditentukan dari Project.** Branch Office untuk Lead tidak boleh
   ditulis berbeda dari Primary Branch Office Project tanpa keputusan bisnis
   eksplisit.
7. **Satu Unit tepat satu Project.** Setiap Housing Unit wajib berada di tepat satu
   Project.
8. **House Type harus satu Project.** Jika Unit mereferensikan House Type, House
   Type tersebut wajib milik Project yang sama. Unit A-12 dari Project A yang
   mereferensikan House Type dari Project B adalah invalid.
9. **Status menggunakan nilai yang disepakati.** Project hanya memakai Akan
   Datang, Sedang Berjalan, atau Selesai; Unit hanya memakai Tersedia, Terbooking,
   atau Terjual.
10. **Translation tetap terhubung.** English tidak boleh menjadi copy independen
    yang kehilangan hubungan dengan canonical Indonesian.
11. **Structured data tidak diduplikasi antarbahasa.** Status, dimensi, koordinat,
    hubungan, dan kontak bersama memiliki satu sumber.
12. **Tepat satu public KPR default.** Pada satu waktu hanya satu KPR Scheme dapat
    ditetapkan sebagai PUBLIC DEFAULT SCHEME.
13. **Inactive KPR tidak menjadi default.** Scheme yang nonaktif tidak boleh
    dipakai sebagai public default.
14. **Branch admin mendahului marketing publik.** Data internal marketing tidak
    mengubah public CTA langsung ke salesperson.
15. **Tidak ada data pembeli di Unit.** Status Terjual tidak menambahkan personal
    data pemilik.
16. **Nama sama bukan berarti data sama.** House Type pada dua Project tidak boleh
    diasumsikan identik hanya karena nama komersialnya sama.
17. **Project publik harus memiliki jalur kontak yang jelas.** Project yang
    ditampilkan dengan CTA kontak harus memiliki Primary Branch Office dan Primary
    Public WhatsApp yang sesuai.

## 24. Open Questions

Lead retention dan detailed access policy adalah satu-satunya pertanyaan model yang
masih terbuka. Pertanyaan PRD lain seperti target performance, URL, brand final, dan
provider peta tidak menjadi blocker model ini.

| ID | Pertanyaan | Dampak model | Status/blocking |
|---|---|---|---|
| CM-Q01 | Berapa lama Lead disimpan dan siapa yang dapat mengaksesnya? | Menentukan lifecycle dan access policy Lead. | **BEFORE LAUNCH; NON-BLOCKING FOR CONTENT MODEL** |

Durasi retensi dan detailed access policy tidak dijawab dengan asumsi teknis atau
durasi buatan. Keputusan ini harus dibuat sebelum production launch, tetapi tidak
mengubah entitas dan hubungan inti Content Model.

## 25. Kriteria Penerimaan Content Model

Content Model ini dapat dianggap memenuhi tujuan konseptual apabila checklist berikut
dapat dijawab “ya”:

- [ ] 30+ Project dapat direpresentasikan dengan pola informasi yang konsisten.
- [ ] Penambahan Province dan Country baru tidak mengharuskan model hanya untuk
      Jawa atau Indonesia.
- [ ] Setiap Project dapat memiliki lebih dari satu House Type.
- [ ] House Type dengan nama sama di dua Project tidak dianggap otomatis identik.
- [ ] Setiap Housing Unit berada di tepat satu Project.
- [ ] Unit dapat terkait dengan House Type dari Project yang sama bila relevan.
- [ ] Unit yang terkait dengan House Type dari Project lain dianggap invalid.
- [ ] Availability summary dapat dihitung dari status unit individual.
- [ ] Manual summary hanya menjadi fallback untuk inventory yang belum digital dan
      tidak aktif bersamaan dengan derived summary untuk inventory yang sama.
- [ ] Setiap Project memiliki tepat satu Primary Branch Office untuk V1.
- [ ] Public WhatsApp/telephone Project mengarah ke Branch Admin Contact, bukan
      langsung ke Marketing Person secara default.
- [ ] Satu Branch Office dapat menangani banyak Project.
- [ ] Marketing assignments dapat bersifat banyak-ke-banyak secara konseptual dan
      memiliki status aktif atau previous, serta tetap internal.
- [ ] Lead menyimpan nama, WhatsApp/telephone, consent, optional message, serta
      source Project, dan hanya dapat diakses staf berwenang.
- [ ] Dari source Project, Branch Office penerima dapat ditentukan.
- [ ] KPR Scheme dapat lebih dari satu dan V1 dapat memakai satu default active
      scheme pada satu waktu; scheme inactive tidak dapat menjadi default.
- [ ] Hasil simulasi dipahami sebagai derived estimate, bukan persetujuan bank.
- [ ] Article dapat berdiri sendiri dan dapat memiliki hubungan Project bila relevan.
- [ ] Project memiliki current progress percentage dan optional short description;
      milestone terstruktur bukan kebutuhan V1.
- [ ] Career Vacancy mendukung listing, detail, status closed, dan application
      instructions/email/external URL tanpa menyimpan applicant records V1.
- [ ] Indonesian menjadi canonical dan English menjadi linked translation.
- [ ] Structured data bersama tidak diduplikasi hanya karena bahasa berbeda.
- [ ] Project selesai, Unit terjual, Branch contact berubah, Marketing assignment
      berakhir, KPR scheme inactive, dan Vacancy closed dapat ditangani tanpa
      menghapus sejarah penting secara otomatis.
- [ ] Lead retention duration dan detailed access policy ditandai sebagai keputusan
      BEFORE LAUNCH yang NON-BLOCKING FOR CONTENT MODEL.
- [ ] Tidak ada keputusan Custom Post Type, taxonomy, field framework, database
      table, PHP, plugin, atau UI yang dibuat dalam model ini.

## 26. Diagram Konseptual

```text
Country
  └── Province
       └── City / Regency
            ├── Project ───────────────┐
            └── Branch Office           │
                                        │
Project                                │
  ├── exactly one Primary Branch ──────┘
  │      └── public Branch Admin Contact
  │             └── internal routing → Marketing Person / Team
  ├── many House Types
  ├── many Housing Units
  │      └── optional House Type
  ├── many Facilities
  ├── progress percentage / short description / gallery / site plan
  └── zero, one, or many related Articles

Lead
  └── source Project → Branch Office → Branch Admin notification

KPR Scheme(s)
  └── exactly one PUBLIC DEFAULT SCHEME → calculated public simulation result

Canonical Indonesian content
  └── linked English translation
       └── shared structured data remains single-source
```

Diagram ini menunjukkan hubungan produk secara konseptual. Diagram ini tidak
menentukan cara WordPress menyimpan atau menampilkan data.
