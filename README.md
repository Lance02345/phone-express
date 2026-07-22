# Phone Express Kenya Automation Platform

## Project Context

Phone Express Kenya is an electronics and mobile-device retailer with an existing website at:

- https://phoneexpresskenya.co.ke/

The website was built by the project owner, and the full source code is available locally in the existing repository.

The objective is to extend the current website into a commerce automation platform that can manage product enquiries, customer conversations, leads, product recommendations, orders, payments, and staff handover across multiple channels.

The first priority is not to rebuild the existing website. Codex should first inspect the current codebase, understand the existing architecture, and extend it cleanly.

## Primary Goal

Build a centralized sales and customer-service automation layer that supports the following flow:

1. A customer asks about a phone or accessory.
2. The system understands the request.
3. The system searches the real product catalogue.
4. The system responds using verified price, stock, specifications, and policy information.
5. The system captures the customer as a lead.
6. A human salesperson can take over the conversation.
7. The same engine can later support the website, WhatsApp, and Instagram.

## Important Product Principle

The AI must never invent:

- Prices
- Discounts
- Stock availability
- Warranty status
- Financing eligibility
- Payment status
- Trade-in values
- Delivery promises

These values must come from the application database, approved rules, or verified integrations.

The AI layer should only be used for:

- Understanding customer intent
- Extracting structured requirements
- Comparing verified products
- Writing natural responses
- Summarizing conversations
- Suggesting the next best question
- Helping staff draft replies

## Existing Codebase Instructions

Before implementing anything, Codex should:

1. Inspect the repository structure.
2. Identify the framework and version.
3. Identify the product and category models.
4. Identify how prices, stock, variants, and images are currently stored.
5. Identify whether the site is using WooCommerce, Laravel, a custom CMS, or another stack.
6. Inspect authentication and admin functionality.
7. Inspect any existing APIs.
8. Inspect deployment and environment requirements.
9. Identify current integrations.
10. Document findings before modifying architecture.

Do not assume the project is Laravel until the repository confirms it.

## Preferred Architecture

Where the existing application permits, use a modular monolith rather than microservices.

Suggested logical modules:

- Products
- Product Variants
- Inventory
- Customers
- Conversations
- Leads
- Recommendations
- Knowledge Base
- Orders
- Payments
- Deliveries
- Repairs
- Trade-ins
- Channel Integrations
- Staff Inbox
- Reports

The current website should remain the public commerce interface. New automation features should be added without breaking current product pages, checkout flows, SEO, analytics, or administration.

## MVP Scope

The first usable version should include:

- Product catalogue synchronization or direct catalogue access
- Product variant support
- Stock-aware product search
- Website chat assistant
- Customer intent extraction
- Budget-based phone recommendations
- FAQ and policy responses
- Lead capture
- Shared staff inbox
- Human takeover
- Internal notes
- Conversation summaries
- Basic reports

The following should not be part of the first MVP unless already supported by the codebase:

- Final trade-in valuation
- Automated financing approval
- Automated repair diagnosis
- Courier auto-assignment
- Full accounting
- Complex marketing automation
- Custom machine-learning models

## Core Customer Use Cases

### Product enquiry

Customer:

> Is the Samsung S24 Ultra available?

System:

- Finds the exact product and relevant variants.
- Returns only verified stock, price, storage, colour, warranty, and delivery information.
- Asks the next useful question.

### Budget recommendation

Customer:

> I need a Samsung below KES 40,000 with a good camera.

System:

- Extracts brand, budget, and priority.
- Queries available products.
- Scores suitable products.
- Returns two to five recommendations.
- Explains the differences using verified specifications.

### Lead capture

Once purchase intent is detected, collect:

- Name
- Phone number
- Product or category of interest
- Budget
- Preferred storage
- Preferred colour
- New or pre-owned preference
- Payment preference
- Pickup or delivery preference
- Location
- Conversation source

### Human handover

The system should hand over when:

- The customer asks for a person.
- A discount is requested.
- Financing approval is required.
- A complaint is made.
- Product information is missing.
- Confidence is low.
- The customer is ready to pay.
- The issue is sensitive or complicated.

During handover:

1. Pause automated replies.
2. Assign or notify an available salesperson.
3. Show a concise conversation summary.
4. Allow staff to reply from the dashboard.
5. Allow staff to return the conversation to automation.

## Suggested Data Model

Codex should adapt this to the existing database rather than blindly duplicating tables.

### Products

Suggested fields:

- id
- name
- slug
- brand_id
- category_id
- model
- description
- condition
- warranty_months
- active
- website_url
- created_at
- updated_at

### Product Variants

Suggested fields:

- id
- product_id
- sku
- colour
- storage
- ram
- cost_price
- selling_price
- discounted_price
- stock_quantity
- reserved_quantity
- status

Availability should be calculated from real quantities where possible:

```text
available_quantity = stock_quantity - reserved_quantity
```

Suggested statuses:

- in_stock
- low_stock
- out_of_stock
- pre_order
- discontinued

### Product Specifications

Suggested fields:

- id
- product_id
- specification
- value

### Conversations

Suggested fields:

- id
- customer_id
- channel
- channel_reference
- status
- automation_enabled
- assigned_to
- last_message_at
- context_json
- created_at
- updated_at

Suggested statuses:

- new
- understanding_request
- showing_products
- collecting_details
- lead_created
- awaiting_human
- human_active
- closed

### Messages

Suggested fields:

- id
- conversation_id
- sender_type
- sender_id
- direction
- message_type
- body
- metadata_json
- external_message_id
- delivery_status
- created_at

### Leads

Suggested fields:

- id
- customer_id
- conversation_id
- product_variant_id
- source
- budget
- payment_preference
- delivery_preference
- location
- status
- assigned_to
- last_contacted_at
- next_follow_up_at
- notes

Suggested lead statuses:

- new
- qualified
- contacted
- negotiating
- awaiting_payment
- won
- lost

### Knowledge Base

Suggested fields:

- id
- title
- category
- content
- status
- effective_from
- effective_to
- approved_by
- updated_at

The knowledge base should contain approved information for:

- Shop locations
- Opening hours
- Delivery policy
- Warranty policy
- Returns
- Payment methods
- Lipa PolePole
- Repairs
- Trade-ins
- Contact information

## Recommendation Engine

The first version should use deterministic scoring rather than machine learning.

Example score:

- Budget fit: 30
- Requested brand: 20
- Condition preference: 15
- Camera priority: 10
- Battery priority: 10
- Storage requirement: 10
- Available stock: 5

The AI may explain results, but the application must select candidates using database rules.

## Channel Architecture

Create a channel-independent conversation service.

Suggested interface:

```php
interface MessagingChannel
{
    public function sendText(string $recipientId, string $message): void;

    public function sendProducts(string $recipientId, iterable $products): void;

    public function markAsRead(string $messageId): void;
}
```

Possible implementations:

- WebsiteChannel
- WhatsAppChannel
- InstagramChannel

The core conversation engine should not depend directly on any one channel.

## Website Chat

Build and validate the website assistant first.

Suggested endpoints:

```text
POST /api/chat/sessions
POST /api/chat/messages
GET  /api/chat/sessions/{session}
POST /api/chat/sessions/{session}/handover
POST /api/chat/sessions/{session}/close
```

Suggested processing flow:

1. Receive message.
2. Save original message.
3. Identify intent.
4. Extract structured filters.
5. Query verified data.
6. Generate a grounded response.
7. Save response.
8. Return response.
9. Trigger human handover when required.

Example structured extraction:

```json
{
  "intent": "product_recommendation",
  "brand": "Samsung",
  "maximum_budget": 40000,
  "condition": "new",
  "priorities": ["camera", "battery"]
}
```

## Shared Staff Inbox

The dashboard should provide:

