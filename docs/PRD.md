# Product Requirements Document (PRD) v1.0

## 1. Informasi Dokumen

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Domain | `marison.id` |
| Versi | 1.0 |
| Status | Approved v1.0 |
| Platform | WordPress |
| Bahasa dokumen | Bahasa Indonesia |

Dokumen ini menjelaskan kebutuhan produk, bukan rancangan teknis. Dokumen ini
tidak menetapkan database, custom fields, post types, plugin, rumus, atau detail
implementasi WordPress.

## 2. Ringkasan Produk

Marison ID adalah website resmi Marison Group, pengembang perumahan yang
beroperasi di Jawa, Indonesia. Website ini menggabungkan tiga kebutuhan utama:

1. Website korporat resmi Marison Group.
2. Website pencarian perumahan dan penghasil leads.
3. Portal karier dan lowongan pekerjaan.

Pengunjung harus dapat menemukan proyek yang relevan, memahami detail proyek dan
ketersediaan unit, menghubungi branch office yang relevan untuk routing internal,
mempelajari KPR, membaca artikel, serta melihat lowongan pekerjaan. Bahasa Indonesia adalah
pengalaman utama dan Bahasa Inggris adalah pengalaman sekunder.

## 3. Latar Belakang

Marison Group memiliki lebih dari 30 proyek perumahan di berbagai wilayah Jawa.
Proyek memiliki status Akan Datang, Sedang Berjalan, atau Selesai. Setiap proyek
juga dapat memiliki unit dengan status Tersedia, Terbooking, atau Terjual, serta
tim marketing yang berbeda.

Website ini dibangun dari nol. Website lama `marison.id` bukan fondasi teknis
website baru. Website lama hanya boleh menjadi referensi merek, referensi konten,
atau sumber migrasi yang disetujui kemudian.

Website baru direncanakan menggunakan WordPress, Hostinger Business, pengembangan
lokal, GitHub, native WordPress editing, tema Marison yang ringan, dan plugin
terpisah untuk kebutuhan bisnis Marison. Elementor dan page builder lain tidak
digunakan.

Prinsip kontak publik: website tidak perlu mengekspos struktur operasional staf
secara berlebihan. Pengguna berinteraksi dengan Marison melalui branch office yang
relevan. Assignment internal kepada personel atau tim marketing adalah proses
operasional.

## 4. Masalah Utama yang Harus Diselesaikan

| Masalah | Kebutuhan produk |
|---|---|
| Pengunjung sulit menemukan rumah yang sesuai | Direktori proyek dan pencarian berdasarkan lokasi |
| Informasi proyek tidak jelas atau tersebar | Detail proyek, status, lokasi, fasilitas, tipe rumah, dan ketersediaan unit yang mudah dipahami |
| Kontak marketing dapat tertukar | Routing kontak berdasarkan proyek |
| Pengunjung membutuhkan edukasi pembelian | Artikel dan informasi KPR yang jelas |
| Perkiraan cicilan sulit dipahami | Simulasi KPR sebagai estimasi, bukan persetujuan bank |
| Informasi sering perlu diperbarui | Staf non-teknis dapat memperbarui konten tanpa coding |
| Informasi karier belum terpusat | Halaman karier dan detail lowongan |
| Pengalaman mobile penting | Aktivitas utama nyaman melalui smartphone |

## 5. Tujuan Produk

1. Membuat Marison Group mudah ditemukan dan dipahami sebagai pengembang
   perumahan.
2. Membantu pengguna menemukan proyek berdasarkan lokasi dan kebutuhan mereka.
3. Membantu pengguna memahami status proyek dan ketersediaan unit.
4. Menghubungkan pengguna dengan branch office yang relevan dan mendukung
   routing internal ke tim marketing yang tepat.
5. Memberikan edukasi KPR dan simulasi cicilan yang bertanggung jawab.
6. Menyediakan artikel untuk edukasi, berita, dan pembaruan proyek.
7. Menyediakan portal karier sederhana untuk lowongan Marison Group.
8. Memungkinkan staf mengelola informasi tanpa mengubah kode.
9. Menyediakan pengalaman Bahasa Indonesia dan Bahasa Inggris.
10. Menjadi fondasi ringan yang dapat berkembang melampaui proyek di Jawa.

## 6. Non-Goals

Hal berikut bukan tujuan versi pertama:

- marketplace atau toko online;
- pembayaran rumah secara online;
- portal akun pelanggan;
- pengganti CRM, ERP, atau sistem operasional perusahaan;
- aplikasi mobile native;
- sistem rekrutmen kompleks;
- custom page builder;
- Elementor atau page builder lain;
- seluruh pekerjaan migrasi dari website lama;
- penetapan struktur teknis WordPress atau database.

## 7. Target Pengguna

