# Blood Link — Smart Blood Bank Management System

A complete Laravel 12 implementation of the Blood Link spec: Admin, Donor,
and Patient roles; donor search with privacy-protected contact sharing;
one-active-session-per-donor donation workflow with a 30-minute timer;
private chat with read-only admin monitoring; automatic cooldown handling;
a real-time leaderboard with badges; dynamic Blood Group management; full
user moderation (activate/deactivate/suspend/ban with audit logging); and
PDF/Excel report exports.

## Requirements

- PHP 8.2+, Laravel 12, MySQL 8+
- Composer packages not in a stock Laravel install — add these:

```bash
composer require barryvdh/laravel-dompdf maatwebsite/excel laravel/reverb
```

## What's included

**Migrations** (`database/migrations/`) — run in order:
1. `create_blood_groups_table`
2. `add_profile_fields_to_users_table` — adds role/status/ban/suspend fields + soft deletes to your existing `users` table
3. `create_donors_table`
4. `create_patients_table`
5. `create_blood_stocks_table`
6. `create_blood_requests_table`
7. `create_donation_sessions_table`
8. `create_chat_messages_table`
9. `create_app_notifications_table` — named `app_notifications` to avoid colliding with Laravel's built-in notifications table
10. `create_user_moderation_logs_table`

Every `blood_group` reference is a real FK (`blood_group_id`) to `blood_groups`
— on donors, patients (optional), blood requests, and blood stock — so the
"must reference blood_groups table" rules are enforced at the schema level.

**Models** (`app/Models/`)
`User`, `Donor`, `Patient`, `BloodGroup`, `BloodStock`, `BloodRequest`,
`DonationSession`, `ChatMessage`, `Notification` (→ `app_notifications`),
`UserModerationLog` — with relationships, casts, and domain helpers
(`isSearchable()`, `badgeForDonationCount()`, `isBanned()`, `remainingCooldownDays()`, etc.)

**Services** (`app/Services/`)
`DonationService` centralizes the entire donor availability / session state
machine: accept, reject, complete, end, contact-sharing, cooldown release,
and expired-session flagging. Controllers stay thin and call into it.

**Middleware** (`app/Http/Middleware/`)
- `AdminMiddleware`, `DonorMiddleware`, `PatientMiddleware` — role gates
- `EnsureAccountIsActive` — force-logout for banned/suspended users on any request
- `SessionActiveMiddleware` — blocks a donor from a second concurrent session
- `DonationEligibilityMiddleware` — enforces the cooldown before accepting a new request

