<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <title>টুর্নামেন্ট আয়-ব্যয় বিবরণী | {{ $tournament->name }}</title>
    <style>
        body {
            font-family: 'SolaimanLipi', 'Kalpurush', 'Nikosh', 'Arial', sans-serif;
            color: #111827;
            background: #fff;
            margin: 0;
            padding: 24px;
            font-size: 13px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px double #111827;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .logo-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            font-size: 13px;
            color: #4b5563;
            margin: 2px 0;
        }
        .report-title {
            display: inline-block;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 4px 16px;
            font-size: 15px;
            font-weight: bold;
            margin-top: 8px;
            border-radius: 4px;
        }
        .meta-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            background: #f9fafb;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }
        .summary-boxes {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }
        .summary-box {
            flex: 1;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            text-align: center;
        }
        .summary-box.income { background: #f0fdf4; border-color: #86efac; }
        .summary-box.expense { background: #fef2f2; border-color: #fca5a5; }
        .summary-box.balance { background: #eff6ff; border-color: #93c5fd; }
        .box-title { font-size: 11px; color: #4b5563; font-weight: bold; }
        .box-val { font-size: 18px; font-weight: bold; margin-top: 4px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            font-size: 12px;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: left;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .signatures {
            margin-top: 48px;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }
        .sign-block {
            text-align: center;
            width: 160px;
            border-top: 1px dashed #4b5563;
            padding-top: 6px;
            font-size: 12px;
            font-weight: bold;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 18px; background: #059669; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            🖨️ প্রিন্ট করুন / PDF ডাউনলোড
        </button>
        <button onclick="window.close()" style="padding: 8px 14px; background: #6b7280; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-left: 6px;">
            বন্ধ করুন
        </button>
    </div>

    <!-- Official Academy Header -->
    <div class="header">
        <h1 class="logo-title">জামিরবাড়িয়া স্পোর্টস একাডেমি</h1>
        <div class="subtitle">ফুলপুর, ময়মনসিংহ • অফিসিয়াল ক্রীড়া ব্যবস্থাপনা পরিষদ</div>
        <div class="report-title">টুর্নামেন্ট আয়-ব্যয় ও অডিট ভাউচার বিবরণী</div>
    </div>

    <!-- Tournament Meta Information -->
    <div class="meta-grid">
        <div>
            <div><strong>টুর্নামেন্টের নাম:</strong> {{ $tournament->name }}</div>
            <div><strong>খেলার বিভাগ:</strong> {{ ucfirst($tournament->sport_type) }} ({{ $tournament->type_name }})</div>
            <div><strong>ভেন্যু:</strong> {{ $tournament->venue }}</div>
        </div>
        <div style="text-align: right;">
            <div><strong>রিপোর্ট তারিখ:</strong> {{ now()->format('d M Y, h:i A') }}</div>
            <div><strong>অংশগ্রহণকারী দল:</strong> {{ $tournament->tournamentTeams->count() }}টি দল</div>
            <div><strong>এন্ট্রি ফি প্রতি দল:</strong> ৳{{ number_format($tournament->entry_fee, 2) }}</div>
        </div>
    </div>

    <!-- Financial KPI Summary Boxes -->
    <div class="summary-boxes">
        <div class="summary-box income">
            <div class="box-title">মোট টিম এন্ট্রি ফি বাবদ আয়</div>
            <div class="box-val" style="color: #15803d;">৳{{ number_format($totalIncome, 2) }}</div>
        </div>
        <div class="summary-box expense">
            <div class="box-title">টুর্নামেন্টের মোট ব্যয়</div>
            <div class="box-val" style="color: #b91c1c;">৳{{ number_format($totalExpenses, 2) }}</div>
        </div>
        <div class="summary-box balance">
            <div class="box-title">{{ $netBalance >= 0 ? 'উদ্বৃত্ত তহবিল (Surplus)' : 'ঘাটতি বাজেট (Deficit)' }}</div>
            <div class="box-val" style="color: {{ $netBalance >= 0 ? '#0369a1' : '#b45309' }};">৳{{ number_format($netBalance, 2) }}</div>
        </div>
    </div>

    <!-- Expense Ledger Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">ক্র.</th>
                <th style="width: 80px;">ভাউচার নং</th>
                <th style="width: 75px;">তারিখ</th>
                <th>শিরোনাম ও বিবরণ</th>
                <th>খাত / ক্যাটাগরি</th>
                <th class="text-right" style="width: 70px;">দর × সংখ্যা</th>
                <th class="text-right" style="width: 80px;">পরিমাণ (৳)</th>
                <th>প্রাপক / ভলান্টিয়ার</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $idx => $exp)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td><code>{{ $exp->voucher_no }}</code></td>
                    <td>{{ $exp->expense_date->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $exp->title }}</strong>
                        @if($exp->item_name)
                            <div style="font-size: 11px; color: #4b5563;">আইটেম: {{ $exp->item_name }}</div>
                        @endif
                        @if($exp->note)
                            <div style="font-size: 10px; color: #6b7280;">{{ $exp->note }}</div>
                        @endif
                    </td>
                    <td>{{ $categories[$exp->category] ?? $exp->category }}</td>
                    <td class="text-right">
                        @if($exp->unit_price)
                            ৳{{ number_format($exp->unit_price) }} × {{ $exp->quantity }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right" style="font-weight: bold;">
                        ৳{{ number_format($exp->amount, 2) }}
                    </td>
                    <td>
                        @if($exp->volunteer)
                            {{ $exp->volunteer->name }} (ভলান্টিয়ার)
                        @else
                            {{ $exp->paid_to ?? '-' }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">কোনো খরচের ভাউচার এন্ট্রি নেই।</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #f9fafb; font-weight: bold;">
                <td colspan="6" class="text-right">সর্বমোট টুর্নামেন্ট ব্যয়:</td>
                <td class="text-right" style="color: #b91c1c;">৳{{ number_format($totalExpenses, 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Official Signatures -->
    <div class="signatures">
        <div class="sign-block">
            হিসাবরক্ষক / প্রস্তুতকারী<br>
            <span style="font-size: 10px; font-weight: normal; color: #6b7280;">তারিখ: ....................</span>
        </div>
        <div class="sign-block">
            টুর্নামেন্ট ডিরেক্টর / সম্পাদক<br>
            <span style="font-size: 10px; font-weight: normal; color: #6b7280;">তারিখ: ....................</span>
        </div>
        <div class="sign-block">
            সভাপতি / একাডেমি চেয়ারম্যান<br>
            <span style="font-size: 10px; font-weight: normal; color: #6b7280;">তারিখ: ....................</span>
        </div>
    </div>

</body>
</html>

