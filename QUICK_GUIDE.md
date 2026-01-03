# 🚀 Quick Start Guide - JJB Travel Bali

## ⚡ PANDUAN CEPAT AFFILIATE

### 📝 DAFTAR SEBAGAI AFFILIATE (5 MENIT)
```
1. 🌐 Buka: localhost:8000/register/affiliate
2. 📋 Isi 4 langkah:
   ├── Personal Info (nama, email, HP, alamat)
   ├── Upload KTP (wajib) + NPWP (opsional)  
   ├── Data Bank (nama bank, rekening, foto buku tabungan)
   └── Setuju terms & submit
3. ✅ Terima konfirmasi → tunggu approval admin
4. 🔑 Password login: 8 digit terakhir KTP
```

### 🚪 LOGIN & DASHBOARD
```
🔐 Login: localhost:8000/login
📊 Dashboard otomatis tampilkan:
   ├── Total booking & komisi
   ├── Grafik performa
   ├── Tombol "Tambah Booking"
   └── Recent activities
```

### ➕ BUAT BOOKING MANUAL (3 MENIT)
```
1. 🎯 Klik "Tambah Booking" di dashboard
2. 📦 Pilih paket travel
3. 👤 Isi data customer (nama, email, HP, KTP)
4. 📅 Pilih tanggal & jumlah peserta
5. 👥 Detail peserta (nama, umur, gender)
6. 💰 Info pembayaran + upload bukti
7. ✅ Submit → tunggu approve admin
```

### 💰 CEK KOMISI & PAYOUT
```
💵 Dashboard → Section "Commission"
📊 Lihat: Earned / Pending / Paid
📤 Request Payout:
   ├── Minimum: IDR 500,000
   ├── Via rekening bank terdaftar
   └── Proses: 3-5 hari kerja
```

---

## 👨‍💼 PANDUAN CEPAT ADMIN

### 🚪 LOGIN ADMIN
```
🌐 URL: localhost:8000/login
👤 Kredensial:
   ├── Super Admin: superadmin@jjbtravelbali.com / password
   └── Admin: admin@jjbtravelbali.com / password
```

### ✅ APPROVE AFFILIATE BARU
```
📍 Navigation: Admin Dashboard → Affiliates → Pending
🔍 Review Process:
   ├── 1. Cek data pribadi lengkap
   ├── 2. Verifikasi dokumen KTP jelas
   ├── 3. Validasi data bank sesuai
   └── 4. Approve/Reject dengan alasan
   
🚀 Quick Actions:
   ├── ✅ Approve: Langsung aktif + email notif
   └── ❌ Reject: Isi alasan penolakan
```

### 📋 APPROVE BOOKING
```
📍 Navigation: Bookings → Pending
⚡ Quick Check:
   ├── Package available? ✅
   ├── Date valid? ✅  
   ├── Price correct? ✅
   ├── Payment proof OK? ✅
   └── Customer data complete? ✅

🎯 Actions:
   ├── ✅ Approve → Booking confirmed
   ├── ❌ Reject → State reason
   └── 📞 Contact customer if needed
```

### 🎯 KELOLA TRAVEL PACKAGES
```
📍 Navigation: Packages → All Packages
➕ Add New Package:
   ├── Basic info (nama, kategori, durasi)
   ├── Pricing (dewasa/anak/bayi)
   ├── Content (deskripsi, highlights)
   ├── Media (foto, gallery, video)
   └── SEO (title, keywords, description)

🔧 Package Management:
   ├── 👁️ Preview customer view
   ├── ✏️ Edit/Update content  
   ├── 📊 View booking statistics
   └── 🗑️ Archive/Delete
```

### 💰 KELOLA PEMBAYARAN
```
📍 Navigation: Payments → Verification
🔍 Verify Payment:
   ├── 1. Check bukti transfer jelas
   ├── 2. Nominal sesuai booking
   ├── 3. Nama pengirim = customer
   └── 4. Mark verified/rejected

💸 Process Payout:
   ├── Review payout requests
   ├── Verify minimum threshold
   ├── Transfer ke affiliate
   └── Update status "Paid"
```

---

## 📊 STATISTIK & REPORTS