**Controllers** (`app/Http/Controllers/` + `Admin/`)
`AuthController`, `ProfileController`, `DashboardController`, `DonorController`
(search + history), `BloodRequestController` (create/list/cancel/incoming/accept/reject),
`DonationSessionController` (complete/end/share-contact), `ChatController`
(participant chat + read-only admin monitoring), `LeaderboardController`,
`NotificationController`, and under `Admin/`: `BloodGroupController`,
`BloodStockController`, `UserManagementController`, `AnalyticsController`
(JSON endpoints for the dashboard's Chart.js charts), `ReportController`
(PDF via DomPDF, Excel via Laravel Excel, in-app preview).

**Console** (`app/Console/Commands/ProcessDonationLifecycle.php` + `routes/console.php`)
Scheduled every 5 minutes: releases donors whose cooldown has ended back to
`Available`, and flags donation sessions that blew past their 30-minute timer.

**Views** (`resources/views/`)
Full Bootstrap 5 + Bootstrap Icons + Chart.js + SweetAlert2 frontend:
landing page, auth screens, all three dashboards, donor search, blood
request form, donor/patient request lists, live chat (AJAX polling, session
countdown, contact-sharing, complete/end actions), donation history,
leaderboard, notifications, profile editor, and the full admin panel
(users, blood groups, blood inventory, chat monitoring, reports).

**Seeders** (`database/seeders/`)
`BloodGroupSeeder` (8 default groups + starter stock), `AdminUserSeeder`
(`admin@bloodbank.com` / `password`), `DemoDataSeeder` (50 sample donors +
50 sample patients across 5 Indian cities, per the spec's acceptance criteria).

## Installing into your existing Laravel 12 project

```bash
# 1. Copy files in (merge, don't blindly overwrite bootstrap/app.php or routes/web.php
#    if you already have content there)
cp -r database/* /path/to/your-app/database/
cp -r app/* /path/to/your-app/app/
cp -r resources/views/* /path/to/your-app/resources/views/
cp routes/web.php /path/to/your-app/routes/web.php
cp routes/console.php /path/to/your-app/routes/console.php

# 2. Merge docs/bootstrap-app-middleware.php's ->withMiddleware() block
#    into your bootstrap/app.php (Laravel 12 registers middleware aliases
#    there, not in Kernel.php)

# 3. Install the PDF/Excel packages
composer require barryvdh/laravel-dompdf maatwebsite/excel

# 4. Run migrations and seed
php artisan migrate
php artisan db:seed

# 5. Storage symlink for profile photos
php artisan storage:link

# 6. Serve
php artisan serve
```

## Design system

The UI was redesigned around one signature motif: a hand-drawn ECG/pulse
waveform — it appears exactly twice (the navbar mark, and once in the home
page hero) and nowhere else. Everything around it stays quiet:

- **Palette** — Crimson Pulse `#C81E3A` (primary), a clinical paper
  background `#FBF7F4`, a muted teal `#2C8C7C` for success/available states,
  and a warm gold `#B8892B` for warnings/badges. These are wired in as
  Bootstrap's own CSS variables (`--bs-primary`, `--bs-success`, etc.) in
  `layouts/app.blade.php`, so every existing `btn-primary` / `bg-danger` /
  `badge` across the app already picks up the new palette — no per-view changes needed.
- **Type** — `Fraunces` (serif) for headlines only, `Inter` for body/UI text,
  `IBM Plex Mono` for stats, ranks, and the session countdown timer.
- **Mobile** — the sidebar collapses into a Bootstrap offcanvas on screens
  below `lg`, opened from a hamburger button in the navbar.
- Respects `prefers-reduced-motion` (the pulse animations disable themselves).

## Real-time chat & notifications (Laravel Reverb)

Chat and the notification bell now update instantly via WebSockets — no
polling, no page reload.

**One-time setup:**

```bash
composer require laravel/reverb
```

Add to `.env`:

```
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=bloodlink
REVERB_APP_KEY=bloodlinkkey
REVERB_APP_SECRET=bloodlinksecret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

Merge `config/broadcasting.php` from this project (already has the `reverb`
connection wired up) into your app if you don't already have one, then start
the Reverb server alongside `php artisan serve`:

```bash
php artisan reverb:start
```

**How it works:**
- `app/Events/ChatMessageSent.php` broadcasts on a private
  `donation-session.{id}` channel the instant a message is sent
  (`ChatController::send`) — both participants see it immediately, and an
  admin viewing the same session in read-only monitoring gets it too.
- `app/Events/NotificationCreated.php` broadcasts on a private `user.{id}`
  channel whenever *any* notification is created — wired into the
  `Notification` model's `created` hook, so every existing call site
  (`DonationService`, `BloodRequestController`, etc.) gets real-time delivery
  for free, with no extra code at each call site.
- Both events implement `ShouldBroadcastNow`, so no queue worker is required
  for delivery — trade-off: broadcasting blocks the request for the (usually
  sub-millisecond) time it takes to publish to Reverb. Switch to
  `ShouldBroadcast` + a running queue worker if you'd rather not have that.
- `routes/channels.php` authorizes both channel types (participants only for
  chat; any authenticated user for their own notification channel).
- The layout (`layouts/app.blade.php`) loads Echo + Pusher-js from CDN
  (matching the CDN-based approach used for Bootstrap/Chart.js/SweetAlert2
  elsewhere in this project — no npm build step required) and plays a short
  two-tone chime via the Web Audio API when a notification arrives, so no
  external audio file is needed either.

## Branded password reset email

Laravel's default password-reset notification is a plain, unstyled email.
This project overrides it with a fully custom, Blood Link–branded HTML
template instead:

- `app/Notifications/ResetPasswordNotification.php` — a custom notification
  that renders `resources/views/emails/reset-password.blade.php` (a
  table-based HTML layout, inline-styled for email client compatibility)
  rather than Laravel's default Markdown mail component.
- `User::sendPasswordResetNotification()` is overridden in `app/Models/User.php`
  to dispatch this custom notification instead of the framework default —
  no other code needs to change; `Password::sendResetLink()` in
  `AuthController` calls this automatically.
- The email uses the same crimson/paper palette as the rest of the app, a
  clear "Reset Password" button, the fallback plain-text link, an expiry
  note, and a "didn't request this?" safety line.
- Because email clients (especially Outlook desktop) don't reliably render
  webfonts, external CSS, or SVGs, the template sticks to web-safe fonts,
  inline styles, and a plain-text 🩸 wordmark instead of the SVG pulse mark
  used elsewhere in the app.

## Default logins after seeding

| Role  | Email                   | Password |
|-------|--------------------------|----------|
| Donor | donor1@example.com … donor50@example.com | password |
| Patient | patient1@example.com … patient50@example.com | password |

## Notes / things worth knowing

- Chat is AJAX-polling based (4-second interval) rather than WebSockets/Reverb
  — swap in Laravel Reverb broadcasting later if you want true real-time push;
  the `ChatController`/`chat.show` view are structured so that's a drop-in change.
- `ReportController` exports use a plain-HTML `admin/reports/pdf.blade.php`
  template (DomPDF doesn't render Bootstrap reliably) and a generic
  `GenericCollectionExport` that turns any associative-array collection into
  an XLSX download.
- Business Rules 1–21 from the spec (session exclusivity, cooldown enforcement,
  blood-group referential integrity, moderation audit logging, "at least one
  active admin," etc.) are enforced in `DonationService`, the middleware, and
  `UserManagementController` — see inline comments referencing rule numbers.
