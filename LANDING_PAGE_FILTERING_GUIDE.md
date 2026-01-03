# Landing Page Experience Filtering Guide

## Overview
Landing page memiliki fitur **Interactive Experience Filtering** yang memungkinkan pengunjung memfilter packages berdasarkan destinasi yang dipilih.

## How It Works

### 1. Experience Cards
Terdapat 6 experience cards:
- **JAVA** - Cultural Heritage & Ancient Temples
- **BALI** - Island Paradise & Spiritual Retreats  
- **LOMBOK** - Pristine Beaches & Adventures
- **LABUAN BAJO** - Komodo Dragons & Marine Life
- **LONG TRIP** - Multi-Destination Adventures
- **CUSTOM** - Tailored Experiences (redirect ke Contact Us)

### 2. Filtering Logic
Ketika user klik salah satu experience card (kecuali CUSTOM), sistem akan:
1. Menampilkan visual indicator (checkmark) pada card yang dipilih
2. Memfilter packages secara real-time
3. Smooth scroll ke section "Our Packages"
4. Menampilkan badge "Showing: [Destination]" dengan tombol "Show All"

### 3. Filter Matching
Packages akan ditampilkan jika memenuhi salah satu kriteria:

| Experience Card | Matching Criteria |
|----------------|-------------------|
| **JAVA** | Package name, category, atau departure_city mengandung "java" |
| **BALI** | Package name, category, atau departure_city mengandung "bali" |
| **LOMBOK** | Package name, category, atau departure_city mengandung "lombok" |
| **LABUAN BAJO** | Package name, category, atau departure_city mengandung "labuan bajo" |
| **LONG TRIP** | Package name mengandung "long", "trip", "java - bali", atau "multi" |

## Package Configuration Tips

### Untuk Admin: Cara Membuat Packages yang Terfilter dengan Benar

#### 1. **Java Packages**
```
Name: "Yogyakarta Heritage Tour" atau "Java Temple Discovery"
Category: Java / Cultural
Departure City: Yogyakarta / Jakarta / Java
```

#### 2. **Bali Packages**
```
Name: "Bali Exotic Paradise" atau "Ubud & Beach Experience"
Category: Bali / Beach
Departure City: Denpasar / Bali
```

#### 3. **Lombok Packages**
```
Name: "Lombok Beach Paradise" atau "Mount Rinjani Trek"
Category: Lombok / Adventure
Departure City: Lombok / Mataram
```

#### 4. **Labuan Bajo Packages**
```
Name: "Komodo Adventure" atau "Labuan Bajo Explorer"
Category: Labuan Bajo / Adventure
Departure City: Labuan Bajo / Flores
```

#### 5. **Long Trip Packages**
```
Name: "Java - Bali Long Trip" atau "Multi-Destination Indonesia"
Category: Long Trip / Multi-Destination
Departure City: Jakarta / Multiple Cities
```

## Important Database Fields

Pastikan field-field ini diisi dengan benar saat membuat package:

1. **name** - Nama package (akan dicek untuk filtering)
2. **category** - Kategori package dari dropdown
3. **departure_city** - Kota keberangkatan (sangat penting untuk filtering)
4. **status** - Harus "active" agar muncul di landing page

## Features

### ✅ Interactive Filtering
- Click pada experience card langsung memfilter packages
- Visual feedback dengan checkmark dan scale effect
- Smooth animations

### ✅ Clear Filter
- Tombol "Show All" untuk reset filter
- Klik "Browse Packages" di hero juga reset filter

### ✅ No Results Handling
- Jika tidak ada package yang match, tampil pesan "No packages found"
- User bisa klik link untuk "view all packages"

### ✅ Responsive Design
- Works on desktop, tablet, dan mobile
- Touch-friendly untuk mobile users

## Testing Checklist

Untuk memastikan filtering bekerja dengan baik:

1. ✓ Create packages dengan nama yang jelas mencakup destinasi
2. ✓ Set category yang sesuai
3. ✓ Isi departure_city dengan benar
4. ✓ Set status = "active"
5. ✓ Test klik setiap experience card
6. ✓ Verify packages ter-filter dengan benar
7. ✓ Test "Show All" button
8. ✓ Test pada mobile devices

## Examples

### ✅ Good Package Setup
```
Name: "3 Days Bali Exotic Paradise"
Category: Bali
Departure City: Denpasar
Status: active
→ Will appear when "BALI" experience is clicked
```

### ✅ Multi-Match Package
```
Name: "Java - Bali Long Trip Adventure"
Category: Long Trip  
Departure City: Jakarta
Status: active
→ Will appear when "JAVA", "BALI", or "LONG TRIP" is clicked
```

### ❌ Package Won't Show
```
Name: "Temple Tour"
Category: Cultural
Departure City: ""
Status: active
→ Won't match any specific experience (too generic)
```

## Technical Implementation

### JavaScript Functions
- `filterPackages(destination)` - Main filtering function
- `clearFilter()` - Reset filter and show all packages
- Active state management on experience cards
- Smooth scroll to packages section

### CSS Classes
- `.experience-card.active` - Selected experience with checkmark
- `.package-item.hidden` - Hidden filtered packages
- `.no-results.show` - No results message display

## Future Enhancements

Possible improvements:
1. Add multi-select filtering (select multiple experiences)
2. Add price range filter
3. Add duration filter (1 day, 3 days, etc)
4. Add sorting options (price, popularity, duration)
5. Save filter state in URL for sharing

---

**Last Updated**: January 2026
**Version**: 1.0
