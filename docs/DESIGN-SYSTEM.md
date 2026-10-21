# Design System Marison ID v1

## 1. Informasi Dokumen

| Item | Nilai |
|---|---|
| Produk | Marison ID |
| Perusahaan | Marison Group |
| Domain | `marison.id` |
| Dokumen | Design System v1 |
| Status | Final v1 — design decisions resolved; asset details remain open |
| Branch | `feat/design-system-v1` |
| Tanggal | 22 Oktober 2026 |
| Sumber | `docs/PRD.md`, `docs/CONTENT-MODEL.md`, `docs/INFORMATION-ARCHITECTURE.md`, `docs/USER-FLOWS.md`, `docs/PROJECT-RULES.md` |
| Bahasa dokumen | Bahasa Indonesia |

Dokumen ini adalah spesifikasi visual dan interaksi dasar untuk menjadi acuan
wireframe, visual design, theme, dan komponen yang akan datang. Dokumen ini tidak
membuat halaman lengkap, wireframe, PHP, CSS production, frontend component,
plugin, atau asset production.

Nilai warna, tipografi, dan token di sini adalah keputusan desain konseptual. Nilai
tersebut tetap perlu diuji dalam implementasi terhadap kontras, performa, konten
aktual, dan final brand asset.

---

## 2. Design Vision

Marison ID harus terasa seperti website pengembang perumahan yang modern dan
percaya diri, tetapi tetap dekat dengan orang yang sedang mencari rumah pertama.
Pengalaman visualnya menggabungkan:

- whitespace yang cukup;
- fotografi proyek yang nyata;
- tipografi kuat dan mudah dibaca;
- kartu dan kontrol yang sederhana;
- green identity yang jelas tetapi tidak mendominasi setiap permukaan;
- detail playful yang kecil dan terukur.

Kesan yang ingin dicapai:

> Modern dan terpercaya, tetapi tetap relevan dan terjangkau bagi saya.

Design System ini mengutamakan informasi yang membantu keputusan: lokasi,
Project Status, House Type, Unit availability, KPR, dan kontak Branch. Visual tidak
boleh mengalahkan informasi tersebut.

### Sasaran visual

1. Membuat Marison terlihat established tanpa terasa kaku.
2. Membuat perumahan terjangkau terasa aspiratif tanpa berpura-pura menjadi luxury
   property.
3. Membantu pengguna smartphone membaca dan bertindak dengan cepat.
4. Membuat konten Project, Article, Vacancy, dan KPR terasa berasal dari satu
   produk yang koheren.

### Batasan

Design System ini tidak menentukan layout halaman tertentu, copy final, logo final,
foto final, atau implementasi WordPress.

---

## 3. Brand Personality

| Sifat | Penerapan visual dan interaksi |
|---|---|
| Modern | Tipografi bersih, grid teratur, whitespace, dan kontrol yang tidak ramai |
| Approachable | Kontras yang nyaman, bahasa sederhana, radius moderat, dan foto autentik |
| Trustworthy | Hierarki informasi jelas, status jujur, focus state terlihat, dan tidak ada fake urgency |
| Optimistic | Fresh Green, fotografi yang hidup, dan aksen kecil yang memberi energi |
| Slightly playful | Detail bentuk, ilustrasi/ikon sederhana, atau aksen warna secara terbatas |
| Clean | Permukaan netral, sedikit dekorasi, dan satu tujuan utama per konteks |
| Established | Konsistensi token, ritme layout, dan presentasi informasi yang tenang |

### Yang harus dihindari

Marison tidak boleh terasa:

- childish;
- overly corporate;
- excessively luxurious;
- cheap atau penuh promosi;
- seperti generic property template;
- seperti website bank atau financial dashboard.

---

## 4. Design Principles

1. **Discovery before conversion.** Visual tidak boleh membuat lead form lebih
   menonjol daripada `Cari Rumah` dan pemahaman Project.
2. **Green with restraint.** Green adalah identitas kuat, bukan warna untuk semua
   teks, badge, background, dan CTA sekaligus.
3. **Content earns emphasis.** Foto, status, lokasi, availability, dan CTA mendapat
   penekanan berdasarkan kebutuhan pengguna, bukan dekorasi.
4. **One product, many content types.** Project, Article, Vacancy, KPR, dan About
   memakai fondasi yang sama tetapi dapat memiliki pola konten yang berbeda.
5. **Status is explicit.** Project Status dan Unit Status tidak boleh tampak sebagai
   satu sistem yang sama.
6. **Mobile-first readability.** Teks, control, foto, dan CTA harus nyaman pada
   smartphone sebelum diperluas ke layar besar.
7. **Calm conversion.** CTA jelas dan mudah ditemukan tanpa flashing, fake scarcity,
   atau pressure.
8. **Accessible by default.** Warna, ikon, animasi, dan bentuk tidak menjadi satu-
   satunya cara untuk memahami informasi.
9. **Honest states.** Empty, unavailable, closed, dan error state menjelaskan
   kondisi sebenarnya serta next action yang berguna.
10. **Admin-friendly presentation.** Pola visual tidak bergantung pada copy panjang
    atau data yang selalu lengkap.
11. **Performance-aware visual.** Fotografi penting, tetapi tidak boleh mengorbankan
    pengalaman mobile melalui asset yang berlebihan.
12. **Reuse without monotony.** Komponen konsisten, tetapi halaman tidak diisi
    nested card dan container hanya demi penggunaan ulang.

---

## 5. Color System

### Final recommendation untuk palette awal

Palette preliminary dari PRD dipertahankan tanpa penggantian warna inti.

| CURRENT | PROPOSED | WHY |
|---|---|---|
| `#1F6B45` Primary Green | `#1F6B45` Primary Green | Mempertahankan identitas Marison dan cukup kuat untuk primary action dengan teks putih setelah validasi kontras. |
| `#123D2A` Deep Green | `#123D2A` Deep Green | Anchor gelap untuk teks kuat, navigasi, atau area brand yang membutuhkan kedalaman. |
| `#64B94F` Fresh Green | `#64B94F` Fresh Green | Aksen optimistis; tidak dipakai sebagai teks kecil di atas putih. |
| `#DDEBDD` Soft Sage | `#DDEBDD` Soft Sage | Surface lembut untuk highlight dan grouping tanpa membuat halaman penuh green gelap. |
| `#F7F4EC` Warm Cream | `#F7F4EC` Warm Cream | Background hangat yang membuat pengalaman tidak terasa seperti dashboard atau bank. |
| `#20251F` Charcoal | `#20251F` Charcoal | Teks utama dengan karakter hangat dan kontras tinggi. |
| `#6E756D` Muted Gray | `#6E756D` Muted Gray | Teks sekunder dan informasi pendukung; harus diuji kontras pada ukuran kecil. |
| `#FFFFFF` White | `#FFFFFF` White | Surface bersih dan kontras untuk konten serta CTA. |

