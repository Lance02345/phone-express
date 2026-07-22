# Implementation decisions and backlog

## Guiding outcome

Improve the site and prepare automation without creating duplicate maintenance work for the client. The existing catalogue is migrated automatically; future data changes happen through one source; product pages consume the same approved data that automation will use.

## Decisions

### 1. Keep a Laravel modular monolith

Do not split this application into microservices. Catalogue, inventory, policies, conversations, and payments should be Laravel modules with clear application actions and interfaces. This is easier to deploy and still isolates external-provider logic.

### 2. MySQL is the runtime system of record

Seeders are bootstrap/import fixtures, not an ongoing content-management interface. Normalize catalogue records in MySQL and track `source` plus `source_key` for safe repeated imports.

This is a technical decision. The business still needs to confirm whether future updates originate in an admin screen, an existing stock system, or a single upload file.

### 3. Do not ask the client to recreate product details

The first importer parses all existing seeders/rows, preserves legacy names and IDs as provenance, links usable images, and creates a review report for only the uncertain fields. Defaults and inherited product-level fields minimize per-variant work.

The product detail page will render:

- existing catalogue facts automatically;
- variant attributes inherited from normalized data;
- “coming soon” imagery when media is missing;
- approved payment/delivery policy content from one policy source;
- no fabricated specification or availability claims.

### 4. Separate a model from a sellable variant

`iPhone 15 Pro` is a product; storage/colour/condition combinations are variants. Price, SKU, stock, and purchase eligibility belong to the variant. This prevents same-name seed rows from overwriting each other.

### 5. Replace sentinel and inferred values

- Price `0` becomes `price = null` plus `quote_required = true`.
- Brand and storage become explicit data, not string filters.
- Featured products use a curated rank, not random selection.
- Availability is shown only when backed by a named stock source and freshness timestamp.
- Installments come from one approved policy calculator.

### 6. Integrations are adapters, not controller code

Meta, AI, and M-Pesa implementations will sit behind interfaces and queued jobs. Incoming callbacks must be signature-checked, stored once using provider event IDs, acknowledged quickly, and processed idempotently.

### 7. Human handoff is a first-class state

Automation must stop and assign a staff handoff when confidence is low, data is stale/missing, the customer disputes a quote, or policy requires manual approval. The assistant must never manufacture stock, final credit approval, warranty exceptions, or payment success.

### 8. Remove inherited demo surface before production

Only public business routes, authenticated staff routes, and explicit APIs/webhooks should remain. Template examples should be removed or unavailable outside local development.

### 9. Test against MySQL

Use a dedicated disposable MySQL test database because search and random-order behavior are database-specific. Add factories/fixtures for products and variants; tests must not rely on the developer catalogue.

## Phased backlog

### Phase 1 — Catalogue foundation (next)

- Add migrations/models for brands, categories, products, variants, media, and specifications.
- Implement a legacy catalogue importer with dry-run, warnings, idempotent upsert, and reconciliation counts.
- Add explicit publication, quote-required, and image states.
- Add a single payment policy calculator and remove duplicate formulas.
- Switch landing, pricing, search, and detail reads behind a catalogue query/action layer.
- Add MySQL feature tests for import, search, filters, detail, missing images, and zero-price conversion.
- Add cache invalidation when catalogue data changes.
- Produce a client review list only for ambiguous/missing facts.

**Exit condition:** every public product card/detail is generated from normalized records; rerunning the importer creates no duplicates; legacy and new result counts reconcile.

### Phase 2 — UI completion and trust content

- Add deterministic featured products and complete filters for every active brand.
- Improve mobile navigation, focus states, empty/loading/error states, and image aspect consistency.
- Add authoritative delivery, warranty, returns, privacy, and payment-plan pages.
- Add structured product metadata, canonical slugs, sitemap, and sensible 404 handling.
- Remove or gate demo/admin-template routes and unused assets.
- Measure and reduce bundle/page weight.

**Exit condition:** core public paths are accessible, responsive, policy-consistent, and covered by smoke tests.

### Phase 3 — Operations and inventory

- Confirm the client's current stock process and select exactly one update method.
- Add locations, inventory levels, import/reconciliation, freshness indicators, and audit logs.
- Build a minimal authenticated staff catalogue/inventory review workflow only where automation cannot resolve data.
- Configure durable queues, shared cache, scheduled tasks, health checks, backups, and centralized logging.

**Exit condition:** staff can reconcile catalogue and stock without entering the same information in multiple places.

### Phase 4 — WhatsApp and lead workflow

- Add Meta webhook verification/signature checks and raw idempotent event storage.
- Store contacts, consent, conversations, messages, leads, and handoffs.
- Implement queued outbound messaging, retry limits, templates, opt-out, and staff escalation.
- Link messages/leads to normalized product variants and policy versions.

**Exit condition:** duplicate provider events are harmless; conversations are auditable; staff can take over safely.

### Phase 5 — AI assistant

- Add retrieval tools limited to approved catalogue, stock, and policy queries.
- Require citations/source IDs internally for factual answers and log tool decisions.
- Add confidence thresholds, prompt-injection defenses, PII minimization, cost limits, and evaluation cases.
- Start in staff-assist/shadow mode before autonomous customer replies.

**Exit condition:** evaluation demonstrates that the assistant refuses or hands off when authoritative data is absent.

### Phase 6 — M-Pesa and order workflow

- Model orders, immutable quote snapshots, payment attempts, callbacks, and reconciliation.
- Implement provider adapter, signature/auth controls, idempotent callbacks, retries, and manual exception queues.
- Reserve/release inventory transactionally where reliable inventory exists.
- Never treat a browser redirect or assistant statement as proof of payment.

**Exit condition:** payment state is derived from verified provider events and reconciles with orders and inventory.

## Immediate implementation slice

The next coding slice should be deliberately small:

1. Create the normalized catalogue migrations and models.
2. Build the dry-run legacy importer and its reconciliation report.
3. Add tests using a dedicated MySQL test configuration.
4. Run the importer against the 210 current records.
5. Review only ambiguous parses and missing images.
6. Put landing/pricing/detail reads behind the new catalogue layer.

No client-facing admin form is needed in this slice. That decision waits until the actual future catalogue/stock source is confirmed.

## Open business confirmations

These questions do not block schema/import work, but they block truthful automation:

- Who owns the catalogue today, and where do they currently edit it?
- Is there an existing POS, ERP, spreadsheet, or branch stock report?
- Does zero price mean unavailable, discontinued, or “contact us”?
- Are colour and condition separate sellable variants?
- What are the approved installment formula, eligible products, fees, and term?
- What delivery, warranty, and returns claims are approved?
- Which phone number/team receives handoffs, and during what hours?

## Definition of done for each phase

Every phase requires migrations with rollback strategy, validation, authorization where relevant, automated tests, structured logs, no secrets in source control, reconciliation/monitoring for external or imported data, and updated documentation. A visually complete screen is not complete if its data or claims are inferred and unauditable.
