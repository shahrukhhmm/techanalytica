<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogFigmaContentSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::first() ?? User::factory()->create([
            'name' => 'Alex Rivera',
            'email' => 'alex@techanalytica.com',
            'password' => bcrypt('password'),
        ]);

        $categoriesData = [
            ['name' => 'Featured', 'slug' => 'featured', 'description' => 'Flagship deep dives, analyses, and system breakdowns.'],
            ['name' => 'Trends & Insights', 'slug' => 'trends-insights', 'description' => 'Emerging architectures and industry shifts.'],
            ['name' => 'Comparisons & Guides', 'slug' => 'comparisons-guides', 'description' => 'Technical evaluations and hands-on implementation playbooks.'],
            ['name' => 'News & PR', 'slug' => 'news-pr', 'description' => 'Regulatory updates, releases, and industry announcements.'],
            ['name' => 'Founder Stories', 'slug' => 'founder-stories', 'description' => 'Behind the scenes with AI software founders and engineering leaders.'],
            ['name' => 'Research & Data', 'slug' => 'research-data', 'description' => 'Empirical telemetry, cost indexes, and benchmark reports.'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = BlogCategory::firstOrCreate(
                ['slug' => $c['slug']],
                ['name' => $c['name'], 'description' => $c['description']]
            );
        }

        $posts = [
            // Hero Story
            [
                'title' => 'The 2026 State of Generative AI Spend and LLM Economics in Production',
                'slug' => '2026-state-generative-ai-spend-llm-economics',
                'category_slug' => 'research-data',
                'meta_description' => 'An investigation into real unit economics, cost curves, and routing architectures powering 200+ enterprise AI stacks.',
                'body' => '<p>An in-depth investigation into unit economics, token cost curves, and routing architectures powering 200+ enterprise AI stacks in 2026.</p><p>As production volumes surge, engineering teams are transitioning from naive API calls to layered tiered routing, aggressive semantic caching, and specialized compact models.</p>',
                'published_at' => '2026-01-15 10:00:00',
            ],
            // Featured Main
            [
                'title' => 'The quiet rewrite: how small teams are out-shipping the giants in 2026',
                'slug' => 'the-quiet-rewrite-how-small-teams-out-shipping-giants-2026',
                'category_slug' => 'featured',
                'meta_description' => 'How lean teams of 3–5 engineers are building defensible, revenue-generating AI systems without raising mega-rounds or hiring 50 ML PhDs.',
                'body' => '<p>In 2026, the velocity advantage belongs to lean teams. By combining foundational models with composable agent harnesses, small squads of 3–5 engineers are delivering software that historically required massive organizations.</p>',
                'published_at' => '2026-01-14 09:30:00',
            ],
            // Trends & Insights 1
            [
                'title' => 'Beyond RAG: how agentic loops actually divide workflows',
                'slug' => 'beyond-rag-how-agentic-loops-divide-workflows',
                'category_slug' => 'trends-insights',
                'meta_description' => 'Why semantic chunking and re-ranking are hitting ceiling limits, and what comes next.',
                'body' => '<p>Standard retrieval-augmented generation is hitting diminishing returns for complex enterprise data. Agentic loops break down large requests into atomic tool-driven steps with verification gates.</p>',
                'published_at' => '2026-01-13 14:00:00',
            ],
            // Trends & Insights 2
            [
                'title' => "Why chat interfaces are dying (and what's replacing them in 2026)",
                'slug' => 'why-chat-interfaces-are-dying-replacements-2026',
                'category_slug' => 'trends-insights',
                'meta_description' => "Natural language is a terrible UI for structured tasks. Here is the canvas-first future.",
                'body' => '<p>Chat is conversational, but terrible for editing, comparing, and structuring complex artifacts. In 2026, the industry is converging on hybrid canvas and inline assist paradigms.</p>',
                'published_at' => '2026-01-12 11:20:00',
            ],
            // Trends & Insights 3
            [
                'title' => 'Guardrails are not a silver bullet: real-world evasion benchmarks',
                'slug' => 'guardrails-not-silver-bullet-evasion-benchmarks',
                'category_slug' => 'trends-insights',
                'meta_description' => 'Testing automated jailbreaks against enterprise LLM wrappers and defensive filters.',
                'body' => '<p>We stress-tested 15 prominent AI guardrail frameworks with automated adversarial fuzzing. Here is what bypassed detection and how to patch vulnerabilities.</p>',
                'published_at' => '2026-01-10 16:45:00',
            ],
            // Trends & Insights 4
            [
                'title' => 'When to fine-tune vs when to prompt-engineer: a 2026 decision tree',
                'slug' => 'when-to-fine-tune-vs-prompt-engineer-decision-tree',
                'category_slug' => 'trends-insights',
                'meta_description' => 'Quantifying cost vs latency tradeoffs before training your own LoRA adapters.',
                'body' => '<p>A practical engineering rubric for choosing between in-context few-shot prompting, retrieval augmentation, and parameter-efficient fine-tuning.</p>',
                'published_at' => '2026-01-08 12:00:00',
            ],
            // Comparisons & Guides 1
            [
                'title' => 'LangChain vs LlamaIndex vs Haystack: the 2026 Enterprise Evaluation',
                'slug' => 'langchain-vs-llamaindex-vs-haystack-2026-enterprise-evaluation',
                'category_slug' => 'comparisons-guides',
                'meta_description' => 'Benchmark results & latency breakdowns across retrieval, memory management, and production readiness.',
                'body' => '<p>A comprehensive benchmark comparing framework overhead, type safety, observability integrations, and pipeline latency at scale.</p>',
                'published_at' => '2026-01-11 08:30:00',
            ],
            // Comparisons & Guides 2
            [
                'title' => 'Fine-tuning Mistral vs LLaMA 3 for niche vertical domain QA',
                'slug' => 'fine-tuning-mistral-vs-llama3-niche-vertical-domain-qa',
                'category_slug' => 'comparisons-guides',
                'meta_description' => 'Dataset curation, LoRA configs & cost analysis on specialized medical and legal datasets.',
                'body' => '<p>Comparing adapter convergence, catastrophic forgetting, and inference cost when adapting open weights to proprietary domain corpora.</p>',
                'published_at' => '2026-01-09 15:10:00',
            ],
            // Comparisons & Guides 3
            [
                'title' => '10 AI tools for automated code reviews that dev teams actually use',
                'slug' => '10-ai-tools-automated-code-reviews-dev-teams-use',
                'category_slug' => 'comparisons-guides',
                'meta_description' => 'Comparison matrix, pricing, and GitHub integrations evaluated by active engineering teams.',
                'body' => '<p>We evaluated 10 code intelligence tools across false-positive rates, security vulnerability detection, and pull request latency.</p>',
                'published_at' => '2026-01-07 10:00:00',
            ],
            // Comparisons & Guides 4
            [
                'title' => 'How we cut our vector DB bills by 73% without sacrificing recall',
                'slug' => 'cut-vector-db-bills-73-percent-without-sacrificing-recall',
                'category_slug' => 'comparisons-guides',
                'meta_description' => 'Quantization, hybrid search, and cache layers implemented in production.',
                'body' => '<p>Step-by-step breakdown of how scalar quantization, approximate nearest neighbor index tuning, and semantic caching reduced infrastructure overhead.</p>',
                'published_at' => '2026-01-05 13:40:00',
            ],
            // Comparisons & Guides 5
            [
                'title' => 'Evaluating enterprise AI agents: governance, eval harnesses, and guardrails',
                'slug' => 'evaluating-enterprise-ai-agents-governance-eval-harnesses-guardrails',
                'category_slug' => 'comparisons-guides',
                'meta_description' => 'Framework comparison & implementation playbook for autonomous agent safety.',
                'body' => '<p>How to design automated test suites, drift monitors, and safety boundaries for multi-step AI agents operating in enterprise environments.</p>',
                'published_at' => '2026-01-03 17:00:00',
            ],
            // News & PR 1
            [
                'title' => 'European Union AI Office Releases Final Model Safety Rules, Outlining High-Impact Thresholds',
                'slug' => 'eu-ai-office-releases-final-model-safety-rules',
                'category_slug' => 'news-pr',
                'meta_description' => 'New compliance obligations for foundation models exceeding 10^25 FLOPs take effect in Q3.',
                'body' => '<p>Regulators in Brussels have finalized the code of practice for general-purpose AI models, establishing technical auditing standards for compute thresholds.</p>',
                'published_at' => '2026-01-12 09:00:00',
            ],
            // News & PR 2
            [
                'title' => 'Open-weights model adoption jumps 140% in enterprise stacks during Q4 2025, survey finds',
                'slug' => 'open-weights-model-adoption-jumps-140-percent',
                'category_slug' => 'news-pr',
                'meta_description' => 'Cost predictability and data sovereignty drive enterprise migrations from closed APIs.',
                'body' => '<p>A survey of 600 tech executives indicates private cloud deployment of open-weights models is outpacing proprietary SaaS APIs for sensitive workflows.</p>',
                'published_at' => '2026-01-10 14:15:00',
            ],
            // News & PR 3
            [
                'title' => 'New standard protocol for tool-use in LLMs proposed by consortium of 30+ AI startups',
                'slug' => 'new-standard-protocol-tool-use-llms-proposed',
                'category_slug' => 'news-pr',
                'meta_description' => 'A unified schema aiming to standardize function calling across open and proprietary models.',
                'body' => '<p>The OpenAgent Protocol seeks to replace fragmented JSON schemas with a single cross-provider interface definition language for tool calling.</p>',
                'published_at' => '2026-01-08 11:30:00',
            ],
            // News & PR 4
            [
                'title' => 'Database engine vendors race to integrate native vector storage and semantic clustering into core kernels',
                'slug' => 'database-engine-vendors-race-native-vector-storage',
                'category_slug' => 'news-pr',
                'meta_description' => 'General-purpose relational and document databases challenge dedicated vector databases.',
                'body' => '<p>Native HNSW indexing and SIMD vector operations are becoming standard features in mainline SQL and NoSQL engines, simplifying data architectures.</p>',
                'published_at' => '2026-01-05 16:20:00',
            ],
            // News & PR 5
            [
                'title' => 'Survey: 68% of enterprise engineering teams have deployed at least one customer-facing AI feature in 2025',
                'slug' => 'survey-68-percent-enterprise-teams-deployed-customer-facing-ai',
                'category_slug' => 'news-pr',
                'meta_description' => 'Customer support, smart search, and code assistance lead real-world production deployments.',
                'body' => '<p>Adoption metrics reveal widespread integration of generative capabilities, with return on investment stabilizing around workflow automation.</p>',
                'published_at' => '2026-01-02 10:00:00',
            ],
            // Founder Stories 1
            [
                'title' => 'How we bootstrapped an agentic dev platform to $2M ARR with zero seed funding',
                'slug' => 'bootstrapped-agentic-dev-platform-2m-arr-zero-seed-funding',
                'category_slug' => 'founder-stories',
                'meta_description' => 'Focusing on deterministic reliability over open-ended chat proved to be the wedge enterprise buyers actually wanted.',
                'body' => '<p>Prism AI founder Marcus Chen shares lessons on building without venture capital, pricing for enterprise procurement, and optimizing model reliability.</p>',
                'published_at' => '2026-01-11 12:00:00',
            ],
            // Founder Stories 2
            [
                'title' => 'Why we killed our AI chatbot and rebuilt a native desktop workflow app instead',
                'slug' => 'why-we-killed-ai-chatbot-rebuilt-native-desktop-app',
                'category_slug' => 'founder-stories',
                'meta_description' => 'Our retention was 8% on web. When we built keyboard-first OS integrations, retention shot up to 64%.',
                'body' => '<p>Nexus AI co-founder Sarah Lin explains why conversational web interfaces failed user retention benchmarks and how native OS hotkeys solved the problem.</p>',
                'published_at' => '2026-01-09 17:30:00',
            ],
            // Founder Stories 3
            [
                'title' => 'The 5 fatal mistakes we made while building an LLM orchestration layer',
                'slug' => '5-fatal-mistakes-building-llm-orchestration-layer',
                'category_slug' => 'founder-stories',
                'meta_description' => 'Premature abstraction, naive retry loops, and ignoring token caching cost us $40k in unnecessary cloud compute.',
                'body' => '<p>ComputeStack VP David Vance breaks down the technical debt and routing inefficiencies that drained their compute budget in early production.</p>',
                'published_at' => '2026-01-07 14:40:00',
            ],
            // Founder Stories 4
            [
                'title' => 'The architecture that survived our first 10 million daily inference calls',
                'slug' => 'architecture-survived-first-10-million-daily-inference-calls',
                'category_slug' => 'founder-stories',
                'meta_description' => 'How streaming WebSockets, regional edge routers, and Redis semantic caching kept P99 latency under 240ms.',
                'body' => '<p>Synapse principal architect Tanya Meyer documents their high-throughput inference proxy layer and fallback strategies across GPU regions.</p>',
                'published_at' => '2026-01-04 11:15:00',
            ],
            // Research & Data 1
            [
                'title' => 'Annual AI Operations Report 2026',
                'slug' => 'annual-ai-operations-report-2026',
                'category_slug' => 'research-data',
                'meta_description' => '1,200+ engineering leaders surveyed on compute spend, model governance, latency budgets, and tooling consolidation.',
                'body' => '<p>The authoritative annual report benchmarking enterprise AI infrastructure spend, GPU availability, and model evaluation protocols.</p>',
                'published_at' => '2026-01-13 08:00:00',
            ],
            // Research & Data 2
            [
                'title' => 'LLM Inference Cost Index: Q1 2026 Pricing Changes and Provider Margins',
                'slug' => 'llm-inference-cost-index-q1-2026-pricing-margins',
                'category_slug' => 'research-data',
                'meta_description' => 'Pricing dynamics across 18 cloud providers, token deflation trends, and hardware cost per million tokens.',
                'body' => '<p>Quarterly tracking of raw inference pricing across leading API providers and private cloud hosting options.</p>',
                'published_at' => '2026-01-11 15:00:00',
            ],
            // Research & Data 3
            [
                'title' => 'The 2026 State of Vector Databases: Latency, Recall, and Cost Benchmarks',
                'slug' => '2026-state-vector-databases-latency-recall-cost-benchmarks',
                'category_slug' => 'research-data',
                'meta_description' => 'Independent testing of 8 vector engines under 100M+ vector workloads with varying dimension sizes.',
                'body' => '<p>Comprehensive latency vs recall trade-off curves under heavy concurrent ingestion and query workloads.</p>',
                'published_at' => '2026-01-09 13:20:00',
            ],
            // Research & Data 4
            [
                'title' => 'Survey: How 400 Engineering Teams Structure Their Production AI Stacks',
                'slug' => 'survey-how-400-engineering-teams-structure-production-ai-stacks',
                'category_slug' => 'research-data',
                'meta_description' => 'Framework choices, evaluation harnesses, vector storage, and orchestration layers used in live software.',
                'body' => '<p>Data on what tools engineering teams actually deploy to production versus test in experimental sandboxes.</p>',
                'published_at' => '2026-01-04 10:45:00',
            ],
            // Research & Data 5
            [
                'title' => 'Enterprise AI Governance Playbook: Audit Trails, Evals, and Red Teaming',
                'slug' => 'enterprise-ai-governance-playbook-audit-trails-evals-red-teaming',
                'category_slug' => 'research-data',
                'meta_description' => 'Compliance protocols, automated logging, and adversarial evaluation harnesses for enterprise compliance.',
                'body' => '<p>Practical implementation blueprint for complying with enterprise security, privacy, and regulatory audit demands.</p>',
                'published_at' => '2025-12-29 16:00:00',
            ],
        ];

        foreach ($posts as $p) {
            $cat = $categories[$p['category_slug']] ?? null;
            Blog::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'category_id' => $cat?->id,
                    'author_id' => $author->id,
                    'meta_title' => $p['title'] . ' | TechAnalytica',
                    'meta_description' => $p['meta_description'],
                    'body' => $p['body'],
                    'status' => 'published',
                    'published_at' => $p['published_at'],
                ]
            );
        }
    }
}