Tidak ada alasan untuk mengganti palette hanya demi novelty. Tonal adjustment kecil
boleh dilakukan setelah contrast testing, tetapi tidak boleh menghilangkan green
identity.

### Corporate blue

Blue yang mungkin terdapat pada logo resmi dipertahankan hanya bila diperlukan oleh
asset logo tersebut. Blue tidak menjadi major UI color atau competing primary brand
color pada V1. Penggunaan blue di luar logo hanya dapat dipertimbangkan kemudian
bila official brand guideline membenarkannya.

### Prinsip penggunaan

- Gunakan Warm Cream atau White sebagai background utama, bukan Deep Green di semua
  section.
- Gunakan Primary Green untuk identitas, link penting, CTA utama, atau anchor
  visual yang memang perlu perhatian.
- Gunakan Deep Green untuk teks/permukaan yang membutuhkan kedalaman, bukan sebagai
  default background seluruh halaman.
- Gunakan Fresh Green sebagai accent, highlight, ilustrasi, atau detail playful;
  jangan menggunakannya untuk body text kecil di atas White.
- Gunakan Soft Sage untuk surface berwarna, bukan sebagai pengganti semua border.
- Jangan membuat green glow, gradient green besar, atau pola dekoratif berulang
  sebagai default.

---

## 6. Semantic Colors

Semantic colors tidak boleh bergantung pada brand green. Setiap semantic state
selalu memakai teks/label dan, bila sesuai, icon atau bentuk tambahan.

| Role | Recommended foreground | Recommended surface | Penggunaan |
|---|---|---|---|
| Brand primary | `#1F6B45` | `#EAF4EC` bila sebagai surface | Identitas, primary CTA, link penting |
| Brand dark | `#123D2A` | `#123D2A` | Heading kuat, navigasi, dark surface terpilih |
| Page background | `#20251F` untuk teks | `#F7F4EC` atau `#FFFFFF` | Background utama dan area baca |
| Surface/card | `#20251F` | `#FFFFFF` atau `#F7F4EC` | Card, form, content surface |
| Border | `#59615B` bila perlu kontras | `#D7DED6` sebagai border halus | Pemisah dan outline; tidak semua container wajib border |
| Primary text | `#20251F` | — | Body dan heading utama |
| Secondary text | `#4E554F` | — | Supporting copy; gunakan `#6E756D` hanya bila ukuran/kontras memadai |
| Focus | `#123D2A` atau `#1F6B45` | Focus ring dengan offset kontras | Keyboard focus dan focus-visible |
| Disabled | `#707770` | `#EEF0ED` | Control disabled tanpa terlihat sebagai error |
| Success | `#17643E` | `#E8F4EC` | Form success dan tindakan berhasil |
| Warning | `#8A4A00` | `#FFF4DD` | Perhatian, konfirmasi, atau status sementara |
| Error | `#A61B1B` | `#FDECEA` | Invalid input, kegagalan, dan kondisi yang perlu diperbaiki |
| Informational | `#0B4F71` | `#E8F3FA` | Notice informatif dan penjelasan non-error |

Foreground dan surface di atas adalah rekomendasi konseptual. Kontras akhir harus
divalidasi dengan WCAG AA pada setiap kombinasi teks dan background yang benar-benar
digunakan.

---

## 7. Project & Unit Status Colors

### Unit Status

Unit Status memakai warna yang sengaja berbeda dan mudah dibedakan:

| Unit Status | Foreground | Surface | Bentuk konseptual | Makna |
|---|---|---|---|---|
| **Tersedia** | `#17643E` | `#E8F4EC` | Badge/status dengan marker positif | Unit tercatat tersedia; tetap dapat memerlukan konfirmasi |
| **Terbooking** | `#8A4A00` | `#FFF4DD` | Badge/status dengan marker pending | Unit tidak boleh dipahami sebagai tersedia untuk pilihan baru |
| **Terjual** | `#59615B` | `#EEF0ED` | Badge/status netral | Unit telah terjual; tidak menunjukkan availability aktif |

Hijau untuk Tersedia tidak boleh disamakan dengan semua status Project. Amber untuk
Terbooking mencegah status tersebut terlihat seperti variasi green. Neutral gray
untuk Terjual menghindari kesan error atau promosi. Merah bukan default untuk
Terjual karena Terjual adalah status komersial availability, bukan error atau
destructive state.

### Project Status

Project Status memakai treatment yang berbeda dari Unit Status, terutama melalui
outline/soft badge, prefix konteks, icon/shape, dan posisi hierarki.

| Project Status | Foreground | Surface/outline | Rekomendasi makna |
|---|---|---|---|
| **Akan Datang** | `#51427A` | `#F1EEFA` | Tahap proyek belum berjalan atau belum dibuka sebagai proyek berjalan |
| **Sedang Berjalan** | `#23615D` | `#E8F3F0` | Pembangunan sedang berlangsung |
| **Selesai** | `#59615B` | `#EEF0ED` | Tahap proyek telah selesai atau berstatus historis |

### Aturan pencegah kebingungan

1. Label selalu menyebut konteks bila ada risiko ambigu, misalnya `Status Project`
   dan `Status Unit`.
2. Project Status menggunakan treatment outline/soft dan biasanya berada dekat
   identitas Project.
3. Unit Status menggunakan treatment availability yang lebih operasional dan
   berada dekat summary/list Unit.
4. Jangan mengandalkan hue saja: gunakan teks, posisi, icon/shape, dan konteks.
5. `Sedang Berjalan` tidak berarti `Tersedia`; `Selesai` tidak otomatis berarti
   `Terjual` atau tidak memiliki Unit.
6. Status color tidak boleh mengubah aturan bisnis atau mengarang availability.

---

## 8. Typography

### Recommendation

Gunakan satu keluarga sans-serif sebagai default agar produk terasa sederhana,
cepat, dan konsisten.

**Default V1:** Plus Jakarta Sans.

Keputusan ini berlaku sampai Marison menyediakan official corporate typeface yang
disetujui. Typeface resmi tersebut dapat menggantikan default V1 pada keputusan
brand berikutnya.

Alasannya:

- terasa modern dan approachable tanpa menjadi dekoratif;
- memiliki karakter yang sesuai untuk website perumahan yang aspiratif tetapi
  accessible;
