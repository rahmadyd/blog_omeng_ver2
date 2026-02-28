# Upload Checklist ke Server

Gunakan file ini sebagai panduan saat upload ke server. Pastikan semua file di-upload dengan benar.

---

## ✅ FILE YANG HARUS DI-UPLOAD (BARU)

### Folder: `htdocs/backend/middleware/`
- [ ] `auth.php` - Middleware authentication

### Folder: `htdocs/admin_panel_omeng_secret/`
- [ ] `index.php` - Dashboard admin (HIDDEN)
- [ ] `admin_edit.php` - Edit item (HIDDEN)
- [ ] `.htaccess` - Proteksi folder

### Folder: `htdocs/`
- [ ] `SECURITY.md` - Dokumentasi security
- [ ] `CHANGELOG.md` - Changelog perubahan
- [ ] `UPLOAD_CHECKLIST.md` - File ini

---

## ✅ FILE YANG HARUS DI-UPLOAD (DIUBAH)

### Folder: `htdocs/backend/admin/`
- [ ] `login_handler.php` - Update redirect + session regeneration
- [ ] `logout.php` - Update redirect
- [ ] `proses_tambah.php` - Tambah middleware + update redirect
- [ ] `proses_tambah_shop.php` - Tambah middleware + update redirect
- [ ] `delete_item.php` - Tambah middleware + update redirect
- [ ] `update_item.php` - Tambah middleware + update redirect
- [ ] `update_settings.php` - Tambah middleware + update redirect (6 tempat)

### Folder: `htdocs/backend/`
- [ ] `.htaccess` - Tambah proteksi file config

### Folder: `htdocs/private_admin_creations/`
- [ ] `index.php` - Tambah middleware + logout button
- [ ] `admin_edit.php` - Tambah middleware
- [ ] `login.php` - Tambah logout message

### Folder: `htdocs/frontend/includes/`
- [ ] `navbar.php` - Hide admin panel link + update variable

---

## ❌ FILE YANG HARUS DI-HAPUS

### Folder: `htdocs/`
- [ ] `admin_edit.php` - HAPUS file ini (unsecured)

---

## 📋 LANGKAH-LANGKAH UPLOAD

### 1. Upload File Baru
```
Upload ke server:
- htdocs/backend/middleware/auth.php
- htdocs/admin_panel_omeng_secret/index.php
- htdocs/admin_panel_omeng_secret/admin_edit.php
- htdocs/admin_panel_omeng_secret/.htaccess
- htdocs/SECURITY.md
- htdocs/CHANGELOG.md
- htdocs/UPLOAD_CHECKLIST.md
```

### 2. Upload File yang Diubah
```
Upload ke server (replace file lama):
- htdocs/backend/admin/login_handler.php
- htdocs/backend/admin/logout.php
- htdocs/backend/admin/proses_tambah.php
- htdocs/backend/admin/proses_tambah_shop.php
- htdocs/backend/admin/delete_item.php
- htdocs/backend/admin/update_item.php
- htdocs/backend/admin/update_settings.php
- htdocs/backend/.htaccess
- htdocs/private_admin_creations/index.php
- htdocs/private_admin_creations/admin_edit.php
- htdocs/private_admin_creations/login.php
- htdocs/frontend/includes/navbar.php
```

### 3. Hapus File Lama
```
Hapus dari server:
- htdocs/admin_edit.php
```

---

## 🔐 TESTING SETELAH UPLOAD

### Test 1: Login Admin
- [ ] Buka `/private_admin_creations/login.php`
- [ ] Login dengan username dan password admin
- [ ] Pastikan redirect ke `/admin_panel_omeng_secret/`

### Test 2: Admin Panel Access
- [ ] Buka `/admin_panel_omeng_secret/`
- [ ] Pastikan dashboard admin muncul
- [ ] Coba buka tab Projects, Shop, Feedback, Settings, Logs

### Test 3: Edit Item
- [ ] Klik Edit pada salah satu project/shop
- [ ] Pastikan halaman edit muncul
- [ ] Coba update item

### Test 4: Logout
- [ ] Klik Logout di admin panel
- [ ] Pastikan redirect ke login page dengan pesan "Logout berhasil"

### Test 5: User Access
- [ ] Logout dari admin
- [ ] Buka homepage `/index.php`
- [ ] Pastikan navbar TIDAK menampilkan admin panel link
- [ ] Coba akses `/admin_panel_omeng_secret/` tanpa login
- [ ] Pastikan redirect ke login page

### Test 6: Direct URL Access
- [ ] Coba akses `/admin_panel_omeng_secret/` tanpa login
- [ ] Pastikan tidak bisa akses (redirect ke login)
- [ ] Coba akses `/admin_edit.php` (file lama)
- [ ] Pastikan file tidak ada (404 error)

---

## 📝 CATATAN PENTING

1. **Folder Permissions**: Pastikan folder `admin_panel_omeng_secret` punya permission 755
2. **File Permissions**: Pastikan file PHP punya permission 644
3. **Database**: Pastikan database sudah ada tabel `admins` dengan password yang di-hash
4. **Session**: Pastikan PHP session sudah enabled di server
5. **HTTPS**: Gunakan HTTPS untuk keamanan maksimal

---

## 🆘 TROUBLESHOOTING

### Jika login tidak bisa redirect ke admin panel
- Cek file `login_handler.php` sudah di-upload dengan benar
- Cek path redirect: `../../admin_panel_omeng_secret/`
- Clear browser cache

### Jika admin panel tidak bisa diakses
- Cek file `auth.php` sudah di-upload di `backend/middleware/`
- Cek file `index.php` di `admin_panel_omeng_secret/` sudah di-upload
- Cek session sudah aktif

### Jika navbar masih menampilkan admin panel link
- Cek file `navbar.php` sudah di-upload dengan benar
- Clear browser cache
- Cek variable `$is_admin_panel` sudah di-update

### Jika file lama `admin_edit.php` masih bisa diakses
- Pastikan file sudah di-hapus dari server
- Clear browser cache

---

## ✨ SELESAI!

Setelah semua langkah di atas selesai, admin panel sudah aman dan hidden. User biasa tidak akan pernah tahu admin panel ada!

**Admin Panel URL**: `/admin_panel_omeng_secret/` (JANGAN SHARE!)
**Login URL**: `/private_admin_creations/login.php`
