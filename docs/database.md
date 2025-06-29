# Struktur Database

## Diagram ERD
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

## Tabel Utama

### Users
- id, name, email, password, is_admin, timestamps

### Categories
- id, name, slug, description, timestamps

### Products
- id, name, slug, description, price, stock, image, is_active, category_id, warna, kondisi, storage, timestamps

### Favorites
- id, user_id, product_id, timestamps

### Orders
- id, user_id, total, status, timestamps

### Order Items
- id, order_id, product_id, quantity, price, timestamps 