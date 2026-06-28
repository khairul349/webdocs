# WebDocs

Aplikasi menulis dan kolaborasi dokumen secara real-time, dibangun dengan Laravel.

## Fitur

- Buat, edit, dan hapus dokumen
- Kolaborasi real-time dengan pengguna lain
- Riwayat versi dokumen
- Berbagi dokumen lewat link publik

## Instalasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm run build
```

## Menjalankan

```bash
composer run dev
```

Buka di browser: `http://localhost:8000`

## Teknologi

Laravel 13, PHP 8.3+, SQLite, Laravel Reverb (realtime), Quill (editor), Tailwind CSS

---

**Dibuat oleh:**
Nama: Khairul Amri
Kelas: A3