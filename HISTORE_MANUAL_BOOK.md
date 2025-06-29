# HISTORE - Manual Book Lengkap
## Sistem E-Commerce Apple Store

---

## 📋 DAFTAR ISI

1. [Pendahuluan](#pendahuluan)
2. [Konsep & Arsitektur](#konsep--arsitektur)
3. [Instalasi & Setup](#instalasi--setup)
4. [Struktur Database](#struktur-database)
5. [Fitur Utama](#fitur-utama)
6. [Admin Panel](#admin-panel)
7. [User Interface](#user-interface)
8. [API & Integrasi](#api--integrasi)
9. [Keamanan](#keamanan)
10. [Maintenance](#maintenance)
11. [Troubleshooting](#troubleshooting)
12. [FAQ](#faq)

---

## 🎯 PENDAHULUAN

### Tentang Histore
Histore adalah platform e-commerce khusus untuk produk Apple yang dibangun menggunakan Laravel 10. Sistem ini dirancang untuk memberikan pengalaman berbelanja yang optimal dengan fokus pada produk Apple yang berkualitas.

### Tujuan
- Menyediakan platform jual-beli produk Apple yang aman dan terpercaya
- Memberikan pengalaman user yang smooth dan responsif
- Memudahkan admin dalam mengelola produk dan transaksi
- Mengintegrasikan sistem chat WhatsApp untuk customer service

### Target Pengguna
- **Admin**: Pengelola toko, sales, dan sistem
- **Customer**: Pembeli produk Apple
- **Sales**: Tim penjualan yang membantu customer

---

## 🏗️ KONSEP & ARSITEKTUR

### Arsitektur Sistem
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   Database      │
│   (Blade)       │◄──►│   (Laravel)     │◄──►│   (MySQL)       │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   User Interface│    │   API Endpoints │    │   File Storage  │
│   Responsive    │    │   RESTful       │    │   (Public)      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Teknologi yang Digunakan
- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Bootstrap 5, Blade Templates
- **Database**: MySQL 8.0+
- **Storage**: Laravel Storage (Public Disk)
- **Authentication**: Laravel Breeze
- **Icons**: Font Awesome 6

### Prinsip Desain
1. **Responsive Design**: Optimal di semua device
2. **User-Centric**: Fokus pada pengalaman pengguna
3. **Security First**: Keamanan data prioritas utama
4. **Scalable**: Mudah dikembangkan dan diperluas
5. **Performance**: Loading cepat dan efisien

---

## ⚙️ INSTALASI & SETUP

### Persyaratan Sistem
- PHP 8.1 atau lebih tinggi
- Composer 2.0+
- MySQL 8.0+
- Node.js 16+ (untuk asset compilation)
- Web Server (Apache/Nginx)

### Langkah Instalasi

#### 1. Clone Repository
```bash
git clone [repository-url]
cd histore
```

#### 2. Install Dependencies
```bash
composer install
npm install
```

#### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

#### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=histore_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 5. Setup Storage
```bash
php artisan storage:link
```

#### 6. Migrasi Database
```bash
php artisan migrate
```

#### 7. Seed Data (Opsional)
```bash
php artisan db:seed
```

#### 8. Compile Assets
```bash
npm run build
```

#### 9. Setup Admin User
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@histore.com',
    'password' => Hash::make('password'),
    'is_admin' => true
]);
```

### Konfigurasi Web Server

#### Apache (.htaccess)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name histore.local;
    root /path/to/histore/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🗄️ STRUKTUR DATABASE

### Diagram ERD
```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│    Users    │    │ Categories  │    │  Products   │
├─────────────┤    ├─────────────┤    ├─────────────┤
│ id          │    │ id          │    │ id          │
│ name        │    │ name        │    │ name        │
│ email       │    │ slug        │    │ slug        │
│ password    │    │ description │    │ description │
│ is_admin    │    │ created_at  │    │ price       │
│ created_at  │    │ updated_at  │    │ stock       │
│ updated_at  │    └─────────────┘    │ image       │
└─────────────┘           │           │ is_active   │
         │                │           │ category_id │
         │                │           │ warna       │
         │                │           │ kondisi     │
         │                │           │ storage     │
         │                │           │ created_at  │
         │                │           │ updated_at  │
         │                │           └─────────────┘
         │                │                   │
         │                │                   │
         ▼                ▼                   ▼
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│  Favorites  │    │   Orders    │    │ Order Items │
├─────────────┤    ├─────────────┤    ├─────────────┤
│ id          │    │ id          │    │ id          │
│ user_id     │    │ user_id     │    │ order_id    │
│ product_id  │    │ total       │    │ product_id  │
│ created_at  │    │ status      │    │ quantity    │
│ updated_at  │    │ created_at  │    │ price       │
└─────────────┘    │ updated_at  │    │ created_at  │
                   └─────────────┘    │ updated_at  │
                                      └─────────────┘
```

### Tabel Utama

#### 1. Users
- **id**: Primary key
- **name**: Nama lengkap user
- **email**: Email unik untuk login
- **password**: Password terenkripsi
- **is_admin**: Boolean untuk admin
- **created_at/updated_at**: Timestamp

#### 2. Categories
- **id**: Primary key
- **name**: Nama kategori
- **slug**: URL-friendly name
- **description**: Deskripsi kategori

#### 3. Products
- **id**: Primary key
- **name**: Nama produk
- **slug**: URL-friendly name
- **description**: Deskripsi produk
- **price**: Harga (decimal)
- **stock**: Jumlah stok
- **image**: Path gambar
- **is_active**: Status aktif
- **category_id**: Foreign key ke categories
- **warna**: Warna produk
- **kondisi**: New/Second
- **storage**: Kapasitas storage

#### 4. Favorites
- **id**: Primary key
- **user_id**: Foreign key ke users
- **product_id**: Foreign key ke products

#### 5. Orders
- **id**: Primary key
- **user_id**: Foreign key ke users
- **total**: Total harga
- **status**: Status order

#### 6. Order Items
- **id**: Primary key
- **order_id**: Foreign key ke orders
- **product_id**: Foreign key ke products
- **quantity**: Jumlah item
- **price**: Harga per item

---

## 🚀 FITUR UTAMA

### 1. Manajemen Produk
- ✅ CRUD produk lengkap
- ✅ Upload dan resize gambar
- ✅ Kategorisasi produk
- ✅ Manajemen stok
- ✅ Status aktif/nonaktif
- ✅ Spesifikasi produk (warna, kondisi, storage)

### 2. Sistem Favorit
- ✅ Favorit untuk user terdaftar (database)
- ✅ Favorit untuk guest (session)
- ✅ Toggle favorit via AJAX
- ✅ Hitung total favorit
- ✅ Refresh count real-time

### 3. Manajemen Stok
- ✅ Input stok saat create/edit produk
- ✅ Tampilan stok dengan warna indikator
- ✅ Filter berdasarkan status stok
- ✅ Alert stok habis
- ✅ Monitoring stok menipis

### 4. Katalog Produk
- ✅ Tampilan grid responsif
- ✅ Filter multi-kriteria
- ✅ Sorting (harga, terbaru, terlaris)
- ✅ Pagination
- ✅ Search produk

### 5. Detail Produk
- ✅ Informasi lengkap produk
- ✅ Galeri gambar
- ✅ Spesifikasi detail
- ✅ Related products
- ✅ Integrasi WhatsApp sales

### 6. Admin Panel
- ✅ Dashboard admin
- ✅ Manajemen produk
- ✅ Manajemen kategori
- ✅ Manajemen user
- ✅ Manajemen banner
- ✅ Manajemen sales

### 7. Authentication
- ✅ Login/Register user
- ✅ Admin middleware
- ✅ Password reset
- ✅ Session management

---

## 👨‍💼 ADMIN PANEL

### Akses Admin Panel
```
URL: /admin
Login: admin@histore.com
Password: [sesuai yang di-set]
```

### Menu Admin

#### 1. Dashboard
- **URL**: `/admin/dashboard`
- **Fitur**:
  - Statistik produk
  - Statistik user
  - Statistik order
  - Grafik penjualan

#### 2. Manajemen Produk
- **URL**: `/admin/products`
- **Fitur**:
  - Daftar semua produk
  - Tambah produk baru
  - Edit produk
  - Hapus produk
  - Filter dan search
  - Upload gambar

**Form Tambah/Edit Produk**:
```
- Nama Produk (required)
- Kategori (required)
- Harga (required, numeric)
- Stok (required, integer)
- Warna (required)
- Kondisi: New/Second (required)
- Storage (optional)
- Deskripsi (required)
- Gambar (required untuk create)
- Status Aktif (checkbox)
```

#### 3. Manajemen Kategori
- **URL**: `/admin/categories`
- **Fitur**:
  - CRUD kategori
  - Slug otomatis
  - Validasi nama unik

#### 4. Manajemen User
- **URL**: `/admin/users`
- **Fitur**:
  - Daftar user
  - Edit user
  - Set admin status
  - Reset password

#### 5. Manajemen Banner
- **URL**: `/admin/banners`
- **Fitur**:
  - Upload banner
  - Set urutan
  - Status aktif

#### 6. Manajemen Sales
- **URL**: `/admin/sales`
- **Fitur**:
  - Data sales
  - WhatsApp integration
  - Status aktif

### Fitur Admin Lainnya

#### Filter & Search
- Search berdasarkan nama produk
- Filter berdasarkan kategori
- Filter berdasarkan kondisi
- Filter berdasarkan stok
- Sorting (nama, harga, terbaru)

#### Bulk Actions
- Aktifkan/nonaktifkan multiple produk
- Hapus multiple produk
- Export data

#### Notifications
- Stok menipis alert
- Order baru notification
- Error logging

---

## 🎨 USER INTERFACE

### 1. Homepage
- **Hero Section**: Banner carousel
- **Featured Products**: Produk unggulan
- **Categories**: Navigasi kategori
- **Call-to-Action**: Browse products

### 2. Product Catalog
- **Filter Bar**: 
  - Sort (harga, terbaru, terlaris)
  - Filter warna
  - Filter kondisi
  - Filter storage
  - Filter stok
- **Product Grid**: Responsive cards
- **Pagination**: Navigasi halaman

### 3. Product Detail
- **Product Images**: Gallery
- **Product Info**: Nama, harga, deskripsi
- **Specifications**: Warna, kondisi, storage, stok
- **Action Buttons**: 
  - Hubungi Sales (WhatsApp)
  - Tambah ke Favorit
  - Share Product
- **Related Products**: Produk serupa

### 4. User Account
- **Login/Register**: Form authentication
- **Profile**: Edit informasi user
- **Favorites**: Daftar produk favorit
- **Orders**: Riwayat order

### 5. Cart & Checkout
- **Cart**: Daftar produk yang dipilih
- **Checkout**: Form order
- **Payment**: Integrasi payment gateway

### Responsive Design
- **Desktop**: Layout 4 kolom
- **Tablet**: Layout 2 kolom
- **Mobile**: Layout 1 kolom
- **Touch-friendly**: Button size optimal

---

## 🔌 API & INTEGRASI

### RESTful API Endpoints

#### Products
```
GET    /api/products          # List products
GET    /api/products/{id}     # Get product detail
POST   /api/products          # Create product (admin)
PUT    /api/products/{id}     # Update product (admin)
DELETE /api/products/{id}     # Delete product (admin)
```

#### Categories
```
GET    /api/categories        # List categories
GET    /api/categories/{id}   # Get category detail
POST   /api/categories        # Create category (admin)
PUT    /api/categories/{id}   # Update category (admin)
DELETE /api/categories/{id}   # Delete category (admin)
```

#### Favorites
```
GET    /api/favorites         # Get user favorites
POST   /api/favorites         # Add to favorites
DELETE /api/favorites/{id}    # Remove from favorites
```

#### Orders
```
GET    /api/orders            # Get user orders
POST   /api/orders            # Create order
GET    /api/orders/{id}       # Get order detail
```

### WhatsApp Integration
```javascript
// Format pesan WhatsApp
const message = `Halo, saya tertarik dengan produk:
${product.name}
Harga: Rp ${product.price}
Link: ${window.location.href}`;

const whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
```

### File Upload
```php
// Upload image
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('products', 'public');
    $product->image = $path;
}
```

---

## 🔒 KEAMANAN

### Authentication & Authorization
- **Laravel Breeze**: Authentication system
- **Middleware**: Admin access control
- **CSRF Protection**: Form security
- **Password Hashing**: Bcrypt encryption

### Data Validation
```php
// Product validation
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
    'stock' => 'required|integer|min:0',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
]);
```

### File Security
- **File Type Validation**: Hanya gambar yang diizinkan
- **File Size Limit**: Maksimal 2MB
- **Storage Security**: File disimpan di public disk
- **Virus Scan**: Implementasi antivirus (opsional)

### Database Security
- **SQL Injection Prevention**: Eloquent ORM
- **XSS Protection**: Blade escaping
- **Input Sanitization**: Laravel validation
- **Backup Regular**: Database backup otomatis

### Session Security
- **Session Encryption**: Laravel session security
- **CSRF Tokens**: Cross-site request forgery protection
- **Session Timeout**: Auto logout setelah idle
- **Secure Cookies**: HTTP-only cookies

---

## 🛠️ MAINTENANCE

### Backup Strategy

#### Database Backup
```bash
# Manual backup
mysqldump -u username -p histore_db > backup_$(date +%Y%m%d_%H%M%S).sql

# Automated backup (cron job)
0 2 * * * mysqldump -u username -p histore_db > /backup/histore_$(date +\%Y\%m\%d).sql
```

#### File Backup
```bash
# Backup storage files
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/

# Backup code
git archive --format=zip --output=code_backup_$(date +%Y%m%d).zip HEAD
```

### Monitoring

#### Log Monitoring
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Error logs
tail -f storage/logs/error.log

# Access logs
tail -f /var/log/apache2/access.log
```

#### Performance Monitoring
- **Response Time**: Monitor API response time
- **Memory Usage**: Check PHP memory usage
- **Database Queries**: Optimize slow queries
- **File Size**: Monitor storage usage

### Updates & Maintenance

#### Laravel Updates
```bash
# Check for updates
composer outdated

# Update Laravel
composer update laravel/framework

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### Security Updates
```bash
# Update dependencies
composer update

# Check security vulnerabilities
composer audit

# Update npm packages
npm update
```

### Performance Optimization

#### Caching
```php
// Route caching
php artisan route:cache

// Config caching
php artisan config:cache

// View caching
php artisan view:cache
```

#### Database Optimization
```sql
-- Optimize tables
OPTIMIZE TABLE products, categories, users;

-- Analyze tables
ANALYZE TABLE products, categories, users;
```

---

## 🔧 TROUBLESHOOTING

### Common Issues

#### 1. Upload Image Error
**Problem**: Gambar tidak bisa diupload
**Solution**:
```bash
# Check storage link
php artisan storage:link

# Check permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Check disk space
df -h
```

#### 2. Database Connection Error
**Problem**: Tidak bisa connect ke database
**Solution**:
```bash
# Check database service
sudo systemctl status mysql

# Check credentials
php artisan tinker
DB::connection()->getPdo();

# Check .env file
cat .env | grep DB_
```

#### 3. 500 Server Error
**Problem**: Internal server error
**Solution**:
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan cache:clear
php artisan config:clear

# Check permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

#### 4. Slow Loading
**Problem**: Website loading lambat
**Solution**:
```bash
# Enable caching
php artisan route:cache
php artisan config:cache
php artisan view:cache

# Optimize images
php artisan optimize:images

# Check database queries
php artisan debugbar:clear
```

#### 5. Favorites Not Working
**Problem**: Fitur favorit tidak berfungsi
**Solution**:
```bash
# Check session configuration
php artisan config:cache

# Check JavaScript console
# Verify AJAX requests

# Check database connection
php artisan tinker
App\Models\Favorite::count();
```

### Debug Commands
```bash
# Show all routes
php artisan route:list

# Show environment
php artisan env

# Show configuration
php artisan config:show

# Clear all caches
php artisan optimize:clear

# Check application status
php artisan about
```

### Log Analysis
```bash
# Search for errors
grep -i error storage/logs/laravel.log

# Search for specific date
grep "2024-01-15" storage/logs/laravel.log

# Monitor real-time
tail -f storage/logs/laravel.log | grep -i error
```

---

## ❓ FAQ

### Umum

**Q: Bagaimana cara mengubah password admin?**
A: 
```bash
php artisan tinker
$user = User::where('email', 'admin@histore.com')->first();
$user->password = Hash::make('new_password');
$user->save();
```

**Q: Bagaimana cara backup database?**
A:
```bash
mysqldump -u username -p histore_db > backup.sql
```

**Q: Bagaimana cara menambah kategori baru?**
A: Login ke admin panel → Categories → Add New Category

**Q: Bagaimana cara mengubah logo website?**
A: Upload file logo ke `public/images/` dan update di layout

### Produk

**Q: Bagaimana cara menambah produk baru?**
A: Admin Panel → Products → Add New Product → Isi form → Save

**Q: Bagaimana cara mengubah stok produk?**
A: Admin Panel → Products → Edit Product → Ubah field Stock → Save

**Q: Bagaimana cara mengupload gambar produk?**
A: Format: JPG, PNG, GIF. Maksimal 2MB. Drag & drop atau klik browse

**Q: Bagaimana cara mengaktifkan/nonaktifkan produk?**
A: Admin Panel → Products → Edit Product → Checkbox "Produk Aktif" → Save

### User

**Q: Bagaimana cara register user baru?**
A: Klik "Register" di homepage → Isi form → Verify email → Login

**Q: Bagaimana cara reset password?**
A: Login page → "Forgot Password?" → Masukkan email → Check email → Reset

**Q: Bagaimana cara menambah user ke favorit?**
A: Klik icon hati di product card atau detail produk

### Technical

**Q: Bagaimana cara deploy ke production?**
A: 
```bash
# Set environment
cp .env.example .env
# Edit .env untuk production

# Install dependencies
composer install --optimize-autoloader --no-dev
npm run build

# Setup database
php artisan migrate --force

# Set permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

**Q: Bagaimana cara mengubah URL website?**
A: Edit file `.env`:
```env
APP_URL=https://yourdomain.com
```

**Q: Bagaimana cara mengubah timezone?**
A: Edit file `.env`:
```env
APP_TIMEZONE=Asia/Jakarta
```

**Q: Bagaimana cara mengaktifkan HTTPS?**
A: 
```bash
# Generate SSL certificate
# Update .env
APP_URL=https://yourdomain.com
ASSET_URL=https://yourdomain.com
```

---

## 📞 SUPPORT

### Contact Information
- **Email**: support@histore.com
- **WhatsApp**: +62 812-3456-7890
- **Documentation**: [Link ke dokumentasi]
- **GitHub**: [Link ke repository]

### Support Hours
- **Monday - Friday**: 09:00 - 17:00 WIB
- **Saturday**: 09:00 - 15:00 WIB
- **Sunday**: Closed

### Emergency Contact
- **Technical Issues**: +62 812-3456-7890
- **Security Issues**: security@histore.com

---

## 📝 CHANGELOG

### Version 1.0.0 (Current)
- ✅ Initial release
- ✅ Product management
- ✅ User authentication
- ✅ Favorites system
- ✅ Stock management
- ✅ Admin panel
- ✅ WhatsApp integration
- ✅ Responsive design

### Planned Features
- 🔄 Payment gateway integration
- 🔄 Order management system
- 🔄 Email notifications
- 🔄 Advanced analytics
- 🔄 Mobile app
- 🔄 Multi-language support

---

## 📄 LICENSE

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**© 2024 Histore. All rights reserved.**

*Manual ini dibuat untuk memudahkan penggunaan dan maintenance sistem Histore. Untuk pertanyaan lebih lanjut, silakan hubungi tim support.* 