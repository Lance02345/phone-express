# Data model

## Current model

```text
Phone
  id
  name
  price
  image_path?
  created_at
  updated_at
```

`name` currently acts as a display name, lookup key, brand source, storage source, and variant description. It cannot safely carry all those responsibilities.

## Catalogue source-of-truth decision

- **Current technical source:** PHP seeders.
- **Current runtime source:** PostgreSQL `phones` rows.
- **Business owner/source:** not yet confirmed in the repository.
- **Recommended operational source:** normalized PostgreSQL catalogue records, updated through one idempotent import/admin workflow.

The client should not update a spreadsheet, PHP seeder, and admin screen separately. The first migration will import the existing seed data automatically. After that, one agreed input method becomes authoritative; the database records its source and external key so repeated imports update rather than duplicate products.

## Proposed catalogue model

### `brands`

| Field | Purpose |
| --- | --- |
| `id` | Internal key |
| `name` | Canonical brand name |
| `slug` | URL/filter key, unique |
| `is_active` | Publication control |

### `categories`

| Field | Purpose |
| --- | --- |
| `id` | Internal key |
| `name`, `slug` | Canonical label and unique URL key |
| `parent_id` nullable | Future hierarchy without schema replacement |
| `is_active` | Publication control |

### `products`

A product is the shared model-level record, for example “Apple iPhone 15 Pro”.

| Field | Purpose |
| --- | --- |
| `id` | Internal key |
| `brand_id`, `category_id` | Explicit relationships |
| `name` | Canonical model name |
| `slug` | Stable product URL, unique |
| `short_description`, `description` | Approved customer-facing copy |
| `status` | draft, active, archived |
| `featured_rank` nullable | Deterministic merchandising |
| `published_at` nullable | Publication lifecycle |

### `product_variants`

A variant is a sellable configuration such as storage, colour, and condition.

| Field | Purpose |
| --- | --- |
| `id`, `product_id` | Identity and parent |
| `sku` | Stable unique business/import key |
| `label` | Human-readable variant label |
| `storage_gb` nullable | Numeric filterable storage |
| `colour` nullable | Variant attribute |
| `condition` | new, refurbished, used, or approved vocabulary |
| `price_minor` nullable | Money in minor units; null means no published price |
| `currency` | Default `KES`, explicit per record |
| `quote_required` | Replaces the ambiguous zero-price sentinel |
| `is_active` | Sellability/publication control |
| `payment_plan_eligible` | Eligibility only; formula lives in policy data |
| `source`, `source_key` | Idempotent import provenance; unique together |

Use a database constraint so `price_minor` is non-negative and require either a published price or `quote_required = true`.

### `product_media`

| Field | Purpose |
| --- | --- |
| `id` | Identity |
| `product_id` / `variant_id` nullable | Scope of image |
| `disk`, `path` | Storage reference |
| `alt_text` | Accessibility and message rendering |
| `sort_order`, `is_primary` | Deterministic display |
| `checksum` nullable | Duplicate/change detection |

### `specification_definitions` and `product_specifications`

Definitions provide stable keys (`display_size`, `battery_mah`, `ram_gb`) and labels/units. Product values store approved text or typed values. This avoids adding a new column for every future specification while preserving filterability for selected indexed attributes.

## Inventory model

Inventory must not be invented. Once the business identifies its stock source, use:

### `locations`

Branch/warehouse identity, name, contact data, and active state.

### `inventory_levels`

| Field | Purpose |
| --- | --- |
| `product_variant_id`, `location_id` | Unique stock position |
| `quantity_on_hand` | Physically recorded units |
| `quantity_reserved` | Units committed but not completed |
| `updated_at` | Freshness signal |
| `source`, `source_key` | Origin and reconciliation |

Available quantity is derived as `on_hand - reserved`; it is not entered separately. If the client cannot maintain exact counts, use an explicit coarse status (`available`, `limited`, `out_of_stock`, `unknown`) and tell the assistant how stale data may be.

## Policy and commercial rules

Hard-coded formulas should move to versioned records or a small policy service backed by approved configuration:

- payment plan name, eligibility, deposit rule, term, fees/interest, effective dates;
- delivery zones, fees, estimates, and exclusions;
- warranty/returns text and effective dates;
- contact and escalation destinations.

Every customer quote should record the policy version used. The landing and product detail controllers currently disagree on installment calculations, which normalization must resolve.

## Future conversation and transaction model

These tables are not part of the first migration, but the catalogue should support them cleanly:

- `contacts` and consent records;
- `conversations`, `messages`, and `handoffs`;
- `leads` with interested `product_variant_id`;
- `orders` and `order_items` referencing a variant and price snapshot;
- `payment_attempts`, `payment_events`, and provider reference IDs;
- `webhook_events` with unique provider event IDs and processing status;
- `audit_logs` for staff and automated changes.

Do not store a mutable product price as the only order price. Order items need an immutable quoted-price snapshot.

## Migration mapping from `phones`

| Existing value | Migration treatment |
| --- | --- |
| `phones.id` | Preserve as `source_key` such as `legacy-phone:{id}` |
| Parsed brand prefix | Map to reviewed canonical `brands` row |
| Model portion of `name` | Create/reuse `products` row |
| Storage/colour in `name` | Populate variant fields where parsing is confident |
| Full `name` | Preserve as initial variant label and legacy name |
| `price > 0` | Convert KES major units to `price_minor = price * 100` |
| `price = 0` | Set price null and `quote_required = true`; require review |
| Valid `image_path` | Create primary media record |
| Missing image | Record import warning; retain UI fallback |

The importer must produce a review report for ambiguous model/variant splits rather than silently guessing. Re-running it must update the same records through `(source, source_key)` uniqueness.

## Required constraints and indexes

- Unique slugs for brands, categories, and products.
- Unique variant SKU and unique `(source, source_key)`.
- Unique `(product_variant_id, location_id)` inventory level.
- Foreign keys with deliberate delete rules; archive catalogue records instead of cascading historical order data.
- Index active/public product queries, brand/category filters, price, storage, and searchable names.
- PostgreSQL search should use an appropriate indexed strategy when catalogue size justifies it; `ILIKE` is sufficient during the initial migration.
