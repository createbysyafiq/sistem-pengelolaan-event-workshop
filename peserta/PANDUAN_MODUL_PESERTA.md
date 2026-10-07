# 📘 PANDUAN LENGKAP MODUL PESERTA (UNTUK PEMULA)
**Mata Kuliah Pemrograman Berbasis Web (PAW)**  
**Sistem Pengelolaan Event & Workshop - Kelompok 8**

---

## 📌 1. Pengantar & Tujuan Modul

Halo! Panduan ini dibuat khusus agar kamu bisa memahami dan menguasai pembuatan **Modul Peserta** dari awal sampai selesai dengan mudah.

Modul ini mengelola data pendaftar/peserta event dan workshop menggunakan konsep **CRUD**:
1. **C (Create)**: Menambahkan data peserta baru lewat formulir pendaftaran.
2. **R (Read)**: Menampilkan daftar seluruh peserta dalam tabel di layar.
3. **U (Update)**: Mengubah atau mengoreksi data peserta yang sudah tersimpan.
4. **D (Delete)**: Menghapus data peserta dari database.

---

## 🗄️ 2. Struktur Database (Tabel `peserta`)

Data peserta disimpan di tabel `peserta` dalam database `db_event_workshop`.  
Tabel ini berelasi dengan tabel `tickets` melalui kolom `id_tiket` (Foreign Key), sehingga saat mendaftar, peserta dapat memilih jenis tiket yang tersedia.

### Kode SQL:
Buka **phpMyAdmin** (`http://localhost/phpmyadmin`), pilih database `db_event_workshop`, lalu klik menu **SQL** dan jalankan perintah berikut:

```sql
-- 1. Buat Tabel `peserta`
CREATE TABLE IF NOT EXISTS peserta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    institusi VARCHAR(100) NOT NULL,
    id_tiket INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tiket) REFERENCES tickets(id) ON DELETE CASCADE
);

-- 2. Tambah Data Awal (Dummy Data) untuk Pengujian
INSERT INTO peserta (nama_lengkap, email, no_hp, institusi, id_tiket) VALUES
('Budi Santoso', 'budi@gmail.com', '081234567890', 'Universitas Indonesia', 1),
('Siti Rahma', 'siti.rahma@yahoo.com', '081987654321', 'Institut Teknologi Bandung', 2),
('Andi Pratama', 'andi.pratama@gmail.com', '085712345678', 'SMK Negeri 1', 3);
```

### Penjelasan Kolom:
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (Primary Key, Auto Increment) | ID unik setiap peserta yang bertambah otomatis |
| `nama_lengkap` | VARCHAR(100) | Nama lengkap peserta |
| `email` | VARCHAR(100) | Alamat email peserta |
| `no_hp` | VARCHAR(20) | Nomor WhatsApp / Handphone aktif |
| `institusi` | VARCHAR(100) | Kampus, sekolah, atau kantor asal peserta |
| `id_tiket` | INT (Foreign Key) | ID jenis tiket yang dipilih dari tabel `tickets` |
| `created_at` | TIMESTAMP | Tanggal & waktu pendaftaran otomatis tersimpan |

---

## 📂 3. Struktur File dalam Folder `peserta/`

Di dalam folder `peserta/`, kita membuat 5 file utama:

```text
peserta/
├── PANDUAN_MODUL_PESERTA.md  <- File panduan ini
├── index.php                 <- Halaman utama: Form pendaftaran + Tabel daftar peserta (READ & form CREATE)
├── proses_tambah.php         <- Logika pemrosesan simpan peserta baru (CREATE)
├── edit.php                  <- Formulir perubahan data peserta (form UPDATE)
├── proses_edit.php           <- Logika pemrosesan update perubahan (UPDATE)
└── hapus.php                 <- Logika pemrosesan hapus data peserta (DELETE)
```

---

## 🔄 4. Alur Kerja (Workflow) Data

1. **Menampilkan Data (Read)**:
   - Pengguna membuka `index.php`.
   - File memanggil koneksi database `koneksi.php`.
   - Menjalankan perintah query `SELECT peserta.*, tickets.tipe_tiket, tickets.harga FROM peserta JOIN tickets ON peserta.id_tiket = tickets.id`.
   - Data di-loop menggunakan `while ($row = mysqli_fetch_assoc($query))` dan dicetak ke tabel HTML.

