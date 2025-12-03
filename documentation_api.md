# Dokumentasi API IMFIT

Dokumentasi ini menjelaskan endpoint API yang tersedia dalam proyek IMFIT.
Semua endpoint menggunakan prefix `/api`.

## Base URL
`http://localhost:8000/api` (atau URL deployment Anda)

## Autentikasi
Sebagian besar endpoint memerlukan token autentikasi (Bearer Token) yang didapatkan setelah login.
Header:
`Authorization: Bearer <token>`
`Accept: application/json`

---

## 1. Autentikasi & Profil

### Register
Mendaftarkan pengguna baru.

- **URL**: `/register`
- **Method**: `POST`
- **Auth**: Tidak perlu
- **Body (Multipart/Form-data)**:
    - `fullname` (string, required)
    - `username` (string, required, unique)
    - `email` (string, required, email, unique)
    - `password` (string, required, min:8)
    - `date_of_birth` (date, required)
    - `profile_picture_url` (file, image, optional)
- **Response Success (201)**:
    ```json
    {
        "success": true,
        "message": "Registrasi berhasil. Silakan login.",
        "data": true
    }
    ```

### Login
Masuk ke aplikasi.

- **URL**: `/login`
- **Method**: `POST`
- **Auth**: Tidak perlu
- **Body (JSON)**:
    - `login` (string, required) - Email atau Username
    - `password` (string, required)
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "message": "Login berhasil.",
        "data": {
            "token": "1|laravel_sanctum_token..."
        }
    }
    ```

### Logout
Keluar dari aplikasi (menghapus token).

- **URL**: `/logout`
- **Method**: `POST`
- **Auth**: Bearer Token
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "message": "Berhasil logout.",
        "data": true
    }
    ```

### Get Profile
Mendapatkan data profil pengguna saat ini.

- **URL**: `/profile`
- **Method**: `GET`
- **Auth**: Bearer Token
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "message": "Data profil berhasil diambil.",
        "data": {
            "fullname": "John Doe",
            "username": "johndoe",
            "email": "john@example.com",
            "date_of_birth": "1990-01-01",
            "profile_picture_url": "path/to/image.jpg"
        }
    }
    ```

---

## 2. Latihan (Exercises)

### List Exercises
Mendapatkan daftar latihan dengan pagination dan pencarian.

- **URL**: `/exercises`
- **Method**: `GET`
- **Query Params**:
    - `search` (string, optional) - Mencari berdasarkan nama atau target otot
    - `page` (int, optional) - Nomor halaman
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "message": "Daftar latihan berhasil diambil.",
        "data": {
            "current_page": 1,
            "data": [
                {
                    "id": 1,
                    "name": "Bench Press",
                    "target_muscle": "Chest"
                }
            ],
            ...
        }
    }
    ```

### Get Exercise Detail
Mendapatkan detail lengkap latihan.

- **URL**: `/exercises/{id}`
- **Method**: `GET`
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "message": "Detail latihan berhasil diambil.",
        "data": {
            "id": 1,
            "name": "Bench Press",
            "description": "Latihan dada menggunakan barbel...",
            "target_muscle": "Chest",
            ...
        }
    }
    ```

---

## 3. Sesi Latihan (Workouts)

### Create Workout Session
Menyimpan sesi latihan yang telah dilakukan.

- **URL**: `/workouts`
- **Method**: `POST`
- **Body (JSON)**:
    ```json
    {
        "session_name": "Chest Day",
        "start_time": "2023-10-27 08:00:00",
        "end_time": "2023-10-27 09:30:00",
        "exercises": [
            {
                "id": 1, // ID dari Exercise
                "order": 1,
                "sets": [
                    { "weight": 60, "reps": 12 },
                    { "weight": 65, "reps": 10 }
                ]
            }
        ]
    }
    ```
- **Response Success (201)**:
    ```json
    {
        "success": true,
        "message": "Sesi latihan berhasil disimpan.",
        "data": null
    }
    ```

### Workout History
Melihat riwayat latihan pengguna.

- **URL**: `/workouts/history`
- **Method**: `GET`
- **Query Params**:
    - `search` (string, optional) - Filter berdasarkan nama sesi
    - `page` (int, optional)
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "message": "Riwayat latihan berhasil diambil.",
        "data": {
            "current_page": 1,
            "data": [
                {
                    "id": 1,
                    "session_name": "Chest Day",
                    "total_duration_in_minutes": 90,
                    "total_volume_kg": 1200,
                    "start_time": "...",
                    "end_time": "..."
                }
            ]
        }
    }
    ```

### Workout Detail
Melihat detail sesi latihan tertentu termasuk set dan repetisi.

- **URL**: `/workouts/{id}`
- **Method**: `GET`
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "message": "Detail sesi latihan berhasil diambil.",
        "data": {
            "id": 1,
            "session_name": "Chest Day",
            "session_exercises": [
                {
                    "exercise": { "name": "Bench Press" },
                    "sets": [
                        { "weight": 60, "reps": 12 }
                    ]
                }
            ]
        }
    }
    ```

---

## 4. Progress (Berat Badan)

### Record Weight
Mencatat berat badan harian.

- **URL**: `/weights`
- **Method**: `POST`
- **Body (JSON)**:
    - `weight` (decimal, required)
    - `date` (date, required, format: YYYY-MM-DD)
- **Response Success (201)**:
    ```json
    {
        "success": true,
        "message": "Berat badan berhasil disimpan.",
        "data": { ... }
    }
    ```

### Weight History
Melihat grafik perkembangan berat badan.

- **URL**: `/weights/history`
- **Method**: `GET`
- **Response Success (200)**:
    ```json
    {
        "success": true,
        "data": [
            { "weight_kg": 70, "date": "2023-10-01" },
            { "weight_kg": 69.5, "date": "2023-10-08" }
        ]
    }
    ```

---

## 5. Admin Area
Memerlukan user dengan `is_admin = 1`.

### Create Exercise (Admin)
- **URL**: `/exercises`
- **Method**: `POST`
- **Body**: `name`, `description`, `target_muscle`

### Update Exercise (Admin)
- **URL**: `/exercises/{id}`
- **Method**: `PUT`
- **Body**: `name`, `description`, `target_muscle`

### Delete Exercise (Admin)
- **URL**: `/exercises/{id}`
- **Method**: `DELETE`
- **Note**: Admin hanya bisa menghapus latihan yang dibuat olehnya (berdasarkan kode saat ini).

### Get All Users (Admin)
- **URL**: `/admin/users`
- **Method**: `GET`