- mendukung teks Latin yang dibutuhkan Bahasa Indonesia dan English;
- cukup fleksibel untuk display, body, label, dan angka.

Fallback konseptual:

```text
Plus Jakarta Sans → Inter → ui-sans-serif → system-ui → sans-serif
```

Font tidak di-download atau ditambahkan pada tahap Design System ini. Pada tahap
implementasi, subset, loading strategy, lisensi, dan fallback harus diverifikasi.

### Prinsip

- Satu keluarga font lebih diutamakan daripada kombinasi display/body yang
  berlebihan.
- Weight menjadi alat hierarchy utama; jangan memakai decorative font untuk heading.
- Heading boleh ekspresif melalui ukuran, weight, dan whitespace, bukan font luxury.
- Body text harus nyaman dibaca pada smartphone dan tidak terlalu rapat.
- Angka untuk availability, progress, dan KPR harus jelas dibedakan antar digit.
- Bahasa Indonesia dan English harus memiliki ruang untuk panjang teks yang berbeda.

### Weight roles

| Weight | Peran |
|---|---|
| Regular | Body, helper text, supporting content |
| Medium | Label, button, navigation, status text |
| Semibold | H3/H4, card title, important metadata |
| Bold | Display, H1/H2, strong emphasis yang terbatas |

Jangan memakai semua weight dalam satu komponen. Weight yang lebih berat harus
menunjukkan hierarchy, bukan sekadar membuat teks terlihat kuat.

---

## 9. Type Scale

Scale bersifat responsif dan konseptual. Angka berikut adalah rentang token awal,
bukan keputusan ukuran setiap halaman.

| Token | Desktop concept | Mobile concept | Line-height principle |
|---|---:|---:|---|
| Display / Hero | 56–72 | 36–48 | Tight tetapi tetap terbaca pada 2–4 baris |
| H1 | 40–56 | 32–40 | Tight/compact untuk heading utama |
| H2 | 32–44 | 28–36 | Compact dengan ruang section yang cukup |
| H3 | 24–32 | 22–28 | Moderat, cocok untuk grouping |
| H4 | 20–24 | 18–22 | Moderat, tidak mengalahkan body |
| Body Large | 18–20 | 17–19 | Nyaman untuk lead/intro |
| Body | 16–18 | 16–18 | Default readable text |
| Small | 14–15 | 14–15 | Supporting information, bukan body utama |
| Caption | 12–13 | 12–13 | Metadata dengan kontras yang cukup |
| Button | 14–16 | 14–16 | Medium/semibold; jelas sebagai action |
| Label | 12–14 | 12–14 | Medium; selalu didukung konteks |

### Responsive type principles

- Display type boleh fluid, tetapi tidak boleh membuat tombol, status, atau content
  utama terdorong jauh pada smartphone.
- Body text tidak boleh diperkecil hanya untuk memasukkan lebih banyak konten.
- Heading yang panjang harus boleh wrap; jangan mengandalkan fixed-height text box.
- Paragraph reading width sebaiknya dibatasi agar baris tidak terlalu panjang.
- Type scale tidak perlu memiliki token untuk setiap kemungkinan ukuran.

---

## 10. Spacing

### Base scale

Gunakan skala berbasis kelipatan 4 dengan token utama:

```text
4 · 8 · 12 · 16 · 24 · 32 · 48 · 64 · 96
```

`128` hanya digunakan sebagai pengecualian untuk area section besar yang memang
memerlukan pemisahan editorial. Nilai tersebut bukan default setiap halaman.

### Penggunaan

| Jenis | Rentang | Contoh penggunaan |
|---|---:|---|
| Micro spacing | 4–12 | Icon ke label, label ke input, badge internal |
| Component spacing | 12–24 | Field group, card content, button group |
| Content spacing | 24–48 | Paragraf, content block, card antar-item |
| Section spacing | 48–96 | Pemisah antar tujuan informasi |
| Large editorial spacing | 96–128 | Hanya untuk section yang benar-benar membutuhkan breathing room |

### Mobile vs desktop

- Mobile mengurangi section spacing secara proporsional, bukan menghapus hierarchy.
- Padding horizontal mobile harus menjaga teks dan control tetap nyaman dibaca.
- Desktop boleh memiliki whitespace lebih besar bila membantu fokus, bukan sekadar
  membuat halaman terlihat kosong.
- Jangan memakai margin arbitrer untuk memperbaiki layout satu halaman.

---

## 11. Layout Principles

### Content width

- Gunakan max-width konten utama sekitar 1120–1280px sesuai kebutuhan halaman.
- Reading content seperti Article, KPR education, dan About sebaiknya dibatasi ke
  sekitar 65–75 karakter per baris.
- Project gallery atau photography boleh menggunakan area yang lebih lebar dari
  reading column.
- Full-bleed hanya digunakan bila foto atau warna memang membutuhkan edge-to-edge
  treatment dan tetap aman pada mobile.

### Gutters

- Mobile: gutter konseptual 16–20px.
- Tablet: gutter konseptual 24–32px.
- Desktop: gutter konseptual 32–48px.

Nilai akhir harus mengikuti konten dan accessibility, bukan device-specific tuning
yang berlebihan.

### Grid philosophy

- Gunakan grid fleksibel dengan 1 kolom pada mobile dan beberapa kolom pada layar
  lebih besar bila konten mendukung.
- Project card, Article card, dan Vacancy card mengikuti grid yang sama secara
  ritme, tetapi tidak harus memiliki ukuran visual identik.
- Form dan KPR simulator memprioritaskan urutan baca dan input, bukan kepadatan.
- Jangan membuat setiap blok menjadi card; section tanpa container sering lebih
  tenang dan editorial.

### Mobile-first behavior

Pada layar kecil, konten menumpuk dengan urutan yang jelas. Tidak boleh ada
horizontal scrolling yang tidak perlu, card yang memaksa teks terlalu pendek, atau
CTA penting yang hanya terlihat setelah kembali ke Home.

---

## 12. Radius

Gunakan rounding moderat untuk membuat interface approachable tanpa terasa seperti
toy UI.

| Token | Konsep | Penggunaan |
|---|---:|---|
| Small | 6–8px | Input, small card detail, image crop, control sederhana |
| Medium | 10–12px | Card utama, form surface, notice |
| Large | 16–20px | Feature surface, photo frame, section yang memang membutuhkan warmth |
| Pill | 999px | Badge, compact status, filter token, bukan semua button |

### Aturan

- Jangan membuat semua elemen pill-shaped.
- Jangan mencampur banyak radius tanpa hierarchy.
- Surface yang cukup editorial dapat tidak memakai radius sama sekali.
- Radius tidak boleh menyembunyikan hubungan antara Project Status dan Unit Status.

