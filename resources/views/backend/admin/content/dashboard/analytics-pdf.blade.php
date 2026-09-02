<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TechAnalytica Platform Executive Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 13px; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #e04385; padding-bottom: 15px; margin-bottom: 25px; }
        .logo { font-size: 24px; font-weight: bold; color: #e04385; }
        .grid { width: 100%; margin-bottom: 20px; }
        .grid td { padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; text-align: center; }
        .val { font-size: 20px; font-weight: bold; color: #1e293b; }
        .lbl { font-size: 11px; color: #64748b; text-transform: uppercase; margin-top: 4px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #e2e8f0; padding: 8px 12px; text-align: left; }
        table.data-table th { background: #f1f5f9; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">TechAnalytica</div>
        <h2 style="margin: 5px 0 0;">Platform Executive Intelligence Report</h2>
        <p style="color: #64748b; font-size: 12px; margin-top: 4px;">Generated on {{ date('F d, Y') }}</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="val">{{ $totalTools }}</div>
                <div class="lbl">Total AI Tools</div>
            </td>
            <td>
                <div class="val">{{ $totalVendors }}</div>
                <div class="lbl">Active Vendors</div>
            </td>
            <td>
                <div class="val">{{ $totalLeads }}</div>
                <div class="lbl">Leads Captured</div>
            </td>
            <td>
                <div class="val">{{ $totalReviews }}</div>
                <div class="lbl">Reviews Logged</div>
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">Top Ranked AI Products</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Classification</th>
                <th>Status</th>
                <th>TechScore</th>
                <th>Reviews</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topTools as $tool)
                <tr>
                    <td><strong>{{ $tool->name }}</strong></td>
                    <td>{{ $tool->ai_type ?? 'AI Tool' }}</td>
                    <td>{{ ucfirst($tool->status) }}</td>
                    <td>{{ $tool->score }} / 100</td>
                    <td>{{ $tool->reviews_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
