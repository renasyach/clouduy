# Panduan Menghubungkan Laravel ke Database AWS RDS MySQL

Dokumen ini menjelaskan langkah-langkah untuk mengonfigurasi dan menghubungkan aplikasi Laravel Anda ke layanan database **Amazon Relational Database Service (RDS)** menggunakan mesin database **MySQL**.

---

## 1. Membuat Database Instance di AWS RDS
1. Masuk ke **AWS Management Console** dan buka dashboard **RDS**.
2. Klik tombol **Create database**.
3. Pilih metode pembuatan **Standard create**.
4. Di bagian **Engine options**, pilih **MySQL**.
5. Pilih **Templates** sesuai kebutuhan Anda (gunakan **Free Tier** jika Anda sedang dalam masa pembelajaran/uji coba).
6. Di bagian **Settings**:
   - **DB instance identifier**: Beri nama instance Anda (contoh: `clouduy-db`).
   - **Master username**: Masukkan username (contoh: `admin` atau `root`).
   - **Master password**: Buat password yang kuat dan catat password tersebut.
7. Di bagian **Connectivity**:
   - **Public access**: Pilih **Yes** jika Anda ingin mengakses database langsung dari komputer lokal Anda untuk kebutuhan migrasi data. *(Catatan: Untuk produksi, disarankan memilih **No** dan mengaksesnya hanya melalui EC2/Elastic Beanstalk di VPC yang sama demi keamanan).*
   - **VPC security group**: Pilih atau buat Security Group baru (misalnya `clouduy-rds-sg`).
8. Klik **Create database** dan tunggu hingga status instance berubah menjadi **Available**.

---

## 2. Mengonfigurasi Security Group AWS RDS
Agar aplikasi Laravel Anda (baik yang berjalan lokal maupun di AWS EC2/Elastic Beanstalk) dapat terhubung ke database RDS, Anda harus membuka port MySQL (**3306**):

1. Buka instance RDS yang telah dibuat, lalu cari tab **Connectivity & security**.
2. Klik link di bawah **VPC security groups**.
3. Pilih Security Group database Anda, buka tab **Inbound rules**, dan klik **Edit inbound rules**.
4. Tambahkan aturan baru (**Add rule**):
   - **Type**: `MYSQL/Aurora` (Port `3306`).
   - **Source**:
     - Jika Anda ingin mengakses dari komputer lokal: Pilih **My IP** atau **Custom** lalu masukkan IP publik Anda.
     - Jika diakses dari server Laravel di EC2/Elastic Beanstalk: Pilih ID Security Group yang digunakan oleh EC2/Elastic Beanstalk Anda (ini adalah cara paling aman).
     - Jika ingin diakses dari mana saja (tidak disarankan untuk produksi): Pilih **Anywhere-IPv4** (`0.0.0.0/0`).
5. Klik **Save rules**.

---

## 3. Mendapatkan Endpoint Database
1. Buka kembali dashboard RDS, klik pada nama database Anda.
2. Di tab **Connectivity & security**, temukan kolom **Endpoint**.
3. Salin nilai Endpoint tersebut (berbentuk seperti: `clouduy-db.xxxxxx.ap-southeast-1.rds.amazonaws.com`).

---

## 4. Mengonfigurasi File `.env` di Laravel
Buka file `.env` di direktori root Laravel Anda dan perbarui konfigurasi database menggunakan detail RDS Anda:

```env
DB_CONNECTION=mysql
DB_HOST=clouduy-db.xxxxxx.ap-southeast-1.rds.amazonaws.com
DB_PORT=3306
DB_DATABASE=clouduy
DB_USERNAME=admin
DB_PASSWORD=password_rds_anda
```

> [!IMPORTANT]
> - Ganti `DB_HOST` dengan **Endpoint** RDS yang sudah Anda salin.
> - Pastikan nama database `DB_DATABASE` sudah dibuat di server RDS Anda. Secara default, RDS tidak selalu membuat database awal kecuali Anda mengisinya di opsi tambahan saat pembuatan. Jika belum dibuat, Anda bisa terhubung menggunakan aplikasi klien database seperti DBeaver/TablePlus lalu menjalankan perintah `CREATE DATABASE clouduy;`.

---

## 5. Menjalankan Migrasi ke AWS RDS
Setelah file `.env` terhubung ke RDS, Anda dapat menjalankan migrasi database dari terminal lokal Anda (jika Security Group mengizinkan akses dari IP Anda):

```bash
php artisan migrate --seed
```

Perintah ini akan secara otomatis membuat tabel-tabel di AWS RDS MySQL dan melakukan *seeding* data admin serta data anggota kelompok.