### Pengguna utama

1. Pembeli rumah pertama.
2. Keluarga muda.
3. Karyawan dan pekerja yang mencari rumah terjangkau.
4. Orang yang tertarik pada rumah bersubsidi dan KPR.

### Pengguna sekunder

5. Pencari kerja.
6. Mitra bisnis.
7. Pengunjung umum yang ingin mengetahui Marison Group.

Bahasa harus mudah dipahami masyarakat umum. Hindari bahasa korporat yang terlalu
formal, istilah teknis yang tidak perlu, dan ajakan yang terasa memaksa.

## 8. Kebutuhan Pengguna

| Pengguna | Kebutuhan |
|---|---|
| Calon pembeli | Menemukan proyek berdasarkan lokasi dan memahami pilihan unit |
| Calon pembeli | Mengetahui kontak branch office yang benar untuk proyeknya |
| Calon pembeli | Memahami KPR dan menghitung perkiraan cicilan |
| Keluarga muda | Mengakses informasi dengan cepat melalui smartphone |
| Pengunjung umum | Memahami profil dan rekam jejak Marison Group |
| Pencari kerja | Melihat daftar serta detail lowongan |
| Staf marketing | Menyajikan informasi kontak proyek yang tepat |
| Staf konten | Memperbarui proyek, unit, artikel, gambar, dan lowongan tanpa coding |

## 9. Alur Pengguna Utama

### 9.1 Menemukan proyek berdasarkan lokasi

1. Pengguna membuka website dan memahami pilihan perumahan Marison.
2. Pengguna mencari atau memilih lokasi.
3. Website menampilkan proyek yang sesuai.
4. Pengguna menyaring atau memilih proyek.
5. Pengguna membuka detail proyek.

### 9.2 Memahami dan menghubungi proyek

1. Pengguna membaca status, lokasi, deskripsi, fasilitas, tipe rumah, dan
   ketersediaan unit bila tersedia.
2. Pengguna memilih WhatsApp, telepon, atau formulir kontak.
3. Kontak diarahkan ke admin branch office proyek tersebut untuk routing internal
   ke tim atau personel marketing yang sesuai.

### 9.3 Memeriksa ketersediaan unit

1. Pengguna membuka detail proyek.
2. Pengguna melihat tipe atau unit rumah.
3. Pengguna memahami status Tersedia, Terbooking, atau Terjual.
4. Pengguna menghubungi branch office untuk informasi lanjutan.

### 9.4 Menggunakan simulasi KPR

1. Pengguna membaca edukasi KPR.
2. Pengguna memasukkan estimasi harga properti, uang muka, jangka waktu, dan
   nilai bunga bila berlaku.
3. Website menampilkan estimasi dan menyatakan bahwa hasil bukan persetujuan
   kredit bank.
4. Pengguna dapat mencari informasi lanjutan atau menghubungi Marison.

### 9.5 Mencari lowongan

1. Pencari kerja membuka halaman Karier.
2. Pencari kerja melihat daftar dan membuka detail lowongan.
3. Pencari kerja mengikuti instruksi lamaran yang tersedia.

### 9.6 Membaca artikel

1. Pengguna membuka artikel atau menemukannya melalui mesin pencari.
2. Pengguna membaca informasi yang relevan.
3. Pengguna dapat melanjutkan ke proyek, KPR, atau kontak bila relevan.

## 10. Cakupan Website

| Kelompok | Cakupan |
|---|---|
| Beranda | Nilai Marison, penemuan proyek, lokasi, kredibilitas, KPR, artikel, karier, dan kontak |
| Perumahan | Direktori, pencarian/filter, lokasi, detail proyek, tipe rumah, dan status unit |
| Korporat | Tentang Marison dan portofolio/rekam jejak |
| KPR | Edukasi dan simulasi perkiraan cicilan |
| Konten | Artikel perumahan, KPR, berita, pembaruan proyek, dan informasi pemilik rumah |
| Karier | Landing page, daftar lowongan, dan detail lowongan |
| Kontak | WhatsApp, telepon, dan formulir kontak |
| Bahasa | Bahasa Indonesia dan Bahasa Inggris |

Prioritas pengalaman homepage adalah: (1) proposisi merek, (2) penemuan
perumahan/proyek, (3) pencarian lokasi, (4) proyek unggulan, (5) kredibilitas
Marison, (6) edukasi atau simulasi KPR, (7) artikel, (8) karier, dan (9) kontak.
Urutan ini harus tetap mengutamakan membantu pengguna menemukan rumah.

Proyek dapat berada di Jawa atau wilayah lain di masa depan. Produk tidak boleh
secara konseptual membatasi data hanya pada Jawa.

## 11. Fitur Inti

| Fitur | Kebutuhan versi pertama |
|---|---|
| Beranda | Membantu pengguna menemukan rumah, bukan memaksa pengisian data pribadi |
| Direktori proyek | Menampilkan proyek perumahan Marison |
| Pencarian/filter | Pencarian berdasarkan lokasi dan penyaringan proyek |
| Detail proyek | Informasi proyek yang lengkap dan mudah dipahami |
| Status proyek | Akan Datang, Sedang Berjalan, atau Selesai |
| Struktur lokasi | Provinsi serta kota/kabupaten |
| Kontak proyek | Kontak branch office yang sesuai dengan proyek dan routing internal |
| Ketersediaan unit | Tersedia, Terbooking, atau Terjual |
| KPR | Edukasi dan simulasi estimasi |
| Artikel | Edukasi, berita, dan pembaruan |
| Karier | Lowongan dan detail lowongan |
| Admin | Pengelolaan konten tanpa coding |
| Bahasa | Indonesia dan Inggris |

## 12. Kebutuhan Proyek Perumahan

Setiap proyek dapat memiliki nama, status, provinsi, kota/kabupaten, alamat,
lokasi peta, deskripsi, gambar utama, galeri, fasilitas, tipe rumah, current
progress percentage, optional short progress/status description, site plan, tepat
satu Primary Branch Office, kontak publik branch office, assignment marketing
internal, dan unit perumahan.

Status yang ditampilkan kepada pengguna:

- Akan Datang;
- Sedang Berjalan;
- Selesai.

Informasi yang tidak tersedia tidak boleh ditampilkan seolah-olah tersedia. Detail
tampilan dan struktur teknis pengelolaan data ditentukan pada tahap desain dan
content model terpisah.

Progress versi pertama tetap sederhana. Riwayat atau pembaruan pembangunan yang
lebih rinci dapat dipublikasikan melalui Article atau Project Update yang terkait
dengan proyek. Structured milestone management bukan persyaratan versi pertama dan
dapat dipertimbangkan kembali kemudian.

Harga rumah tidak wajib ditampilkan pada versi pertama. Produk harus memungkinkan
harga ditambahkan kemudian jika keputusan bisnis berubah, tanpa menjadikannya
syarat peluncuran.

## 13. Kebutuhan Unit

### Kemampuan data produk

1. Sistem harus mendukung unit perumahan individual.
2. Data unit individual adalah sumber kebenaran yang diprioritaskan jika tersedia.
3. Setiap unit mendukung Tersedia, Terbooking, atau Terjual.
4. Setiap Housing Unit individual harus dimiliki tepat satu Project.
5. Unit dapat merujuk House Type bila relevan.
6. Jika Unit merujuk House Type, House Type tersebut harus berasal dari Project
   yang sama.
7. Status dapat dikelola administrator.
8. Harga publik bukan syarat untuk menampilkan status unit pada versi pertama.

### Cara tampil publik

1. Proyek dapat menampilkan daftar unit individual.
2. Proyek dapat menampilkan ringkasan ketersediaan yang diturunkan dari data unit
   individual.
3. Ringkasan yang diturunkan tidak boleh dikelola sebagai angka manual duplikat.
4. Ringkasan manual sementara dapat digunakan untuk proyek yang belum memiliki
   inventaris unit individual terdigitalisasi.
5. Site plan interaktif merupakan kemungkinan pengembangan berikutnya.
6. Status yang terlihat pengguna harus jelas dan tidak menyesatkan. Pengguna harus
   memahami bahwa status dapat memerlukan konfirmasi lebih lanjut.

PRD ini tidak menetapkan struktur database atau field teknis unit.

## 13.1 Kebutuhan Tipe Rumah

Satu proyek dapat memiliki lebih dari satu tipe rumah. Setiap tipe rumah secara
konseptual mendukung informasi minimum berikut:

- nama tipe rumah;
- luas bangunan;
- luas tanah;
- jumlah kamar tidur;
- jumlah kamar mandi;
- jumlah lantai;
- gambar utama dan/atau denah;
- deskripsi singkat.

Spesifikasi tambahan dapat bersifat opsional. Daftar ini adalah kebutuhan produk,
bukan definisi WordPress field atau database schema.

## 14. Kebutuhan Lokasi

1. Pengguna dapat menemukan proyek berdasarkan lokasi.
2. Proyek dapat dikaitkan dengan provinsi dan kota/kabupaten.
3. Lokasi harus membantu pengguna memahami area proyek, bukan hanya menjadi label.
4. Lokasi di Jawa didukung sejak awal.
5. Ekspansi ke provinsi lain tidak boleh memerlukan perombakan produk secara
   keseluruhan.
6. Alamat atau peta harus membantu pengguna memutuskan untuk melanjutkan kontak.

## 15. Kebutuhan Marketing dan Leads

