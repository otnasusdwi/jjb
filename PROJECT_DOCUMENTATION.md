# JJB Travel Bali - Affiliate System Documentation

## 📋 Project Overview

**JJB Travel Bali Affiliate System** is a comprehensive travel agent platform built with Laravel 10+ and Bootstrap 5. The system enables travel affiliates to manage bookings, earn commissions, and provides a complete administrative interface for managing the business.

## 🏗️ Architecture & Tech Stack

### Backend
- **Framework**: Laravel 10+
- **Authentication**: Laravel Breeze
- **Database**: MySQL 8.0+
- **File Storage**: Laravel Storage (local/cloud)
- **PHP Version**: 8.1+

### Frontend
- **CSS Framework**: Bootstrap 5
- **JavaScript**: jQuery + Chart.js
- **Icons**: Bootstrap Icons + RemixIcon
- **Templates**: Blade Templates

### Features Overview
- ✅ Multi-role authentication (Super Admin, Admin, Affiliate)
- ✅ Affiliate registration and approval workflow
- ✅ Admin dashboard with statistics
- 🔄 Manual booking system (6-step process)
- 🔄 Commission tracking and management
- 🔄 Travel package management
- 🔄 Personalized landing pages
- 🔄 Reports and analytics

## 🗃️ Database Schema

### Core Tables

#### Users Table (Extended)
```sql
- id, name, email, password, email_verified_at
- role (enum: super_admin, admin, affiliate)
- status (enum: active, inactive, pending, rejected)
- affiliate_code (varchar 10, unique, nullable)
- created_at, updated_at
```

#### Affiliate Profiles
```sql
- id, user_id (FK)
- phone, whatsapp_number, address, birth_date
- ktp_number, ktp_file_path, npwp_number, npwp_file_path
- bank_name, account_number, account_holder_name, account_file_path
- commission_rate (decimal 5,2), referral_code
- approved_at, approved_by (FK), rejection_reason
- created_at, updated_at
```

#### Package Categories
```sql
- id, name, slug, description, image_path
- sort_order, status
- created_at, updated_at
```

#### Travel Packages
```sql
- id, category_id (FK), name, slug
- short_description, full_description
- highlights (json), includes (json), excludes (json)
- terms_conditions, duration_days, duration_nights
- price_adult, price_child, price_infant
- min_participants, max_participants, difficulty_level
- departure_city, meeting_point, transportation_details
- accommodation_details, main_image_path, gallery_images (json)
- video_url, virtual_tour_url, commission_rate
- is_featured, status, seo_title, seo_description, keywords
- created_by (FK), created_at, updated_at
```

#### Bookings
```sql
- id, booking_code (unique), package_id (FK), affiliate_id (FK)
- booking_source (enum: online, manual, phone, whatsapp)
- customer_name, customer_email, customer_phone, customer_address
- customer_ktp_number, participants_adult, participants_child, participants_infant
- travel_date, return_date, total_amount, commission_amount
- booking_status (enum: draft, pending, confirmed, paid, completed, cancelled)
- payment_status (enum: pending, down_payment, paid, refunded)
- payment_method, payment_proof_path, down_payment_amount
- down_payment_date, full_payment_date, special_requests
- affiliate_notes, admin_notes, cancellation_reason
- created_by (FK), approved_by (FK), approved_at
- created_at, updated_at
```

#### Supporting Tables
- **booking_participants**: Individual participant details
- **booking_payments**: Payment tracking
- **landing_page_settings**: Affiliate customization
- **system_settings**: Application configuration

## 👥 User Roles & Permissions

### Super Admin
- Full system access
- User management
- System settings
- Reports and analytics

### Admin  
- Affiliate management
- Package management
- Booking approval
- Payment verification
- Reports

### Affiliate
- Dashboard access
- Manual booking creation
- Commission tracking
- Profile management
- Landing page customization

## 🔐 Authentication System

### Login Credentials (Development)
```
Super Admin: superadmin@jjbtravelbali.com / password
Admin: admin@jjbtravelbali.com / password
Affiliate: affiliate@example.com / password
```

### Registration Flow
1. **Self Registration**: `/register/affiliate`
2. **Document Upload**: KTP, NPWP (optional), Bank Account
3. **Admin Approval**: Manual review and approval
4. **Account Activation**: Email credentials sent

## 🎯 Implemented Features

### ✅ 1. Project Foundation
- Laravel 10+ installation with Breeze
- MySQL database configuration
- Development environment setup
- Basic project structure

### ✅ 2. Database Architecture
- Complete migration files
- Eloquent models with relationships
- Database seeders for initial data
- Proper indexing for performance

### ✅ 3. Authentication & Authorization
- Extended Laravel Breeze for multi-role support
- Role-based middleware (`RoleMiddleware`)
- Automatic dashboard redirection based on role
- Session management and security

### ✅ 4. Admin Dashboard
- Statistics overview cards
- Recent bookings table
- Pending affiliates management
- Responsive Bootstrap 5 layout
- Navigation sidebar with role-based menus

### ✅ 5. Affiliate Registration System
- **Multi-step form** (4 steps):
  - Personal Information
  - Document Upload
  - Banking Details
  - Terms & Finalization
