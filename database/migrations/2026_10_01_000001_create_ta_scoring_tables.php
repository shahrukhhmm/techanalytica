<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates all tables required by the TA Scoring Engine v1.0 specification.
     */
    public function up(): void
    {
        // -------------------------------------------------------------------------
        // 1. methodology_versions  — immutable record of scoring configuration
        // -------------------------------------------------------------------------
        Schema::create('methodology_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version_name')->unique(); // e.g. "TA Score v1.0"
            $table->json('weights');                  // dimension_key => weight (0-1)
            $table->json('global_parameters');        // bayesian_m, recency_weights, confidence_thresholds, etc.
            $table->timestamp('effective_date');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // -------------------------------------------------------------------------
        // 2. category_templates  — per-category scoring requirements
        // -------------------------------------------------------------------------
        Schema::create('category_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('template_version');
            $table->timestamp('effective_date');
            $table->json('core_requirements');        // ordered list of core capabilities
            $table->json('advanced_capabilities');    // ordered list
            $table->json('important_integrations');   // ordered list
            $table->json('target_segments');          // ['solo','smb','mid-market','enterprise']
            $table->json('trust_requirements')->nullable();
            $table->text('ai_depth_definition')->nullable();
            $table->json('pricing_comparison_basis')->nullable();
            $table->json('minimum_evidence_requirements')->nullable();
            $table->json('manual_review_triggers')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['category_id', 'template_version']);
        });

        // -------------------------------------------------------------------------
        // 3. evidence_sources  — approved sources for a product
        // -------------------------------------------------------------------------
        Schema::create('evidence_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->string('source_type');            // 'vendor_page','documentation','pricing','review_platform', etc.
            $table->string('source_family');          // 'g2','gartner_digital_markets','trustradius','vendor_controlled', etc.
            $table->string('url');
            $table->enum('authority_level', ['primary', 'secondary', 'corroborating'])->default('primary');
            $table->enum('allowed_usage_mode', ['aggregate_only', 'full', 'manual_entry'])->default('full');
            $table->boolean('is_active')->default(true);
            $table->integer('refresh_ttl_days')->nullable(); // TTL in days; null = manual
            $table->timestamps();
        });

        // -------------------------------------------------------------------------
        // 4. evidence_items  — individual extracted facts with provenance
        // -------------------------------------------------------------------------
        Schema::create('evidence_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('evidence_sources')->cascadeOnDelete();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->string('field_key');              // e.g. 'has_api', 'pricing_public', 'soc2_certified'
            $table->text('extracted_value')->nullable();
            $table->text('raw_excerpt')->nullable();  // snippet/pointer to original content
            $table->timestamp('retrieved_at');
            $table->timestamp('expires_at')->nullable();
            $table->float('extractor_confidence')->nullable(); // 0.0–1.0
            $table->enum('verified_status', ['unverified', 'verified', 'conflicting', 'stale'])->default('unverified');
            $table->timestamps();

            $table->index(['tool_id', 'field_key']);
        });

        // -------------------------------------------------------------------------
        // 5. product_facts  — current validated facts used by scoring engine
        // -------------------------------------------------------------------------
        Schema::create('product_facts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->string('field_key');
            $table->text('value')->nullable();
            $table->json('evidence_item_ids')->nullable(); // array of evidence_items IDs
            $table->enum('status', ['verified', 'unverified', 'disputed', 'stale'])->default('unverified');
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();

            $table->unique(['tool_id', 'field_key']);
            $table->index(['tool_id']);
        });

        // -------------------------------------------------------------------------
        // 6. review_aggregates  — external review data per source family
        // -------------------------------------------------------------------------
        Schema::create('review_aggregates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->string('source_family');          // 'g2', 'gartner_digital_markets', 'trustradius', etc.
            $table->float('rating_raw')->nullable();  // raw rating from source
            $table->float('rating_norm')->nullable(); // normalised to 0–100
            $table->integer('review_count')->default(0);
            $table->json('recency_data')->nullable();  // breakdown by age bucket
            $table->timestamp('retrieved_at');
            $table->timestamps();

            $table->unique(['tool_id', 'source_family']);
        });

        // -------------------------------------------------------------------------
        // 7. score_runs  — immutable history of every scoring run
        // -------------------------------------------------------------------------
        Schema::create('score_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('methodology_version_id')->constrained('methodology_versions');
            $table->string('template_version');
            $table->timestamp('run_at');
            $table->float('internal_score');          // 0–100 weighted sum
            $table->float('public_score');            // 0.0–10.0
            $table->float('confidence_score');        // 0–100
            $table->enum('confidence_label', ['High', 'Moderate', 'Low']);
            $table->enum('status', ['ranked', 'provisional', 'unranked'])->default('provisional');
            $table->boolean('is_published')->default(false);
            $table->boolean('flagged_for_review')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['tool_id', 'category_id', 'run_at']);
        });

        // -------------------------------------------------------------------------
        // 8. score_breakdowns  — explainability per sub-criterion per run
        // -------------------------------------------------------------------------
        Schema::create('score_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('score_run_id')->constrained('score_runs')->cascadeOnDelete();
            $table->string('dimension_key');
            $table->string('subcriterion_key');
            $table->float('raw_value')->nullable();
            $table->float('points_awarded');
            $table->float('max_points');
            $table->string('rule_version')->nullable();
            $table->json('evidence_item_ids')->nullable();
            $table->text('reasoning')->nullable();
            $table->timestamps();

            $table->index(['score_run_id', 'dimension_key']);
        });

        // -------------------------------------------------------------------------
        // 9. rank_snapshots  — monthly category rank history
        // -------------------------------------------------------------------------
        Schema::create('rank_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('score_run_id')->constrained('score_runs');
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->date('snapshot_date');
            $table->integer('rank');
            $table->integer('eligible_count');
            $table->timestamps();

            $table->index(['category_id', 'snapshot_date']);
        });

        // -------------------------------------------------------------------------
        // 10. review_exceptions  — founder review queue
        // -------------------------------------------------------------------------
        Schema::create('review_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->foreignId('score_run_id')->nullable()->constrained('score_runs')->nullOnDelete();
            $table->string('trigger_type');           // 'score_change', 'top_10_entry', 'confidence_drop', etc.
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['open', 'in_review', 'resolved', 'dismissed'])->default('open');
            $table->string('owner')->nullable();
            $table->text('description')->nullable();
            $table->text('resolution')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'severity']);
        });

        // -------------------------------------------------------------------------
        // 11. vendor_corrections  — vendor-submitted factual challenges
        // -------------------------------------------------------------------------
        Schema::create('vendor_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->foreignId('submitter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('correction_type');        // 'incorrect_info','feature_change','pricing_change', etc.
            $table->text('claim');
            $table->string('evidence_url')->nullable();
            $table->string('evidence_file')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('resolution')->nullable();
            $table->timestamps();
        });

        // -------------------------------------------------------------------------
        // 12. audit_logs  — full audit trail for scoring integrity
        // -------------------------------------------------------------------------
        Schema::create('scoring_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('entity_type');            // 'ProductFact','EvidenceItem','CategoryTemplate', etc.
            $table->unsignedBigInteger('entity_id');
            $table->string('action');                 // 'create','update','delete','review','recalculate'
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->text('reason')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scoring_audit_logs');
        Schema::dropIfExists('vendor_corrections');
        Schema::dropIfExists('review_exceptions');
        Schema::dropIfExists('rank_snapshots');
        Schema::dropIfExists('score_breakdowns');
        Schema::dropIfExists('score_runs');
        Schema::dropIfExists('review_aggregates');
        Schema::dropIfExists('product_facts');
        Schema::dropIfExists('evidence_items');
        Schema::dropIfExists('evidence_sources');
        Schema::dropIfExists('category_templates');
        Schema::dropIfExists('methodology_versions');
    }
};
