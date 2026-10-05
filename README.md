# SIMRS - Sistem Informasi Manajemen Rumah Sakit

Sistem Informasi Manajemen Rumah Sakit (SIMRS) adalah aplikasi berbasis web yang dibangun menggunakan Laravel 11 untuk mengelola operasional rumah sakit.

## Fitur Utama

### 1. Multi-Role Authentication
- **Admin**: Manajemen seluruh sistem
- **Dokter**: Pemeriksaan pasien, resep, dan medical record
- **Perawat**: Monitoring pasien rawat inap
- **Kasir**: Billing dan pembayaran
- **Farmasi**: Manajemen obat dan resep
- **Laboratorium**: Pemeriksaan lab
- **Radiologi**: Pemeriksaan radiologi

### 2. Modul Utama
- ✅ **Registrasi Pasien** - Data pasien lengkap dengan nomor rekam medis otomatis
- ✅ **Rawat Jalan** - Pemeriksaan poliklinik
- ✅ **Rawat Inap** - Manajemen bed dan kamar
- ✅ **Farmasi** - Stok obat dan resep
- ✅ **Laboratorium** - Permintaan dan hasil lab
- ✅ **Radiologi** - Permintaan dan hasil radiologi
- ✅ **Billing** - Invoice dan pembayaran
- ✅ **Rekam Medis** - Medical record terintegrasi

## Teknologi yang Digunakan

- **Framework**: Laravel 11
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Build Tool**: Vite

## Instalasi

### Persyaratan
- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js & NPM

### Langkah Instalasi

1. **Clone atau copy folder project**
   ```bash
   cd d:\project\test\simrs
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Copy environment file**
   ```bash
   # File .env sudah ada, pastikan konfigurasi database benar
   ```

4. **Generate application key** (sudah dilakukan)
   ```bash
   php artisan key:generate
   ```

5. **Buat database MySQL**
   - Buat database dengan nama: `simrs`
   - Database sudah dikonfigurasi di file `.env`

6. **Jalankan migrations**
   ```bash
   php artisan migrate
   ```

7. **Jalankan seeders**
   ```bash
   php artisan db:seed
   ```

8. **Build assets**
   ```bash
   npm run build
   # Atau untuk development
   npm run dev
   ```

9. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

10. **Akses aplikasi**
    - URL: http://localhost:8000
    - Login dengan kredensial dari file `CREDENTIALS.md`

## Struktur Database

### Tabel Utama

1. **users** - User sistem dengan role
2. **pasiens** - Data pasien
3. **dokters** - Data dokter
4. **perawats** - Data perawat
5. **polikliniks** - Data poliklinik
6. **rawat_jalans** - Data rawat jalan
7. **rawat_inaps** - Data rawat inap
8. **kamars** - Data kamar
9. **beds** - Data bed/tempat tidur
10. **obats** - Data obat
11. **reseps** - Data resep
12. **resep_details** - Detail resep
13. **pemeriksaan_labs** - Pemeriksaan laboratorium
14. **pemeriksaan_radiologis** - Pemeriksaan radiologi
15. **billing** - Data billing/invoice

## Struktur Folder

```
simrs/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controllers untuk admin
│   │   │   ├── Dokter/         # Controllers untuk dokter
│   │   │   ├── Kasir/          # Controllers untuk kasir
│   │   │   ├── Farmasi/        # Controllers untuk farmasi
│   │   │   ├── Laboratorium/   # Controllers untuk lab
│   │   │   └── Radiologi/      # Controllers untuk radiologi
│   │   └── Middleware/
│   │       └── CheckRole.php   # Middleware untuk role-based access
│   └── Models/                 # Eloquent models
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   └── views/
│       └── dashboard/          # Dashboard views per role
└── routes/
    └── web.php                 # Route definitions
