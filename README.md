# Project UAS PWL - Company Profile Website - CodeIgniter 4
Website Company Profile PT. Samsudi Indoniaga Sedaya. Dibangun menggunakan Framework CodeIgniter 4.

Anggota Kelompok
1. Aditia Eka Ramadhan – A11.2023.14997
2. Daniel Aquaries Pratama - A11.2023.15003


## 📁 Struktur Project

```
company-profile/
├── app/
│   ├── Controllers/
│   │   ├── CompanyProfile.php      # Main website controller
│   │   ├── Admin.php               # Admin panel controller
│   │   ├── ImageUpload.php         # Image upload handler
│   │   └── Api/
│   │       ├── CompanyApi.php      # Company API endpoints
│   │       └── PartnerApi.php      # Partner API endpoints
│   ├── Models/
│   │   ├── CompanySettingsModel.php
│   │   ├── AdminUserModel.php
│   │   ├── ServiceModel.php
│   │   ├── PartnerModel.php
│   │   └── ContactModel.php
│   ├── Views/
│   │   ├── company/                # Public website views
│   │   ├── admin/                  # Admin panel views
│   │   └── layouts/                # Layout templates
│   ├── Database/
│   │   ├── Migrations/             # Database migrations
│   │   └── Seeds/                  # Database seeders
│   └── Config/
│       └── Routes.php              # Application routes
├── public/
│   ├── assets/
│   │   ├── css/main.css           # Main stylesheet
│   │   └── images/uploads/        # Upload directory
│   └── index.php
├── writable/                      # Cache, logs, session
└── vendor/                        # Composer dependencies
```

## 🚀 Fitur Utama

### Frontend (Website Publik)

- **Responsive Design**: Website yang mobile-friendly dan SEO optimized
- **Dynamic Content**: Semua konten diambil dari database
- **Hero Section**: Background image dan tagline yang dapat diubah dari admin
- **About Section**: Informasi perusahaan dengan gambar yang dapat diupload
- **Services**: Layanan perusahaan dengan icon Font Awesome yang dapat dipilih
- **Partners**: Logo dan informasi partner/mitra dengan upload gambar
- **Contact Form**: Form kontak dengan notifikasi dan tersimpan ke database
- **Professional Icons**: Menggunakan Font Awesome 6.4.0

### Backend (Admin Panel)

- **Dashboard**: Statistik pesan dan overview data
- **Contact Management**: Kelola pesan masuk dari website dengan bulk actions
- **Company Settings**: Atur informasi perusahaan, upload logo, background
- **Services Management**: CRUD layanan dengan icon picker interaktif
- **Partners Management**: CRUD partner dengan upload logo
- **Image Upload**: Upload dan hapus gambar dengan preview dan validasi
- **User Management**: Login/logout admin dengan session
- **Password Management**: Ganti password admin
- **Data Initialization**: Setup data awal otomatis

## 🛠️ Instalasi & Setup

### 1. Download Project

```bash
# Clone atau download project ini
git clone [repository-url]
cd company-profile

# Atau extract dari ZIP file
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
# Copy environment file
cp env .env

# Edit .env file dan sesuaikan konfigurasi database
```

**Edit file `.env`:**

```env
# Database Configuration
database.default.hostname = localhost
database.default.database = company_profile_db
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi

# App Configuration
app.baseURL = 'http://localhost:8080/'
app.indexPage = ''

# Environment
CI_ENVIRONMENT = development
```

### 4. Database Setup

```bash
# Buat database (via MySQL client atau phpMyAdmin)
CREATE DATABASE company_profile_db;

# Jalankan migrations
php spark migrate

# Seed data awal dan admin user
php spark db:seed AdminSeeder
```

### 5. Set Permissions

```bash
# Linux/Mac
chmod -R 755 writable/
chmod -R 755 public/assets/images/uploads/

# Windows (via PowerShell as Administrator)
icacls writable /grant Users:F /T
icacls public\assets\images\uploads /grant Users:F /T
```

### 6. Jalankan Server

```bash
# Development server
php spark serve

# Akses website: http://localhost:8080
# Akses admin: http://localhost:8080/admin/login
```
