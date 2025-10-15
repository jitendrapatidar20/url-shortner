# 🚀 Sembark URL Shortener

A Laravel 11 project implementing a URL Shortener system with role-based access, invitations, and company-level management.

1. Clone repo
2. copy .env.example -> .env, set DB settings (sqlite: database/database.sqlite or mysql)
3. composer install
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed --class=SuperAdminSeeder
   This creates roles, a sample company and a SuperAdmin user (Email : superadmin@sembark.com / Password : superadmin)
7. php artisan serve
8. Visit /login to authenticate and then /admin/short-urls

## 📋 Features

- Role-based authentication (`SuperAdmin`, `Admin`, `Member`)
- Company (client) management with URL tracking
- URL shortening & redirection
- Invitation system with approval workflow
- DataTables with filters 
- Role-based access for creating and viewing URLs

---

## 🛠️ Tech Stack

- **PHP** 8.2+
- **Laravel** 11
- **MySQL** or **SQLite**
- **jQuery DataTables**
- **Bootstrap 5**

---

## ⚙️ Installation Guide

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/jitendrapatidar20/url-shortner.git
cd url-shortener