1. Website mendukung WhatsApp, telepon, dan formulir kontak.
2. Website mendukung lebih dari satu branch office.
3. Satu branch office dapat menangani lebih dari satu proyek.
4. Setiap proyek harus memiliki tepat satu Primary Branch Office untuk public
   contact routing versi pertama.
5. Setiap branch office memiliki satu Primary Public WhatsApp dan dapat memiliki
   telephone publik secara opsional.
6. Alur kontak publik yang normal adalah: pengunjung → proyek → Primary Branch
   Office → Primary Public WhatsApp.
7. Public Project CTA tidak boleh secara default menuju nomor WhatsApp individual
   personel marketing.
8. Assignment kepada Marketing Person/Team adalah informasi internal. Assignment
   dapat aktif, inactive, atau previous, dan sejarah yang berguna dapat dipelihara.
9. Satu personel atau tim marketing dapat menangani beberapa proyek, dan satu proyek
   dapat memiliki lebih dari satu assignment internal.
10. Kontak dari Proyek A tidak boleh otomatis diarahkan ke Primary Branch Office
    Proyek B.
11. Konteks proyek harus tetap melekat pada percakapan atau lead sehingga branch
    admin dapat mengetahui proyek yang ditanyakan.
12. Lead minimal disimpan di WordPress dan branch office/admin yang relevan diberi
    notifikasi.
13. Branch admin melakukan routing internal ke tim atau personel marketing yang
    sesuai.
14. CRM tidak diperlukan untuk peluncuran versi pertama. Tidak termasuk sales
    pipeline, automatic assignment, commission tracking, lead rotation, atau
    salesperson dashboard.
15. Formulir lead utama menggunakan field wajib: nama, nomor WhatsApp/telepon,
    proyek yang diminati, dan consent pemrosesan data pribadi. Pesan bersifat
    opsional.
16. Formulir harus singkat dan tidak boleh meminta field kualifikasi yang tidak
    diperlukan pada kontak pertama.
17. Beranda mengutamakan penemuan proyek sebelum meminta data pribadi.
18. Formulir besar tidak boleh menjadi pengalaman utama pada layar pertama.

## 16. Kebutuhan KPR

1. Website menyediakan edukasi KPR dalam bahasa yang mudah dipahami.
2. Website menyediakan simulasi KPR.
3. Input konseptual versi pertama adalah estimasi harga properti, uang muka,
   jangka waktu pembiayaan, dan nilai bunga bila berlaku.
4. Hasil adalah estimasi, bukan janji atau persetujuan bank.
5. Pernyataan tersebut harus terlihat jelas.
6. Produk harus secara konseptual mendukung konfigurasi KPR scheme yang dapat
   memiliki nama scheme, bunga tahunan, pilihan tenor, asumsi uang muka minimum
   atau default, tanggal berlaku, status aktif/nonaktif, dan disclaimer.
7. Sistem dapat menyimpan lebih dari satu KPR Scheme.
8. Versi pertama hanya boleh memiliki tepat satu eligible KPR Scheme sebagai
   PUBLIC DEFAULT SCHEME pada satu waktu.
9. Kalkulator publik menggunakan PUBLIC DEFAULT SCHEME tersebut.
10. Scheme inactive tidak boleh menjadi PUBLIC DEFAULT SCHEME.
11. Scheme historis dapat dipertahankan jika masih berguna.
12. Produk tidak boleh menganggap hanya satu scheme akan selalu ada.
13. Parameter KPR pada akhirnya dapat diubah oleh admin yang berwenang.
14. Formula harus didokumentasikan sebelum implementasi.
15. Rumus, sumber suku bunga, pembulatan, dan skenario pembiayaan belum
    diimplementasikan dalam pekerjaan PRD ini.

## 17. Kebutuhan Artikel

Website mendukung artikel tentang edukasi perumahan, edukasi KPR, berita
perusahaan, pembaruan proyek, dan informasi berguna bagi pemilik rumah.

Artikel harus mudah ditemukan oleh pengguna dan membantu mesin pencari memahami
topik Marison. Staf harus dapat membuat, mengedit, dan menerbitkan artikel tanpa
mengubah kode. Sebuah artikel dapat tidak memiliki hubungan proyek, terkait dengan
satu proyek, atau terkait dengan beberapa proyek. General KPR education dapat
berdiri sendiri; construction update dapat terkait satu proyek; regional/company
news dapat terkait beberapa proyek. Tidak setiap artikel wajib memiliki proyek.

## 18. Kebutuhan Karier

### Persyaratan peluncuran

- halaman landing Karier;
- daftar lowongan;
- detail lowongan;
- informasi yang mudah dipahami pencari kerja;
- application instructions, recruitment email, atau external application URL.

