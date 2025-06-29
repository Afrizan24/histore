# Konsep & Arsitektur

## Arsitektur Sistem

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

## Teknologi yang Digunakan
- Backend: Laravel 10 (PHP 8.1+)
- Frontend: Bootstrap 5, Blade Templates
- Database: MySQL 8.0+
- Storage: Laravel Storage (Public Disk)
- Authentication: Laravel Breeze
- Icons: Font Awesome 6

## Prinsip Desain
1. Responsive Design
2. User-Centric
3. Security First
4. Scalable
5. Performance 