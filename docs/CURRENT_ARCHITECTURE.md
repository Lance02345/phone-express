# Current architecture

## System shape

Phone Express is currently a Laravel modular monolith in deployment shape, but not yet in domain organization. Controllers query Eloquent models directly and render Blade pages. MySQL stores users and phones; local files hold images, sessions, and cache data.

```text
Browser
  |
  | HTTP / Blade forms / small JSON search endpoint
  v
Laravel routes
  |
  +-- DashboardsController ------ landing page
  +-- PagesController ----------- catalogue, filters, template pages
  +-- PhoneController ----------- product detail
  +-- template controllers ------ inherited demo pages
  |
  v
Phone Eloquent model
  |
  v
MySQL: phones

Static product images -> public/Images
Cache/session          -> local files
Outbound contact       -> wa.me deep links
```

There are no service, repository, domain-event, job, webhook, or integration layers for the business workflow yet.

## Runtime components

### Public web

- `/` and `/index` render the landing page.
- `/pricing` is the browse/search/filter catalogue.
- `/phones/{phone}` is the detail view.
- Page navigation uses route URLs plus landing-page anchors.
- Product images are served from `public/`; missing files use a presentation fallback.
- WhatsApp buttons open a customer-authored `wa.me` message and do not create application records.

### Backend

- `DashboardsController` selects twelve random priced phones, caches them for a day, and calculates selected installment data in memory.
- `PagesController` owns catalogue filtering, sorting, pagination, suggestions, and a JSON response path.
- `PhoneController` infers brand and storage from `name`, calculates a second payment estimate, and retrieves related phones.
- `Phone::scopeSearch()` uses the active database driver's case-insensitive search behavior.

### Persistence

- `phones` is the only commercial/domain table.
- `users`, reset tokens, failed jobs, and Sanctum tokens are framework scaffolding.
- Eight brand/group seeders plus `PhoneSeeder` populate `phones` through `DatabaseSeeder`.
- Catalogue values are not editable through a real admin workflow.

### Frontend toolchain

- Blade and Bootstrap render server-side pages.
- Vite compiles Sass and JavaScript.
- The repository retains a broad admin-template dependency and asset set.
- Vite watcher exclusions avoid watching the large Tabler SVG collection during development.

## Configuration and environment

The application is configured to use MySQL in development and production. File-backed cache/session and the synchronous queue are development defaults. Future Meta, AI, and M-Pesa environment placeholders do not correspond to implemented integrations yet.

Configuration ownership should evolve as follows:

| Concern | Current | Required before production automation |
| --- | --- | --- |
| Database | MySQL | Managed MySQL, backups, dedicated test DB |
| Cache | File | Redis or another shared cache when horizontally scaled |
| Queue | Sync | Durable async worker with retry/dead-letter policy |
| Images | `public/Images` | Managed storage, validation, stable URLs |
| Secrets | `.env` | Environment secret manager and rotation procedure |
| Logs | Laravel local log | Centralized structured logs and alerts |

## Route and trust boundaries

The current route file mixes business pages with inherited demos. Of 184 routes, 179 use the standard web middleware group and only one API route requires Sanctum. The intended boundary should be made explicit:

```text
Public
  landing, catalogue, product detail, policy pages

Customer API (future)
  conversation messages, lead consent, status lookup
  -> rate limiting + validation

Provider webhooks (future)
  Meta, M-Pesa callbacks
  -> signature validation + idempotency + raw event ledger

Staff admin (future)
  catalogue, stock, policy, conversations
  -> authentication + roles + audit log
```

## Current data flow limitations

1. PHP seeders write directly to the final presentation table.
2. Controllers reverse-engineer structured attributes from a display string.
3. Views and controllers encode business policies independently.
4. Cache keys are time-based rather than invalidated by catalogue changes.
5. Customer WhatsApp intent leaves the application, so there is no lead history or conversion attribution.
6. There is no inventory source, so “in stock” is not a defensible application state.

## Recommended target shape

Retain one Laravel application and introduce domain modules rather than separate services:

```text
HTTP controllers / webhooks / console imports
                 |
                 v
Application actions
  Catalogue | Inventory | Policies | Conversations | Payments
                 |
                 v
Eloquent domain models + MySQL
                 |
      +----------+----------+
      v                     v
Queued jobs             Read models/cache
      |
Meta / AI / M-Pesa adapters
```

This keeps operations simple while adding the boundaries required for later automation. External providers should be adapters behind application interfaces; controllers and AI prompts should never query provider SDKs directly.

## Compatibility strategy

The public UI does not need a rewrite during normalization:

1. Add normalized catalogue tables and importer.
2. Migrate current seeded data using stable import keys.
3. Change the `Phone` read path or introduce a compatible catalogue query object that exposes the fields the existing views expect.
4. Move inferred brand/storage/payment logic into authoritative records.
5. Switch landing, pricing, and detail pages one at a time.
6. Retire `phones` and seeders only after parity checks pass.

This sequence avoids a big-bang migration and avoids asking the client to re-enter 210 products.