---

## 13. Borders & Shadows

### Border

Gunakan border ketika pengguna perlu memahami batas, grouping, atau state:

- input dan select;
- divider yang membantu scanning;
- card yang membutuhkan separation pada background yang sama;
- focus/selected state bila tidak cukup dengan background.

Gunakan border tipis dan low-contrast secara default. Border yang terlalu gelap
membuat halaman terasa seperti dashboard.

### Shadow

Gunakan subtle shadow hanya ketika ada hubungan elevation yang nyata, misalnya:

- menu atau popover yang berada di atas content;
- floating control yang perlu terpisah;
- feature card tertentu pada background datar.

Card biasa sebaiknya memakai background contrast atau border ringan, bukan shadow
berat. Hindari semua card terlihat seperti widget SaaS yang melayang.

### No container

Section editorial, paragraph, gallery, dan content list boleh tampil tanpa border
atau shadow bila whitespace sudah cukup membedakan konteksnya.

---

## 14. Button Hierarchy

### Primary

Primary button adalah satu action paling penting dalam konteks tertentu:

- global: `Cari Rumah`;
- Project Detail: `Chat WhatsApp` melalui Primary Branch;
- context lain: action utama yang benar-benar menyelesaikan tujuan pengguna.

Treatment konseptual: Primary Green dengan teks yang memiliki kontras memadai.

### Secondary

Secondary button mendukung primary action tanpa bersaing dengannya:

- `Lihat Ketersediaan`;
- `Pelajari KPR`;
- `Buka Detail` pada card bila konteks membutuhkan;
- telephone atau form alternatif pada Project.

Treatment dapat berupa outline, soft surface, atau neutral filled control sesuai
background.

### Tertiary / Text

Tertiary action digunakan untuk navigasi ringan atau pilihan yang tidak boleh
mengambil perhatian utama:

- `Baca selengkapnya`;
- `Lihat artikel lain`;
- kembali ke daftar;
- link ke informasi pendukung.

### Destructive

Destructive hanya untuk operasi internal/admin atau tindakan yang benar-benar
merusak data. Jangan memakai red sebagai CTA publik biasa.

### States

Setiap button atau control yang relevan harus memiliki prinsip untuk:

- normal;
- hover, bila pointer tersedia;
- focus-visible;
- active/pressed;
- disabled;
- loading.

Loading state tidak boleh menghilangkan konteks action. Disabled state harus tetap
terbaca dan tidak boleh disalahartikan sebagai error. Focus harus terlihat tanpa
mengandalkan hover.

### Rule satu primary

Jangan membuat semua action menjadi Primary. Dalam satu konteks visual, satu action
utama harus jelas; action lain turun ke Secondary atau Tertiary.

---

## 15. Links

- Inline link harus dapat dikenali tanpa hanya mengandalkan perbedaan warna.
- Underline atau treatment visual lain digunakan pada paragraph link bila perlu.
- Link menuju Project, Article, KPR, dan Contact harus memiliki label yang jelas,
  bukan hanya `klik di sini`.
- Hover adalah enhancement, bukan satu-satunya state.
- Focus-visible harus tampak jelas.
- Visited state dapat digunakan untuk long-form editorial bila membantu orientasi,
  tetapi tidak boleh membuat semantic color membingungkan.
- Text link tidak boleh terlihat identik dengan body text atau badge.

---

## 16. Form System

### Field principles

Semua field memiliki persistent label. Placeholder bukan pengganti label. Helper
text digunakan untuk menjelaskan format atau tujuan, bukan untuk menyembunyikan
persyaratan penting.

Lead form yang disetujui hanya memakai:

- Name;
- WhatsApp / telephone;
- Interested Project;
- consent;
- optional Message.

Jangan menambahkan salary, NIK, SLIK, employment data, financial history, atau
qualification panjang pada kontak awal.

### Field types

| Field | Prinsip |
|---|---|
| Text input | Label persisten, contoh format bila membantu, dan error dekat dengan field |
| Telephone input | Mendukung input smartphone dan menjelaskan format yang diharapkan |
| Select | Menjelaskan pilihan dan state terpilih; tidak memaksa daftar terlalu panjang tanpa grouping |
| Search | Memiliki label atau accessible name, state loading, clear, dan no-result |
| Textarea | Message optional; tidak digunakan untuk pertanyaan qualification yang tidak disetujui |
| Checkbox | Consent memiliki copy yang jelas dan tidak pre-checked secara default |
| Field label | Terhubung secara konseptual dengan field dan tetap terlihat setelah input |
| Helper text | Informasi pendukung yang tidak menggantikan error atau label |

### States

- **Default:** border dan label jelas.
- **Focus:** focus ring terlihat dan tidak hanya berubah warna samar.
- **Filled:** nilai mudah dibaca dan label tetap teridentifikasi.
- **Error:** error menjelaskan apa yang perlu diperbaiki; tidak hanya border merah.
- **Success:** konfirmasi apa yang berhasil dan next action bila ada.
- **Disabled:** menjelaskan bahwa control belum tersedia atau tidak dapat dipakai.
- **Loading:** mempertahankan konteks dan tidak membuat pengguna mengirim ulang
  tanpa informasi.
- **Consent:** tujuan pemrosesan dan link policy bila tersedia harus mudah dipahami.

### Smartphone

Form harus nyaman disentuh, tidak memerlukan zoom, tidak menyebabkan horizontal
scroll, dan tidak memaksa pengguna mengingat pilihan dari langkah sebelumnya.
Error harus tetap terlihat setelah keyboard muncul.

---

## 17. Search & Filters

Housing Directory menggunakan filter yang disetujui:

- City / Regency;
- Province sebagai pilihan opsional, browsing level, atau grouping;
- Project Status.

### Prinsip interaksi

1. Direct City/Regency selection harus menjadi jalur first-class.
2. Province tidak boleh menjadi Province-first gate bagi pengguna yang sudah tahu
   City/Regency.
3. Selected filter selalu terlihat dan dapat dihapus satu per satu.
4. `Clear filter` mengembalikan pencarian ke state yang dapat dipahami, bukan
   menghapus konteks tanpa penjelasan.
5. Loading state memberi indikasi bahwa hasil sedang diperbarui.
6. No-result state menjelaskan kombinasi yang dipilih dan memberi next action.
7. Filter state bukan otomatis halaman SEO.
8. Jangan menambahkan filter harga, gaji, luas, kamar, atau qualification yang
   belum disetujui.

### Search behavior

