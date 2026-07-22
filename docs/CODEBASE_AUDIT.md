# Phone Express codebase audit

Audit date: 22 July 2026  
Scope: the current local worktree, including uncommitted UI and catalogue fixes.

## Executive summary

The project is a Laravel 10 server-rendered application backed by MySQL. The public landing, catalogue, and newly added product-detail experience are usable, and the frontend production build completes. The business domain underneath them is still a prototype: a single `phones` table stores only `name`, `price`, and `image_path`; eight PHP seeders are the catalogue source; and brand, storage, payment plans, availability, and specifications are inferred at request time.

The safest next move is not automation yet. First establish a reliable catalogue contract, migrate the seed data idempotently, and make MySQL the runtime source of truth. The existing pages can remain online throughout that work by keeping `Phone` as a compatibility layer.

## Repository inventory

| Area | Current state | Assessment |
| --- | --- | --- |
| Backend | Laravel 10, PHP requirement `^8.1`, Eloquent, Blade | Appropriate for a modular monolith |
| Database | MySQL | Correct deployment target, but schema is under-modelled |
| Frontend | Blade, Bootstrap 5.3, Sass, Vite 4 | Works, but carries a large admin-template asset surface |
| Catalogue | `phones` table plus 8 seeders | Technical source exists; business ownership is not encoded |
| Product detail | `PhoneController@show` and `phone-show.blade.php` | Useful UI, but details are derived rather than authoritative |
| Search/filter | Controller query helpers and `/api/phone-search` | MySQL-compatible search is in place; filters cover only Apple/Samsung explicitly |
| Authentication | User/Sanctum scaffolding and template pages | No complete customer/admin workflow found |
| Orders/payments | Template routes/views only | No order, payment, or M-Pesa domain implementation |
| Inventory | None | Availability cannot be truthfully automated yet |
| Messaging/AI | WhatsApp deep links only | No webhook, conversation store, assistant, or handoff flow |
| Queue/cache | `sync` queue, file cache/session | Fine for local work, insufficient for resilient webhook processing |
| Tests | One trivial unit test and one `/` smoke test | No domain, MySQL, catalogue, or product-detail coverage |
| Delivery | No CI/CD or container definition found | Deployment procedure is not reproducible from the repo |

## Application surface

`php artisan route:list --json` reports 184 routes: 179 use the `web` middleware group, two use `api`, and only `/api/user` is protected with `auth:sanctum`. Most routes are inherited admin-template demonstrations and are publicly reachable. This makes navigation and maintenance harder and unnecessarily enlarges the attack surface.

The business-relevant public flow is:

```text
GET / or /index
  -> DashboardsController@index
  -> cached/random Phone records
  -> pages.landing

GET /pricing
  -> PagesController@pricing
  -> filters/sorts Phone records
  -> pages.pricing

GET /phones/{phone}
  -> PhoneController@show
  -> Phone + inferred metadata + related records
  -> pages.phone-show

GET /api/phone-search
  -> PagesController search endpoint
```

## Data findings

The only business table is `phones`:

| Column | Type | Issue |
| --- | --- | --- |
| `id` | bigint | Internal identifier only |
| `name` | varchar | Contains model, variant, storage, and sometimes colour in one string |
| `price` | integer | No currency; zero is used as an undocumented sentinel |
| `image_path` | nullable varchar | Local relative path with no asset validation or media metadata |
| timestamps | timestamps | Seeder updates can blur original creation dates |

Seeders currently call `updateOrCreate(['name' => ...])`. That is repeatable, but `name` is not a stable variant key. Two items sharing a display name but differing by colour/image can overwrite one another. The catalogue has no SKU, slug, brand ID, category ID, status, stock level, colour, storage, condition, description, specifications, or payment eligibility.

The last verified seed run produced 210 phone rows. A prior asset audit found 38 missing image files, including case-sensitive path mismatches. The UI fallback prevents broken cards, but does not repair catalogue integrity.

## Behaviour and correctness findings

1. **Business claims are calculated or hard-coded.** The landing and detail controllers use two different installment formulas. Delivery, warranty, customer, sales, and branch claims are not backed by domain records.
2. **Homepage content changes randomly.** Featured phones are cached random results and customer/sales statistics use `rand()`. This is unsuitable for verifiable reporting or curated merchandising.
3. **Filtering is name parsing.** Only Apple and Samsung have explicit brand filters; storage is a substring search. Other seeded brands cannot be filtered consistently.
4. **Price statistics use the current page.** They describe the paginated collection, not necessarily all matching products.
5. **Zero price is ambiguous.** Some queries exclude it, while catalogue/detail UI must interpret it. It should become an explicit publication or quote-required state.
6. **Images are coupled to `public/`.** File existence checks protect rendering, but there is no managed media lifecycle.
7. **Cache invalidation is incomplete.** Daily catalogue caches do not clear when seed or product data changes.

## Security and operational findings

- Almost all template/demo routes are public. Remove them or restrict an admin route group before deployment.
- There is no role/permission model and no authenticated catalogue administration.
- No request-signature validation, idempotency store, webhook event log, or rate-limited messaging endpoint exists.
- Secrets have placeholders in environment examples, but there is no integration configuration or secret-rotation procedure.
- A synchronous queue would make future webhook responses slow and fragile.
- No structured health check, error reporting integration, backup/restore instructions, or CI checks were found.
- Dependency installation reports known npm advisories; upgrades should be reviewed deliberately rather than applying a forced breaking audit fix.
- The Vite bundle includes many unused admin-template dependencies and a 726 kB uncompressed CSS artifact.

## Verification snapshot

| Check | Result |
| --- | --- |
| `npm run build` | Pass |
| Unit example test | Pass |
| Feature `/` smoke test | Passes when the configured local MySQL database is available |
| Business/domain tests | Absent |
| Route inventory | 184 total |

The test configuration still exposes an isolation problem: tests rely on the developer database instead of a dedicated, disposable test database.

## Priority risks

| Priority | Risk | Why it blocks automation |
| --- | --- | --- |
| P0 | No authoritative variant/stock model | An assistant cannot promise an available phone safely |
| P0 | Payment and delivery rules are hard-coded | Customer quotes may be inconsistent or wrong |
| P0 | No dedicated test database/domain tests | Catalogue migrations can regress public pages unnoticed |
| P1 | Public demo/admin route surface | Avoidable security and maintenance exposure |
| P1 | Catalogue images and identifiers are unreliable | Product cards and outbound messages cannot be deterministic |
| P1 | No async queue/webhook ledger | Meta and payment retries would duplicate or lose work |
| P2 | Heavy inherited frontend assets | Performance and upgrade cost remain higher than necessary |

## Audit conclusion

Proceed with catalogue normalization as Phase 1. Preserve the current public controllers and views, introduce authoritative product/variant records behind them, import existing seed data once, and add an idempotent catalogue import/update path. Only after stock and policy ownership are confirmed should WhatsApp or AI be allowed to give definitive availability, delivery, or installment answers.
