# 🚀 Nama Proyek: My Modern Portfolio & Shop

## 🌟 Ringkasan Proyek

Web ini adalah proyek *front-end* minimalis yang berfungsi sebagai Portofolio dan *Landing Page* E-commerce sederhana. Web ini menampilkan proyek-proyek terbaru (*Project Section*) dan item-item yang dijual (*Shop Section*), dengan desain yang fokus pada kontras warna Hitam dan Pink.

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan teknologi dasar *front-end*:

  * **HTML5:** Untuk struktur dasar dan konten web.
  * **CSS3 (Vanilla CSS):** Untuk seluruh gaya dan tata letak, termasuk:
      * **CSS Variables (Custom Properties):** Untuk manajemen warna dan *spacing* yang konsisten.
      * **CSS Grid & Flexbox:** Untuk tata letak *desktop* dan responsif (seperti tata letak *Card*).
      * **CSS Keyframes:** Digunakan untuk animasi *Marquee* (tulisan berjalan) yang *infinite*.
  * **JavaScript (Minimal):** Hanya digunakan untuk fungsionalitas:
      * *Progress Bar* (Status gulir halaman).
      * *Burger Menu* (yang akan kita kembangkan untuk tampilan *mobile*).

## 🖼️ Fitur Utama

  * **Progress Bar:** Indikator di *navbar* yang menunjukkan status *scroll* halaman.
  * **Infinite Marquee:** Tulisan berjalan yang bergerak horizontal tanpa henti, memisahkan *navbar* dan konten utama.
  * **Modern Card Layout:** Tata letak *card* responsif dengan *Box Shadow* unik (Pink) dan desain kontras (Hitam-Pink) menggunakan CSS Grid.
  * **Header Navigasi:** Dilengkapi dengan *Search Bar* yang berpusat di *desktop*.

## 📂 Struktur File

```
.
├── css/
│   ├── _base.css         # Reset CSS, font, dan definisi CSS Variables (Warna, Spacing)
│   ├── _layout.css       # Gaya untuk elemen besar (Header, Footer, Section, Grid)
│   ├── _components.css   # Gaya untuk komponen yang dapat digunakan kembali (Card, Button, Search Bar)
│   └── main.css          # File utama yang mengimpor semua file CSS lainnya
├── js/
│   └── main.js           # Logika JavaScript untuk Progress Bar dan Menu
└── index.html          # Halaman utama (Landing Page)
```
