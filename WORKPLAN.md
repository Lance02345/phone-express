# Phone Express Kenya Automation Workplan

## Objective

Extend the existing Phone Express Kenya website into a centralized product-enquiry, lead-management, and sales-automation platform.

The work must begin with a repository audit because the website already exists and its codebase is available.

---

## Phase 0: Repository Audit and Technical Discovery

### Tasks

- Inspect the complete project structure.
- Identify the framework, language, and versions.
- Identify product, category, variant, stock, order, customer, and user models.
- Identify current authentication and authorization.
- Identify current admin screens.
- Identify the product source of truth.
- Identify how prices, sales prices, images, specifications, and stock are stored.
- Identify whether product variants already exist.
- Identify any existing checkout, order, delivery, and payment workflows.
- Identify current APIs and webhooks.
- Identify queues, caching, scheduled tasks, and background workers.
- Identify current deployment process and environment requirements.
- Identify current tests and code-quality tools.
- Identify analytics, SEO, and tracking integrations that must not be broken.
- Document technical risks and architectural constraints.

### Deliverables

- `docs/CODEBASE_AUDIT.md`
- `docs/CURRENT_ARCHITECTURE.md`
- `docs/DATA_MODEL.md`
- `docs/IMPLEMENTATION_DECISIONS.md`
- Proposed backlog based on the actual codebase

### Exit Criteria

- The current catalogue structure is understood.
- The product source of truth is confirmed.
- The safest extension points are identified.
- No major implementation begins before this phase is documented.

---

## Phase 1: Catalogue and Data Foundations

### Tasks

- Normalize or extend product data without breaking existing pages.
- Add or confirm support for product variants.
- Add or confirm SKU handling.
- Add stock quantity and reserved quantity where needed.
- Add explicit product condition.
- Add warranty metadata.
- Add searchable specifications.
- Add product status values.
- Add indexing for common product searches.
- Create an import or synchronization path if the catalogue comes from another source.
- Add audit logging for price and stock changes.
- Create a knowledge-base structure for approved company policies.
- Add roles and permissions needed for sales, catalogue, and administration.

### Suggested Outputs

- Product service
- Product search service
- Variant service
- Stock availability service
- Knowledge-base service
- CSV or API synchronization service
- Admin management screens

### Tests

- Product search
- Price filtering
- Storage filtering
- Brand filtering
- Stock availability
- Variant selection
- Product status
- Knowledge-base retrieval
- Authorization

### Exit Criteria

- Staff can manage products, variants, stock, and policies.
- The system can return verified product matches through application services.
- Existing website product pages still work.

---

## Phase 2: Conversation and Lead Domain

### Tasks

- Create customer records.
- Create conversations.
- Create messages.
- Create structured conversation context.
- Create lead records.
- Define conversation states.
- Define lead states.
- Implement assignment to staff.
- Implement internal notes.
- Implement conversation summaries.
- Implement human handover.
- Implement return-to-automation.
- Add notifications for new qualified leads.
- Add follow-up dates and reminders.
- Add source attribution.

### Suggested Conversation States

- new
- understanding_request
- showing_products
- collecting_details
- lead_created
- awaiting_human
- human_active
- closed

### Suggested Lead States

- new
- qualified
- contacted
- negotiating
- awaiting_payment
- won
- lost

### Tests

- Conversation creation
- Message persistence
- Lead creation
- Assignment
- Handover
- Automation pause
- Automation resume
- Internal note visibility
- Lead-stage transitions

### Exit Criteria

- A customer conversation can become a lead.
- Staff can take over and return a conversation to automation.
- Customer-visible messages and internal notes are clearly separated.

---

## Phase 3: Website Chat MVP

### Tasks

- Build a website chat widget matching the current site design.
- Create chat session endpoints.
- Create message endpoints.
- Connect the widget to the conversation domain.
- Add rate limiting.
- Add anonymous visitor handling.
- Add optional customer identification.
- Add typing and sending states.
- Add product-card responses.
- Add retry and error handling.
- Add mobile responsiveness.
- Add analytics events for chat opening, lead creation, handover, and completion.

### Suggested Endpoints

```text
POST /api/chat/sessions
POST /api/chat/messages
GET  /api/chat/sessions/{session}
POST /api/chat/sessions/{session}/handover
POST /api/chat/sessions/{session}/close
```

