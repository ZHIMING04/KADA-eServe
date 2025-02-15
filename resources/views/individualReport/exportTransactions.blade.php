<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
            font-size: 14px;
        }
        .container {
            width: 100%;
            padding: 10px;
            margin: 0 auto;
        }
        .section {
            margin-bottom: 30px;
            border: 1px solid #0056b3;
            padding: 15px;
            border-radius: 5px;
        }
        .section-title {
            font-weight: bold;
            font-size: 18px;
            color: #fff;
            background-color: #0056b3;
            padding: 10px;
            border-radius: 5px 5px 0 0;
            margin: -15px -15px 15px -15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-item label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #0056b3;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .logo {
            width: 100px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/KADAlogoresize.png') }}" alt="KADA Logo" class="logo">
            <h1>Laporan Transaksi</h1>
            <p>Dijana pada {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        </div>

        <div class="section">
            <div class="section-title">Maklumat Ahli</div>
            <div class="info-item">
                <label>Nama:</label> {{ $member->name }}
            </div>
            <div class="info-item">
                <label>No Ahli:</label> {{ $member->no_anggota }}
            </div>
            <div class="info-item">
                <label>Tarikh:</label> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </div>
        </div>

        <div class="section">
            <div class="section-title">Laporan Transaksi Bulan {{ \Carbon\Carbon::now()->locale('ms')->translatedFormat('F Y') }}</div>
            <table>
                <thead>
                    <tr>
                        <th>Tarikh</th>
                        <th>Jenis</th>
                        <th>Jumlah (RM)</th>
                        <th>Kaedah Pembayaran</th>
                        <th>Rujukan</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($transactions->isEmpty())
                        <tr>
                            <td colspan="5" style="text-align: center;">Tiada transaksi yang direkodkan untuk bulan ini</td>
                        </tr>
                    @else
                        @forelse ($transactions->where('status', 'approved') as $transaction)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($transaction->type == 'loan')
                                        Pinjaman
                                    @elseif ($transaction->type == 'savings')
                                        Simpanan
                                    @else
                                        {{ $transaction->type }}
                                    @endif
                                </td>
                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    @if ($transaction->payment_method == 'cash')
                                        Tunai
                                    @elseif ($transaction->payment_method == 'online')
                                        Bank Dalam Talian
                                    @elseif ($transaction->payment_method == 'auto_transfer')
                                        Pindahan Bank Auto
                                    @endif
                                </td>
                                <td>
                                    @if ($transaction->type == 'loan')
                                        Bayaran Balik {{ $transaction->loan_type }}
                                        ({{ $transaction->loan_id }})
                                    @else
                                        @switch($transaction->savings_type)
                                            @case('welfare_fund')
                                                Tabung Anggota
                                                @break
                                            @case('subscription_capital')
                                                Modal Yuran
                                                @break
                                            @case('share_capital')
                                                Modal Syer
                                                @break
                                            @case('fixed_savings')
                                                Simpanan Tetap
                                                @break
                                            @case('member_deposit')
                                                Deposit Ahli
                                                @break
                                            @default
                                                {{ $transaction->savings_type }}
                                        @endswitch
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Terima kasih kerana menggunakan perkhidmatan kami.</p>
        </div>
    </div>
</body>
</html>