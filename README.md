
# 🎓 E-PKL-BPS (Sistem Magang)

> Sistem manajemen kegiatan magang di BPS untuk mahasiswa dan peserta magang.

---

## 1. ⚙️ Persiapan

Pastikan sudah menginstal:

| Software        | Versi Minimal       |
|-----------------|------------------|
| PHP             | 8.0              |
| Composer        | -                |
| MySQL / MariaDB | -                |
| Git             | -                |
| Node.js & npm   | Opsional (Laravel Mix) |

---

## 2. 📂 Clone Repository

```bash
git clone https://github.com/Fitridwianisa/E-PKL-BPS.git
cd E-PKL-BPS/sistem-magang
```

---

## 3. 🛠 Install Dependencies

```bash
composer install
```

---

## 4. 🔧 Konfigurasi `.env`

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Edit file `.env` sesuai konfigurasi database:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. 🗝 Generate Application Key

```bash
php artisan key:generate
```

---

## 6. 🗄 Migrasi Database

Jalankan semua migration untuk membuat tabel-tabel:

```bash
php artisan migrate
```

File migration utama:

```
create_users_table.php
create_cache_table.php
create_sessions_table.php
create_biodata_peserta_table.php
create_pendaftaran_magang_table.php
create_artikels_table.php
create_surat_balasan_table.php
create_sertifikats_table.php
add_file_and_status_to_sertifikats_table.php
update_enum_status_pendaftaran_magang.php
```

---

## 7. 📝 Seed Database (Isi Data Awal)

File Excel di folder `seeders/data`:

```
biodata.xlsx
pendaftaran.xlsx
users.xlsx
```

Seeder PHP:

```
BiodataPeserta.php
UserSeeder.php
PendaftaranMagangSeeder.php
DatabaseSeeder.php
```

Jalankan seeder:

```bash
php artisan db:seed
```

> ⚠️ Pastikan file temporary Excel (`~$biodata.xlsx`, dsb.) dihapus sebelum seed agar tidak error.

---

## 8. 🚀 Jalankan Server Laravel

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```
http://127.0.0.1:8000
```

---

## 9. ⚠️ Catatan Penting


