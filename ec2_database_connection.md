# Panduan Menghubungkan Laravel di EC2 ke Database AWS

Karena Anda sudah memiliki **EC2 Instance** dan **Database** (baik AWS RDS maupun database MySQL di server terpisah), berikut adalah langkah-langkah untuk menghubungkan keduanya agar aman dan berkinerja tinggi.

---

## Langkah 1: Izinkan Koneksi di Security Group AWS (Sangat Penting)
Secara default, AWS memblokir semua lalu lintas masuk ke database Anda. Anda harus mengizinkan EC2 untuk mengakses database pada port **3306**.

### Hubungan EC2 ke AWS RDS:
1. Buka **AWS Console** -> masuk ke **RDS** -> Klik nama database Anda.
2. Di tab **Connectivity & security**, klik Security Group yang tertera di bawah **VPC security groups** database Anda.
3. Buka tab **Inbound rules**, lalu klik **Edit inbound rules**.
4. Tambahkan aturan baru (**Add rule**):
   - **Type**: `MYSQL/Aurora` (Port `3306`).
   - **Source**: Pilih **Custom**, lalu cari dan pilih **ID Security Group dari EC2 Anda** (biasanya dimulai dengan `sg-xxxxxx`).
     > [!TIP]
     > Menggunakan ID Security Group EC2 sebagai *Source* jauh lebih aman dibandingkan memasukkan IP, karena jika instance EC2 Anda di-restart atau diubah, koneksi database tidak akan terputus.
5. Klik **Save rules**.

---

## Langkah 2: Dapatkan Informasi Koneksi Database
Catat informasi berikut dari database Anda:
*   **Host/Endpoint**: 
    - Jika menggunakan **RDS**: Buka RDS -> tab *Connectivity & security* -> salin alamat **Endpoint** (contoh: `database-1.xxxx.ap-southeast-1.rds.amazonaws.com`).
    - Jika menggunakan **Database di EC2 yang sama**: Gunakan `127.0.0.1`.
    - Jika menggunakan **EC2 Server Terpisah**: Gunakan **Private IP** dari EC2 database Anda.
*   **Port**: `3306` (default MySQL).
*   **Database Name**: Nama database yang sudah Anda buat (contoh: `clouduy`).
*   **Username**: Username database Anda.
*   **Password**: Password database Anda.

---

## Langkah 3: Konfigurasi File `.env` di dalam EC2
Anda perlu memperbarui konfigurasi di instance EC2 Anda agar Laravel menggunakan database tersebut.

1. Masuk ke EC2 Anda via SSH (menggunakan Terminal, Git Bash, atau PuTTY):
   ```bash
   ssh -i "key-pair-anda.pem" ubuntu@ip-public-ec2-anda
   ```
2. Masuk ke direktori tempat proyek Laravel Anda di-deploy:
   ```bash
   cd /var/www/html/clouduy # (Sesuaikan dengan folder deploy Anda)
   ```
3. Edit file `.env` di EC2 menggunakan editor teks seperti `nano`:
   ```bash
   nano .env
   ```
4. Ubah baris konfigurasi database dengan data yang sudah Anda catat:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=endpoint-database-anda-atau-ip-private
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=username_database_anda
   DB_PASSWORD=password_database_anda
   ```
5. Simpan perubahan (jika menggunakan `nano`: tekan `Ctrl + O` lalu `Enter` untuk menyimpan, kemudian `Ctrl + X` untuk keluar).

---

## Langkah 4: Jalankan Migrasi & Bersihkan Cache di EC2
Setelah `.env` diubah, lakukan langkah berikut di dalam terminal EC2 Anda agar Laravel membaca konfigurasi database baru:

1. **Bersihkan cache konfigurasi** agar Laravel memuat `.env` yang baru:
   ```bash
   php artisan config:clear
   ```
2. **Jalankan migrasi database dan seed data** untuk membuat tabel anggota kelompok dan akun admin:
   ```bash
   php artisan migrate --seed
   ```
   > Jika database Anda sudah memiliki data dari proyek lain dan Anda hanya ingin menambahkan tabel anggota kelompok, cukup jalankan `php artisan migrate` tanpa `--seed` jika tidak ingin menyuntikkan data duplikat admin, lalu Anda bisa mengisi data secara manual lewat halaman admin.

---

## 🔍 Troubleshooting (Jika Gagal Terhubung)
*   **Error: Connection Timeout**:
    - Periksa kembali Security Group database Anda. Pastikan port 3306 terbuka dengan source Security Group EC2 Anda.
    - Pastikan EC2 dan RDS berada di dalam **VPC yang sama**.
*   **Error: Access Denied**:
    - Periksa apakah username dan password database di `.env` sudah benar.
    - Jika database berada di EC2 terpisah, pastikan user MySQL tersebut diizinkan menerima koneksi dari host luar (`'username'@'%'` atau `'username'@'ip-private-ec2'`).
