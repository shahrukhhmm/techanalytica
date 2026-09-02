<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\PricingTier;
use App\Models\Review;
use App\Models\Tool;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Author / Admin Users if not present
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Alex Rivera',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified' => true,
            ]
        );

        $vendorUser = User::firstOrCreate(
            ['email' => 'salesforce@vendor.com'],
            [
                'name' => 'Salesforce Rep',
                'password' => Hash::make('12345678'),
                'role' => 'vendor',
                'email_verified' => true,
            ]
        );

        $vendor = Vendor::firstOrCreate(
            ['user_id' => $vendorUser->id],
            [
                'company_name' => 'Salesforce, Inc.',
                'billing_email' => 'billing@salesforce.com',
                'company_website' => 'https://salesforce.com',
            ]
        );

        $proTier = PricingTier::where('name', 'Pro Yearly')->first() ?? PricingTier::firstOrCreate(
            ['name' => 'Pro Yearly'],
            [
                'monthly_price' => 24.00,
                'annual_price' => 290.00,
                'features' => ['3 Tool Listing Slots', 'Verified Badge', 'Priority TechScore', 'Advanced Analytics'],
                'permissions' => ['manage_pricing', 'manage_features', 'view_analytics', 'manage_reviews', 'featured_listing'],
            ]
        );

        // 2. Categories
        $categoriesData = [
            [
                'name' => 'CRM Software',
                'slug' => 'crm-software',
                'description' => 'Customer Relationship Management platforms for enterprise sales and SMB pipelines.',
            ],
            [
                'name' => 'Development & Code AI',
                'slug' => 'development',
                'description' => 'Intelligent copilots, terminal agents, automated refactoring, and code generation.',
            ],
            [
                'name' => 'Design & Graphics',
                'slug' => 'design-graphics',
                'description' => 'AI image generators, vector art, UI mockups, and neural rendering engines.',
            ],
            [
                'name' => 'Marketing & Growth',
                'slug' => 'marketing',
                'description' => 'Omnichannel attribution, ad creative synthesis, and conversion rate optimization.',
            ],
            [
                'name' => 'Copywriting & SEO',
                'slug' => 'copywriting',
                'description' => 'Autonomous content writing, keyword clustering, and search ranking tools.',
            ],
            [
                'name' => 'Analytics & Data',
                'slug' => 'analytics',
                'description' => 'Predictive dashboards, automated churn analytics, and data pipeline orchestrators.',
            ],
            [
                'name' => 'Productivity & Automation',
                'slug' => 'productivity',
                'description' => 'Workflow triggers, prompt engineering pipelines, and multi-agent coordination.',
            ],
            [
                'name' => 'Enterprise SaaS',
                'slug' => 'enterprise-saas',
                'description' => 'Multi-tenant infrastructure, compliance filters, and enterprise ERP tools.',
            ],
        ];

        $categoryModels = [];
        foreach ($categoriesData as $catData) {
            $categoryModels[$catData['slug']] = Category::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 3. Featured Tools & CRM Platforms
        $toolsData = [
            [
                'name' => 'Salesforce Sales Cloud',
                'slug' => 'salesforce-sales-cloud',
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'The enterprise CRM platform engineered for AI-driven pipeline automation, revenue forecasting, and global sales operations.',
                'long_description' => 'Salesforce Sales Cloud is the industry-standard customer relationship management platform engineered to synchronize sales, marketing, service, and revenue operations into a single scalable data foundation. Built on multi-tenant cloud infrastructure with enterprise-grade encryption and granular role hierarchies, it processes over 5 billion daily transaction events across global deployments.',
                'website_url' => 'https://www.salesforce.com',
                'pricing_text' => '$25 / user / mo',
                'pricing_structured' => [
                    'starter' => ['name' => 'Starter', 'price' => '$25', 'desc' => 'Simplified CRM for small teams up to 10 users.', 'features' => ['Basic Lead & Deal Tracking', 'Email Integration', 'Mobile Access']],
                    'pro' => ['name' => 'Professional', 'price' => '$80', 'desc' => 'Complete CRM features for teams of any size.', 'features' => ['Pipeline & Forecast Mgmt', 'Rule-Based Lead Assignment', 'Quote & Contract Creation', 'Einstein 1 AI Trial']],
                    'enterprise' => ['name' => 'Enterprise', 'price' => '$165', 'desc' => 'Deep customization & AI for complex organizations.', 'features' => ['Full Einstein 1 AI Copilot', 'Unlimited Flow Automation', 'Advanced Territory Mgmt', '24/7 Dedicated Support']],
                ],
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'is_claimed' => true,
                'rank' => 98,
                'published_at' => now(),
                'categories' => ['crm-software', 'enterprise-saas'],
            ],
            [
                'name' => 'HubSpot Sales Hub',
                'slug' => 'hubspot-sales-hub',
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'HubSpot Sales Hub combines an intuitive UI with robust email tracking, automated meeting scheduling, and inbound marketing synchronization.',
                'long_description' => 'HubSpot Sales Hub is an easy-to-use sales CRM that includes engagement tools, configure-price-quote (CPQ) functionality, and rich sales analytics for scaling organizations.',
                'website_url' => 'https://www.hubspot.com',
                'pricing_text' => 'Free tier available • from $15 / user / mo',
                'pricing_structured' => [
                    'free' => ['name' => 'Free', 'price' => '$0', 'desc' => 'Essential free CRM tools', 'features' => ['Contact management', 'Deal tracking', 'Meeting scheduling']],
                    'starter' => ['name' => 'Starter', 'price' => '$15', 'desc' => 'For growing teams', 'features' => ['Simple automation', 'Email sequences', 'Live chat']],
                    'pro' => ['name' => 'Professional', 'price' => '$90', 'desc' => 'Complete sales automation', 'features' => ['Custom reporting', 'Lead scoring', 'Forecasting']],
                ],
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'is_claimed' => true,
                'rank' => 95,
                'published_at' => now(),
                'categories' => ['crm-software', 'marketing'],
            ],
            [
                'name' => 'Zoho CRM',
                'slug' => 'zoho-crm',
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Best value CRM for SMBs featuring Zia AI conversational assistant, omnichannel customer engagement, and flexible customization.',
                'long_description' => 'Zoho CRM empowers global businesses with 360-degree customer relationship lifecycle management, automated deal assignment, and rich analytics at a fraction of legacy cost.',
                'website_url' => 'https://www.zoho.com/crm',
                'pricing_text' => 'from $14 / user / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 92,
                'published_at' => now(),
                'categories' => ['crm-software', 'productivity'],
            ],
            [
                'name' => 'Pipedrive',
                'slug' => 'pipedrive',
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Visual sales pipeline management designed by salespeople, for salespeople to drive deal closures with minimal friction.',
                'long_description' => 'Pipedrive is an easy-to-use sales CRM that helps sales reps focus on actions that drive deals forward through customizable pipeline stages and automated activity prompts.',
                'website_url' => 'https://www.pipedrive.com',
                'pricing_text' => 'from $15 / user / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 90,
                'published_at' => now(),
                'categories' => ['crm-software', 'productivity'],
            ],
            [
                'name' => 'PromptHub AI',
                'slug' => 'prompthub-ai',
                'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Automate complex daily workflows with collaborative prompt engineering pipelines, version control, and multi-model benchmarks.',
                'long_description' => 'PromptHub AI provides engineering and product teams with collaborative prompt management, automated regression evaluations, and cost optimization telemetry.',
                'website_url' => 'https://prompthub.ai',
                'pricing_text' => 'from $29 / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 96,
                'published_at' => now(),
                'categories' => ['productivity', 'development'],
            ],
            [
                'name' => 'CodePulse Pro',
                'slug' => 'codepulse-pro',
                'logo_url' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Intelligent code refactoring, context-aware multi-file generation, and automated end-to-end test writing.',
                'long_description' => 'CodePulse Pro is an AI development copilot that accelerates repository-wide refactoring, framework migrations, and security vulnerability remediations.',
                'website_url' => 'https://codepulse.pro',
                'pricing_text' => 'from $19 / user / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 97,
                'published_at' => now(),
                'categories' => ['development'],
            ],
            [
                'name' => 'Synthetix Art',
                'slug' => 'synthetix-art',
                'logo_url' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Generate production-ready vector graphics, 3D meshes, and UI mockups from natural language prompts.',
                'long_description' => 'Synthetix Art produces ultra-high-resolution SVG vectors, 3D textures, and responsive UI components with clean code export for modern design systems.',
                'website_url' => 'https://synthetix.art',
                'pricing_text' => 'from $24 / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 94,
                'published_at' => now(),
                'categories' => ['design-graphics'],
            ],
            [
                'name' => 'MetricMind',
                'slug' => 'metricmind',
                'logo_url' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Transform raw tabular data into intuitive executive dashboards and predictive churn insights in seconds.',
                'long_description' => 'MetricMind is an AI business intelligence platform that connects directly to SQL databases and data warehouses to generate natural language executive insights.',
                'website_url' => 'https://metricmind.io',
                'pricing_text' => 'from $49 / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 93,
                'published_at' => now(),
                'categories' => ['analytics'],
            ],
            [
                'name' => 'ChatFlow Enterprise',
                'slug' => 'chatflow-enterprise',
                'logo_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Deploy custom trained AI support bots with direct CRM omnichannel sync and sentiment-based ticket routing.',
                'long_description' => 'ChatFlow Enterprise provides autonomous Tier-1 customer resolution bots with SOC2 Type II isolation, multilingual support, and zero hallucination guardrails.',
                'website_url' => 'https://chatflow.enterprise',
                'pricing_text' => 'from $79 / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 95,
                'published_at' => now(),
                'categories' => ['enterprise-saas'],
            ],
            [
                'name' => 'WriterGenie 2.0',
                'slug' => 'writergenie-2-0',
                'logo_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                'short_description' => 'Autonomous article generation, brand tone matching, and real-time Google search ranking optimization.',
                'long_description' => 'WriterGenie 2.0 combines programmatic SEO, semantic keyword clustering, and real-time search intent matching to generate high-converting editorial content.',
                'website_url' => 'https://writergenie.ai',
                'pricing_text' => 'from $15 / mo',
                'status' => 'published',
                'is_featured' => true,
                'is_verified' => true,
                'rank' => 91,
                'published_at' => now(),
                'categories' => ['copywriting', 'marketing'],
            ],
        ];

        foreach ($toolsData as $toolData) {
            $catSlugs = $toolData['categories'];
            unset($toolData['categories']);

            $tool = Tool::updateOrCreate(
                ['slug' => $toolData['slug']],
                array_merge($toolData, [
                    'vendor_id' => $vendor->id,
                    'tier_id' => $proTier->id,
                ])
            );

            // Sync categories
            $catIds = [];
            foreach ($catSlugs as $cSlug) {
                if (isset($categoryModels[$cSlug])) {
                    $catIds[] = $categoryModels[$cSlug]->id;
                }
            }
            if (!empty($catIds)) {
                $tool->categories()->sync($catIds);
            }

            // Create 3 Verified Reviews per tool
            Review::updateOrCreate(
                ['tool_id' => $tool->id, 'user_email' => 'sarah@techcorp.io'],
                [
                    'user_id' => $admin->id,
                    'user_name' => 'Sarah Jenkins',
                    'rating' => 5,
                    'comment' => "{$tool->name} transformed our workflow. The setup was intuitive and the ROI was evident within our first month of deployment.",
                    'status' => 'approved',
                ]
            );

            Review::updateOrCreate(
                ['tool_id' => $tool->id, 'user_email' => 'michael@designlab.co'],
                [
                    'user_id' => $admin->id,
                    'user_name' => 'Michael Chang',
                    'rating' => 5,
                    'comment' => "Remarkable accuracy and developer ergonomics. Our team saved over 12 hours a week since migrating to {$tool->name}.",
                    'status' => 'approved',
                ]
            );
        }

        // 4. Seed Rich Published Blogs
        $blogsData = [
            [
                'title' => 'The quiet rewrite: how small teams are out-shipping the giants in 2026',
                'slug' => 'the-quiet-rewrite-how-small-teams-are-out-shipping-the-giants-in-2026',
                'meta_title' => 'The quiet rewrite: how small teams are out-shipping the giants in 2026',
                'meta_description' => 'Inside the lean startups using autonomous agents, local models, and serverless edge compute to run rings around 500-person incumbents.',
                'body' => "For the past decade, enterprise tech companies maintained market dominance through sheer headcount scale. Building complex web platforms, data pipelines, and internal tools required dozens of specialized software engineers working in synchronized quarters.\n\nToday, that paradigm has broken down entirely. A new generation of technical founders is executing full product lifecycles with ultra-lean teams—relying on generative AI code orchestration, serverless edge compute, and unified API ecosystems to compress multi-month engineering sprints into afternoons.\n\n## Why the conditions changed\n\nThe primary bottleneck in software development was never writing code—it was architectural coordination, manual testing overhead, and context switching across large engineering organizations. When headcount swells past 50 engineers, communication complexity scales quadratically.\n\nWith modern AI tooling like Cursor, GitHub Copilot, and Claude 3.5 Sonnet acting as force multipliers, senior engineers are now functioning as high-level product architects rather than line-by-line syntax writers.\n\n## The no-bloat tech stack\n\n- **Autonomous Agent Workflows:** Offloading routine regression testing, error triage, and PR reviews to automated background agent execution loops.\n- **Serverless DB Clusters:** Replacing traditional dedicated database clusters with serverless vector databases that scale instantly on demand.\n- **Decoupled API Fabrics:** Orchestrating micro-services via GraphQL and lightweight edge handlers.",
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'The new LLM cost matrix: context windows vs fine-tuning',
                'slug' => 'the-new-llm-cost-matrix-context-windows-vs-fine-tuning',
                'meta_title' => 'The new LLM cost matrix: context windows vs fine-tuning',
                'meta_description' => 'A comprehensive cost breakdown comparing high-context API calls against custom fine-tuned checkpoints.',
                'body' => "As context windows expand to 2 million tokens, engineering teams are re-evaluating whether fine-tuning models remains cost-effective compared to retrieval-augmented generation (RAG) and dynamic in-context caching.",
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Why autonomous AI agents demand new security paradigms',
                'slug' => 'why-autonomous-ai-agents-demand-new-security-paradigms',
                'meta_title' => 'Why autonomous AI agents demand new security paradigms',
                'meta_description' => 'How security architects are auditing non-deterministic execution loops and prompt injection vectors.',
                'body' => "When software agents execute multi-step decision trees with tool invocation privileges, traditional static analysis and firewall rules fail to prevent prompt injection and unauthorized database mutation.",
                'status' => 'published',
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Vector databases in production: what benchmark tests won\'t tell you',
                'slug' => 'vector-databases-in-production-what-benchmark-tests-wont-tell-you',
                'meta_title' => 'Vector databases in production: benchmarks vs reality',
                'meta_description' => 'Real-world latency, index reconstruction overhead, and memory footprints under heavy concurrent loads.',
                'body' => "Benchmarking vector databases in synthetic environments rarely mirrors production conditions with dynamic indexing, continuous document upserts, and multi-tenant metadata filtering.",
                'status' => 'published',
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'The 2026 State of Generative AI & SaaS Benchmarks',
                'slug' => 'the-2026-state-of-generative-ai-and-saas-benchmarks',
                'meta_title' => 'The 2026 State of Generative AI & SaaS Benchmarks',
                'meta_description' => 'An in-depth report analyzing adoption rates, ROI metrics, and infrastructure spending across top tech teams.',
                'body' => "Our 2026 survey of over 1,200 CTOs and engineering directors highlights a 68% acceleration in feature deployment speed among teams leveraging automated AI pipelines.",
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Anthropic Claude 3.5 Sonnet vs OpenAI GPT-4o for Coding',
                'slug' => 'anthropic-claude-3-5-sonnet-vs-openai-gpt-4o-for-coding',
                'meta_title' => 'Claude 3.5 Sonnet vs GPT-4o for Coding Benchmarks',
                'meta_description' => 'Deep benchmark comparison evaluating accuracy, refactoring speed, and context window handling.',
                'body' => "We evaluated Claude 3.5 Sonnet and GPT-4o across 500 complex full-stack coding tasks, evaluating single-shot accuracy, multi-file refactoring, and hallucination rates.",
                'status' => 'published',
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'How Prism scaled to 10M active developer requests in 6 months',
                'slug' => 'how-prism-scaled-to-10m-active-developer-requests-in-6-months',
                'meta_title' => 'Founder Story: Scaling Prism to 10M Requests',
                'meta_description' => 'Zeno Rocha discusses API design simplicity, developer ergonomics, and modern infra scaling.',
                'body' => "Building for developers requires absolute respect for milliseconds, clean error messaging, and intuitive API ergonomics that eliminate documentation lookups.",
                'status' => 'published',
                'published_at' => now()->subDays(18),
            ],
            [
                'title' => 'Navigating AI governance in multi-tenant SaaS applications',
                'slug' => 'navigating-ai-governance-in-multi-tenant-saas-applications',
                'meta_title' => 'AI Governance & Compliance in Multi-Tenant SaaS',
                'meta_description' => 'Implementing data isolation guarantees, SOC2 compliance filters, and audit logs for enterprise customers.',
                'body' => "Enterprise buyers require cryptographically verified tenant isolation guarantees before allowing model inference pipelines to process sensitive proprietary records.",
                'status' => 'published',
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($blogsData as $bData) {
            Blog::updateOrCreate(
                ['slug' => $bData['slug']],
                array_merge($bData, [
                    'author_id' => $admin->id,
                    'vendor_id' => $vendor->id,
                ])
            );
        }
    }
}