Versi pertama tidak perlu menyimpan job applicant records. Applicant database, CV
storage, candidate tracking, internal applicant form, dan internal recruitment
management system berada di luar versi pertama.

### Perbaikan setelah peluncuran

- pengiriman lamaran langsung melalui website;
- penyaringan kandidat;
- alur persetujuan internal;
- sistem manajemen rekrutmen kompleks;
- integrasi otomatis dengan sistem HR.

Versi pertama tidak membangun sistem recruitment management kompleks. Metode
aplikasi tidak dikunci ke satu provider atau satu metode tertentu.

## 19. Kebutuhan Multibahasa

1. Bahasa Indonesia adalah pengalaman utama; Bahasa Inggris adalah pengalaman
   sekunder.
2. Pengguna dapat memahami bahasa yang sedang dipakai.
3. Bahasa Indonesia adalah canonical/source content.
4. Konten Bahasa Inggris merupakan translation yang terhubung dengan konten
   Bahasa Indonesia, bukan website independen tanpa hubungan.
5. Informasi penting seperti status dan kontak tidak boleh berbeda secara
   menyesatkan antarbahasa.
6. Informasi terstruktur atau bersama, seperti status unit, dimensi, koordinat,
   dan progres proyek, tidak perlu dipelihara dua kali hanya karena ada dua bahasa.
7. Konten editorial yang dapat dibaca manusia dapat membutuhkan terjemahan.
8. Plugin atau mekanisme teknis multibahasa belum dipilih dalam PRD ini.

## 20. Kebutuhan Admin

Staf Marison non-teknis pada akhirnya harus dapat menambah atau mengedit proyek,
status proyek, status unit, branch office, kontak publik branch office, assignment
marketing internal, artikel, lowongan, gambar, dan informasi website yang
disediakan untuk dikelola.

Admin yang berwenang juga pada akhirnya dapat memperbarui parameter KPR sesuai
aturan akses yang disetujui.

Pengelolaan konten dan layout tetap terpisah. Administrator seharusnya tidak perlu
mengubah layout untuk memperbarui informasi. Rincian peran, persetujuan, dan
riwayat perubahan masih merupakan pertanyaan terbuka.

Lead records are INTERNAL ONLY dan hanya dapat diakses oleh personel Marison yang
berwenang. Durasi retensi, detailed access policy, deletion procedure, dan privacy
governance harus ditentukan **BEFORE LAUNCH** dan **NON-BLOCKING FOR CURRENT
PRODUCT DESIGN**. PRD ini tidak menetapkan durasi retensi atau kebijakan teknisnya.

## 21. Kebutuhan Mobile

Website dirancang mobile-first. Pada layar kecil, pengguna harus dapat mencari
proyek, membaca detail, menghubungi WhatsApp atau telepon, memeriksa unit,
menggunakan simulasi KPR, membaca artikel, dan melihat lowongan tanpa zoom atau
geser horizontal yang tidak perlu.

## 22. Prinsip Desain

### Kepribadian

Website harus playful tetapi tidak kekanak-kanakan, modern, minimal,
approachable, terpercaya, dan aspiratif tanpa terlihat terlalu mewah. Website
melayani audiens rumah subsidi dan terjangkau, bukan hanya properti eksklusif.

### Arah visual awal

| Nama | Nilai awal |
|---|---|
| Primary Green | `#1F6B45` |
| Deep Green | `#123D2A` |
| Fresh Green | `#64B94F` |
| Soft Sage | `#DDEBDD` |
| Warm Cream | `#F7F4EC` |
| Charcoal | `#20251F` |
| Muted Gray | `#6E756D` |
| White | `#FFFFFF` |

Palet ini masih preliminary dan dapat diperbarui dalam Design System.

### Pedoman

- gunakan whitespace yang cukup dan foto proyek yang nyata;
- gunakan tipografi kuat tetapi sederhana;
- gunakan rounded corners secara moderat;
- gunakan motion secara terbatas dan bermakna;
- gunakan navigasi sederhana serta call to action yang jelas;
- hindari gradient, glow, glassmorphism, visual clutter, dan animasi tanpa tujuan.

## 23. Kebutuhan Aksesibilitas

Desain dan pengembangan harus mempertimbangkan teks yang mudah dibaca, kontras
yang memadai, navigasi keyboard, label formulir yang jelas, link dan tombol yang
dapat dipahami, focus state yang terlihat, serta pesan status dan error yang jelas.

Kriteria pengujian aksesibilitas yang lebih rinci ditetapkan pada tahap desain dan
pengembangan.

## 24. Kebutuhan SEO

Website harus membantu mesin pencari memahami Marison Group, setiap proyek,
lokasi proyek, artikel, halaman karier, dan lowongan.

