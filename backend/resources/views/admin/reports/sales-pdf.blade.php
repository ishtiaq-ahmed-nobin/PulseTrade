<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report — PulseTrade</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Helvetica, Arial, sans-serif; color: #1a1a2e; font-size: 12px; line-height: 1.5; }
        .container { padding: 30px; }
        .header { border-bottom: 3px solid #5C7DFF; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { font-size: 22px; font-weight: 700; color: #1a1a2e; }
        .header p { font-size: 12px; color: #666; margin-top: 4px; }
        .summary-grid { display: flex; gap: 15px; margin-bottom: 25px; }
        .summary-card { flex: 1; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; }
        .summary-card .label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #888; margin-bottom: 4px; }
        .summary-card .value { font-size: 20px; font-weight: 700; color: #1a1a2e; }
        .section { margin-bottom: 25px; }
        .section-title { font-size: 14px; font-weight: 700; color: #1a1a2e; border-bottom: 1px solid #e5e7eb; padding-bottom: 6px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fa; text-align: left; padding: 8px 12px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #666; border-bottom: 2px solid #e5e7eb; }
        td { padding: 8px 12px; border-bottom: 1px solid #f0f0f0; font-size: 12px; }
        .text-right { text-align: right; }
        .empty-state { text-align: center; padding: 30px; color: #999; font-style: italic; }
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #e5e7eb; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PulseTrade — Sales Report</h1>
            <p>Period: {{ $from->format('M d, Y') }} — {{ $to->format('M d, Y') }}</p>
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Total Revenue</div>
                <div class="value">{{ $currencySymbol }}{{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Orders</div>
                <div class="value">{{ $totalOrders }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Paid Orders</div>
                <div class="value">{{ $paidOrders }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Avg Order Value</div>
                <div class="value">{{ $currencySymbol }}{{ number_format($avgOrderValue, 2) }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Daily Sales</div>
            @if ($dailySales->count())
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-right">Orders</th>
                            <th class="text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dailySales as $day)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                                <td class="text-right">{{ $day->orders }}</td>
                                <td class="text-right">{{ $currencySymbol }}{{ number_format($day->revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">No sales data for this period.</div>
            @endif
        </div>

        <div class="section">
            <div class="section-title">Top Products</div>
            @if ($topProducts->count())
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-right">Qty Sold</th>
                            <th class="text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td class="text-right">{{ $product->qty_sold }}</td>
                                <td class="text-right">{{ $currencySymbol }}{{ number_format($product->total_revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">No product data for this period.</div>
            @endif
        </div>

        <div class="footer">
            Generated on {{ now()->format('M d, Y \a\t g:i A') }} — PulseTrade Analytics
        </div>
    </div>
</body>
</html>
