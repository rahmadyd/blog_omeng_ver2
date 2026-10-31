# Portofolio Omeng — Art Director & Senior Software Engineer

Situs portofolio statis berkinerja tinggi yang dibangun dengan **Astro 5 (SSG)**, **TypeScript**, dan **CSS Custom Properties murni**. Dirancang tanpa runtime UI framework berlebih untuk mencapai skor Lighthouse 95+ di perangkat mobile, LCP < 2,0 detik, dan CLS < 0,05.

---

## 🛠️ Stack Teknologi

- **Framework:** Astro 5 (Statis / SSG)
- **Bahasa:** TypeScript
- **Styling:** CSS Native dengan Design Tokens (`src/styles/tokens.css`)
- **Tipografi:** *Bebas Neue* (Display / Judul) & *Poppins* (Body)
- **Konten:** Astro Content Collections (`src/content/karya/`)
- **SEO & Sitemap:** `@astrojs/sitemap`, Open Graph, `robots.txt`
- **Hosting:** Vercel (Preset Astro Otomatis)

---

## 📁 Struktur Direktori

```text
blog_omeng/
├─ public/
│  ├─ favicon.svg
│  └─ robots.txt
├─ src/
│  ├─ content/
│  │  ├─ config.ts            # Skema Zod koleksi "karya"
│  │  └─ karya/               # File Markdown studi kasus
│  │     ├─ nebula-design-system.md
│  │     ├─ aurora-creative-engine.md
│  │     ├─ omeng-brand-identity.md
│  │     ├─ strata-fintech-dashboard.md
│  │     └─ vortex-headless-commerce.md
│  ├─ components/
│  │  ├─ HeroName.astro       # Hero interaktif kursor & responsif
│  │  ├─ ProjectTile.astro    # Tile studi kasus berdesain grid 6 kolom
│  │  └─ Footer.astro         # Bagian kontak (mailto) & footer
│  ├─ layouts/
│  │  ├─ Base.astro           # Meta SEO, tipografi, dan navigasi global
│  │  └─ CaseStudy.astro      # Template halaman detail studi kasus
│  ├─ pages/
│  │  ├─ index.astro          # Beranda (Hero, Karya Pilihan, Kontak)
│  │  ├─ karya/[slug].astro   # Rute dinamis studi kasus
│  │  ├─ tentang.astro        # Filosofi, alat, dan 15 tahun perjalanan
│  │  └─ 404.astro            # Halaman kesalahan ramah navigasi
│  └─ styles/
│     └─ tokens.css           # Token warna, jarak, font, dan reset CSS
├─ astro.config.mjs
├─ vercel.json                # Aturan redirect 301 dari URL PHP lama
├─ tsconfig.json
└─ package.json
```

---

## ✍️ Cara Menambah Studi Kasus Baru

Cukup buat file Markdown baru di dalam folder `src/content/karya/`, contohnya `nama-proyek-baru.md`:

```markdown
---
title: "Nama Proyek Keren"
kind: "Design + Engineering" # Opsi: 'Design' | 'Engineering' | 'Design + Engineering'
role: "Lead Architect"
year: 2025
summary: "Ringkasan 1-2 kalimat (maksimal 160 karakter) mengenai dampak proyek ini."
span: 4                      # Lebar tile di grid: 2, 3, 4, atau 6
featured: true               # true untuk tampil di Beranda
color: "#161622"             # Warna latar belakang card
ink: "#ffffff"               # Warna teks card
client: "Nama Klien / Perusahaan"
duration: "6 Bulan"
liveUrl: "https://proyekanda.com"
repoUrl: "https://github.com/username/repo"
---

## Ringkasan Proyek
Penjelasan konteks proyek...

## Masalah
Tantangan nyata yang dihadapi...

## Pendekatan & Keputusan Kunci
### 1. Keputusan Desain (Art Direction)
...
### 2. Keputusan Teknis (Engineering)
...

## Hasil yang Terverifikasi
- Angka hasil atau metrik dampak konkret...
```

Halaman detail di `/karya/nama-proyek-baru` dan kartu di Beranda akan terbuat otomatis saat build!

---

## 💻 Menjalankan di Lokal

```bash
# Pasang dependensi (jika belum)
npm install

# Jalankan dev server lokal
npm run dev

# Bangun versi produksi statis
npm run build

# Pratinjau hasil build lokal
npm run preview
```

---

## 🚀 Panduan Deploy ke Vercel

1. Pastikan seluruh perubahan sudah di-commit dan di-push ke GitHub:
   ```bash
   git add .
   git commit -m "feat: complete modern portfolio in Astro 5"
   git push origin main
   ```
2. Buka dashboard [Vercel](https://vercel.com) dan pilih **Add New Project**.
3. Import repositori GitHub ini.
4. Vercel akan otomatis mengenali preset **Astro**. Anda tidak memerlukan Environment Variables tambahan.
5. Klik **Deploy**. File `vercel.json` sudah otomatis menangani pengalihan 301 dari URL PHP lama (`/index.php`, `/about.php`, `/myproject.php`) ke rute baru.
