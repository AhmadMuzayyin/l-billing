# Recreate PHPNuxBill 1:1 ke Laravel 13 + Inertia Svelte

## 1. Tujuan
Membangun ulang PHPNuxBill ke Laravel 13 + Inertia Svelte dengan tingkat presisi fitur 1:1 terhadap aplikasi asli, sambil menjaga best practice Laravel untuk struktur kode, migration, otorisasi, dan maintainability.

## 2. Ruang Lingkup Pekerjaan
- Fokus utama: parity 1:1 fungsional terhadap PHPNuxBill saat ini.
- Fondasi wajib: database design 1:1 terlebih dahulu, lalu menu dan modul 1:1.
- Seeder minimal: hanya akun admin.
  - email: admin@admin.com
  - password: password
- Pengujian: tidak membuat unit test pada fase ini, cukup memastikan formatting dengan Laravel Pint.

## 3. Hasil Studi Mendalam PHPNuxBill (Baseline)

### 3.1 Arsitektur dan Alur Request
- Entry point utama: index.php -> system/boot.php -> dynamic route via parameter _route.
- Router bersifat file-based ke system/controllers/{handler}.php.
- Rendering UI memakai Smarty template.
- API mode memakai system/api.php dengan token session-style.
- Auth terpisah:
  - Admin: tabel tbl_users (session aid)
  - Customer: tabel tbl_customers (session uid)
- Pola extensibility:
  - Hook runtime via Hookers.php dan run_hook(...)
  - Plugin menu injection ke placeholder _MENU_* di sidebar.

