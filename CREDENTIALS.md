# SIMRS - Kredensial Login Default

## Data Login untuk Testing

### Admin
- **Email:** admin@simrs.com
- **Password:** password
- **Role:** admin

### Dokter
1. **Dr. Ahmad Hidayat, Sp.PD**
   - **Email:** dr.ahmad@simrs.com
   - **Password:** password
   - **Role:** dokter
   - **Poliklinik:** Poli Umum
   - **Spesialisasi:** Penyakit Dalam

2. **Dr. Siti Nurhaliza, Sp.A**
   - **Email:** dr.siti@simrs.com
   - **Password:** password
   - **Role:** dokter
   - **Poliklinik:** Poli Anak
   - **Spesialisasi:** Anak

### Perawat
- **Ns. Budi Santoso, S.Kep**
  - **Email:** perawat.budi@simrs.com
  - **Password:** password
  - **Role:** perawat

### Kasir
- **Email:** kasir@simrs.com
- **Password:** password
- **Role:** kasir

### Farmasi
- **Email:** farmasi@simrs.com
- **Password:** password
- **Role:** farmasi

### Laboratorium
- **Email:** lab@simrs.com
- **Password:** password
- **Role:** laboratorium

### Radiologi
- **Email:** radiologi@simrs.com
- **Password:** password
- **Role:** radiologi

---

## Data Master yang Sudah Tersedia

### Poliklinik (6 Poli)
1. Poli Umum
2. Poli Anak
3. Poli Gigi
4. Poli Mata
5. Poli Kandungan
6. Poli Jantung

### Kamar (10 Kamar dengan berbagai kelas)
- VIP (2 kamar)
- Kelas 1 (2 kamar)
- Kelas 2 (2 kamar)
- Kelas 3 (2 kamar)
- ICU (2 kamar)

### Obat (8 jenis obat)
1. Paracetamol 500mg
2. Amoxicillin 500mg
3. OBH Sirup
4. Antasida DOEN
5. Vitamin C 500mg
6. Ibuprofen 400mg
7. Cetirizine 10mg
8. Salep Bioplacenton

### Total Beds: 24 beds
- Disesuaikan dengan kapasitas masing-masing kamar

---

## Cara Menjalankan Aplikasi

1. Pastikan database MySQL sudah dibuat dengan nama `simrs`
2. Jalankan migrations: `php artisan migrate`
3. Jalankan seeder: `php artisan db:seed`
4. Jalankan aplikasi: `php artisan serve`
5. Akses aplikasi di: http://localhost:8000

---

**PENTING:** Ganti semua password default sebelum menggunakan di production!