Halaman proyek dan lokasi harus berguna bagi manusia, relevan, dan bukan halaman
otomatis berkualitas rendah. Versi pertama membutuhkan fondasi SEO, termasuk
struktur URL dan metadata yang jelas, tetapi tool atau plugin SEO belum dipilih.
URL proyek yang sudah diterbitkan harus diperlakukan sebagai aset yang dijaga.

## 25. Kebutuhan Performance

Performance adalah kebutuhan produk. Produk harus menghindari plugin yang tidak
diperlukan, page builder berat, JavaScript berlebihan, gambar terlalu besar, dan
animasi yang tidak perlu.

Target angka performance dan metode pengukuran: **TO BE DEFINED**. Detail
optimasi teknis tidak ditulis dalam PRD ini.

## 26. Prinsip Privasi dan Data Formulir

1. Minta hanya data pribadi yang dibutuhkan untuk tujuan kontak atau layanan yang
   jelas.
2. Jangan memaksa data pribadi sebelum pengguna menemukan proyek.
3. Jelaskan tujuan pengiriman formulir.
4. Arahkan kontak ke pihak marketing yang relevan.
5. Jangan membagikan data ke pihak yang tidak berkaitan tanpa dasar dan
   persetujuan yang sesuai.
6. Lead records are INTERNAL ONLY dan aksesnya dibatasi untuk personel Marison yang
   berwenang.
7. Tetapkan retensi, detailed access policy, consent, pemberitahuan privasi,
   deletion procedure, dan privacy governance sebelum formulir produksi digunakan.
8. Durasi retensi dan rincian access policy tetap **TO BE DEFINED** dan merupakan
   keputusan **BEFORE LAUNCH**, bukan blocker untuk current product design.
9. Data uji dan sample data tidak boleh berisi data pribadi nyata.

## 27. Ruang Lingkup Versi 1

Semua item berikut adalah persyaratan peluncuran:

| Item | Klasifikasi |
|---|---|
| Homepage | Launch requirement |
| Direktori proyek perumahan | Launch requirement |
| Pencarian/filter proyek | Launch requirement |
| Detail proyek | Launch requirement |
| Status proyek | Launch requirement |
| Struktur lokasi | Launch requirement |
| Kontak branch office khusus proyek dan routing marketing internal | Launch requirement |
| WhatsApp | Launch requirement |
| Telepon | Launch requirement |
| Formulir kontak | Launch requirement |
| Unit perumahan individual | Launch requirement |
| Status ketersediaan unit | Launch requirement |
| Edukasi KPR | Launch requirement |
| Simulasi KPR | Launch requirement |
| Tentang Marison | Launch requirement |
| Portofolio/rekam jejak | Launch requirement |
| Artikel | Launch requirement |
| Karier | Launch requirement |
| Detail lowongan | Launch requirement |
| Bahasa Indonesia | Launch requirement |
| Bahasa Inggris | Launch requirement |
| Pengeditan admin WordPress | Launch requirement |
| Fondasi SEO | Launch requirement |
| Pengalaman mobile-first | Launch requirement |
| Fondasi performance | Launch requirement |

Harga publik tidak termasuk syarat peluncuran versi 1.

## 28. Ruang Lingkup Fase 2

Item berikut adalah perbaikan setelah versi 1, kecuali ada alasan produk kuat yang
disetujui secara khusus:

- site plan grafis interaktif;
- perbandingan proyek;
- proyek favorit;
- akun pengunjung;
- properti tersimpan;
- integrasi CRM lanjutan;
- alur marketing otomatis;
- sistem rekrutmen kompleks;
- reservasi rumah online;
- pembayaran online;
- aplikasi mobile native.

Item fase 2 tidak boleh diam-diam dipromosikan menjadi persyaratan peluncuran.

## 29. Di Luar Lingkup Versi 1

Berikut secara eksplisit tidak direncanakan untuk peluncuran:

- e-commerce;
- pembayaran rumah online;
- portal akun pelanggan;
- aplikasi mobile;
- CRM kompleks;
- ERP;
- custom page builder;
- Elementor.

## 30. Indikator Keberhasilan

Angka target bisnis belum diberikan dan tidak dibuat-buat. Target angka serta
periode pengukuran: **TO BE DEFINED**.

| Kategori | Indikator |
|---|---|
| Penemuan proyek | Pengguna dapat menemukan proyek relevan berdasarkan lokasi |
| Pemahaman proyek | Pengguna dapat mengidentifikasi lokasi, status, dan informasi utama |
| Kontak | Pengguna dapat menghubungi branch office yang benar dan lead dapat dirouting secara internal |
| Ketersediaan unit | Pengguna dapat memahami tiga status unit |
| KPR | Pengguna dapat menyelesaikan simulasi dan memahami hasilnya hanya estimasi |
| Admin | Staf dapat memperbarui konten tanpa coding |
| Konten | Administrator dapat menerbitkan artikel dan lowongan |
| Mobile | Aktivitas inti dapat dilakukan dengan nyaman melalui smartphone |
| SEO | Halaman proyek, lokasi, artikel, dan karier dapat ditemukan serta diindeks |
| Performance | Halaman dan aktivitas inti memenuhi target yang akan ditentukan |
| Bahasa | Pengguna dapat memilih Indonesia atau Inggris dengan konten yang sesuai |

