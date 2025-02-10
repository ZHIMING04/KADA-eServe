<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <table>
        <tr rowspan='2'>
            <td style="border: none;">
                <img src="{{ public_path('images/KADAlogoresize.png') }}" alt="KADA Logo" class="logo">
            </td>
            <td>
                <div class="header-title">
                    <p>Nama: <strong>{{ $member->name }}</strong></p>
                    <p>No Ahli: <strong>{{ $member->no_anggota }}</strong> | Tarikh: <strong>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong></p>
                </div>
            </td>
        </tr>
    </table>

    <h2>Laporan Transaksi Bulan {{ \Carbon\Carbon::now()->locale('ms')->translatedFormat('F Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>Tarikh</th>
                <th>Jenis</th>
                <th>Jumlah (RM)</th>
                <th>Rujukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
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
        </tbody>
    </table>
</body>
</html>