### Tests

- Session creation
- Anonymous user flow
- Product enquiry
- Invalid input
- Rate limits
- Lead capture
- Handover
- Product-card rendering
- Mobile layout
- Existing site regression

### Exit Criteria

- A website visitor can ask about products.
- The system can return stock-aware product results.
- The visitor can become a lead.
- Staff can take over the conversation.

---

## Phase 4: Intent Extraction and Grounded AI

### Tasks

- Create an AI provider abstraction.
- Define supported intents.
- Build structured output validation.
- Extract brand, budget, storage, colour, condition, and priorities.
- Map extracted data to application filters.
- Retrieve products before generating a response.
- Retrieve approved knowledge-base content.
- Generate answers only from retrieved data.
- Add confidence thresholds.
- Add fallback and handover rules.
- Add prompt and response logging without exposing sensitive information.
- Add token and cost tracking.
- Add protection against prompt injection.
- Add tests using mocked AI responses.

### Initial Supported Intents

- product_search
- product_recommendation
- product_comparison
- stock_question
- price_question
- warranty_question
- delivery_question
- payment_question
- shop_information
- repair_enquiry
- trade_in_enquiry
- human_request
- unsupported

### Grounding Rules

- Query the database before composing product answers.
- Never rely on the language model's memory for prices or specifications.
- Refuse to confirm stock when stock cannot be verified.
- Escalate discounts, financing, complaints, and final trade-in values.
- Store extracted context as structured data.

### Tests

- Structured extraction
- Invalid AI output
- Missing fields
- Budget filtering
- Stock grounding
- Knowledge grounding
- Low-confidence handover
- Prompt-injection resistance
- No-product-found flow

### Exit Criteria

- The assistant answers using verified catalogue and policy data.
- The assistant never invents price or stock.
- Low-confidence and sensitive cases are handed over.

---

## Phase 5: Recommendation Engine

### Tasks

- Implement deterministic scoring.
- Add budget-fit scoring.
- Add brand scoring.
- Add condition scoring.
- Add storage scoring.
- Add camera and battery preference scoring.
- Exclude unavailable products unless pre-order is explicitly allowed.
- Add explainable ranking output.
- Add configurable score weights.
- Add recommendation analytics.
- Add staff override capability.

### Tests

- Ranking
- Ties
- Out-of-stock exclusion
- Budget boundary
- Missing specifications
- Preference weighting
- Pre-owned versus new
- Empty result fallback

### Exit Criteria

- Recommendations are repeatable and explainable.
- The system can show best overall, best value, and best feature match.

---

## Phase 6: Shared Staff Inbox

### Tasks

- Build the conversation list.
- Add channel indicators.
- Add search and filters.
- Add unread counts.
- Add customer profile panel.
- Add lead panel.
- Add product-interest panel.
- Add assignment controls.
- Add reply composer.
- Add internal notes.
- Add AI summary.
- Add AI or human mode indicator.
- Add close and reopen.
- Add follow-up scheduling.
- Add staff notifications.
- Add activity audit trail.
- Add role-based access.

### Suggested Filters

- Channel
- Assigned staff member
- Unassigned
- Lead stage
- Unread
- Awaiting human
- Payment pending
- Follow-up due
- Closed

### Exit Criteria

- Sales staff can manage all website chats from one inbox.
- Supervisors can monitor assignment and response status.
- Conversations have traceable ownership.

---

## Phase 7: WhatsApp Business Integration

### Dependencies

- Meta Business account
- Verified business assets where required
- WhatsApp Business Account
- Approved phone number
- Access token strategy
- App permissions
- Public HTTPS webhook endpoint
- Message templates

### Tasks

- Create a WhatsApp channel adapter.
- Add webhook verification.
- Verify webhook signatures.
- Process incoming messages through queues.
- Handle duplicate webhook events.
- Send text responses.
- Send images and product information.
- Track sent, delivered, read, and failed statuses.
- Handle customer media.
- Support interactive selections where appropriate.
- Support approved templates for business-initiated messages.
- Add opt-in and opt-out handling.
- Add failure alerts and retry strategy.
- Map WhatsApp users to customers and conversations.

### Tests

- Webhook verification
- Signature verification
- Duplicate messages
- Delivery statuses
- Failed sends
- Media messages
- Interactive replies
- Opt-out
- Queue retries

### Exit Criteria