## 31. Risiko dan Asumsi

### Risiko

| Risiko | Dampak | Mitigasi yang diperlukan |
|---|---|---|
| Data proyek atau unit tidak diperbarui | Informasi pengguna salah | Tetapkan pemilik data dan jadwal pembaruan |
| Routing branch office salah | Leads masuk ke jalur yang tidak sesuai | Uji routing setiap proyek sebelum produksi |
| Simulasi dianggap persetujuan bank | Pengguna salah memahami pembiayaan | Tampilkan disclaimer yang jelas |
| Terlalu banyak data diminta di awal | Pengguna meninggalkan website | Utamakan discovery dan kontak ringan |
| Terjemahan tidak sinkron | Pengalaman bahasa menyesatkan | Tetapkan proses dan pemilik terjemahan |
| Gambar atau script berlebihan | Mobile lambat | Tetapkan standar konten dan pengujian |
| Halaman lokasi tidak bernilai | Kualitas SEO rendah | Publikasikan lokasi yang benar-benar berguna |
| Admin kesulitan mengedit | Informasi menjadi usang | Uji alur admin dengan staf non-teknis |
| Kebijakan data belum jelas | Risiko privasi | Selesaikan kebijakan sebelum formulir produksi |

### Asumsi

Asumsi ini berasal dari arahan proyek, bukan keputusan tambahan:

1. Marison saat ini beroperasi di Jawa dan dapat berkembang ke provinsi lain.
2. Bahasa Indonesia utama, Bahasa Inggris sekunder.
3. Proyek dapat memiliki kontak marketing yang berbeda.
4. Status proyek dan unit dikelola administrator.
5. Harga publik tidak wajib untuk peluncuran versi 1.
6. Pengguna utama banyak mengakses melalui smartphone.
7. Pembayaran, akun pelanggan, aplikasi mobile, CRM/ERP kompleks, dan page
   builder tidak termasuk versi pertama.

## 32. Pertanyaan Terbuka

Pertanyaan berikut belum diputuskan dan tidak dijawab atas nama Marison. Keputusan
yang sudah disetujui tidak lagi dicantumkan sebagai unresolved question.

Q01. Siapa pemilik dan penanggung jawab pembaruan data setiap proyek dan unit?
Q02. Seberapa sering status proyek dan unit harus diperbarui?
Q05. Apakah alamat dan peta memakai format atau provider tertentu?
Q09. Berapa lama data leads disimpan dan siapa yang boleh mengaksesnya? Durasi
retensi dan detailed access policy: **BEFORE LAUNCH; NON-BLOCKING FOR CURRENT
PRODUCT DESIGN**.
Q10. Apakah CRM atau sistem marketing akan diintegrasikan kemudian?
Q12. Siapa yang menulis, meninjau, dan menerjemahkan artikel serta lowongan?
Q15. Siapa yang boleh mengubah parameter KPR?
Q16. Apakah informasi harga publik akan diaktifkan setelah peluncuran?
Q17. Apakah ada aturan merek final selain palet preliminary?
Q18. Apa target angka untuk leads, simulasi, SEO, dan performance?
Q19. Bagaimana rekam jejak dan portofolio Marison dikelompokkan?
Q20. Apa alur persetujuan sebelum proyek, unit, artikel, atau lowongan diterbitkan?
Q21. Kebijakan privasi, consent, deletion procedure, dan privacy governance apa
yang berlaku? Keputusan ini diperlukan **BEFORE LAUNCH**.
Q22. URL dan struktur navigasi mana yang harus diprioritaskan?

## 33. Kriteria Penerimaan

PRD v1.0 menjadi dasar yang dapat diterima apabila checklist berikut dapat
dijawab “ya” atau memiliki keputusan tertulis.

### Dasar produk

- [ ] Website didefinisikan sebagai website korporat, pencarian perumahan dan
      leads, serta portal karier.
- [ ] Target pengguna utama dan sekunder tercantum.
- [ ] Alur mencari proyek, menghubungi branch office, menggunakan KPR, membaca
      artikel, dan mencari lowongan tercantum.
- [ ] Homepage diprioritaskan untuk membantu pengguna menemukan rumah.
- [ ] Formulir besar tidak menjadi pengalaman utama layar pertama.

