<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Analytics Report - {{ now()->format('d/m/Y') }}</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 11px;
      color: #333;
      margin: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 12px 0;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 6px 8px;
      text-align: right;
    }

    th {
      background: #f0f0f0;
      text-align: center;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .summary {
      background: #f8f9fa;
      padding: 12px;
      border-radius: 4px;
      margin-bottom: 20px;
    }

    h1,
    h2 {
      color: #222;
      margin: 0 0 10px;
    }

    .highlight {
      color: #28c76f;
      font-weight: bold;
    }

    .negative {
      color: #ea5455;
    }
  </style>
</head>

<body>

  <div class="header">
    <h1>Financial Analytics Report</h1>
    <p><strong>Period:</strong> Last 12 Months • <strong>Generated:</strong> {{ now()->format('d M Y') }}</p>
    <p><strong>Department:</strong> {{ $departmentName }}</p>
  </div>

  <div class="summary">
    <h2>Key Summary</h2>
    <p><strong>Total Sales:</strong> Rs. {{ number_format($salesTotal) }}</p>
    <p><strong>Total Expenses:</strong> Rs. {{ number_format($expensesTotal) }}</p>
    <p><strong>Net Profit:</strong> <span class="{{ $profit >= 0 ? 'highlight' : 'negative' }}">Rs.
        {{ number_format($profit) }}</span></p>
    <p><strong>Average Monthly Sales:</strong> Rs. {{ number_format($averageMonthlySales) }}</p>
    <p><strong>Average Monthly Expenses:</strong> Rs. {{ number_format($averageMonthlyExpense) }}</p>
  </div>

  <h2>Monthly Breakdown</h2>
  <table>
    <thead>
      <tr>
        <th>Month</th>
        <th>Sales (PKR)</th>
        <th>Expenses (PKR)</th>
        <th>Profit/Loss (PKR)</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($months as $index => $month)
        <?php
        $sales = $salesData[$index];
        $expense = $expensesData[$index];
        $monthlyProfit = $sales - $expense;
        ?>
        <tr>
          <td style="text-align:left">{{ $month }}</td>
          <td>Rs. {{ number_format($sales) }}</td>
          <td>Rs. {{ number_format($expense) }}</td>
          <td class="{{ $monthlyProfit >= 0 ? 'highlight' : 'negative' }}">
            Rs. {{ number_format($monthlyProfit) }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <h2>Highlights</h2>
  <ul>
    <li><strong>Best Sales Month:</strong> {{ $months[$bestMonthIndex] }} → Rs. {{ number_format($bestMonthSales) }}
    </li>
    <li><strong>Worst Sales Month:</strong> {{ $months[$worstMonthIndex] }} → Rs.
      {{ number_format($worstMonthSales) }}</li>
  </ul>

  <p style="text-align:center; color:#777; margin-top:40px; font-size:9px;">
    Generated from your system • © {{ now()->year }}
  </p>

</body>

</html>
