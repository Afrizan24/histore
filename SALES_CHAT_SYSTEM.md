# Sales Chat System Documentation

## Overview
Sistem ini mengatur batasan chat WhatsApp untuk sales representative. Setiap sales hanya dapat menerima maksimal 5 chat per hari. Setelah mencapai batas, sales akan otomatis tidak ditampilkan di halaman publik dan admin akan mendapat notifikasi.

## Fitur Utama

### 1. Tracking Chat WhatsApp
- Mencatat setiap chat WhatsApp yang dilakukan user (login atau tidak)
- Menyimpan informasi: sales ID, user ID (jika login), IP address, user agent, timestamp
- Reset otomatis setiap hari

### 2. Batasan Chat Harian
- Maksimal 5 chat per sales per hari
- Sales yang mencapai limit tidak ditampilkan di halaman publik
- Admin dapat melihat status chat count di dashboard

### 3. Notifikasi Admin
- Email notification ke semua admin ketika sales mencapai limit
- Log notification di database
- Admin dapat reset chat count atau nonaktifkan sales

### 4. Interface User
- Halaman sales menampilkan chat count dan status limit
- Tombol chat disabled ketika limit tercapai
- Pesan error yang informatif

## Database Structure

### Table: whatsapp_chats
```sql
- id (primary key)
- sale_id (foreign key ke sales table)
- user_id (foreign key ke users table, nullable)
- visitor_ip (string, nullable)
- visitor_user_agent (string, nullable)
- chatted_at (timestamp)
- created_at, updated_at
```

### Table: notifications
```sql
- id (primary key)
- type (string)
- notifiable_type (string)
- notifiable_id (bigint)
- data (text)
- read_at (timestamp, nullable)
- created_at, updated_at
```

## API Endpoints

### Public Routes
- `GET /sales` - Menampilkan sales yang tersedia
- `POST /sales/{sale}/chat` - Record chat dan redirect ke WhatsApp

### Admin Routes
- `GET /admin/sales` - Dashboard admin dengan chat count
- `POST /admin/sales/{sale}/toggle-active` - Toggle status aktif/nonaktif
- `POST /admin/sales/{sale}/reset-chats` - Reset chat count hari ini

## Commands

### Testing
```bash
# Test chat system untuk sales tertentu
php artisan sales:test-chat {sale_id} {count}

# Contoh: Tambah 3 chat untuk sales ID 1
php artisan sales:test-chat 1 3
```

### Maintenance
```bash
# Reset semua chat count hari ini
php artisan sales:reset-chats

# Reset chat count untuk tanggal tertentu
php artisan sales:reset-chats --date=2025-06-20
```

## Model Methods

### Sale Model
```php
// Get chat count hari ini
$sale->getTodayChatCount()

// Cek apakah sudah mencapai limit
$sale->hasReachedDailyLimit()

// Get sales yang tersedia (belum mencapai limit)
Sale::getAvailableSales()

// Record chat baru
$sale->recordChat($userId, $request)
```

### WhatsappChat Model
```php
// Get chat count untuk sales tertentu
WhatsappChat::getChatCountForSale($saleId, $date)

// Cek apakah sudah mencapai limit
WhatsappChat::hasReachedDailyLimit($saleId, $limit, $date)

// Record chat baru
WhatsappChat::recordChat($saleId, $userId, $request)
```

## Workflow

### 1. User Mengakses Halaman Sales
- Sistem menampilkan hanya sales yang aktif dan belum mencapai limit
- Setiap sales menampilkan chat count hari ini

### 2. User Klik Chat WhatsApp
- Sistem mengecek apakah sales masih tersedia
- Jika tersedia: record chat dan redirect ke WhatsApp
- Jika tidak: tampilkan pesan error

### 3. Sales Mencapai Limit (Chat ke-5)
- Sistem otomatis record chat
- Kirim notifikasi ke semua admin
- Sales tidak akan ditampilkan lagi hari ini

### 4. Admin Management
- Admin dapat melihat chat count di dashboard
- Admin dapat toggle status aktif/nonaktif
- Admin dapat reset chat count untuk emergency
- Admin mendapat email notification ketika sales mencapai limit

## Configuration

### Chat Limit
Limit chat per hari dapat diubah di:
- `app/Models/Sale.php` - method `hasReachedDailyLimit($limit = 5)`
- `app/Models/WhatsappChat.php` - method `hasReachedDailyLimit($limit = 5)`

### Notification Settings
Email notification dapat dikonfigurasi di:
- `config/mail.php` - SMTP settings
- `app/Notifications/SalesLimitReached.php` - notification content

## Security Features

1. **CSRF Protection** - Semua form menggunakan CSRF token
2. **Input Validation** - Validasi semua input user
3. **SQL Injection Protection** - Menggunakan Eloquent ORM
4. **Rate Limiting** - Bisa ditambahkan middleware rate limiting

## Monitoring & Logging

1. **Application Logs** - Semua event chat direcord di log
2. **Database Logs** - Chat history tersimpan di database
3. **Email Notifications** - Admin mendapat notifikasi real-time
4. **Dashboard Monitoring** - Admin dapat monitor status di dashboard

## Troubleshooting

### Sales Tidak Muncul di Halaman Publik
1. Cek apakah sales `is_active = true`
2. Cek apakah chat count sudah mencapai 5
3. Cek apakah ada error di log

### Notifikasi Tidak Terkirim
1. Cek konfigurasi email di `config/mail.php`
2. Cek apakah ada admin user dengan `is_admin = true`
3. Cek queue worker jika menggunakan queue

### Chat Count Tidak Reset
1. Pastikan timezone server benar
2. Cek apakah ada error di migration
3. Gunakan command `php artisan sales:reset-chats` untuk manual reset

## Future Enhancements

1. **Queue System** - Implementasi queue untuk notification
2. **Analytics Dashboard** - Chart dan statistik chat
3. **Auto Reset Schedule** - Cron job untuk auto reset
4. **Multiple Limits** - Limit berbeda untuk hari kerja/weekend
5. **Chat History** - Halaman detail chat history
6. **Export Data** - Export chat data untuk analisis 