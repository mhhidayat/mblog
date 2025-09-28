# M-Blog - Aplikasi Blog Laravel dengan Livewire

Aplikasi blog modern yang dibangun menggunakan Laravel 12 dan Livewire 3, dengan antarmuka yang responsif menggunakan Tailwind CSS.

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM atau Yarn
- PostgreSQL (default) atau MySQL/SQLSQLite

## 🚀 Cara Menjalankan Proyek

### 1. Clone dan Setup Awal

```bash
# Clone repository
git clone https://github.com/mhhidayat/mblog.git
cd mblog

# Install dependencies PHP
composer install

# Install dependencies Node.js
npm install
```

### 2. Konfigurasi Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Buat koneksi database PostgreSQL (jika belum ada)
```

### 3. Setup Database

```bash
# Jalankan migrasi database
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

### 4. Menjalankan Aplikasi

#### Opsi 1: Development dengan satu perintah
```bash
composer run dev
```
Perintah ini akan menjalankan:
- Laravel development server (port 8000)
- Queue worker
- Log monitoring
- Vite development server untuk asset

#### Opsi 2: Manual (untuk kontrol lebih detail)
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite untuk asset development
npm run dev

# Terminal 3 (opsional): Queue worker
php artisan queue:work
```

### 5. Akses Aplikasi

- **Frontend**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin (setelah login sebagai admin)

## 🏗️ Arsitektur Aplikasi (MVC)

### Stack Teknologi
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Livewire 3 + Blade Templates
- **Styling**: Tailwind CSS 4
- **Database**: PostgreSQL (default), mendukung MySQL/SQLite
- **Build Tool**: Vite
- **Queue**: Database driver (default)

### Struktur Direktori

```
├── app/
│   ├── Http/           # Controllers & Middleware
│   ├── Livewire/       # Komponen Livewire
│   ├── Models/         # Eloquent Models
│   └── Providers/      # Service Providers
├── database/
│   ├── migrations/     # Database migrations
│   ├── factories/      # Model factories
│   └── seeders/        # Database seeders
├── resources/
│   ├── views/          # Blade templates
│   ├── css/            # Stylesheet files
│   └── js/             # JavaScript files
├── routes/
│   └── web.php         # Web routes
└── public/             # Public assets
```

### Komponen Utama

#### 1. **Frontend Components (Livewire)**
- `BlogIndex`: Halaman utama blog dengan daftar artikel
- `BlogPost`: Halaman detail artikel
- `ContactPage`: Halaman kontak dengan form
- `AboutPage`: Halaman tentang
- `ServicesPage`: Halaman layanan

#### 2. **Authentication**
- `Login`: Komponen login
- `Register`: Komponen registrasi
- Middleware untuk proteksi route admin

#### 3. **Admin Panel**
- `Dashboard`: Dashboard admin
- `PostForm`: Form untuk membuat/edit artikel
- Middleware `admin` untuk akses kontrol

#### 4. **Database Models**
- `User`: Model pengguna
- `Post`: Model artikel blog (diasumsikan)
- `ContactMessage`: Model pesan kontak

### Fitur Utama

1. **Blog System**
   - Daftar artikel dengan pagination
   - Detail artikel dengan slug URL
   - Sistem admin untuk mengelola konten

2. **Authentication**
   - Login/Register pengguna
   - Role-based access control
   - Session management

3. **Contact System**
   - Form kontak dengan validasi
   - Penyimpanan pesan ke database
   - Flash message feedback

4. **Responsive Design**
   - Mobile-first approach dengan Tailwind CSS
   - Komponen UI yang konsisten


## 📦 Build untuk Production

```bash
# Build assets untuk production
npm run build

# Optimize Laravel untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔧 Konfigurasi Tambahan

### Database
Untuk menggunakan MySQL/PostgreSQL, edit file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 📝 Catatan Pengembangan

- Aplikasi menggunakan PotgreSQL sebagai database default untuk kemudahan development
- Asset dikompilasi menggunakan Vite untuk performa optimal
- Livewire memungkinkan interaktivitas tanpa JavaScript kompleks

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT.