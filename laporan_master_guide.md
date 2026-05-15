### SQL Structure (MySQL)
Berikut adalah struktur tabel yang digunakan untuk mendukung fitur Laporan Master:

```sql
-- Tabel Klaster
CREATE TABLE klasters (
    id_klaster INT PRIMARY KEY AUTO_INCREMENT,
    nama_klaster VARCHAR(255),
    status TINYINT DEFAULT 1
);

-- Tabel Program
CREATE TABLE programs (
    id_program INT PRIMARY KEY AUTO_INCREMENT,
    id_klaster INT,
    nama_program VARCHAR(255),
    status TINYINT DEFAULT 1,
    FOREIGN KEY (id_klaster) REFERENCES klasters(id_klaster)
);

-- Tabel Indikator
CREATE TABLE indikators (
    id_indikator INT PRIMARY KEY AUTO_INCREMENT,
    id_program INT,
    nama_indikator TEXT,
    status TINYINT DEFAULT 1,
    FOREIGN KEY (id_program) REFERENCES programs(id_program)
);

-- Tabel Desa
CREATE TABLE desas (
    id_desa INT PRIMARY KEY AUTO_INCREMENT,
    nama_desa VARCHAR(100),
    status TINYINT DEFAULT 1
);

-- Tabel Target
CREATE TABLE targets (
    id_target INT PRIMARY KEY AUTO_INCREMENT,
    id_indikator INT,
    id_program INT,
    id_klaster INT,
    target_tahunan DOUBLE,
    status TINYINT DEFAULT 1,
    FOREIGN KEY (id_indikator) REFERENCES indikators(id_indikator)
);

-- Tabel Capaian
CREATE TABLE capaians (
    id_capaian INT PRIMARY KEY AUTO_INCREMENT,
    id_target INT,
    id_desa INT,
    bulan INT,
    capaian_bulan DOUBLE,
    analisa_masalah TEXT,
    rtl TEXT,
    status TINYINT DEFAULT 1,
    updated_at TIMESTAMP,
    FOREIGN KEY (id_target) REFERENCES targets(id_target),
    FOREIGN KEY (id_desa) REFERENCES desas(id_desa)
);
```

### File Structure in Laravel
1. `app/Http/Controllers/LaporanMasterController.php` (Logika backend & AJAX)
2. `resources/views/laporan_master/index.blade.php` (UI Dashboard Modern)
3. `resources/views/laporan_master/pdf.blade.php` (Template Cetak PDF)
4. `routes/web.php` (Definisi endpoint)