- WhatsApp messages appear in the same staff inbox.
- The same grounded conversation engine works on WhatsApp.
- Staff can take over WhatsApp conversations.

---

## Phase 8: Instagram Messaging Integration

### Dependencies

- Confirmed official Instagram account
- Professional account
- Correct Meta business connection
- Required permissions and access tokens

### Tasks

- Create Instagram channel adapter.
- Connect incoming DMs.
- Connect story replies where supported.
- Add message status handling where available.
- Display Instagram conversations in the shared inbox.
- Track Instagram as a lead source.
- Add safe comment-to-message workflows only where officially supported.
- Add access-token renewal and failure monitoring.

### Tests

- Account connection
- Incoming DM
- Staff reply
- Lead creation
- Duplicate event handling
- Token failure
- Source attribution

### Exit Criteria

- Instagram enquiries enter the same conversation and lead workflow.
- No unofficial browser automation is used.

---

## Phase 9: Quotation and Order Management

### Tasks

- Convert qualified leads into quotations.
- Add quotation lines and totals.
- Add discount approval rules.
- Convert quotations into orders.
- Add order statuses.
- Reserve stock.
- Release expired reservations.
- Add customer confirmation.
- Add invoice or receipt output where applicable.
- Add pickup and delivery details.
- Add cancellation and refund states.
- Add order audit trail.

### Suggested Order States

- draft
- awaiting_customer_confirmation
- awaiting_payment
- paid
- processing
- ready_for_pickup
- dispatched
- delivered
- cancelled
- refunded

### Exit Criteria

- A conversation can progress into a controlled order workflow.
- Stock reservations prevent overselling.

---

## Phase 10: M-Pesa Integration

### Tasks

- Confirm payment provider and credentials.
- Implement STK Push.
- Implement callback endpoint.
- Verify callback authenticity where supported.
- Add idempotency.
- Match payments to orders.
- Handle partial, duplicate, failed, and delayed payments.
- Store transaction references.
- Add reconciliation tools.
- Notify staff and customers.
- Prevent duplicate order updates.
- Add monitoring and alerts.

### Tests

- Successful payment
- Failed payment
- Cancelled request
- Delayed callback
- Duplicate callback
- Unknown order
- Amount mismatch
- Partial payment
- Reconciliation

### Exit Criteria

- Payment confirmation updates orders automatically.
- Duplicate callbacks cannot duplicate payments.

---

## Phase 11: Delivery Workflow

### Tasks

- Add pickup and delivery options.
- Capture delivery location and contact information.
- Add dispatch statuses.
- Add rider or courier assignment.
- Send automated status notifications.
- Add proof of dispatch.
- Add proof of delivery.
- Add failed-delivery handling.
- Add delivery reporting.
- Integrate courier APIs only after the internal workflow is stable.

### Exit Criteria

- Staff can manage delivery progression.
- Customers receive clear updates.

---

## Phase 12: Trade-in Requests

### Tasks

- Create trade-in request model.
- Capture phone details.
- Capture condition details.
- Accept images.
- Add staff inspection status.
- Add estimated-value range.
- Add final staff-approved value.
- Link approved trade-in to a quotation or order.
- Add disclaimers.
- Add audit history.

### Important Rule

Automated values are estimates only. Final valuation requires staff inspection.

### Exit Criteria

- Customers can submit a structured trade-in request.
- Staff can inspect, approve, revise, or decline it.

---

## Phase 13: Repairs

### Tasks

- Create repair tickets.
- Capture device and customer details.
- Capture reported issue.
- Add diagnosis.
- Add quotation.
- Add customer approval.
- Assign technician.
- Track parts.
- Track repair status.
- Add collection or delivery.
- Add repair notifications.
- Add repair history.

### Exit Criteria

- Repair enquiries become traceable service tickets.
- Customers can receive status updates.

---

## Phase 14: Marketing and Follow-up Automation

### Tasks

- Add customer segmentation.
- Add abandoned-enquiry follow-up.
- Add pending-payment reminders.
- Add post-purchase accessory offers.
- Add warranty reminders.
- Add upgrade campaigns.
- Add review requests.
- Add opt-out and communication preferences.
- Add campaign performance reporting.
- Use approved WhatsApp templates where required.

### Exit Criteria

- Staff can run targeted, permission-aware follow-ups.
- Campaigns are based on verified customer and purchase data.