### 📈 DASHBOARD METRICS
```
👥 Affiliate Stats:
   ├── Total/Active/Pending affiliates
   ├── New registrations (daily/monthly)
   └── Performance ranking

💰 Revenue Stats:
   ├── Total/Daily/Monthly revenue  
   ├── Commission payouts
   └── Profit margins

📋 Booking Stats:
   ├── Total/Confirmed/Pending bookings
   ├── Package popularity
   └── Customer acquisition
```

### 📊 GENERATE REPORTS
```
📍 Navigation: Reports → Generate
📈 Available Reports:
   ├── Affiliate Performance (commission, bookings)
   ├── Revenue Analysis (daily/monthly/yearly)
   ├── Package Performance (bestsellers, low performers)
   ├── Customer Analytics (acquisition, retention)
   └── Financial Summary (profit, expenses)

📤 Export Options: Excel, PDF, CSV
```

---

## 🆘 TROUBLESHOOTING CEPAT

### ❗ MASALAH UMUM AFFILIATE
```
🔐 Login Error:
   └── Pastikan status "Active" (bukan Pending/Rejected)

📄 Upload Error:
   └── Check: File < 5MB, format JPG/PNG/PDF

💰 Komisi Tidak Muncul:
   └── Booking harus status "Paid" dulu

📱 Landing Page Tidak Update:
   └── Clear cache browser atau tunggu 5 menit
```

### ❗ MASALAH UMUM ADMIN
```
👥 Affiliate Tidak Bisa Login:
   └── Check status user = "Active"

📋 Booking Tidak Muncul:
   └── Pastikan affiliate submit (bukan save draft)

💸 Error Payout:
   └── Verify data bank affiliate benar

📊 Dashboard Lambat:
   └── Clear application cache: php artisan cache:clear
```

---

## 🔧 QUICK COMMANDS DEVELOPER

### 🚀 SETUP AWAL
```bash
# Install dependencies
composer install
npm install && npm run build

# Database setup  
php artisan migrate:fresh --seed
php artisan storage:link

# Start server
php artisan serve
```

### 🗃️ DATABASE OPERATIONS
```bash
# Fresh migration
php artisan migrate:fresh --seed

# Create new user
php artisan make:user

# Backup database
php artisan backup:run

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### 📊 MONITORING & LOGS
```bash
# View logs
tail -f storage/logs/laravel.log

# Queue monitoring
php artisan queue:work

# Performance check
php artisan route:cache
php artisan config:cache
```

---

## 🎯 WORKFLOW BISNIS

### 🔄 ALUR AFFILIATE ONBOARDING
```
1. 📝 Affiliate daftar via form
2. 📧 Admin dapat notifikasi 
3. 🔍 Admin review & verify documents
4. ✅ Admin approve/reject
5. 📧 Email kredensial ke affiliate
6. 🚀 Affiliate mulai bisa booking
```

### 🔄 ALUR BOOKING PROCESS  
```
1. 🎯 Affiliate buat booking manual
2. 📋 Submit ke admin untuk review
3. ✅ Admin approve booking
4. 📧 Konfirmasi ke customer
5. 💰 Customer bayar
6. ✅ Admin verify payment
7. 🎉 Trip confirmed
8. 💸 Commission released
```

### 🔄 ALUR COMMISSION PAYOUT
```
1. 💰 Affiliate request payout (min 500K)
2. 🔍 Admin verify eligibility  
3. 🏦 Admin transfer ke bank affiliate
4. ✅ Update status "Paid"
5. 📧 Notification ke affiliate
```

---

## 📱 KONTAK & SUPPORT

### 🆘 BANTUAN TEKNIS
```
📧 Email: admin@jjbtravelbali.com
📱 WhatsApp: +62 812-3456-7890  
🕒 Jam Kerja: 09:00-17:00 WIB (Senin-Jumat)
```

### 🔗 QUICK LINKS
```
🌐 Website: localhost:8000
👤 Login Admin: localhost:8000/login
📝 Daftar Affiliate: localhost:8000/register/affiliate
📊 Admin Dashboard: localhost:8000/admin/dashboard
💼 Affiliate Dashboard: localhost:8000/affiliate/dashboard
```

---

**⚡ Quick Tip**: Bookmark halaman ini untuk referensi cepat!

**📅 Updated**: November 9, 2025
