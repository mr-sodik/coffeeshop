# ☕ 404 CAFE - Coffee Shop System

Aplikasi coffee shop berbasis Laravel dengan fitur modern dan multi role.

---

## 🚀 Fitur Utama
- Login Multi Role (Admin, Kasir, Customer)
- Sistem Kasir (POS)
- Manajemen Menu & Kategori
- Keranjang (Cart) untuk customer
- Detail menu ala e-commerce
- Dashboard Admin
- Laporan transaksi

---

## 🛠️ Teknologi
- Laravel
- MySQL
- JavaScript
- CSS

---

## 🎨 UI / UX
- Design minimalis ala Kurasu Coffee
- Tampilan premium & clean
- Responsive

---

## ⚙️ Cara Menjalankan Project

```bash
git clone https://github.com/mr-sodik/coffeeshop.git
cd coffeeshop
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve