# 🔄 JJB Travel Bali - Workflow Diagrams

## 🎯 AFFILIATE REGISTRATION WORKFLOW

```mermaid
graph TD
    A[🌐 Visitor mengakses /register/affiliate] --> B[📋 Form Step 1: Personal Info]
    B --> C[📄 Form Step 2: Upload Documents]
    C --> D[🏦 Form Step 3: Banking Details]
    D --> E[✅ Form Step 4: Terms & Submit]
    E --> F[💾 Data tersimpan di database]
    F --> G[📧 Email notifikasi ke Admin]
    G --> H{🔍 Admin Review}
    H -->|Approve| I[✅ Status = Active]
    H -->|Reject| J[❌ Status = Rejected]
    I --> K[📧 Email kredensial ke Affiliate]
    J --> L[📧 Email penolakan + alasan]
    K --> M[🚀 Affiliate bisa login & booking]
    L --> N[🔄 Affiliate bisa daftar ulang]
```

## 📋 BOOKING CREATION WORKFLOW

```mermaid
graph TD
    A[👤 Affiliate Login] --> B[📊 Dashboard]
    B --> C[➕ Klik 'Tambah Booking']
    C --> D[📦 Pilih Package]
    D --> E[👤 Input Data Customer]
    E --> F[📅 Set Travel Date & Peserta]
    F --> G[👥 Input Detail Peserta]
    G --> H[💰 Input Payment Info]
    H --> I{💾 Save Option}
    I -->|Draft| J[📝 Save as Draft]
    I -->|Submit| K[📤 Submit for Approval]
    J --> L[✏️ Bisa edit lagi nanti]
    K --> M[📧 Notifikasi ke Admin]
    M --> N{🔍 Admin Review}
    N -->|Approve| O[✅ Booking Confirmed]
    N -->|Reject| P[❌ Booking Rejected]
    O --> Q[📧 Email konfirmasi ke Customer]
    P --> R[📧 Email penolakan ke Affiliate]
```

## 💰 COMMISSION & PAYOUT WORKFLOW

```mermaid
graph TD
    A[✅ Booking Approved] --> B[💰 Customer Bayar]
    B --> C[📸 Upload Bukti Payment]
    C --> D{🔍 Admin Verify Payment}
    D -->|Valid| E[✅ Payment Confirmed]
    D -->|Invalid| F[❌ Payment Rejected]
    E --> G[💸 Commission Generated]
    F --> H[🔄 Request Payment Ulang]
    G --> I[📊 Commission Added to Affiliate]
    I --> J{💰 Payout Request?}
    J -->|Yes| K[📤 Affiliate Request Payout]
    J -->|No| L[💾 Commission Accumulated]
    K --> M{✅ Min 500K Met?}
    M -->|Yes| N[🏦 Admin Process Transfer]
    M -->|No| O[⏳ Wait for Minimum]
    N --> P[💸 Transfer ke Rekening]
    P --> Q[✅ Mark as Paid]
    Q --> R[📧 Notification ke Affiliate]
```

## 🛡️ ADMIN APPROVAL WORKFLOW

```mermaid
graph TD
    A[📧 Admin Dapat Notifikasi] --> B[🔍 Open Admin Panel]
    B --> C{📋 Type of Request}
    C -->|Affiliate Registration| D[👤 Review Documents]
    C -->|Booking Approval| E[📦 Review Booking Details]
    C -->|Payment Verification| F[💰 Review Payment Proof]
    C -->|Payout Request| G[💸 Review Payout Eligibility]
    
    D --> H{✅ Documents Valid?}
    H -->|Yes| I[✅ Approve Affiliate]
    H -->|No| J[❌ Reject dengan Alasan]
    
    E --> K{📋 Booking Valid?}
    K -->|Yes| L[✅ Approve Booking]
    K -->|No| M[❌ Reject Booking]
    
    F --> N{💰 Payment Valid?}
    N -->|Yes| O[✅ Verify Payment]
    N -->|No| P[❌ Reject Payment]
    
    G --> Q{💸 Eligible for Payout?}
    Q -->|Yes| R[✅ Process Payout]
    Q -->|No| S[❌ Reject Payout]
```

---

## 🎯 USER ROLE PERMISSIONS

### 👤 AFFILIATE PERMISSIONS

```mermaid
graph LR
    A[👤 AFFILIATE] --> B[📊 View Own Dashboard]
    A --> C[➕ Create Manual Booking]
    A --> D[👁️ View Own Bookings]
    A --> E[✏️ Edit Draft Bookings]
    A --> F[💰 View Commission]
    A --> G[📤 Request Payout]
    A --> H[🔧 Edit Profile]
    A --> I[🌐 Manage Landing Page]
    A --> J[📊 View Own Reports]
```

### 🔧 ADMIN PERMISSIONS

```mermaid
graph LR
    A[🔧 ADMIN] --> B[📊 View All Dashboards]
    A --> C[👥 Manage Affiliates]
    A --> D[✅ Approve/Reject Registrations]
    A --> E[📋 Approve/Reject Bookings]
    A --> F[💰 Verify Payments]
    A --> G[💸 Process Payouts]
    A --> H[🎯 Manage Packages]
    A --> I[📊 View All Reports]
    A --> J[⚙️ System Settings]
```

### 👑 SUPER ADMIN PERMISSIONS

```mermaid
graph LR
    A[👑 SUPER ADMIN] --> B[🔧 All Admin Permissions]
    A --> C[👥 Manage Admin Users]
    A --> D[⚙️ System Configuration]
    A --> E[🗃️ Database Management]
    A --> F[🔒 Security Settings]
    A --> G[📊 Advanced Analytics]
    A --> H[🛠️ Developer Tools]
```

---

## 📊 DATA FLOW ARCHITECTURE

```mermaid
graph TB
    subgraph "Frontend Layer"
        A[🌐 Web Interface]
        B[📱 Mobile View]
    end
    
    subgraph "Controller Layer"
        C[👤 AuthController]
        D[🔧 AdminController]
        E[👥 AffiliateController]
        F[📋 BookingController]
    end
    
    subgraph "Model Layer"
        G[👤 User Model]
        H[👥 AffiliateProfile]
        I[🎯 TravelPackage]
        J[📋 Booking Model]
        K[💰 Payment Model]
    end
    
    subgraph "Database Layer"
        L[(🗃️ MySQL Database)]
    end
    
    A --> C
    A --> D
    A --> E
    A --> F
    B --> C
    B --> E
    
    C --> G
    D --> G
    D --> H
    D --> I
    E --> G
    E --> H
    E --> J
    F --> J
    F --> K
    
    G --> L
    H --> L
    I --> L
    J --> L
    K --> L
```

---

## 🔄 SYSTEM INTEGRATION FLOW

```mermaid
graph TD
    subgraph "Core System"
        A[🌐 Laravel Application]
        B[🗃️ MySQL Database]
        C[📁 File Storage]
    end
    
    subgraph "External Services"
        D[📧 Email Service]
        E[📱 WhatsApp API]
        F[💳 Payment Gateway]
        G[☁️ Cloud Storage]
    end
    
    subgraph "User Interfaces"
        H[💻 Admin Dashboard]
        I[👤 Affiliate Portal]
        J[🌐 Public Landing]
    end
    
    A <--> B
    A <--> C
    A --> D
    A --> E
    A --> F
    A --> G
    
    H --> A
    I --> A
    J --> A
    
    D -.-> K[📧 Email Notifications]
    E -.-> L[📱 WhatsApp Messages]
    F -.-> M[💰 Payment Processing]
    G -.-> N[☁️ File Backup]
```

---

## 📱 RESPONSIVE DESIGN WORKFLOW

```mermaid
graph LR
    A[👤 User Access] --> B{📱 Device Type?}
    B -->|Desktop| C[💻 Full Dashboard]
    B -->|Tablet| D[📟 Adapted Layout]
    B -->|Mobile| E[📱 Mobile Optimized]
    
    C --> F[🔧 Full Admin Features]
    D --> G[📊 Essential Features]
    E --> H[⚡ Quick Actions]
    
    F --> I[✅ All CRUD Operations]
    G --> J[📋 View & Basic Edit]
    H --> K[📞 Call-to-Action Focus]
```

---

## 🛡️ SECURITY WORKFLOW

```mermaid
graph TD
    A[🌐 User Request] --> B{🔐 Authenticated?}
    B -->|No| C[🚪 Redirect to Login]
    B -->|Yes| D{👤 Role Check}
    
    D -->|Admin| E[🔧 Admin Routes]
    D -->|Affiliate| F[👤 Affiliate Routes]
    D -->|Invalid| G[🚫 Access Denied]
    
    E --> H[✅ Allow Admin Actions]
    F --> I[✅ Allow Affiliate Actions]
    G --> J[❌ 403 Error Page]
    
    H --> K[📊 Log Admin Activity]
    I --> L[📊 Log Affiliate Activity]
    
    K --> M[✅ Response]
    L --> M
```

---

## 📈 PERFORMANCE MONITORING FLOW

```mermaid
graph TB
    A[📊 System Metrics] --> B{⚡ Performance Check}
    B -->|Good| C[✅ Normal Operation]
    B -->|Slow| D[⚠️ Warning Alert]
    B -->|Critical| E[🚨 Critical Alert]
    
    C --> F[📝 Log Performance]
    D --> G[🔧 Optimization Needed]
    E --> H[🚨 Immediate Action]
    
    G --> I[🗃️ Database Optimization]
    G --> J[☁️ Cache Improvement]
    G --> K[📁 File Optimization]
    
    H --> L[📞 Alert Developer]
    H --> M[🔄 System Recovery]
```

---

**📅 Last Updated**: November 9, 2025  
**🎯 Purpose**: Visual workflow documentation untuk development & user training
