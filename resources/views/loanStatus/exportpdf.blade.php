<!DOCTYPE html>
<html>
<head>
    <title>Butiran Pinjaman</title>
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
            border: 0;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        label {
            font-weight: bold;
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
            <h1>PERMOHONAN PEMBIAYAAN ANGGOTA</h1>
            <p>Dijana pada {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        </div>

        <div class="section">
            <div class="section-title">Butiran Pinjaman</div>
            <table>
            <tr>
                <td><label>ID Pinjaman</label></td>
                <td>: {{ $loan->loan_id }}</td>
                <td><label>Jenis Pinjaman</label></td>
                <td>: {{ $loan->loan_type->loan_type }}</td>
            </tr>
            <tr>
                <td><label>Kadar Faedah</label></td>
                <td>: {{ $loan->interest_rate }}%</td>
                <td><label>Amaun Pinjaman</label></td>
                <td>: RM {{ number_format($loan->loan_amount, 2) }}</td>
            </tr>
            <tr>
                <td><label>Pinjaman Jangka</label></td>
                <td>: {{ $loan->loan_period }} Bulan</td>
                <td><label>Tarikh Pinjaman</label></td>
                <td>: {{ $loan->date_apply }}</td>
            </tr>
            <tr>
                <td><label>Jumlah Bayaran</label></td>
                <td>: RM {{ number_format($loan->loan_total_repayment, 2) }}</td>
                <td><label>Bayaran Bulanan</label></td>
                <td>: RM {{ number_format($loan->monthly_repayment, 2) }}</td>
            </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Butiran Peribadi Pemohon</div>
            <table>
            <tr>
                <td><label>Nama</label></td>
                <td colspan="5">: {{ $member->name }}</td>
            </tr>
            <tr>
                <td><label>No K/P</label></td>
                <td>: {{ $member->ic }}</td>
                <td><label>Tarikh Lahir</label></td>
                <td>: {{ $member->DOB }}</td>
                <td><label>Jantina</label></td>
                <td>: {{ $member->gender }}</td>
            </tr>
            <tr>
                <td><label>Agama</label></td>
                <td>: {{ $member->agama }}</td>
                <td><label>Bangsa</label></td>
                <td>: {{ $member->bangsa }}</td>
                <td><label>No. Telefon</label></td>
                <td>: {{ $member->phone }}</td>
            </tr>
            <tr>
                <td><label>Alamat</label></td>
                <td colspan="5">: {{ $member->address }}</td>
            </tr>
            <tr>
                <td><label>Bandar</label></td>
                <td>: {{ $member->city }}</td>
                <td><label>Poskod</label></td>
                <td>: {{ $member->postcode }}</td>
                <td><label>Negeri</label></td>
                <td>: {{ $member->state }}</td>
            </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Butiran Pekerjaan</div>
            <table>
                <tr>
                    <td><label>No Anggota</label></td>
                    <td colspan="2">: {{ $member->no_anggota }}</td>
                    <td><label>No. PF</label></td>
                    <td colspan="2">: {{ $member->no_pf }}</td>
                </tr>
                <tr>
                    <td><label>Alamat Pejabat</label></td>
                    <td colspan="5">: {{ $member->office_address }}</td>
                </tr>
                <tr>
                    <td><label>Bandar</label></td>
                    <td>: {{ $member->office_city }}</td>
                    <td><label>Poskod</label></td>
                    <td>: {{ $member->office_postcode }}</td>
                    <td><label>Negeri</label></td>
                    <td>: {{ $member->office_state }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Butiran Bank</div>
            <table>
                <tr>
                    <td><label>Nama Bank:</label></td>
                    <td>: {{ $loan->bank->bank_name }}</td>
                    <td><label>Akaun Bank:</label></td>
                    <td>: {{ $loan->bank->bank_account }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Penjamin</div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>IC</th>
                        <th>Telefon</th>
                        <th>No Anggota</th>
                        <th>No taktau</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loan->guarantors as $index => $guarantor)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $guarantor->name }}</td>
                            <td>{{ $guarantor->ic }}</td>
                            <td>{{ $guarantor->phone }}</td>
                            <td>{{ $guarantor->address }}</td>
                            <td>{{ $guarantor->relationship }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p>Adalah dengan ini saya/kami rela hati bersetuju bersama-sama atau berasingan bertanggungjawab sepenuhnya ke atas ansuran harga barangan atau pembiayaan ini.
            Kami berjanji akan membayar balik kesemua ansuran hutang yang diberikan kepada peminjam di atas jika sekiranyan beliau tidak membayar balik ansuran itu mengikut perjanjian yang telah diperetujui.</p>
        </div>

        <div class="section">
            <div class="section-title">Pengakuan Pemohon</div>
            <p>Saya {{ $member->name }}, No. K/P: {{ $member->ic }} dengan ini memberi kuasa kepada KOPERASI KAKITANGAN KADA KELANTAN BHD atau waliknya yang sah untuk mendapat apa-apa maklumat yang diperlukan
            dan juga mendapatkan bayaran balik dari potongan gaji saya, sebagaimana yang dipinjamkan. Saya juga bersetuju menerima sebarang keputusan dari koperasi ini untuk menolak permohonan tanpa memberi sebarang alasan.</p>
        </div>

        <div class="footer">
            <p>Terima kasih kerana menggunakan perkhidmatan kami.</p>
        </div>
    </div>
</body>
</html>