Search harus toleran terhadap variasi penulisan lokasi yang wajar, tetapi hasil
yang ditampilkan tetap harus berasal dari data yang valid. Empty result tidak boleh
diisi Project yang hanya mirip tetapi tidak sesuai.

---

## 18. Card System

Card adalah pola grouping, bukan kewajiban untuk setiap content block. Setiap card
harus memiliki satu tujuan dan tidak memuat seluruh field sumber.

### Project Card

Dapat memuat:

- photography atau fallback image;
- nama Project;
- City/Regency atau konteks lokasi utama;
- Project Status;
- satu supporting information yang berguna;
- satu action menuju detail.

Availability hanya ditampilkan bila source jelas dan tidak membuat card terlalu
padat. Harga publik tidak wajib. Jangan menampilkan setiap House Type, fasilitas,
atau internal contact pada card.

### Article Card

Dapat memuat:

- image/editorial thumbnail;
- category atau topic label;
- judul;
- tanggal atau metadata yang memang berguna;
- short excerpt bila membantu scanning.

Article card tidak boleh memaksa semua artikel menjadi sales card. Related Project
adalah optional.

### Vacancy Card

Dapat memuat:

- posisi;
- lokasi/department bila tersedia dan relevan;
- status aktif;
- short summary;
- action menuju detail.

Closed Vacancy tidak muncul pada active listing; jika detail dipertahankan, status
`Lowongan Ditutup` harus terlihat jelas dan tidak ada application action.

### Location Card

Location Card hanya digunakan bila lokasi memiliki tujuan discovery yang nyata.
Card dapat memuat nama City/Regency atau Province, jumlah/context Project bila valid,
dan action ke hasil lokasi. Jangan membuat card untuk thin atau empty location.

### Card rules

- Satu card memiliki satu primary destination.
- Card dapat berupa surface tanpa shadow.
- Text boleh wrap; jangan memotong judul penting dengan fixed-height.
- Status dan CTA tidak boleh memiliki hierarchy yang lebih lemah daripada dekorasi.

---

## 19. Badges & Labels

### Kategori

| Kategori | Visual rule |
|---|---|
| Project Status | Soft/outline treatment, konteks `Project`, tidak memakai Unit Status colors |
| Unit Status | Operational status treatment, label `Tersedia`, `Terbooking`, `Terjual`, dan marker non-color |
| Article category | Editorial accent yang tenang; tidak memakai warna error/success |
| Vacancy status | Active atau `Lowongan Ditutup`; closed tidak boleh tampak actionable |

### Prinsip

- Badge menjelaskan, bukan menggantikan heading atau body copy.
- Label tidak boleh terlalu kecil pada mobile.
- Status selalu ditulis sebagai text.
- Icon atau shape hanya memperkuat arti, bukan menjadi satu-satunya penanda.
- Jangan memakai green badge untuk semua kategori.
- Badge tidak boleh memaksa kalimat panjang ke dalam pill sempit.

---

## 20. Photography & Images

Fotografi adalah elemen utama untuk membuat Marison terasa nyata dan aspiratif.

### Prioritas sumber

1. Real Marison Project photography.
2. Real development/progress photography.
3. Real housing environment photography.
4. Neutral fallback/placeholder bila diperlukan.

Generic stock-property photography bukan sumber defining brand. Bila stock image
terpaksa digunakan pada konteks tertentu, image tersebut tidak boleh menyamar
sebagai foto Project Marison.

### Aspect-ratio principles

| Konteks | Rekomendasi konseptual |
|---|---|
| Project hero | Landscape lebar, sekitar 16:9 atau 3:2, dengan focal point yang aman untuk crop |
| Project card | Landscape sekitar 4:3 atau 3:2 untuk menjaga detail rumah dan lingkungan |
| Article card | 16:9 atau 3:2 sesuai gaya editorial |
| Gallery | Campuran landscape/portrait boleh, tetapi metadata dan crop harus konsisten |
| Mobile crop | Fokus utama tetap terlihat; jangan memotong rumah, manusia, atau konteks penting |

### Fallback

Jika gambar belum tersedia:

- gunakan surface Warm Cream/Soft Sage yang tenang;
- tampilkan label bahwa foto belum tersedia bila konteks membutuhkannya;
- gunakan neutral fallback/placeholder hanya bila diperlukan;
- jangan menampilkan generic image seolah-olah itu Project Marison;
- jangan membuat gallery kosong dengan placeholder berulang.

### Caption

Caption digunakan bila membantu memahami lokasi, tahap pembangunan, atau konteks
foto. Caption bukan tempat untuk fake urgency atau klaim yang tidak didukung.

Gambar perlu memiliki alternative text yang bermakna untuk fungsi informasional.
Gambar dekoratif tidak boleh mengganggu screen reader experience.

---

## 21. Iconography

Gunakan satu keluarga icon yang:

- simple;
- consistent;
- modern;
- recognizable;
- memiliki bentuk yang tetap terbaca pada ukuran kecil.

### Aturan

- Prefer outlined atau single-style icon set secara konsisten.
- Filled icon boleh digunakan sebagai state khusus bila ada alasan yang jelas,
  tetapi jangan mencampurnya tanpa rule.
- Jangan mencampur outlined, filled, 3D, emoji, dan decorative icon sebagai satu
  bahasa visual.
- Icon mendukung teks; icon tidak menggantikan label `Tersedia`, `Terbooking`,
  `Terjual`, atau CTA penting.
- Icon status harus memiliki bentuk/marker berbeda bila diperlukan untuk membantu
  pengguna color vision deficiency.
- Gunakan icon location, telephone, WhatsApp, KPR, dan navigation dengan makna yang
  umum; jangan memakai icon abstrak untuk action kritis.

Tidak ada icon library yang dipilih atau di-install dalam dokumen ini.

---

## 22. Motion

Motion harus membantu orientasi atau feedback, bukan menjadi attraction utama.

### Dapat digunakan

- subtle hover transition;
- perubahan state button atau filter;
- small section entrance effect bila tidak mengganggu reading;
- transisi expand/collapse pada FAQ atau detail;
- feedback sukses/error yang tidak memindahkan fokus secara mengejutkan.

### Hindari

- scroll hijacking;
- parallax overload;
- text animation yang memperlambat reading;
- large cinematic intro;
- autoplay motion yang mengalihkan perhatian dari housing information;
- infinite animation pada status atau CTA.

### Motion principles

- Durasi konseptual: short untuk control feedback, standard untuk state transition,
  dan long hanya untuk konteks yang benar-benar membutuhkan; jangan membuat motion
  terasa lambat.
- `prefers-reduced-motion` harus dihormati.
- State tetap dapat dipahami tanpa animasi.
- Motion tidak boleh menyembunyikan error, availability, status, atau CTA.

