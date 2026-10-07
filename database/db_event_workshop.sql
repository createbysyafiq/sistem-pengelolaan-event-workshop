
-- Database: db_event_workshop
-- Modul C: Tiket & Kategori
-- Studi Kasus Sistem Pengelolaan Event & Workshop


CREATE DATABASE IF NOT EXISTS db_event_workshop;
USE db_event_workshop;


-- Struktur Tabel `tickets`
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipe_tiket VARCHAR(50) NOT NULL,
    harga INT NOT NULL,
    kuota INT NOT NULL,
    benefit TEXT NOT NULL
);


-- Contoh Data Awal (Dummy Data)
INSERT INTO tickets (tipe_tiket, harga, kuota, benefit) VALUES
('Early Bird', 75000, 30, 'E-Sertifikat, Snack Box, Akses Materi Workshop'),
('Regular', 100000, 50, 'E-Sertifikat, Snack Box, Akses Materi, Seminar Kit'),
('VIP', 150000, 20, 'E-Sertifikat, Lunch & Snack, Akses Kursi Depan, Goodie Bag Eksklusif');


-- ==========================================
-- Modul: Peserta (Event & Workshop)
-- ==========================================

-- Struktur Tabel `peserta`
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

-- Contoh Data Awal Peserta (Dummy Data)
INSERT INTO peserta (nama_lengkap, email, no_hp, institusi, id_tiket) VALUES
('Budi Santoso', 'budi@gmail.com', '081234567890', 'Universitas Indonesia', 1),
('Siti Rahma', 'siti.rahma@yahoo.com', '081987654321', 'Institut Teknologi Bandung', 2),
('Andi Pratama', 'andi.pratama@gmail.com', '085712345678', 'SMK Negeri 1', 3);


-- ==========================================
-- Modul: Pembicara (Speaker)
-- ==========================================

-- Struktur Tabel `pembicara`
CREATE TABLE IF NOT EXISTS pembicara (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    topik VARCHAR(200) NOT NULL,
    institusi VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contoh Data Awal Pembicara (Dummy Data)
INSERT INTO pembicara (nama, email, topik, institusi, no_hp) VALUES
('Dr. Ir. Syafiq Ahmad', 'syafiq@expert.com', 'AI & Machine Learning dalam Industri', 'Universitas Indonesia', '081122334455'),
('Maya Putri, M.T.', 'maya.putri@tech.id', 'Pengembangan Web Modern dengan PHP & Mysql', 'Tech Innovators', '085566778899');