```

## Routes

### Public Routes
- `GET /` - Welcome page
- `GET /login` - Login page
- `POST /login` - Login process

### Authenticated Routes
- `GET /dashboard` - Redirect ke dashboard sesuai role

### Admin Routes (`/admin/*`)
- `resource('pasien')` - CRUD Pasien
- `resource('dokter')` - CRUD Dokter
- `resource('poliklinik')` - CRUD Poliklinik
- `resource('kamar')` - CRUD Kamar
- `resource('obat')` - CRUD Obat

### Dokter Routes (`/dokter/*`)
- `resource('rawat-jalan')` - Manajemen Rawat Jalan
- `resource('rawat-inap')` - Manajemen Rawat Inap
- `resource('resep')` - Manajemen Resep

### Kasir Routes (`/kasir/*`)
- `resource('billing')` - Manajemen Billing

### Farmasi Routes (`/farmasi/*`)
- `resource('resep')` - Proses Resep

### Laboratorium Routes (`/laboratorium/*`)
- `resource('pemeriksaan-lab')` - Manajemen Pemeriksaan Lab

### Radiologi Routes (`/radiologi/*`)
- `resource('pemeriksaan-radiologi')` - Manajemen Pemeriksaan Radiologi

## Kredensial Login

Lihat file `CREDENTIALS.md` untuk daftar lengkap user dan password default.

**Default Admin:**
- Email: admin@simrs.com
- Password: password

## Models dan Relasi

### User
- `hasOne` Dokter
- `hasOne` Perawat

### Pasien
- `hasMany` RawatJalan
- `hasMany` RawatInap
- `hasMany` Resep
- `hasMany` PemeriksaanLab
- `hasMany` PemeriksaanRadiologi
- `hasMany` Billing

### Dokter
- `belongsTo` User
- `belongsTo` Poliklinik
- `hasMany` RawatJalan
- `hasMany` RawatInap
- `hasMany` Resep

### RawatJalan
- `belongsTo` Pasien
- `belongsTo` Poliklinik
- `belongsTo` Dokter
- `hasMany` Resep
- `hasOne` Billing

### RawatInap
- `belongsTo` Pasien
- `belongsTo` Dokter
- `belongsTo` Kamar
- `belongsTo` Bed
- `hasMany` Resep
- `hasOne` Billing

## Middleware

### CheckRole
Middleware untuk mengecek role user yang sedang login.

**Usage:**
```php
Route::middleware('role:admin,dokter')->group(function () {
    // Routes yang hanya bisa diakses admin dan dokter
});
```

## Helper Methods

### User Model
- `isAdmin()` - Cek apakah user adalah admin
- `isDokter()` - Cek apakah user adalah dokter
- `isPerawat()` - Cek apakah user adalah perawat
- `isKasir()` - Cek apakah user adalah kasir
- `isFarmasi()` - Cek apakah user adalah farmasi
- `isLaboratorium()` - Cek apakah user adalah laboratorium
- `isRadiologi()` - Cek apakah user adalah radiologi

### Pasien Model
- `getUmurAttribute()` - Mendapatkan umur pasien

### Kamar Model
- `bedTersedia()` - Mendapatkan jumlah bed tersedia

### Obat Model
- `isStokRendah()` - Cek apakah stok obat rendah
- `isKadaluarsa()` - Cek apakah obat kadaluarsa

### RawatInap Model
- `getLamaRawatAttribute()` - Menghitung lama rawat

## Development

### Menambah Fitur Baru

1. Buat migration: `php artisan make:migration create_xxx_table`
2. Buat model: `php artisan make:model Xxx`
3. Buat controller: `php artisan make:controller XxxController --resource`
4. Tambahkan routes di `routes/web.php`
5. Buat views di `resources/views/`

### Testing

```bash
php artisan test
```

## Security

- ✅ Password di-hash menggunakan bcrypt
- ✅ CSRF protection di semua form
- ✅ SQL injection protection dengan Eloquent ORM
- ✅ XSS protection dengan Blade escaping
- ✅ Role-based access control
- ✅ Authentication dengan Laravel Breeze

## TODO / Future Development

- [ ] Implementasi UI untuk semua CRUD operations
- [ ] Export laporan ke PDF dan Excel
- [ ] Dashboard dengan charts dan statistik
- [ ] Notifikasi real-time
- [ ] Print resep dan invoice
- [ ] Backup database otomatis
- [ ] API untuk integrasi dengan aplikasi mobile
- [ ] Multi-tenant untuk multiple rumah sakit
- [ ] Appointment/booking online
- [ ] Telemedicine

## Kontribusi

Silakan buat pull request atau issue jika menemukan bug atau ingin menambah fitur.

## License

Aplikasi ini dibuat untuk keperluan pembelajaran dan pengembangan.

## Support

Untuk pertanyaan dan dukungan, silakan hubungi tim developer.

---

**Developed with ❤️ using Laravel**
