
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
