<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel" alt="Laravel 13">
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php" alt="PHP 8.3+">
  <img src="https://img.shields.io/badge/License-MIT-blue?style=flat-square" alt="License MIT">
</p>

<h1 align="center">📝 WebDocs</h1>

<p align="center">
  Aplikasi penulisan dan kolaborasi dokumen secara <b>real-time</b>, dibangun dengan Laravel.
</p>

---

## Tentang WebDocs

WebDocs adalah aplikasi berbasis web untuk menulis, menyimpan, dan mengelola dokumen secara online — mirip Google Docs dalam skala sederhana. Setiap pengguna dapat membuat dokumen, mengundang kolaborator untuk menulis bersama secara real-time, melihat riwayat perubahan, dan membagikan dokumen lewat tautan publik.

## ✨ Fitur Utama

- **Autentikasi pengguna** — daftar, masuk, verifikasi email, dan reset password (berbasis Laravel Breeze).
- **Dokumen pribadi** — buat, edit, dan hapus dokumen tak terbatas dari dashboard.
- **Editor rich text** — menulis dengan format teks menggunakan [Quill](https://quilljs.com).
- **Kolaborasi real-time** — undang pengguna lain sebagai kolaborator dan tulis bersama dalam dokumen yang sama, perubahan tersinkron otomatis lewat WebSocket ([Laravel Reverb](https://laravel.com/docs/reverb) + [Laravel Echo](https://laravel.com/docs/broadcasting)).
- **Indikator aktivitas** — lihat siapa yang sedang mengetik dan aktivitas terbaru pada dokumen secara langsung.
- **Riwayat versi** — setiap perubahan tersimpan sebagai versi, dapat dilihat dan ditelusuri kembali kapan saja.
- **Berbagi dokumen publik** — bagikan dokumen lewat tautan unik tanpa perlu login.
- **Dashboard ringkas** — statistik jumlah dokumen, dokumen yang dibuat hari ini, dan kapan terakhir diubah.

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 13 (PHP 8.3+) |
| Database | SQLite (default), bisa diganti MySQL/PostgreSQL |
| Realtime / WebSocket | Laravel Reverb, Laravel Echo, Pusher JS |
| Editor teks | Quill.js |
| Frontend build | Vite, Tailwind CSS, Alpine.js |
| Autentikasi | Laravel Breeze |

## 📋 Prasyarat

Pastikan sudah terpasang di komputer Anda:

- PHP **8.3** atau lebih baru
- Composer
- Node.js **18+** dan NPM
- Ekstensi PHP: `sqlite3` (atau driver database lain sesuai pilihan)

## 🚀 Instalasi

1. **Clone atau salin proyek ini**, lalu masuk ke direktori proyek:
   ```bash
   cd webdocs
   ```

2. **Install dependency PHP:**
   ```bash
   composer install
   ```

3. **Install dependency JavaScript:**
   ```bash
   npm install
   ```

4. **Salin file environment** dan generate application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Siapkan database** (default menggunakan SQLite):
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

   > Jika ingin memakai MySQL/PostgreSQL, ubah variabel `DB_*` di file `.env` sesuai konfigurasi database Anda sebelum menjalankan migrasi.

6. **(Opsional) Isi data contoh** untuk keperluan testing:
   ```bash
   php artisan db:seed
   ```

7. **Build asset frontend:**
   ```bash
   npm run build
   ```

## ▶️ Menjalankan Aplikasi

### Mode development

Jalankan semua service sekaligus (server Laravel, queue worker, log viewer, dan Vite dev server) dengan satu perintah:

```bash
composer run dev
```

Atau jalankan secara manual di terminal terpisah:

```bash
php artisan serve              # server web
php artisan queue:listen       # worker antrian
npm run dev                    # Vite dev server (hot reload)
php artisan reverb:start       # server WebSocket untuk fitur realtime
```

Aplikasi dapat diakses di `http://localhost:8000`.

### Mode produksi

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan reverb:start
```

> Untuk produksi, jalankan `reverb:start` di balik process manager seperti Supervisor agar tetap berjalan, dan pastikan variabel `REVERB_*` di `.env` sudah disesuaikan (host, port, app key/secret).

## ⚙️ Konfigurasi Penting

Beberapa variabel `.env` yang perlu diperhatikan:

```env
APP_NAME=WebDocs
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite

BROADCAST_CONNECTION=reverb
REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

Agar fitur kolaborasi real-time berfungsi, pastikan `BROADCAST_CONNECTION` diatur ke `reverb` (bukan `log`) dan server Reverb (`php artisan reverb:start`) sedang berjalan.

## 📁 Struktur Proyek Singkat

```
app/
├── Events/            → event broadcasting (update dokumen, typing, aktivitas user)
├── Http/Controllers/  → DocumentController, SharedDocumentController, TypingController, dll
├── Models/             → Document, DocumentVersion, User
resources/views/
├── documents/          → dashboard, editor, riwayat, halaman share
├── auth/               → login, register, reset password, dll
├── layouts/            → layout utama & layout guest
database/migrations/    → struktur tabel documents, document_versions, document_user
```

## 🧪 Menjalankan Test

```bash
composer test
```

atau

```bash
php artisan test
```

## 📄 Lisensi

Proyek ini dibangun di atas framework [Laravel](https://laravel.com) yang dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

---

**Dibuat oleh:**
Nama: Khairul Amri
Kelas: A3