2. **Menambah Data (Create)**:
   - Pengguna mengisi formulir di `index.php` dan menekan tombol **"Daftarkan Peserta"**.
   - Data dikirim dengan method `POST` menuju `proses_tambah.php`.
   - `proses_tambah.php` menerima data, menyaringnya, dan menyimpannya menggunakan **Prepared Statement** (`INSERT INTO peserta ...`).
   - Browser otomatis dialihkan kembali ke `index.php?status=sukses`.

3. **Mengubah Data (Update)**:
   - Pengguna mengklik tombol **"Edit"** di salah satu baris tabel `index.php` (misal: `edit.php?id=2`).
   - `edit.php` menangkap parameter `id` melalui `$_GET['id']` dan mengambil data spesifik tersebut dari database.
   - Form diisi nilai lama peserta. Pengguna mengubah data lalu klik **"Simpan Perubahan"**.
   - Data dikirim ke `proses_edit.php` lewat `POST`.
   - Perubahan disimpan dengan query `UPDATE peserta SET ... WHERE id = ?`.
   - Dialihkan kembali ke `index.php?status=update_sukses`.

4. **Menghapus Data (Delete)**:
   - Pengguna mengklik link **"Hapus"** di tabel (misal: `hapus.php?id=2`).
   - Tampil pop-up konfirmasi JavaScript `confirm('...')`.
   - Jika pengguna setuju, `hapus.php` mengeksekusi `DELETE FROM peserta WHERE id = ?`.
   - Dialihkan kembali ke `index.php?status=hapus_sukses`.

---

## 💡 5. Penjelasan Kode & Konsep Penting PHP untuk Pemula

### A. Mengapa Menggunakan `include "../koneksi.php"`?
Karena folder `peserta` berada satu tingkat di bawah folder utama proyek, kita menggunakan `../` untuk naik 1 tingkat direktori dan memanggil file `koneksi.php`.

### B. Mengapa Menggunakan `mysqli_prepare` & Prepared Statements?
Hindari menggabungkan variabel langsung ke query seperti `mysqli_query($koneksi, "INSERT INTO ... '$nama'")` karena rentan terhadap peretasan **SQL Injection**.  
Prepared statements memisahkan query SQL dengan nilai input pengguna:
- `mysqli_prepare()` menyiapkan cetakan query dengan tanda tanya `?`.
- `mysqli_stmt_bind_param()` memasukkan nilai ke tanda tanya sesuai tipe data:
  - `s` = string (teks)
  - `i` = integer (angka)
- `mysqli_stmt_execute()` menjalankan query dengan aman.

### C. Mengapa Menggunakan `htmlspecialchars()`?
Fungsi `htmlspecialchars($row['nama_lengkap'])` mencegah celah keamanan **XSS (Cross-Site Scripting)** agar karakter seperti `<` atau `>` diubah menjadi entitas HTML aman dan tidak dieksekusi sebagai script berbahaya.

---

## 🚀 6. Cara Menjalankan & Menguji

1. Nyalakan **Apache** dan **MySQL** di kontrol panel **XAMPP**.
2. Pastikan database `db_event_workshop` sudah memiliki tabel `tickets` dan tabel `peserta`.
3. Buka browser (Chrome, Edge, dll) dan akses URL:
   ```text
   http://localhost/sistem-pengelolaan-event-workshop/peserta/
   ```
4. Coba lakukan 4 pengujian:
   - **Tambah Peserta**: Isi form dan klik simpan. Pastikan data muncul di tabel.
   - **Edit Peserta**: Klik tombol Edit, ubah nomor HP atau tiket, simpan dan periksa apakah datanya berubah.
   - **Hapus Peserta**: Klik tombol Hapus, konfirmasi, dan pastikan data terhapus dari tabel.
   - **Relasi Tiket**: Pastikan dropdown tiket menampilkan tipe tiket yang diambil langsung dari database.

---
*Semangat belajarnya! Jika ada error atau bagian yang kurang dipahami, periksa pesan error di browser atau sesuaikan port database di `koneksi.php`.*