### Proyek, lokasi, dan unit

- [ ] Direktori, pencarian/filter, detail proyek, dan lokasi termasuk versi 1.
- [ ] Status proyek dan status unit ditetapkan dalam istilah Indonesia.
- [ ] Sistem mendukung data unit individual sebagai sumber kebenaran yang
      diprioritaskan.
- [ ] Setiap Housing Unit dimiliki tepat satu Project.
- [ ] Unit dapat merujuk House Type, tetapi House Type tersebut harus berasal dari
      Project yang sama.
- [ ] Project memiliki current progress percentage dan optional short
      progress/status description.
- [ ] Structured milestone management tidak diperlukan untuk versi pertama.
- [ ] Proyek dapat menampilkan daftar unit individual, ringkasan ketersediaan,
      atau site plan interaktif di masa depan.
- [ ] Ringkasan ketersediaan diturunkan dari unit individual bila data unit ada;
      ringkasan manual hanya menjadi opsi sementara bila inventaris belum digital
      dan tidak bersaing dengan derived summary.
- [ ] Satu proyek dapat memiliki lebih dari satu tipe rumah dengan informasi
      minimum yang disepakati.
- [ ] Kebutuhan proyek, lokasi, dan unit dijelaskan tanpa mengunci database.
- [ ] Produk dapat berkembang dari Jawa ke provinsi lain.
- [ ] Harga publik tidak menjadi syarat peluncuran.

### Kontak, KPR, konten, dan karier

- [ ] WhatsApp, telepon, dan formulir kontak termasuk versi 1.
- [ ] Setiap Project memiliki tepat satu Primary Branch Office untuk versi 1.
- [ ] Setiap Branch memiliki satu Primary Public WhatsApp dan telephone publik
      bersifat opsional.
- [ ] WhatsApp publik Project resolves melalui Primary Branch Office dan tidak
      memerlukan kontak individual Marketing sebagai CTA default.
- [ ] Lead menyimpan konteks proyek dan branch admin dapat mengidentifikasi
      proyek asal lead untuk routing internal.
- [ ] Formulir utama dapat bekerja hanya dengan nama, nomor WhatsApp/telepon,
      proyek yang diminati, dan consent; pesan bersifat opsional.
- [ ] Edukasi dan simulasi KPR termasuk versi 1.
- [ ] Input konseptual simulasi tercantum.
- [ ] Disclaimer bahwa hasil simulasi bukan persetujuan bank tercantum.
- [ ] Konfigurasi KPR dapat mendukung lebih dari satu scheme dan tepat satu
      eligible scheme menjadi PUBLIC DEFAULT SCHEME pada satu waktu.
- [ ] Scheme inactive tidak dapat menjadi PUBLIC DEFAULT SCHEME.
- [ ] Artikel, karier, daftar lowongan, dan detail lowongan termasuk versi 1.
- [ ] Career Vacancy mendukung instructions, recruitment email, atau external URL
      tanpa menyimpan job applicant records pada versi pertama.
- [ ] Applicant database, CV storage, candidate tracking, dan internal recruitment
      management system berada di luar versi pertama.
- [ ] Article dapat tidak memiliki Project, terkait satu Project, atau terkait
      beberapa Project.

### Bahasa, admin, dan kualitas pengalaman

- [ ] Bahasa Indonesia utama dan Inggris sekunder.
- [ ] Bahasa Indonesia menjadi canonical/source content dan Bahasa Inggris
      menjadi translation yang terhubung.
- [ ] Informasi terstruktur bersama tidak perlu dipelihara secara duplikat hanya
      karena ada dua bahasa.
- [ ] Admin non-teknis dapat mengelola konten tanpa coding.
- [ ] Pengelolaan konten dan layout terpisah.
- [ ] Mobile-first, aksesibilitas, SEO, dan performance termasuk kebutuhan.
- [ ] Elementor dan page builder tidak digunakan.

### Ruang lingkup dan keputusan

- [ ] Launch requirement, fase 2, dan out of scope tersedia secara terpisah.
- [ ] Indikator keberhasilan tidak mengarang angka; target yang belum diketahui
      ditandai **TO BE DEFINED**.
- [ ] Pertanyaan yang belum diputuskan tercantum di Open Questions.
- [ ] Lead retention, detailed access policy, deletion procedure, dan privacy
      governance tetap ditandai BEFORE LAUNCH dan NON-BLOCKING FOR CURRENT PRODUCT
      DESIGN.
- [ ] Tidak ada keputusan bisnis baru yang disamarkan sebagai requirement.

Implementasi berikutnya harus dapat ditinjau terhadap checklist ini. Perubahan
scope atau pertanyaan terbuka harus disetujui dan dicatat sebelum masuk pekerjaan
produk berikutnya.
