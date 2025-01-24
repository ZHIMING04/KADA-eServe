<!DOCTYPE html>
<html>
<head>
    <title>Butiran Pinjaman</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 20px;
            color: #333;
            font-size: 12px;
        }
        .container {
            width: 100%;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 0 auto;
            border-radius: 8px;
        }
        .section {
            margin-bottom: 10px;
        }
        .section-title {
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 5px;
            text-align: center;
            font-size: 14px;
            color: #0056b3;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        td {
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #0056b3;
        }
        .header p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
            <table>
                <tr rowspan='2'>
                    <td style="border: none;">
                        <img src="{{ public_path('images/KADAlogoresize.png') }}" alt="KADA Logo" class="logo">
                    </td>
                    <td>
                        <div class="header">
                        <h1>PERMOHONAN PEMBIAYAAN ANGGOTA</h1>
                        <p>Dijana pada {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                        </div>
                    </td>
            </table>

        <div class="section">
            <div class="section-title">Butiran Pinjaman</div>
            <table>
                <tr>
                    <th>ID Pinjaman</th>
                    <td>{{ $loan->loan_id }}</td>
                </tr>
                <tr>
                    <th>Jenis Pinjaman</th>
                    <td>{{ $loan->loan_type->loan_type }}</td>
                </tr>
                <tr>
                    <th>Amaun Pinjaman</th>
                    <td>RM {{ number_format($loan->loan_amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Bayaran Bulanan</th>
                    <td>RM {{ number_format($loan->monthly_repayment, 2) }}</td>
                </tr>
                <tr>
                    <th>Kadar Faedah</th>
                    <td>{{ $loan->interest_rate }}%</td>
                </tr>
                <tr>
                    <th>Tarikh Pinjaman</th>
                    <td>{{ $loan->created_at }}</td>
                </tr>
            </table>
        </div>

        <br>

        <div class="section">
            <div class="section-title">Butiran Peribadi Pemohon</div>
            <table>
                <tr>
                    <th>Nama</th>
                    <td>{{ $member->name }}</td>
                </tr>
                <tr>
                    <th>No K/P</th>
                    <td>{{ $member->ic }}</td>
                </tr>
                <tr>
                    <th>Tarikh Lahir</th>
                    <td>{{ $member->DOB }}</td>   
                </tr>
                <tr>
                    <th>Agama</th>
                    <td>{{ $member->agama }}</td>
                </tr>
                <tr>
                    <th>Bangsa</th>
                    <td>{{ $member->bangsa }}</td>
                </tr>
                <tr>
                    <th>No. Telefon</th>
                    <td>{{ $member->phone }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $member->address }}</td>
                </tr>
                <tr>
                    <th>Poskod</th>
                    <td>{{ $member->postcode }}</td>
                </tr>
                <tr>
                    <th>Bandar</th>
                    <td>{{ $member->city }}</td>
                </tr>
                <tr>
                    <th>Negeri</th>
                    <td>{{ $member->state }}</td>
                </tr>
            </table>
        </div>

        <br>

        <div class="section">
            <div class="section-title">Butiran Pekerjaan</div>
            <table>
                <tr>
                    <th>No Anggota</th>
                    <td>{{ $member->no_anggota }}</td>
                </tr>
                <tr>
                    <th>No. PF</th>
                    <td>{{ $member->no_pf}}</td>
                </tr>
                <tr>
                    <th>Alamat Pejabat</th>
                    <td>{{ $member->office_address }}</td>
                </tr>
                <tr>
                    <th>Poskod</th>
                    <td>{{ $member->office_postcode }}</td>
                </tr>
                <tr>
                    <th>Bandar</th>
                    <td>{{ $member->office_city }}</td>
                </tr>
                <tr>
                    <th>Negeri</th>
                    <td>{{ $member->office_state }}</td>
                </tr>
            </table>

        <br>

        <div class="section">
            <div class="section-title">Butiran Bank</div>
            <table>
                <tr>
                    <th>Nama Bank</th>
                    <td>{{ $loan->bank->bank_name }}</td>
                </tr>
                <tr>
                    <th>Akaun Bank</th>
                    <td>{{ $loan->bank->bank_account }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Penjamin</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>IC</th>
                        <th>Telefon</th>
                        <th>Alamat</th>
                        <th>Hubungan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loan->guarantors as $guarantor)
                        <tr>
                            <td>{{ $guarantor->name }}</td>
                            <td>{{ $guarantor->ic }}</td>
                            <td>{{ $guarantor->phone }}</td>
                            <td>{{ $guarantor->address }}</td>
                            <td>{{ $guarantor->relationship }}</td>
                        </tr>
                    @endforeach
                </tbody>

                Adalah dengan ini saya/kami rela hati bersetuju bersama-sama atau berasingan bertanggungjawab sepenuhnya ke atas ansuran harga barangan atau pembiayaan ini.
                Kami berjanji akan membayar balik kesemua ansuran hutang yang diberikan kepada peminjam di atas jika sekiranyan beliau tidak membayar balik ansuran itu mengikut perjanjian yang telah diperetujui.

            </table>
        </div>

        <br>

        <div class="section">
            <div class="section-title">Pengakuan Pemohon</div>
            <p>Saya {{ $member->name }}, No. K/P: {{ $member->ic }} dengan ini memberi kuasa kepada KOPERASI KAKITANGAN KADA KELANTAN BHD atau waliknya yang sah untuk mendapat apa-apa maklumat yang diperlukan
                dan juga mendapatkan bayaran balik dari potongan gaji saya, sebagaimana yang dipinjamkan. Say juga bersetuju menerima sebarang keputusan dari koperasi ini unutk menolak permohonan tanpa member sebarang alasan.</p>
        <div>

        <div class="footer">
            <p>Terima kasih kerana menggunakan perkhidmatan kami.</p>
        </div>

    </div>
</body>
</html>