---

## 23. Accessibility

Target konseptual minimum adalah WCAG AA.

### Visual dan teks

- Sufficient color contrast untuk body, heading, label, link, status, dan CTA.
- Body text tetap readable pada smartphone; jangan mengandalkan text kecil untuk
  menampung terlalu banyak informasi.
- Heading hierarchy mengikuti struktur informasi, bukan hanya ukuran visual.
- Buttons dapat dibedakan dari inline links dan body text.
- Focus-visible harus jelas untuk keyboard dan input navigation.

### Status dan feedback

- Error, success, warning, Unit Status, dan Project Status tidak boleh disampaikan
  melalui warna saja.
- Setiap status memiliki text; icon/shape digunakan bila membantu.
- Empty state menjelaskan kondisi tanpa menyalahkan pengguna.
- Form error ditempatkan dekat dengan field dan memiliki pesan yang actionable.
- Loading state memiliki semantic label yang dapat dipahami.

### Forms dan touch

- Semua field memiliki persistent label dan accessible name.
- Consent tidak pre-checked.
- Touch target harus nyaman untuk smartphone dan tidak memerlukan precision kecil.
- Control penting tidak bergantung pada hover.
- Tidak ada horizontal scrolling sebagai syarat untuk menggunakan form atau membaca
  status.

### Motion dan media

- Reduced motion didukung.
- Video atau motion tidak autoplay tanpa kontrol yang jelas.
- Foto informasional memiliki alternative text.
- Decorative image tidak mengulang informasi yang sudah ada di text.

Accessibility harus diuji secara teknis pada implementasi, bukan dianggap selesai
hanya karena token telah ditulis.

---

## 24. Responsive Principles

Responsive behavior mobile-first dan menggunakan sedikit behavioral ranges:

| Range konseptual | Fokus |
|---|---|
| Small smartphone | Satu kolom, text wrap, CTA dan form nyaman disentuh |
| Large smartphone | Ruang tambahan untuk card/media tanpa mengubah hierarchy |
| Tablet | Grid mulai melebar; reading width tetap terkendali |
| Laptop/desktop | Multi-column content dan photography dengan max-width |
| Wide desktop | Whitespace bertambah secara terkontrol; content tidak melebar tanpa batas |

Tidak perlu puluhan breakpoint device-specific. Breakpoint implementasi dipilih
kemudian berdasarkan perubahan layout nyata, bukan berdasarkan daftar perangkat.

### Responsive requirements

- Cari Rumah dan Project contact tetap mudah ditemukan pada layar kecil.
- Project Status, Unit availability, lokasi, dan WhatsApp tidak boleh tersembunyi
  di balik interaction yang sulit.
- Card dapat berubah dari grid ke stack tanpa membuat content hilang.
- Table-like information harus memiliki strategi baca mobile yang jelas.
- Font, image crop, dan spacing boleh menyesuaikan, tetapi hierarchy tetap sama.
- Tidak ada zoom atau horizontal scrolling yang tidak perlu.

---

## 25. Feedback / Empty / Error States

Semua state harus menjawab tiga hal: apa yang terjadi, apa yang tidak tersedia, dan
apa langkah berikutnya bila ada.

| State | Prinsip visual dan copy | Next action |
|---|---|---|
| No Project results | Netral, jelas, tidak menyalahkan filter pengguna | Hapus filter, pilih City/Regency lain, perluas Province, atau lihat semua Project |
| No digitized Unit data | Nyatakan bahwa detail Unit belum terdigitalisasi; jangan menampilkan angka palsu | Hubungi Branch untuk konfirmasi |
| Branch contact unavailable | Gunakan notice yang jujur dan tidak menawarkan Branch acak | Telephone valid, approved central fallback bila configured, atau stop dengan informasi jelas |
| KPR calculator unavailable | Pertahankan edukasi; jelaskan simulator sementara tidak tersedia | Cari Rumah atau General Contact |
| Closed Vacancy | Label `Lowongan Ditutup`, visual tidak actionable | Kembali ke Karier atau lowongan aktif lain |
| Missing translation | Informasikan English belum tersedia dan pertahankan konteks | Tetap di/kembali ke konten Indonesia yang bersesuaian |
| Form error | Beri pesan field-specific dan pertahankan input yang valid | Perbaiki input dan kirim kembali |
| Form success | Konfirmasi pengiriman dan jelaskan next step tanpa janji berlebihan | Kembali ke Project, baca informasi lain, atau tutup state |
| Loading | Pertahankan ruang dan hierarchy secukupnya tanpa fake content | Tunggu atau retry bila error berikutnya muncul |

### State rules

- Jangan mengisi empty state dengan konten fiktif.
- Jangan menyamarkan unavailable sebagai success.
- Jangan memakai red untuk semua kondisi kosong; banyak empty state bersifat netral.
- Notice tidak boleh menjadi dinding text yang menghalangi tujuan utama.
- State harus tetap readable ketika diterjemahkan ke English yang lebih panjang.

---

## 26. Language & Content Tone

### Bahasa

- Bahasa Indonesia adalah canonical/source content.
- English adalah linked translation, bukan copy independen yang kehilangan context.
- UI harus memiliki ruang untuk perbedaan panjang teks antarbahasa.
- Jangan membuat button width atau fixed-height text container yang hanya aman untuk
  Bahasa Indonesia.
- Status, kontak, dimensi, koordinat, dan structured data tetap shared source.

### Tone

Tone Marison harus:

- jelas;
- approachable;
- membantu;
- confident;
- tidak over-promotional.

### UX writing rules

- Utamakan istilah yang dipahami first-home buyer.
- Jelaskan istilah KPR atau teknis bila diperlukan.
- Hindari corporate jargon dan copy yang terasa memaksa.
- Hindari excessive English pada Indonesian interface.
- Gunakan `Cari Rumah`, bukan `Explore Property`, bila maksudnya sama.
- Gunakan label status yang disetujui: `Akan Datang`, `Sedang Berjalan`, `Selesai`,
  `Tersedia`, `Terbooking`, `Terjual`, dan `Lowongan Ditutup`.
- CTA menyatakan hasil action, bukan tekanan: `Lihat Ketersediaan` lebih informatif
  daripada copy urgency yang tidak didukung data.

---

## 27. Design Tokens

Token berikut adalah kategori dan arah konseptual. Ini bukan production CSS
variable, file theme, atau API komponen.