- Conversation list
- Unread count
- Channel indicator
- Customer profile
- Lead details
- Product of interest
- AI or human status
- Assigned salesperson
- Internal notes
- Conversation summary
- Reply composer
- Handover controls
- Close or reopen controls
- Follow-up date
- Lead stage

## WhatsApp Integration

Add WhatsApp only after website chat is stable.

Expected implementation:

- Meta WhatsApp Cloud API
- Webhook verification
- Incoming message handling
- Outgoing message handling
- Message delivery status
- Read status
- Images and documents
- Interactive product choices
- Approved template messages
- Queue-based processing
- Idempotent webhook handling

The webhook should acknowledge quickly and dispatch processing to a queue.

## Instagram Integration

Add Instagram after the website and WhatsApp workflows are stable.

Expected support:

- Instagram professional account connection
- Incoming DMs
- Story replies where supported
- Staff responses from the shared inbox
- Source attribution
- Lead capture
- Comment-to-message workflows only where permitted by Meta

Do not rely on unofficial automation, browser bots, or credential scraping.

## Orders and Payments

Later phases can support:

```text
Lead
  -> Quotation
  -> Order
  -> Payment
  -> Fulfilment
  -> Delivery
```

For M-Pesa:

- STK Push
- Callback handling
- Transaction validation
- Order matching
- Receipt storage
- Reconciliation
- Idempotency
- Unique provider transaction reference

Repeated callbacks must not create duplicate payments.

## Trade-ins

The first trade-in feature should create an inspection request, not a guaranteed valuation.

Capture:

- Brand
- Model
- Storage
- Battery health
- Screen condition
- Repair history
- General condition
- Images
- Customer expected value

Any automated value must be labelled as an estimate and require staff inspection.

## Repairs

Suggested repair workflow:

```text
Ticket
  -> Device details
  -> Reported problem
  -> Diagnosis
  -> Quotation
  -> Customer approval
  -> Repair
  -> Quality check
  -> Collection or delivery
```

## Security Requirements

- Validate and sanitize all inbound webhook data.
- Verify webhook signatures where supported.
- Encrypt sensitive credentials.
- Never log access tokens or customer payment credentials.
- Restrict staff access using roles and permissions.
- Record audit logs for price, stock, lead, order, and payment changes.
- Use rate limiting on public endpoints.
- Protect all admin and inbox routes.
- Use idempotency for webhooks and payments.
- Avoid exposing internal product costs to customers.
- Separate internal notes from customer-visible messages.
- Comply with applicable Kenyan data-protection requirements.

## Testing Requirements

The project should include:

- Unit tests for recommendation scoring
- Unit tests for intent-to-filter mapping
- Feature tests for chat endpoints
- Feature tests for lead creation
- Feature tests for handover
- Feature tests for stock-aware responses
- Webhook signature tests
- Webhook duplicate-delivery tests
- Payment callback idempotency tests
- Role and permission tests
- Regression tests for existing website functionality

## Definition of Success for the First Milestone

Given this request:

```json
{
  "message": "I need an iPhone below 70k with at least 128GB"
}
```

The application should return only verified matching products:

```json
{
  "intent": "product_recommendation",
  "filters": {
    "brand": "Apple",
    "maximum_budget": 70000,
    "minimum_storage": 128
  },
  "products": [
    {
      "name": "Example iPhone",
      "condition": "Pre-owned",
      "storage": "128GB",
      "price": 68000,
      "stock_status": "in_stock"
    }
  ],
  "next_question": "Which colour would you prefer?"
}
```

The example product above is illustrative only. Tests must use actual catalogue records or fixtures.

## Codex Working Rules

1. Inspect first, then plan.
2. Preserve the existing website.
3. Reuse current models and services where sensible.
4. Do not introduce microservices for the MVP.
5. Do not hard-code product data into prompts.
6. Keep business rules in application code.
7. Keep channel integrations behind interfaces.
8. Queue long-running tasks.
9. Add tests with each feature.
10. Make small, reviewable commits.
11. Update project documentation after each phase.
12. Note assumptions and unresolved dependencies clearly.