---

## Phase 15: Reports and Owner Dashboard

### Suggested Metrics

- Enquiries by channel
- Qualified leads
- Conversion rate
- Response time
- Human handover rate
- Leads by staff member
- Leads by product and brand
- Most requested products
- No-stock requests
- Lost-lead reasons
- Orders
- Revenue
- Pending payments
- Delivery status
- Low stock
- Repair turnaround
- Trade-in conversion
- Campaign performance

### Deliverables

- Daily dashboard
- Weekly summary
- Exportable reports
- Optional scheduled email or WhatsApp summary

### Exit Criteria

- Management can understand enquiry, lead, sales, and operational performance.

---

## Immediate Codex Execution Plan

Codex should begin with the following sequence:

### Step 1

Create the repository audit documents.

### Step 2

Identify the current product and stock source of truth.

### Step 3

Propose database and service changes using the existing architecture.

### Step 4

Implement one application service that accepts structured filters and returns verified matching products.

Example input:

```json
{
  "brand": "Apple",
  "maximum_budget": 70000,
  "minimum_storage": 128,
  "condition": "pre_owned"
}
```

### Step 5

Add automated tests for that service.

### Step 6

Expose the service through an internal or public API endpoint.

### Step 7

Implement the first website-chat vertical slice:

```text
Visitor message
  -> intent extraction
  -> product query
  -> grounded response
  -> message persistence
  -> lead capture
  -> human handover
```

### Step 8

Create the basic shared inbox.

### Step 9

Validate the MVP internally before starting WhatsApp or Instagram.

---

## First Vertical-Slice Acceptance Criteria

The first complete feature should satisfy all of the following:

- A website visitor can open a chat session.
- The visitor can ask for a phone by budget, brand, or storage.
- The system extracts structured filters.
- The system queries the real catalogue.
- Out-of-stock products are not presented as available.
- Prices come from the database.
- The system asks a useful next question.
- The conversation is stored.
- Customer details can be captured.
- A lead can be created.
- Staff can take over.
- Automated responses stop during handover.
- Tests cover the full flow.

---

## Technical Quality Checklist

- Use existing project conventions.
- Keep changes modular.
- Avoid unnecessary packages.
- Add migrations safely.
- Add database indexes.
- Use queues for slow work.
- Add retry policies.
- Add idempotency.
- Add audit logs.
- Add role-based permissions.
- Add validation.
- Add rate limiting.
- Add structured logs.
- Add automated tests.
- Preserve backwards compatibility.
- Document configuration.
- Document environment variables.
- Document deployment steps.
- Document rollback steps.

---

## Environment Variables to Plan For

Exact names should follow the current project conventions.

```text
AI_PROVIDER
AI_API_KEY
AI_MODEL
META_APP_ID
META_APP_SECRET
META_VERIFY_TOKEN
WHATSAPP_PHONE_NUMBER_ID
WHATSAPP_BUSINESS_ACCOUNT_ID
WHATSAPP_ACCESS_TOKEN
INSTAGRAM_ACCOUNT_ID
MPESA_CONSUMER_KEY
MPESA_CONSUMER_SECRET
MPESA_SHORTCODE
MPESA_PASSKEY
MPESA_CALLBACK_URL
QUEUE_CONNECTION
REDIS_HOST
```

Do not commit credentials.

---

## Project Risks

- Existing catalogue data may not be normalized.
- Stock may not currently be maintained accurately.
- Product variants may be stored only in descriptions.
- Meta approvals may delay WhatsApp and Instagram.
- AI answers may become unreliable without strict grounding.
- Staff may continue using personal messaging accounts outside the system.
- Duplicate payment callbacks may cause incorrect order states.
- Trade-in values may be too variable for full automation.
- Marketing automation requires clear customer consent.
- Existing SEO and checkout flows can regress if changes are intrusive.

Each risk should have a documented mitigation during implementation.

---

## Recommended Delivery Order

1. Audit
2. Catalogue foundation
3. Conversation and leads
4. Website chat
5. Grounded AI
6. Recommendation engine
7. Staff inbox
8. WhatsApp
9. Instagram
10. Orders
11. M-Pesa
12. Delivery
13. Trade-ins
14. Repairs
15. Marketing
16. Reports

This order intentionally proves the core product before adding external channel and payment complexity.
