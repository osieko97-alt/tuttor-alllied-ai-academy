# tuttor-alllied-ai-academy
Here’s a **full README.md** for the **from-scratch (Codex-mode) PHP MVC build** of **Tutor & Allied AI Academy**.
Copy-paste this into `README.md` at the repo root.

---

# Tutor & Allied AI Academy (Codex Build)

**Build. Deploy. Graduate.**
Domain: **Tutor-Allied.dev**

Tutor & Allied AI Academy is an outcome-driven EdTech + incubation platform for **16–25+** (high school seniors, university students, early builders). The platform enforces real-world outcomes: users graduate only after completing a **14-day sprint**, passing a **deploy checklist**, linking a GitHub-backed project, and receiving at least **one verified review**.

This repository is a **from-scratch PHP MVC build** (“Codex mode”), designed to be simple, explicit, and production-expandable.

---

## Features (MVP Scope)

### Public Marketing Site

* Home (hero + conversion CTAs)
* Tracks (Coding Green / Aware but Stuck / Expert)
* Courses directory (Developers / Creators / AI+Crypto utility)
* Incubation (project listings + workflow preview)
* Partners & mentorship sessions
* Forum + Blog (starter UI + moderation pipeline)
* AI Assistant CTA (Coming Soon page)

### App (Authenticated)

* Dashboard
* 14-Day Sprint (daily tasks + proof submissions)
* Deploy Checklist (hard gate)
* Incubation Project page (repo + reviews + verification status)
* Graduation gate + certificate issuance

### Admin Console

* Unified moderation queue (reports across forum/chat/projects/reviews)
* User actions (warn/mute/suspend/ban + audit logs)
* Integrations manager (encrypted secrets, enable/disable, test buttons)
* Webhook logs + replay capability
* Audit logs for all sensitive ops

### GitHub Proof & Integrity (Core Moat)

* Reviews must reference **PR/commit evidence**
* Verified reviews can be **partner verified**
* GitHub webhooks protected by **HMAC signature validation**
* No payment logic (Pi Network concept only; payments ignored)

---

## Tech Stack

* PHP **8.2+**
* MySQL / MariaDB
* Composer
* Custom MVC:

  * Router
  * Controllers
  * Service layer
  * Minimal templating (Blade-like or PHP templates)
* Encrypted secrets (at-rest in DB)
* Session auth (cookie-based)
* REST-style endpoints

> This is intentionally “framework-light” so you can scale it either:
>
> * into Laravel later, or
> * keep it as a clean, explicit PHP codebase.

---

## Repo Structure

```text
/
├─ public/                  # Web root
│  ├─ index.php             # Front controller
│  └─ assets/               # CSS + images + branding kit
├─ app/
│  ├─ Core/                 # Router, DB, Auth, CSRF, Middleware
│  ├─ Controllers/
│  │  ├─ Marketing/
│  │  ├─ App/
│  │  └─ Admin/
│  ├─ Models/               # Thin models / DB helpers
│  ├─ Services/             # Domain logic (Graduation, Integrations, GitHub, Moderation)
│  └─ Middleware/
├─ resources/
│  └─ views/                # Templates (marketing/app/admin)
├─ database/
│  ├─ schema.sql            # Full DB schema
│  └─ seed.sql              # Seed admin user + defaults
├─ .env.example
├─ composer.json
├─ LICENSE
└─ README.md
```

---

## Local Setup

### 1) Install dependencies

```bash
composer install
cp .env.example .env
```

### 2) Create database

Create a MySQL database (example name: `tutor_allied`).

### 3) Import schema + seed

```bash
mysql -u root -p tutor_allied < database/schema.sql
mysql -u root -p tutor_allied < database/seed.sql
```

### 4) Run locally

Use PHP’s built-in server (for preview/dev):

```bash
php -S 127.0.0.1:8000 -t public
```

Then open:

* [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Default Accounts (Seed)

### Admin

* Email: **[admin@tutor-allied.dev](mailto:admin@tutor-allied.dev)**
* Password: **ChangeMeNow!**

⚠️ Change this immediately in production.

---

## Routes Overview

### Marketing (Public)

* `/` Home
* `/tracks`
* `/courses`
* `/incubation`
* `/partners`
* `/forum`
* `/blog`
* `/ai` (Coming Soon)

### App (Auth Required)

* `/app`
* `/app/learn`
* `/app/learn/day/{n}`
* `/app/deploy`
* `/app/project/{slug}`
* `/app/graduation`
* `/app/certificate/{enrollmentId}`

### Admin (Admin Role)

* `/admin`
* `/admin/moderation`
* `/admin/users/{id}`
* `/admin/integrations`
* `/admin/integrations/{key}/edit`
* `/admin/integrations/{key}/test`
* `/admin/integrations/{key}/webhooks`
* `/admin/integrations/{key}/webhooks/{eventId}/replay`

### Webhooks

* `POST /webhooks/github` (signature protected)

---

## Core Business Rules

### Graduation Gate (Non-negotiable)

A user can only graduate if:

1. 14-day sprint completed
2. Deploy checklist completed
3. Project linked to enrollment
4. At least **1 verified review** exists
5. No ban/suspension restrictions apply

Graduation creates:

* certificate record + code
* sets enrollment status to `graduated`

### Reviews Must Be Evidence-Based

A review must include:

* PR URL or Commit URL
* Summary
* Status flow: `submitted → implemented → verified`

---

## Integrations

### GitHub

Used for:

* proof verification (PR/commit)
* webhook evidence ingestion
* repo linking workflow

Store secrets in Admin → Integrations:

* `github.token`
* `github.webhook_secret`

### Google OAuth (optional)

For sign-in, store:

* `google.client_id`
* `google.client_secret`
* redirect URI in `.env`

---

## Security Notes

* Secrets are stored encrypted in DB (not in git)
* Webhook signature verification enabled for GitHub
* Audit logs track all admin actions
* Moderation actions enforce:

  * mute (blocks posting)
  * suspend (blocks app access)
  * ban (blocks access entirely)

---

## Deployment Notes (Production)

Minimum production setup:

* Nginx/Apache → `public/` as web root
* PHP-FPM
* MySQL
* HTTPS required
* Environment:

  * `APP_ENV=production`
  * `APP_DEBUG=false`
  * Use strong session settings
* Set up cron (optional) for:

  * queue processing
  * reminder/notification jobs
  * cleanup of old logs/webhook payloads

---

## Asset Directory

Your brand assets live in:

```text
public/assets/
├─ css/theme.css
└─ img/
   ├─ logo.png
   ├─ hero.png
   ├─ ecton_cutout.png
   └─ track_thumbs.png
```

Only **approved static assets** should be committed.
User uploads must go to `storage/` or object storage (S3/GCS).

---

## License

This project uses a **Proprietary License** (see `LICENSE`).
No resale, no cloning, no public SaaS deployment without a commercial agreement.

---

## Roadmap (Next Build Steps)

* Full auth UI (register/login/reset)
* Real forum posting + chat sync
* Real incubation CRUD + review moderation
* Partner dashboard + verification workflow
* Certificate PDF generation + public verification endpoint
* Rate limiting + WAF + abuse protections
* Institutional cohorts and partner-sponsored tracks

---

## Support / Contact

For licensing, partnerships, or investor discussions:
**[legal@tutor-allied.dev](mailto:legal@tutor-allied.dev)**

---

If you want, I can also add:

* `SECURITY.md` (responsible disclosure + policy)
* `CONTRIBUTING.md` (PR rules aligned to your license)
* `DEPLOYMENT.md` (Nginx + SSL + env + DB hardening)
