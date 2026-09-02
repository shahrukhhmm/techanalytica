<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AI Tool Comparison: {{ $tool1->name }} vs {{ $tool2->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 13px; line-height: 1.5; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #e04385; padding-bottom: 15px; margin-bottom: 25px; }
        .logo { font-size: 24px; font-weight: bold; color: #e04385; }
        .title { font-size: 18px; font-weight: 700; margin-top: 5px; color: #222; }
        .comparison-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .comparison-table th, .comparison-table td { border: 1px solid #e2e8f0; padding: 12px; text-align: left; }
        .comparison-table th { background-color: #f8fafc; font-weight: bold; }
        .tool1-col { color: #e04385; font-weight: bold; }
        .tool2-col { color: #3b82f6; font-weight: bold; }
        .score-badge { display: inline-block; padding: 4px 8px; border-radius: 4px; background: #e04385; color: #fff; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">TechAnalytica</div>
        <div class="title">Interactive AI Tool Benchmark & Comparison Report</div>
        <p style="margin: 5px 0 0; color: #64748b;">Generated on {{ date('F d, Y') }}</p>
    </div>

    <table class="comparison-table">
        <thead>
            <tr>
                <th style="width: 30%;">Attribute / Spec</th>
                <th style="width: 35%;" class="tool1-col">{{ $tool1->name }}</th>
                <th style="width: 35%;" class="tool2-col">{{ $tool2->name }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>AI Classification Type</strong></td>
                <td>{{ $tool1->ai_type ?? 'General AI' }}</td>
                <td>{{ $tool2->ai_type ?? 'General AI' }}</td>
            </tr>
            <tr>
                <td><strong>TechScore</strong></td>
                <td><span class="score-badge">{{ $tool1->score }} / 100</span></td>
                <td><span class="score-badge" style="background: #3b82f6;">{{ $tool2->score }} / 100</span></td>
            </tr>
            <tr>
                <td><strong>Community Rating</strong></td>
                <td>{{ number_format($tool1->reviews->avg('rating') ?: 4.5, 1) }} / 5.0 ({{ $tool1->reviews->count() }} reviews)</td>
                <td>{{ number_format($tool2->reviews->avg('rating') ?: 4.0, 1) }} / 5.0 ({{ $tool2->reviews->count() }} reviews)</td>
            </tr>
            <tr>
                <td><strong>Pricing Model</strong></td>
                <td>{{ $tool1->pricing_text ?? ($tool1->tier->name ?? 'Free / Freemium') }}</td>
                <td>{{ $tool2->pricing_text ?? ($tool2->tier->name ?? 'Free / Freemium') }}</td>
            </tr>
            <tr>
                <td><strong>Categories</strong></td>
                <td>{{ $tool1->categories->pluck('name')->join(', ') ?: 'AI Tool' }}</td>
                <td>{{ $tool2->categories->pluck('name')->join(', ') ?: 'AI Tool' }}</td>
            </tr>
            <tr>
                <td><strong>Overview</strong></td>
                <td>{{ $tool1->short_description }}</td>
                <td>{{ $tool2->short_description }}</td>
            </tr>
            <tr>
                <td><strong>Key Advantages (Pros)</strong></td>
                <td>
                    @if(!empty($tool1->pros))
                        <ul style="padding-left: 15px; margin: 0;">
                            @foreach($tool1->pros as $p)
                                <li>{{ $p }}</li>
                            @endforeach
                        </ul>
                    @else
                        High enterprise performance & reliability
                    @endif
                </td>
                <td>
                    @if(!empty($tool2->pros))
                        <ul style="padding-left: 15px; margin: 0;">
                            @foreach($tool2->pros as $p)
                                <li>{{ $p }}</li>
                            @endforeach
                        </ul>
                    @else
                        Fast setup & intuitive workflow
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Official Website</strong></td>
                <td>{{ $tool1->website_url ?? 'N/A' }}</td>
                <td>{{ $tool2->website_url ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} TechAnalytica Inc. All Rights Reserved. Confidential & Proprietary Comparison Telemetry.
    </div>
</body>
</html>
