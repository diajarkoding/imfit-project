# Dokumentasi Proyek IMFIT

IMFIT adalah aplikasi backend berbasis Laravel untuk pelacakan latihan (workout) dan perkembangan fisik pengguna. Aplikasi ini menyediakan API untuk mengelola latihan, mencatat sesi latihan, dan melacak berat badan pengguna.

## 🛠 Teknologi yang Digunakan

- **Framework Backend:** Laravel 12.x
- **Bahasa Pemrograman:** PHP 8.2+
- **Database:** MySQL
- **Otentikasi:** Laravel Sanctum
- **Frontend Tooling:** Vite + Tailwind CSS 4.0 (untuk sisi client/web jika ada)
- **Testing:** Pest PHP

## 🚀 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Langkah-langkah

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd imfit-project
   ```

2. **Install Dependensi PHP**
   ```bash
   composer install
   ```

3. **Install Dependensi Node.js**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   ```
   
   Buka file `.env` dan sesuaikan bagian berikut:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=imfit_project
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database**
   Pastikan database `imfit_project` sudah dibuat di MySQL, lalu jalankan:
   ```bash
   php artisan migrate
   ```

7. **Jalankan Server**
   Untuk backend Laravel:
   ```bash
   php artisan serve
   ```
   Untuk aset frontend (jika diperlukan):
   ```bash
   npm run dev
   ```

## 📂 Struktur Database

Aplikasi ini menggunakan skema database relasional sebagai berikut:

- **users**: Menyimpan data pengguna (nama, email, password, role admin, dll).
- **exercises**: Daftar gerakan latihan (nama, deskripsi, otot target).
- **workout_sessions**: Mencatat sesi latihan pengguna (waktu mulai/selesai, total volume).
- **session_exercises**: Pivot table antara sesi dan latihan, mencatat urutan latihan dalam sesi.
- **session_sets**: Detail set untuk setiap latihan (berat beban, repetisi).
- **user_weights**: Riwayat berat badan pengguna.

## 🔌 Dokumentasi API

Untuk melihat detail lengkap mengenai Request, Response, dan Contoh Penggunaan API, silakan kunjungi file berikut:

👉 **[Dokumentasi Lengkap API (documentation_api.md)](./documentation_api.md)**

### Ringkasan Endpoint

Semua endpoint API menggunakan prefix `/api`.

### Otentikasi (Public)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/register` | Mendaftar pengguna baru |
| POST | `/login` | Masuk dan mendapatkan token akses |

### User & Profil (Protected)
Memerlukan Header: `Authorization: Bearer <token>`

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/logout` | Keluar dan menghapus token |
| GET | `/profile` | Mendapatkan informasi profil pengguna login |

### Latihan (Exercises)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/exercises` | Melihat daftar semua latihan |
| GET | `/exercises/{id}` | Melihat detail latihan tertentu |

### Sesi Latihan (Workouts)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/workouts` | Mencatat sesi latihan baru (beserta set) |
| GET | `/workouts/history` | Melihat riwayat latihan pengguna |
| GET | `/workouts/{id}` | Melihat detail sesi latihan tertentu |

### Progress (Berat Badan)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/weights` | Mencatat berat badan baru |
| GET | `/weights/history` | Melihat grafik/riwayat berat badan |

### Admin Area
Hanya dapat diakses oleh user dengan `is_admin = 1`.

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/exercises` | Membuat latihan baru |
| PUT | `/exercises/{id}` | Mengupdate data latihan |
| DELETE | `/exercises/{id}` | Menghapus latihan |
| GET | `/admin/users` | Melihat daftar seluruh pengguna |

## 📝 Catatan Tambahan

- **Role Admin**: User biasa memiliki `is_admin = 0`. Untuk membuat user menjadi admin, ubah nilai kolom `is_admin` menjadi `1` secara manual di database atau melalui seeder (jika tersedia).
- **Format Request**: API menerima input dalam format JSON.