### 3.2 Menu Admin (Aktual)
| Grup Menu | Item Menu | Route Legacy |
|---|---|---|
| Dashboard | Dashboard | dashboard |
| Customer | Customer | customers |
| Services | Active Customers, Refill Customer, Vouchers, Coupons, Recharge Customer, Refill Balance | plan/list, plan/refill, plan/voucher, coupons, plan/recharge, plan/deposit |
| Internet Plan | Hotspot, PPPOE, VPN, Bandwidth, Customer Balance | services/hotspot, services/pppoe, services/vpn, bandwidth/list, services/balance |
| Maps | Customer, Routers, ODPs | maps/customer, maps/routers, maps/odp |
| Reports | Daily Reports, Activation History | reports, reports/activation |
| Send Message | Single Customer, Bulk Customers | message/send, message/send_bulk |
| Network | Routers, IP Pool, Port Pool, ODP List | routers, pool/list, pool/port, odp |
| Radius (opsional) | Radius NAS | radius/nas-list |
| Static Pages | Order Voucher, Theme Voucher, Announcement, Customer Announcement, Registration Info, Payment Info, Privacy Policy, Terms and Conditions | pages/* |
| Settings | General Settings, Localisation, Custom Fields, Miscellaneous, Maintenance Mode, Widgets, User Notification, Devices, Administrator Users, Backup/Restore, Payment Gateway, Plugin Manager | settings/*, paymentgateway, pluginmanager |
| Logs | PhpNuxBill, Radius, Message | logs/phpnuxbill, logs/radius, logs/message |
| Lainnya | Documentation, Community | settings/docs, community |

Role gating penting:
- SuperAdmin/Admin: akses hampir semua menu.
- Report: fokus report.
- Agent/Sales: subset operasi recharge/customer.

### 3.3 Menu Customer (Aktual)
| Grup Menu | Item Menu | Route Legacy |
|---|---|---|
| Dashboard | Dashboard | home |
| Inbox | Inbox | mail |
| Voucher | Voucher Activation | voucher/activation |
| Order | Buy Balance, Buy Package, Payment History | order/balance, order/package, order/history |
| History | Activation History | voucher/list-activated |

### 3.4 Domain Fitur Inti
- Auth customer, auth admin, login page custom, maintenance mode gating.
- Registrasi customer + OTP SMS/WA + custom field dinamis.
- Customer profile, ganti password, update email/phone OTP.
- Manajemen customer (CRUD, import CSV, sync, deactivate, login-as, view order/activation).
- Plan management: Hotspot, PPPOE, VPN, Balance.
- Recharge engine + extend expiry + prorata period + bill tambahan (tbl_customers_fields).
- Voucher lifecycle: generate, activate, invoice, print, bulk delete.
- Order & payment gateway:
  - transaksi unpaid/paid/cancel
  - coupon fixed/percent + rate limit attempt
  - topup balance custom amount
  - send plan ke teman, transfer balance
- Router/network: routers, IP pool, port pool, ODP, map display.
- Radius support (DB radius terpisah, NAS management, radius accounting table).
- Messaging: single/bulk, segmentasi status pelanggan, log message.
- Reporting: daily/by date/by period, activation history, export/print/pdf.
- Widgets dashboard dinamis per role (admin/agent/sales/customer).
- Plugin manager, payment gateway manager, devices manager.
- Cron:
  - expire plan + auto renewal by balance
  - router health monitor + offline alert
  - reminder H-7/H-3/H-1.

### 3.5 Library dan Teknologi yang Dipakai
- Backend core legacy:
  - Idiorm (ORM custom)
  - Smarty
  - PHPMailer
  - PEAR2 (Mikrotik)
- Composer dependency legacy:
  - mpdf/mpdf
  - smarty/smarty
  - yosiazwan/php-facedetection
- Frontend assets legacy:
  - Bootstrap
  - AdminLTE
  - Select2
  - SweetAlert2
  - Chart.js
  - Summernote
- Adapter device:
  - MikrotikHotspot
  - MikrotikPppoe
  - MikrotikVpn
  - Radius
  - RadiusRest

### 3.6 Database Legacy yang Harus Dipertahankan 1:1
| Tabel | Fungsi |
|---|---|
| tbl_appconfig | key-value seluruh konfigurasi runtime |
| tbl_users | akun admin/operator |
| tbl_customers | akun pelanggan |
| tbl_customers_fields | atribut dinamis (Bill, Invoice, custom field) |
| tbl_plans | master paket (Hotspot/PPPOE/Balance/VPN logic) |
| tbl_bandwidth | profil bandwidth |
| tbl_user_recharges | paket aktif pelanggan |
| tbl_transactions | invoice dan histori recharge |
| tbl_payment_gateway | transaksi order gateway |
| tbl_voucher | master voucher |
| tbl_pool | IP pool |
| tbl_port_pool | port pool |
| tbl_routers | master router |
| tbl_odps | data ODP |
| tbl_coupons | kupon diskon |
| tbl_widgets | konfigurasi widget per role |
| tbl_logs | log aplikasi |
| tbl_message_logs | log pengiriman pesan |
| tbl_customers_inbox | inbox customer |
| tbl_meta | metadata generik |
| rad_acct | radius rest accounting internal |

Skema radius terpisah (opsional, koneksi radius): nas, radacct, radcheck, radgroupcheck, radgroupreply, radpostauth, radreply, radusergroup, nasreload.

### 3.7 Catatan Parity Kritis
- Banyak behavior ditentukan appconfig (bukan hardcode), wajib dipertahankan.
- Plan Period memiliki aturan tanggal jatuh tempo bulanan + prorata invoice awal.
- Satu customer bisa punya kombinasi aktif berdasar type/router; behavior extend/change plan harus identik.
- Auto-renew balance dari cron wajib identik dengan validasi status + saldo.
- Dynamic menu injection plugin harus disiapkan sejak awal arsitektur Laravel.
- Widget per role harus configurable dan urutan render dipertahankan.

## 4. Rencana Implementasi Terstruktur

## Status Eksekusi
- Phase 1A (selesai): migration tabel legacy 1:1 + seeder admin + validasi pint/migrate pretend.
- Phase 1B (selesai): model Eloquent inti untuk tabel legacy utama dan radius.
- Phase 2A (selesai): fondasi menu admin/customer 1:1 (registry menu, route placeholder, prop Inertia, sidebar binding).
- Phase 2B (selesai): implementasi dashboard admin & customer + icons menu + stub pages untuk semua customer menu items.
- Phase 3 (progres): modul inti berjalan untuk Admin Customers (list/create/update/delete), Admin Plans (list/create/update/delete), Customer Voucher Activation, serta dashboard stats berbasis data legacy.

## Tahap A - Desain Database 1:1 (Prioritas Utama)

### A1. Prinsip desain
- Nama tabel tetap sama dengan legacy untuk mempermudah parity dan migrasi data.
- Gunakan migration Laravel terpisah per domain, tetapi urutan create table mengikuti dependensi.
- Gunakan type yang aman untuk data finansial: decimal untuk nominal.
- Tambahkan foreign key secara selektif agar tidak merusak behavior legacy yang longgar.
- Simpan enum sebagai string/enum sesuai kebutuhan parity.
- Tetap sediakan kolom kompatibilitas legacy meski nanti ada layer service modern.

### A2. Urutan migration yang harus dikerjakan
1. tbl_appconfig
2. tbl_users
3. tbl_customers
4. tbl_customers_fields
5. tbl_bandwidth
6. tbl_routers
7. tbl_plans
8. tbl_pool
9. tbl_port_pool
10. tbl_odps
11. tbl_voucher
12. tbl_user_recharges
13. tbl_transactions
14. tbl_payment_gateway
15. tbl_coupons
16. tbl_customers_inbox
17. tbl_widgets
18. tbl_logs
19. tbl_message_logs
20. tbl_meta
21. rad_acct
22. radius schema tambahan (nas, radacct, radcheck, radgroupcheck, radgroupreply, radpostauth, radreply, radusergroup, nasreload) jika radius diaktifkan

### A3. Mapping model Eloquent awal
- AppConfig, AdminUser, Customer, CustomerField, Plan, Bandwidth, Router, UserRecharge, Transaction, PaymentGatewayTransaction, Voucher, Coupon, Pool, PortPool, Odp, Widget, CustomerInbox, AppLog, MessageLog, Meta.

### A4. Constraint dan index minimal
- Unique:
  - tbl_customers.username
  - tbl_users.username
  - tbl_voucher.code
  - tbl_coupons.code
- Index penting:
  - tbl_user_recharges: customer_id, username, plan_id, status, expiration
  - tbl_transactions: username, invoice, recharged_on
  - tbl_payment_gateway: username, user_id, status, gateway_trx_id
  - tbl_plans: type, enabled, is_radius, routers, plan_type
  - tbl_routers: name, enabled
  - tbl_customers_inbox: customer_id, date_read

### A5. Seeder minimal (sesuai instruksi)
- Hanya 1 akun admin:
  - email: admin@admin.com
  - password: password
- Tidak membuat seed data lain pada fase ini.

### A6. Deliverable Tahap A
- Semua migration database parity 1:1 selesai.
- Semua model Eloquent inti selesai.
- Seeder admin selesai.
- Laravel Pint dijalankan.

## Tahap B - Pembuatan Menu 1:1 + Modul Inti (Prioritas Kedua)

### B1. Arsitektur menu Laravel + Svelte
- Gunakan Inertia layout terpisah:
  - AdminLayout
  - CustomerLayout
- Sidebar dibangun dari konfigurasi menu server-side agar role gating dan feature toggle identik.
- Mekanisme ekstensi disiapkan (menu registry) untuk menggantikan placeholder _MENU_* legacy.

### B2. Urutan implementasi menu admin
1. Dashboard
2. Customer
3. Services (Active, Refill, Voucher, Recharge, Deposit, Coupons)
4. Internet Plan (Hotspot/PPPOE/VPN/Bandwidth/Balance)
5. Maps
6. Reports
7. Send Message
8. Network (Routers, IP Pool, Port Pool, ODP)
9. Radius
10. Static Pages
11. Settings
12. Logs
13. Documentation dan Community

### B3. Urutan implementasi menu customer
1. Dashboard
2. Inbox
3. Voucher Activation
4. Buy Balance
5. Buy Package
6. Payment History
7. Activation History

### B4. Pola backend Laravel yang harus dipakai
- Route group per domain + middleware role.
- Form Request untuk validasi create/update.
- Service layer untuk business logic kritis:
  - RechargeService
  - VoucherService
  - PaymentService
  - NotificationService
  - RouterProvisioningService
- Policy/Gate untuk role SuperAdmin/Admin/Report/Agent/Sales.
- Scheduler Laravel untuk pengganti cron.php dan cron_reminder.php.

### B5. Parity behavior wajib saat implementasi menu
- Role-gated menu sama seperti legacy.
- Toggle menu berbasis konfigurasi (disable_voucher, enable_balance, radius_enable, enable_coupons, dll) harus identik.
- Flow invoice, payment status, unpaid transaction, cancel payment harus identik.
- Widget dashboard per role + urutan harus identik.

### B6. Deliverable Tahap B
- Semua menu tampil 1:1.
- Semua endpoint menu tersambung ke controller/service Laravel sesuai best practice.
- Semua page Svelte tersedia untuk setiap menu.
- Laravel Pint dijalankan.

## 5. Backlog Eksekusi Per Domain (Setelah Tahap A dan B)
1. Authentication parity (admin/customer split, remember token behavior).
2. Customer management parity.
3. Plan and recharge engine parity.
4. Voucher parity.
5. Payment gateway and coupon parity.
6. Messaging and notification parity.
7. Report/export/print parity.
8. Router and radius parity.
9. Widget and plugin extensibility parity.

## 6. Definisi Selesai (Definition of Done)
- Database Laravel telah merepresentasikan seluruh struktur PHPNuxBill yang aktif dipakai fitur.
- Menu admin dan customer tampil dengan urutan, visibilitas role, dan toggle fitur yang setara legacy.
- Alur bisnis utama (recharge, voucher, order, payment, expiration, auto-renewal) berjalan dengan output yang setara.
- Hanya ada seeder admin sesuai ketentuan.
- Tidak menambah unit test pada fase ini.
- Kode lolos Laravel Pint.

## 7. Catatan Implementasi Disiplin Migrasi
- Semua keputusan implementasi harus mengutamakan parity 1:1 dulu, baru optimasi setelah parity stabil.
- Tidak menambah fitur baru di fase recreate inti.
- Jika ada gap perilaku antara legacy dan Laravel, perilaku legacy menjadi acuan utama selama fase parity.