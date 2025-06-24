# Project UAS PWL - Company Profile Website - CodeIgniter 4
Website Company Profile dengan nama Company PT. Samsudi Indoniaga Sedaya. Dibangun menggunakan CodeIgniter 4.

Anggota Kelompok
1. Aditya Eka Ramadhan – A11.2023.14497
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