- **File upload handling** for documents
- **Validation** at each step
- **Success page** with next steps
- **Admin approval** workflow

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   └── DashboardController.php
│   │   ├── Affiliate/
│   │   │   └── DashboardController.php
│   │   └── AffiliateRegistrationController.php
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php (extended)
│   ├── AffiliateProfile.php
│   ├── PackageCategory.php
│   ├── TravelPackage.php
│   ├── Booking.php
│   ├── BookingParticipant.php
│   ├── BookingPayment.php
│   ├── LandingPageSetting.php
│   └── SystemSetting.php

database/
├── migrations/
│   ├── 2025_11_09_132311_modify_users_table_for_travel_system.php
│   ├── 2025_11_09_132317_create_affiliate_profiles_table.php
│   ├── 2025_11_09_132323_create_package_categories_table.php
│   ├── 2025_11_09_132327_create_travel_packages_table.php
│   ├── 2025_11_09_132331_create_bookings_table.php
│   ├── 2025_11_09_132342_create_booking_participants_table.php
│   ├── 2025_11_09_132349_create_booking_payments_table.php
│   ├── 2025_11_09_132356_create_landing_page_settings_table.php
│   └── 2025_11_09_132401_create_system_settings_table.php
└── seeders/
    ├── UserSeeder.php
    ├── PackageCategorySeeder.php
    └── SystemSettingSeeder.php

resources/views/
├── layouts/
│   └── admin.blade.php
├── admin/
│   └── dashboard.blade.php
└── auth/
    ├── affiliate-register.blade.php
    └── affiliate-register-success.blade.php
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL 8.0+

### Installation Steps
1. **Clone/Download** the project
2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   npm run build
   ```
3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Database Configuration** in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jjbtravelbali
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. **Run Migrations**:
   ```bash
   php artisan migrate:fresh --seed
   ```
6. **Start Server**:
   ```bash
   php artisan serve
   ```

### Storage Setup
```bash
php artisan storage:link
```

## 🔄 Next Development Phases

### Phase 1: Affiliate Dashboard (In Progress)
- [ ] Enhanced dashboard with Chart.js
- [ ] Commission tracking interface
- [ ] Profile management
- [ ] Landing page customization

### Phase 2: Manual Booking System
- [ ] 6-step booking form
- [ ] Package selection interface
- [ ] Customer information collection
- [ ] Participant details management
- [ ] Payment processing
- [ ] Booking confirmation

### Phase 3: Admin Management
- [ ] Complete affiliate management
- [ ] Travel package CRUD
- [ ] Booking approval system
- [ ] Payment verification
- [ ] Commission management

### Phase 4: Public Interface
- [ ] Main website landing page
- [ ] Personalized affiliate pages
- [ ] Package browsing
- [ ] SEO optimization

### Phase 5: Advanced Features
- [ ] Email notifications
- [ ] Reports & analytics
- [ ] Mobile responsiveness
- [ ] Performance optimization

## 🧪 Testing

### Manual Testing Routes
- **Home**: `http://localhost:8000`
- **Login**: `http://localhost:8000/login`
- **Admin Dashboard**: `http://localhost:8000/admin/dashboard`
- **Affiliate Registration**: `http://localhost:8000/register/affiliate`

### Test Data
- 12 package categories seeded
- 3 test users (super admin, admin, affiliate)
- System settings configured

## 🔧 Configuration

### Key Configuration Files
- **Environment**: `.env`
- **Database**: `config/database.php`
- **Authentication**: `config/auth.php`
- **File Storage**: `config/filesystems.php`

### Important Settings
- **Commission Rate**: Default 10% (configurable)
- **File Upload**: Max 5MB per file
- **Allowed Types**: JPG, PNG, PDF
- **Auto Approval**: Disabled (manual approval required)

## 📊 Current Status

### Completed (50% of total system)
- ✅ Core infrastructure
- ✅ Database architecture
- ✅ Authentication system
- ✅ Admin foundation
- ✅ Affiliate registration

### In Progress
- 🔄 Affiliate dashboard enhancement
- 🔄 Manual booking system

### Pending
- ⏳ Package management
- ⏳ Payment system
- ⏳ Public landing pages
- ⏳ Reports & analytics

## 🐛 Known Issues & TODO

### Current Issues
- [ ] File upload validation needs enhancement
- [ ] Error handling in registration form
- [ ] Email notification system not implemented
- [ ] Commission calculation logic needs refinement

### Improvements Needed
- [ ] Add proper logging
- [ ] Implement caching for better performance
- [ ] Add API endpoints for mobile app
- [ ] Enhance security measures

## 📝 Development Notes

### Code Standards
- PSR-4 autoloading
- Laravel naming conventions
- Proper MVC separation
- Database relationships properly defined

### Security Measures
- CSRF protection enabled
- File upload validation
- Role-based access control
- Input sanitization

### Performance Considerations
- Database indexing implemented
- Lazy loading for relationships
- Efficient query structure
- File storage optimization

---

**Last Updated**: November 9, 2025  
**Status**: Foundation Complete - Active Development  
**Next Milestone**: Affiliate Dashboard Enhancement
