<p align="center">
  <img src="public/assets/img/logo/techanalytica-logo.png" alt="TechAnalytica Logo" height="60px" onerror="this.style.display='none'">
</p>

<h1 align="center">TechAnalytica</h1>

<p align="center">
  <strong>The independent B2B SaaS intelligence platform — scoring, ranking, and comparing software tools with a deterministic, tamper-proof methodology.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red?logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-purple?logo=bootstrap" alt="Bootstrap">
  <img src="https://img.shields.io/badge/TA_Score-v1.0-green" alt="TA Score v1.0">
  <img src="https://img.shields.io/badge/License-MIT-lightgrey" alt="MIT License">
</p>

---

## Table of Contents

1. [What is TechAnalytica?](#what-is-techanalytica)
2. [Core Principles](#core-principles)
3. [Tech Stack](#tech-stack)
4. [Project Structure](#project-structure)
5. [Installation](#installation)
6. [Environment Configuration](#environment-configuration)
7. [Database Setup](#database-setup)
8. [TA Scoring Engine v1.0](#ta-scoring-engine-v10)
   - [Architecture](#architecture)
   - [The TA Score Formula](#the-ta-score-formula)
   - [8 Scoring Dimensions](#8-scoring-dimensions)
   - [Evidence Confidence Engine](#evidence-confidence-engine)
   - [Ranking Algorithm](#ranking-algorithm)
   - [Exception & Review Queue](#exception--review-queue)
   - [Audit Trail](#audit-trail)
9. [User Roles](#user-roles)
10. [Frontend Features](#frontend-features)
11. [Admin Panel Features](#admin-panel-features)
12. [Vendor Portal Features](#vendor-portal-features)
13. [Key Admin Routes — TA Scoring](#key-admin-routes--ta-scoring)
14. [Getting Started with Scoring](#getting-started-with-scoring)
15. [Commercial Integrity Guarantee](#commercial-integrity-guarantee)
16. [Roadmap](#roadmap)
17. [Contributing](#contributing)
18. [License](#license)

---

## What is TechAnalytica?

TechAnalytica is a **B2B SaaS review and intelligence platform** that helps knowledge-workers and buyers evaluate, compare, and choose software tools with confidence. Unlike affiliate-driven directories, TechAnalytica uses a **deterministic, rules-based scoring engine** (the TA Score) to evaluate products on objective, evidence-based criteria.

**Key differentiators:**
- ✅ TA Score is calculated by a deterministic algorithm — never assigned by a human or AI model
- ✅ Paid plans, sponsorships, and vendor spend never affect TA Score or organic category rank
- ✅ Every score, rank, and data change is recorded in a tamper-evident audit log
- ✅ Vendors can submit factual corrections with evidence; accepted corrections trigger automatic recalculation
- ✅ Full methodology versioning — historical scores are always reproducible

---

## Core Principles

| Principle | Rule |
|-----------|------|
| **Deterministic Scoring** | Same inputs → same score, always. The engine is pure PHP logic with no randomness. |
| **AI Boundary** | AI may collect and structure evidence. AI must never assign the final TA Score. |
| **Commercial Neutrality** | Paid plans, sponsorships, advertising, affiliates, and vendor spend are forbidden scoring inputs. |
| **Auditability** | Every data change, score run, publish, and correction is logged with actor, timestamp, before/after state. |
| **Reproducibility** | All score runs are linked to a `MethodologyVersion`. Old scores can be exactly reproduced. |
| **Confidence Transparency** | Every public TA Score displays a confidence label (High / Moderate / Low) so buyers know how much evidence supports the evaluation. |

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 8.2+, Laravel 11.x |
| **Frontend** | Blade templates, Bootstrap 5.3, Vanilla CSS, Vite |
| **Admin UI** | Sneat Bootstrap 5 Admin Template |
| **Database** | MySQL 8.0 |
| **Icons** | Boxicons |
| **Charts** | Chart.js 4.x |
| **Auth** | Laravel Breeze / built-in auth |
| **Dev Server** | XAMPP (Apache + MySQL) |
| **Asset Build** | Vite + Yarn |

---

## Project Structure

```
techanalytica/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── backend/
│   │       │   ├── admin/              ← Admin panel controllers
│   │       │   │   ├── ScoringController.php   ← TA Scoring Engine admin
│   │       │   │   ├── ToolController.php
│   │       │   │   ├── CategoryController.php
│   │       │   │   ├── ReviewController.php
│   │       │   │   ├── UserController.php
│   │       │   │   └── ...
│   │       │   └── vendor/            ← Vendor portal controllers
│   │       └── frontend/
│   │           ├── PageController.php
│   │           └── VendorCorrectionController.php  ← Public correction form
│   ├── Models/
│   │   ├── Tool.php                   ← Core product model (with TA Score accessor)
│   │   ├── Category.php
│   │   ├── User.php
│   │   ├── Review.php
│   │   │
│   │   ├── ─── TA Scoring Models ───
│   │   ├── MethodologyVersion.php     ← Versioned scoring weights
│   │   ├── CategoryTemplate.php       ← Per-category evaluation requirements
│   │   ├── EvidenceSource.php         ← Approved evidence URLs
│   │   ├── EvidenceItem.php           ← Extracted facts with provenance
│   │   ├── ProductFact.php            ← Current validated scoring inputs
│   │   ├── ReviewAggregate.php        ← External review data (G2, Gartner, etc.)
│   │   ├── ScoreRun.php               ← Immutable score history
│   │   ├── ScoreBreakdown.php         ← Sub-criterion audit trail
│   │   ├── RankSnapshot.php           ← Monthly category rank history
│   │   ├── ReviewException.php        ← Founder review queue
│   │   ├── VendorCorrection.php       ← Vendor factual correction requests
│   │   └── ScoringAuditLog.php        ← Complete audit trail
│   │
│   └── Services/
│       └── Scoring/
│           ├── TAScoringEngine.php    ← Core deterministic scoring engine
│           ├── ConfidenceEngine.php   ← Evidence confidence calculator
│           └── RankingService.php     ← Category ranking algorithm
│
├── database/
│   └── migrations/
│       └── 2026_10_01_000001_create_ta_scoring_tables.php
│
├── resources/views/
│   ├── backend/admin/
│   │   ├── scoring/                   ← All scoring admin views
│   │   │   ├── dashboard.blade.php
│   │   │   ├── show.blade.php
│   │   │   ├── exceptions.blade.php
│   │   │   ├── facts.blade.php
│   │   │   ├── templates.blade.php
│   │   │   ├── methodology.blade.php
│   │   │   ├── corrections.blade.php
│   │   │   ├── audit-log.blade.php
│   │   │   ├── leaderboard.blade.php
│   │   │   └── tool-history.blade.php
│   │   └── content/
│   │       ├── tools/
│   │       ├── categories/
│   │       └── ...
│   └── frontend/
│       └── pages/
│           ├── tools/
│           │   ├── correction.blade.php   ← Public vendor correction form
│           │   └── ...
│           └── ...
│
└── routes/
    └── web.php                        ← All routes including 24 scoring routes
```

---

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+ & Yarn
- XAMPP (or Apache + MySQL equivalent)

### Steps

```bash
# 1. Clone the repository
git clone <repository-url> techanalytica
cd techanalytica

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
yarn install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure .env (see section below)
# Edit .env with your DB credentials

# 7. Run all database migrations
php artisan migrate

# 8. Seed the default methodology version (required for scoring)
php artisan db:seed --class=MethodologyVersionSeeder
# Or manually via tinker — see "Getting Started with Scoring" below

# 9. Build frontend assets
yarn dev

# 10. Start the development server
php artisan serve
```

---

## Environment Configuration

Key `.env` variables:

```dotenv
APP_NAME=TechAnalytica
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techanalytica
DB_USERNAME=root
DB_PASSWORD=

# Storage for vendor correction file uploads
FILESYSTEM_DISK=public
```

Run `php artisan storage:link` to expose the storage disk publicly.

---

## Database Setup

After configuring `.env`, run:

```bash
# All migrations (core platform + TA Scoring Engine tables)
php artisan migrate

# Seed the default TA Score v1.0 methodology (required before first score run)
php artisan tinker
```

Then in Tinker:

```php
use App\Models\MethodologyVersion;

MethodologyVersion::create([
    'version_name' => 'TA Score v1.0',
    'weights' => [
        'use_case_fit' => 0.25, 'ai_utility' => 0.15,
        'usability' => 0.15, 'workflow_fit' => 0.10,
        'value_pricing' => 0.10, 'trust_readiness' => 0.10,
        'customer_evidence' => 0.10, 'product_health' => 0.05
    ],
    'global_parameters' => [
        'bayesian_m' => 20,
        'recency_window_months' => 24,
        'confidence_thresholds' => ['high' => 80, 'moderate' => 60],
        'global_review_prior' => 65.0,
    ],
    'effective_date' => now(),
    'published_at' => now(),
    'is_active' => true,
]);
```

> **Note:** The 12 TA Scoring tables are created by migration `2026_10_01_000001_create_ta_scoring_tables.php`.

---

## TA Scoring Engine v1.0

The TA Scoring Engine is the analytical heart of TechAnalytica. It calculates an objective, deterministic score (0.0–10.0) for any software product within a specific category.

### Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    EVIDENCE LAYER                           │
│  EvidenceSource → EvidenceItem → ProductFact               │
│  ReviewAggregate (G2, Gartner Digital Markets, TrustRadius) │
└───────────────────────┬─────────────────────────────────────┘
                        │ validated facts feed into
┌───────────────────────▼─────────────────────────────────────┐
│               TAScoringEngine.php                           │
│  - Reads ProductFacts + CategoryTemplate requirements       │
│  - Runs 8-dimension weighted calculation                    │
│  - Applies Bayesian adjustment to customer evidence         │
│  - Detects exception triggers                               │
│  - Writes immutable ScoreRun + ScoreBreakdowns             │
└───────────────┬───────────────────┬─────────────────────────┘
                │                   │
    ┌───────────▼──────┐   ┌────────▼──────────────┐
    │ ConfidenceEngine │   │   RankingService       │
    │  High/Moderate/  │   │   Category rank sort   │
    │  Low label       │   │   + RankSnapshot       │
    └──────────────────┘   └───────────────────────┘
```

### The TA Score Formula

```
Internal Score (0–100) = Σ( dimension_normalized_score × dimension_weight )

Public TA Score (0.0–10.0) = round( InternalScore / 10, 1 )
```

The public score is **absolute** (not normalised against competitors). A competitor joining or leaving a category changes ranks but never changes another product's TA Score.

### 8 Scoring Dimensions

| # | Dimension | Weight | Key Sub-criteria |
|---|-----------|--------|-----------------|
| 1 | **Use-Case Fit & Capability Depth** | 25% | Core capability coverage, advanced capabilities, depth vs breadth |
| 2 | **AI Utility & Product Depth** | 15% | AI relevance, capability depth, control/transparency, differentiation |
| 3 | **Usability & Time to Value** | 15% | Onboarding quality, workflow clarity, time-to-first-value, adoption support |
| 4 | **Workflow & Integration Fit** | 10% | API/webhook presence, data export, extensibility, team fit |
| 5 | **Value & Pricing** | 10% | Pricing transparency, entry value, capability-to-price ratio, commercial flexibility |
| 6 | **Trust & Business Readiness** | 10% | Privacy/security, reliability, support quality, vendor governance |
| 7 | **Customer Evidence** | 10% | Bayesian-adjusted rating, review volume, recency, source diversity |
| 8 | **Product Health & Momentum** | 5% | Release cadence, maintenance activity, platform continuity |

**Weights always sum to exactly 1.0.** Any change to weights requires creating a new `MethodologyVersion`.

#### Customer Evidence — Bayesian Adjustment

To prevent gaming by products with few but perfect reviews, ratings are adjusted:

```
Bayesian_Rating = (m × C + n × R) / (m + n)

Where:
  m = prior strength (default: 20 reviews)
  C = global category prior (default: 65.0/100)
  n = actual review count for this source
  R = actual normalised rating (0–100)
```

**Capterra, GetApp, and Software Advice are treated as a single source family** (`gartner_digital_markets`) to prevent triple-counting.

**No zero for missing reviews** — if no external reviews exist, the category Bayesian prior is used.

#### Recency Weighting

| Review Age | Weight |
|-----------|--------|
| 0–6 months | 1.00 |
| 6–12 months | 0.85 |
| 12–18 months | 0.65 |
| 18–24 months | 0.45 |
| >24 months | 0.00 (excluded) |

### Evidence Confidence Engine

Every TA Score is accompanied by a **confidence label** (High / Moderate / Low) that describes how much current, corroborated evidence supports the evaluation.

| Component | Weight | Description |
|-----------|--------|-------------|
| Core criterion evidence coverage | 40% | % of required scoring inputs with at least one valid evidence item |
| Independent corroboration | 25% | % of claims confirmed by 2+ independent source families |
| Evidence freshness | 20% | Weighted freshness vs per-field TTLs (pricing: 30d, security: 90d, general: 60d) |
| Customer evidence sufficiency | 15% | Volume + source breadth + recency |

| Label | Threshold |
|-------|----------|
| **High** | ≥ 80 |
| **Moderate** | 60–79 |
| **Low** | < 60 |

> Products with Low Confidence are scored but shown as **Provisional** and may be excluded from ranked leaderboards.

### Ranking Algorithm

```
Sort order (all descending):
  1. public_score
  2. confidence_score          (tie-break 1)
  3. use_case_fit dimension    (tie-break 2)
  4. customer_evidence dimension (tie-break 3)
  5. Equal rank if still tied
```

- Scores within **0.1 points** after rounding are considered tied
- Ranks are persisted as monthly `RankSnapshot` records
- **Sponsorships, paid plans, and affiliate data are never read by the ranking service**

### Exception & Review Queue

The engine automatically flags score runs for human review when:

| Trigger | Condition |
|---------|----------|
| `score_change` | Public score changes by ≥ 0.7 points between runs |
| `rank_jump` | Category rank changes by ≥ 5 positions |
| `top_10_entry` | Product enters the top 10 for the first time |
| `confidence_drop` | Confidence score drops below 60 |
| `vendor_correction` | A vendor submits a factual correction request |
| `source_conflict` | Two evidence sources contradict each other |

Reviewers can **resolve** or **dismiss** exceptions, but they can never directly enter a TA Score. To change a score they must edit evidence/facts and trigger a re-calculation.

### Audit Trail

Every action is recorded in `scoring_audit_logs`:

- Who made the change (actor)
- What entity was changed (type + ID)
- What action was taken (create / update / delete / publish / resolve)
- Before and after state (JSON snapshots)
- Reason / resolution notes

---

## User Roles

| Role | Access |
|------|--------|
| **Admin / Founder** | Full access: scoring engine, all admin pages, user management, vendor management |
| **Editor** | Scoring dashboard, product facts, evidence management, exception queue |
| **Vendor** | Vendor portal: own tool listings, analytics, leads, blog posts |
| **Registered User** | Reviews, favorites, comparisons, correction submissions |
| **Guest** | Public tool listings, categories, leaderboard (read-only) |

---

## Frontend Features

- **Tool Discovery** — Browse and search thousands of B2B SaaS tools
- **Category Leaderboard** — Ranked by TA Score (paid plans never affect rank)
- **Tool Detail Pages** — Full score breakdown, evidence confidence badge, review history
- **Side-by-Side Comparison** — Compare up to 4 tools across all dimensions
- **User Reviews** — Star ratings and text reviews; moderated before publishing
- **Favorites** — Save tools to personal shortlists
- **Vendor Correction Form** — `/tools/{tool}/correction` — submit factual errors with evidence
- **Blog** — Industry analysis and tool category guides

---

## Admin Panel Features

Accessible at `/admin/` (admin/editor roles required):

| Section | URL | Description |
|---------|-----|-------------|
| **Scoring Dashboard** | `/admin/scoring` | Stats overview, score trigger, recent runs |
| **Score Run Detail** | `/admin/scoring/runs/{id}` | Dimension breakdown, sub-criterion audit, score history chart |
| **Exception Queue** | `/admin/scoring/exceptions` | Review flagged runs; resolve or dismiss |
| **Product Facts** | `/admin/scoring/tools/{id}/facts` | Enter/edit scoring inputs, evidence sources, review aggregates |
| **Category Templates** | `/admin/scoring/templates` | Define per-category core requirements |
| **Methodology Versions** | `/admin/scoring/methodology` | Manage scoring weights; creates new version on every change |
| **Vendor Corrections** | `/admin/scoring/corrections` | Review factual correction requests; accepted = auto-rescore |
| **Audit Log** | `/admin/scoring/audit-log` | Complete, filterable change history |
| **Category Leaderboard** | `/admin/scoring/ranks/{cat}/leaderboard` | Preview ranks, publish monthly snapshots |
| **Tool Management** | `/admin/tools` | CRUD for all tool listings |
| **Category Management** | `/admin/categories` | Manage product categories |
| **Reviews** | `/admin/reviews` | Moderate user reviews |
| **Users** | `/admin/users` | User management |
| **Vendors** | `/admin/vendors` | Vendor account management |

---

## Vendor Portal Features

Accessible at `/vendor/` (vendor role required):

- Dashboard with analytics summary
- Tool listing management (create/edit own tools)
- Blog post management
- Lead inbox
- Review responses
- Billing & subscription management

---

## Key Admin Routes — TA Scoring

```
GET    /admin/scoring                              → Dashboard
POST   /admin/scoring/score-product               → Score a single tool
POST   /admin/scoring/score-category/{category}   → Score all tools in a category
GET    /admin/scoring/runs/{scoreRun}              → Score run detail
POST   /admin/scoring/runs/{scoreRun}/publish     → Publish a score run
POST   /admin/scoring/runs/{scoreRun}/unpublish   → Unpublish a score run
GET    /admin/scoring/tools/{tool}/history         → Score history for a tool
GET    /admin/scoring/exceptions                   → Exception queue
PATCH  /admin/scoring/exceptions/{id}/resolve     → Resolve an exception
GET    /admin/scoring/tools/{tool}/facts           → Manage product facts
POST   /admin/scoring/tools/{tool}/facts           → Add/update a fact
DELETE /admin/scoring/tools/{tool}/facts/{fact}    → Delete a fact
POST   /admin/scoring/tools/{tool}/evidence-sources → Add evidence source
POST   /admin/scoring/evidence-sources/{src}/items  → Add evidence item
POST   /admin/scoring/tools/{tool}/review-aggregates → Add review aggregate
GET    /admin/scoring/templates                    → Category templates
POST   /admin/scoring/templates                    → Create template
GET    /admin/scoring/methodology                  → Methodology versions
POST   /admin/scoring/methodology                  → Create new version
GET    /admin/scoring/corrections                  → Vendor corrections
PATCH  /admin/scoring/corrections/{id}/resolve    → Resolve correction
GET    /admin/scoring/audit-log                    → Audit log
POST   /admin/scoring/ranks/{category}/publish    → Publish rank snapshot
GET    /admin/scoring/ranks/{category}/leaderboard → Preview leaderboard

# Public
GET    /tools/{tool}/correction                    → Correction form
POST   /tools/{tool}/correction                    → Submit correction
```

---

## Getting Started with Scoring

Follow these steps to score your first product:

### Step 1 — Create a Category Template
Navigate to **Admin → Scoring → Category Templates** → `New Template`

Enter the **core requirements** for the category (e.g. for "SEO Content Tools"):
```
Content analysis
Keyword/topic analysis
Optimization recommendations
SERP/competitive context
Content scoring/actionable prioritization
```

### Step 2 — Enter Product Facts
Navigate to **Admin → Scoring → Tools → [Tool Name] → Facts**

Add scoring inputs using the fact editor. Key field keys:

```
capability_depth_score      (0–100)
ai_relevance_score          (0–100)
has_api                     (true/false)
has_free_trial              (true/false)
pricing_public              (true/false)
has_privacy_policy          (true/false)
has_release_last_12m        (true/false)
onboarding_score            (0–100)
security_score              (0–100)
```

### Step 3 — Add External Review Aggregates
On the same Facts page → `Add Review Aggregate`

Enter data from:
- **G2** → source_family: `g2`
- **Capterra / GetApp / Software Advice** → source_family: `gartner_digital_markets` *(all three as one family)*
- **TrustRadius** → source_family: `trustradius`

### Step 4 — Run the Scoring Engine
On the Scoring Dashboard → select tool + category → click **Run Scoring Engine**

Use **Dry Run** first to preview the score without saving.

### Step 5 — Review & Publish
Navigate to the Score Run detail page → review the dimension breakdown and confidence label → click **Publish**

### Step 6 — Publish Category Ranks
**Admin → Scoring → Leaderboard → Publish Rank Snapshot**

---

## Commercial Integrity Guarantee

> **Paid plans, sponsorships, advertising, affiliate relationships, and vendor spend must never change TA Score or organic category rank.**

This is enforced architecturally:

1. **No score input field exists** in any admin UI — admins edit facts/evidence only
2. **Sponsorship data is never imported** into any scoring service or ranking service
3. **The `RankingService`** reads only `ScoreRun.public_score`, `confidence_score`, and dimension breakdowns
4. **Every change** is logged with actor identity and is auditable by any founder at `/admin/scoring/audit-log`
5. **Score runs are immutable** — never updated in place; each run creates a new record

---

## Roadmap

### Phase 1 — Foundation ✅ (Complete)
- [x] TA Scoring Engine v1.0 (deterministic, 8-dimension)
- [x] Evidence Confidence Engine (High/Moderate/Low)
- [x] Ranking Service with tie-breaking algorithm
- [x] Admin scoring dashboard + all management views
- [x] Exception queue with auto-triggers
- [x] Vendor correction flow (public + admin)
- [x] Complete audit trail
- [x] Methodology version system
- [x] Category template system
- [x] Bayesian-adjusted customer evidence

### Phase 2 — Evidence Automation (Planned)
- [ ] AI evidence extractor (Module B) — writes to `product_facts` and `evidence_items`
- [ ] Scheduled source refresh jobs with per-field TTLs
- [ ] Automated monthly scoring runs via Laravel Queue
- [ ] Source conflict detection and auto-flagging

### Phase 3 — Public-Facing (Planned)
- [ ] TA Score badge on public tool detail pages
- [ ] Score breakdown panel (dimension bars) visible to users
- [ ] "How TechAnalytica Scores Software" public methodology page
- [ ] Score history chart on public tool profiles
- [ ] Confidence badge tooltip explaining evidence quality

### Phase 4 — Scale (Future)
- [ ] API for scores and rankings (read-only, authenticated)
- [ ] Category market map visualizations
- [ ] Automated calibration reports
- [ ] Multi-language support

---

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Commit your changes: `git commit -m 'feat: add your feature'`
4. Push to the branch: `git push origin feature/your-feature`
5. Open a Pull Request

### Contribution Rules — Scoring Engine

> ⚠️ **Critical:** Any change to the scoring engine must:
> - Not introduce any non-deterministic behaviour (no `random`, no LLM calls)
> - Not read sponsorship, advertising, or billing data
> - Create a new `MethodologyVersion` if weights are changed
> - Add entries to `scoring_audit_logs` for every state change
> - Pass the weights-sum-to-1.0 validation

---

## License

MIT License — see [LICENSE](LICENSE) for details.

---

<p align="center">
  Built with ❤️ for B2B software buyers who deserve independent, tamper-proof intelligence.
</p>
