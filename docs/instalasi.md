# Instalasi & Setup

## Persyaratan Sistem
- PHP 8.1 atau lebih tinggi
- Composer 2.0+
- MySQL 8.0+
- Node.js 16+
- Web Server (Apache/Nginx)

## Langkah Instalasi

### 1. Clone Repository
```bash
git clone [repository-url]
cd histore
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=histore_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Setup Storage
```bash
php artisan storage:link
```

### 6. Migrasi Database
```bash
php artisan migrate
```

### 7. Seed Data (Opsional)
```bash
php artisan db:seed
```

### 8. Compile Assets
```bash
npm run build
```

### 9. Setup Admin User
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
    ...
}
``` 