| Kategori | Token yang perlu disiapkan | Prinsip |
|---|---|---|
| Color | Brand, semantic, surface, text, border, focus, status | Roles harus konsisten; jangan memakai raw color tanpa alasan |
| Typography | Family, weight, size, line-height, letter spacing | Gunakan type scale terbatas dan responsive |
| Spacing | 4–96 dengan exceptional 128 | Semua jarak berasal dari rhythm yang dapat dipahami |
| Radius | Small, Medium, Large, Pill | Rounding moderat dan tidak seragam secara buta |
| Border | Default, strong, focus, selected | Border membantu state dan grouping |
| Shadow | None, subtle, overlay | Elevation jarang dan bermakna |
| Motion | Short, standard, reduced-motion | Motion tidak menghalangi task |
| Layer/elevation | Base, raised, overlay, modal bila diperlukan | Hanya gunakan saat hubungan kedalaman nyata |
| Content state | Default, hover, focus, disabled, loading, empty, error, success | State harus reusable lintas content type |

Implementasi kelak harus memetakan token ini ke platform yang dipilih tanpa
mengubah makna visualnya secara diam-diam.

---

## 28. Component Inventory

Inventory ini adalah daftar awal untuk wireframe dan development berikutnya. Tidak
ada komponen yang diimplementasikan oleh dokumen ini.

| Komponen | Klasifikasi | Peran awal |
|---|---|---|
| Header | NAVIGATION | Brand, main navigation, language, dan entry CTA |
| Mobile Navigation | NAVIGATION | Akses menu inti pada smartphone tanpa menambah Lokasi sebagai nav baru |
| Footer | NAVIGATION | Secondary navigation, legal, language, dan corporate contact context |
| Breadcrumb | NAVIGATION | Menjaga context pada Project, Article, Vacancy, atau location |
| Pagination | NAVIGATION | Menavigasi archive/list yang panjang tanpa infinite scroll wajib |
| Button | FOUNDATIONAL | Hierarchy Primary, Secondary, Tertiary, dan Destructive |
| Text Link | FOUNDATIONAL | Inline dan contextual navigation yang identifiable |
| Badge | FOUNDATIONAL | Project Status, Unit Status, Article category, Vacancy status |
| Alert / Notice | FEEDBACK | Informasi, warning, unavailable, atau error yang perlu perhatian |
| Search Field | FORM | Pencarian lokasi/Project dengan clear dan loading state |
| Filter | FORM | City/Regency, Province opsional, dan Project Status |
| Form Field | FORM | Input dengan label, helper, error, success, disabled, loading |
| Select | FORM | Pilihan terstruktur untuk Project, lokasi, atau parameter yang disetujui |
| Checkbox | FORM | Consent dan pilihan yang benar-benar membutuhkan multiple state |
| KPR Input | FORM | Input simulator sesuai scheme dan disclaimer |
| Project Card | CONTENT | Discovery card dengan foto, nama, lokasi, status, dan action |
| House Type Summary | CONTENT | Ringkasan tipe rumah yang dimiliki Project |
| Availability Summary | CONTENT | Summary status Unit dari source yang jelas |
| Unit Status | CONTENT | Status Tersedia, Terbooking, atau Terjual dengan non-color cue |
| Article Card | CONTENT | Entry editorial tanpa memaksa sales funnel |
| Vacancy Card | CONTENT | Listing Vacancy aktif dengan status dan detail action |
| Location Card | CONTENT | Discovery lokasi yang hanya dipakai bila memiliki nilai nyata |
| CTA Section | CONTENT | Grouped next action dengan satu hierarchy utama |
| Gallery | CONTENT | Presentasi foto Project dengan fallback dan caption |
| Accordion / FAQ | CONTENT | Content tambahan, terutama KPR atau pertanyaan yang dapat dipindai |
| KPR Result | FEEDBACK | Estimated result, disclaimer, unavailable, dan next action |
| Empty State | FEEDBACK | No-result, no-data, unavailable, dan recovery |

### Prioritas pembentukan

1. FOUNDATIONAL dan NAVIGATION menjadi basis konsistensi.
2. FORM diperlukan untuk discovery, Project contact, dan KPR.
3. CONTENT mengikuti kebutuhan Project, Article, Vacancy, dan About.
4. FEEDBACK harus tersedia sebelum state kosong/error dianggap selesai.

---

## 29. Design Anti-Patterns

Marison harus secara eksplisit menghindari:

1. **Elementor-style visual clutter:** terlalu banyak section, badge, divider, dan
   style lokal yang tidak mengikuti system.
2. **Excessive nested cards:** card di dalam card di dalam card sampai hierarchy
   tidak dapat dibaca.
3. **Gradients everywhere:** gradient bukan pengganti hierarchy atau photography.
4. **Large glowing backgrounds:** glow dan neon green mengalahkan content serta
   membuat pengalaman terasa campaign-only.
5. **Generic luxury-property language:** black/gold, marble, dan copy eksklusif yang
   tidak relevan dengan first-home buyer.
6. **Excessive animation:** motion tidak boleh membuat user menunggu atau kehilangan
   informasi.
7. **Oversized hero hiding useful actions:** hero tidak boleh menunda Cari Rumah,
   lokasi, atau Project discovery.
8. **Overly small text:** jangan mengorbankan readability untuk memuat lebih banyak
   metadata.
9. **Low contrast:** jangan memakai Muted Gray, green muda, atau text di atas foto
   tanpa validasi contrast.
10. **Fake urgency:** countdown, flash, atau klaim keterbatasan yang tidak memiliki
    sumber data.
11. **Too many CTA colors:** setiap action tidak membutuhkan warna brand baru.
12. **Inconsistent border radii:** radius tidak berubah-ubah tanpa hierarchy.
13. **Dense mobile UI:** terlalu banyak filter, field, metadata, atau CTA dalam satu
    viewport.
14. **Color-only status:** status yang hanya dibedakan melalui hue tidak acceptable.
15. **Bank dashboard imitation:** KPR tidak boleh membuat seluruh produk terasa
    seperti aplikasi finansial.
16. **Fake photography:** stock image tidak boleh dipresentasikan sebagai Project
    Marison yang nyata.

---

## 30. Open Design Questions

Pertanyaan berikut berkaitan langsung dengan visual foundation, tetapi tidak
memblokir seluruh Design System karena arah sementara yang aman telah ditentukan.

### DS-Q01 — Final approved Marison logo variants

**STATUS:** OPEN / NON-BLOCKING.

**RECOMMENDED DEFAULT:** siapkan system untuk normal logo, logo yang sesuai pada
light background, dan logo yang sesuai pada dark background hanya bila official
assets mendukungnya. Gunakan logo resmi sebagai asset brand terpisah.

Jangan menginvent atau menggambar ulang logo. Horizontal dan compact variant hanya
digunakan bila memang disediakan atau disetujui sebagai official asset.

**WHY:** logo harus mempertahankan identitas dan keterbacaan pada Header, Footer,
dan background yang berbeda.

**IMPACT:** tanpa variant final, visual detail Header/Footer dan minimum clear-space
belum dapat difinalkan; palette dan token tetap dapat berjalan.

### DS-Q02 — Official corporate font, jika ada

**STATUS:** RESOLVED FOR V1 — Plus Jakarta Sans, kecuali Marison kemudian
menyediakan official corporate typeface.

**RECOMMENDED DEFAULT:** gunakan Plus Jakarta Sans sebagai default V1 dengan
fallback Inter/system sans-serif.

**WHY:** satu sans-serif praktis, mudah dibaca, dan sesuai dengan karakter
approachable Marison.

**IMPACT:** jika font resmi berbeda, type metrics, wrapping, dan beberapa ukuran
layout perlu disesuaikan; hierarchy tidak perlu berubah.

### DS-Q03 — Official brand guideline

**STATUS:** OPEN / NON-BLOCKING.

**RECOMMENDED DEFAULT:** pertahankan palette preliminary dan prinsip visual dokumen
ini sebagai working direction, tanpa mengklaimnya sebagai brand guideline final.

**WHY:** green identity harus konsisten sementara aturan brand resmi belum tersedia.

**IMPACT:** guideline resmi dapat mengubah logo usage, tone, color refinement, atau
typography; komponen dan prinsip accessibility tetap dipertahankan.

### DS-Q04 — Final photography library

**STATUS:** OPEN / NON-BLOCKING.

**RECOMMENDED DEFAULT:** gunakan real Marison Project photography sebagai prioritas,
diikuti real development/progress photography dan real housing environment
photography; gunakan neutral fallback bila foto belum tersedia; jangan membuat foto
palsu.

**WHY:** foto autentik meningkatkan trust dan membedakan Marison dari template
property generic.

**IMPACT:** rasio/crop dan art direction halaman dapat disesuaikan setelah library
tersedia, tetapi image token dan fallback tetap berlaku.

### DS-Q05 — Corporate blue pada logo saat ini

**STATUS:** RESOLVED FOR V1 — primarily logo-only / highly restrained.

**RECOMMENDED DEFAULT:** jika logo resmi memiliki blue, pertahankan blue hanya pada
logo asset atau konteks brand yang disetujui; jangan menambahkan blue sebagai
competing primary UI color.

**WHY:** mencegah palette UI melebar dan mengurangi konflik antara green identity
dan warna logo yang mungkin bersifat asset-specific.

**IMPACT:** keputusan final dapat menambah token brand secondary, tetapi tidak perlu
mengubah semantic success, warning, error, atau status Unit.

### Status pertanyaan

| Pertanyaan | Status | Dampak |
|---|---|---|
| Final logo variants | OPEN / NON-BLOCKING | Detail asset dan clear-space final menunggu official production assets. |
| Official corporate font | RESOLVED FOR V1 | Plus Jakarta Sans dipakai sampai official corporate typeface tersedia. |
| Official brand guideline | OPEN / NON-BLOCKING | Palette dan prinsip tetap sebagai working direction sementara. |
| Final photography library | OPEN / NON-BLOCKING | Art direction dan crop dapat disempurnakan setelah library tersedia. |
| Corporate blue usage | RESOLVED FOR V1 | Logo-only atau highly restrained; green tetap dominan. |

Tidak ada pertanyaan di atas yang menjadi Design System blocker. Asset atau guideline
resmi yang belum tersedia tidak boleh diganti dengan asset buatan atau asumsi brand
baru.

---

## 31. Acceptance Criteria

Design System v1 dapat ditinjau terhadap checklist berikut:

- [ ] Website memiliki arah visual Marison yang koheren dari Home sampai Project,
      Article, Vacancy, KPR, About, dan Contact.
- [ ] Green tetap menjadi identitas Marison tanpa dipakai sebagai satu-satunya
      warna untuk semua semantic state.
- [ ] Arah visual terasa modern, approachable, trustworthy, optimistic, clean, dan
      aspirational tanpa menjadi luxury-only.
- [ ] Project Status dan Unit Status memiliki hierarchy, treatment, dan semantics
      yang berbeda.
- [ ] Tersedia, Terbooking, dan Terjual memiliki warna yang dapat dibedakan serta
      text/icon/shape non-color cue.
- [ ] Typography memiliki family recommendation, hierarchy, responsive scale, dan
      fallback strategy.
- [ ] Mobile readability, wrapping, touch comfort, dan reduced motion diprioritaskan.
- [ ] CTA hierarchy menetapkan Cari Rumah sebagai global primary dan Chat WhatsApp
      sebagai Project conversion CTA.
- [ ] Lihat Ketersediaan dan Pelajari KPR tidak bersaing sebagai primary action
      tanpa alasan konteks.
- [ ] Form mengikuti field minimum PRD dan tidak menambah qualification fields.
- [ ] Search/filter mendukung direct City/Regency dan Province opsional.
- [ ] Card principles mencegah Project, Article, Vacancy, dan Location card menjadi
      terlalu padat.
- [ ] Photography memprioritaskan foto nyata dan memiliki fallback tanpa fake image.
- [ ] Iconography, motion, radius, border, dan shadow memiliki aturan konsisten.
- [ ] WCAG AA menjadi target minimum konseptual dan accessibility tidak bergantung
      pada warna saja.
- [ ] Empty, error, unavailable, success, closed, dan missing translation states
      memiliki prinsip serta next action yang jelas.
- [ ] Bahasa Indonesia canonical, English secondary, dan teks berbeda panjang dapat
      ditampung tanpa fixed-height yang rapuh.
- [ ] Token categories terdokumentasi tanpa menulis production CSS variables.
- [ ] Component inventory diklasifikasikan menjadi FOUNDATIONAL, CONTENT,
      NAVIGATION, FORM, dan FEEDBACK.
- [ ] Anti-pattern visual Marison didokumentasikan secara eksplisit.
- [ ] Open Design Questions memiliki recommended default, why, dan impact tanpa
      dianggap sebagai keputusan final Marison.
- [ ] Dokumen tidak membuat UI lengkap, wireframe, PHP, CSS production, plugin,
      library, atau asset production.

---

Dokumen ini menjadi fondasi visual dan interaksi untuk pekerjaan wireframe berikutnya.
Wireframe tetap harus memvalidasi hierarchy, responsive behavior, content density,
dan state nyata tanpa mengubah prinsip system secara diam-diam.
