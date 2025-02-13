<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Individu</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .container {
                width: 100%;
                border: 1px solid black;
                padding: 20px;
                margin: 0 auto;
            }
            .header {
                display: flex;
                align-items: center;
            }
            .logo {
                width: 120px;
                height: 80px;
                margin-right: 20px;
            }
            .header-title {
                margin-left: 10px;
            }
            .header-title h3 {
                margin-left: 10px;
            }
            .section {
                margin-bottom: 20px;
            }
            .section-title {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
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
                        <div class="header-title">
                            <p>Nama: <strong>{{ $member->name }}</strong></p>
                            <p>IC: <strong>{{ $member->ic }}</strong> | No Ahli: <strong>{{ $member->no_pf }}</strong></p>
                        </div>
                    </td>
            </table>
                <div class="header-box">
                    Tuan/Puan,
                    <br>
                    <strong class="section-title">PENGESAHAN PENYATA KEWANGAN AHLI KOPERASI KAKITANGAN KADA KELANTAN BERHAD BAGI TAHUN BERAKHIR {{ date('t-m-Y') }}</strong>
                </div>
        
            

            
            <br>
            Untuk penentuan Juruaudit, kami dengan ini menyatakan bagi akaun tuan/puan adalah sebagaimana berikut:
            <br>
            <br>

            <div class="section">
                <div class="section-title">MAKLUMAT SAHAM AHLI</div>
                <table>
                    <tr>
                        <td>Modal Syer</td>
                        <td>Simpanan Tetap</td>                    
                        <td>Modal Yuran</td>
                        <td>Tabung Kebajikan</td>
                        
                    </tr>
                    <tr>
                        <td>{{ number_format($saving->share_capital,2) }}</td>
                        <td>{{ number_format($saving->subscription_capital,2) }}</td>
                        <td>{{ number_format($saving->fixed_savings,2) }}</td>
                        <td>{{ number_format($saving->welfare_fund,2) }}</td>
                    </tr>
                </table>
                </div>
                    <!-- Loan Details -->
                <div class="section-title">MAKLUMAT PINJAMAN AHLI</div>
                        <table>        
                            <thead>
                                <tr>
                                    <th>
                                        Pinjaman Jenis
                                    </th>
                                    <th>
                                        Amaun
                                    </th>
                                    <th>
                                        Bayaran Bulanan
                                    </th>
                                    <th>
                                        Kadar
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @php
                                            $approvedLoans = $loans->filter(function ($loan) {
                                            return $loan->status == 'approved';
                                            });
                                        @endphp

                                    @forelse($approvedLoans as $loan)
                            
                                <tr>
                                    <td>
                                        {{$loan->loan_type->loan_type }}
                                    </td>
                                    <td>
                                        RM {{number_format($loan->loan_amount, 2)}}
                                    </td>
                                    <td>
                                        RM {{number_format($loan->monthly_repayment, 2)}}
                                    </td>
                                    <td>
                                        {{$loan->interest_rate}}%
                                    </td>
                                </tr>
                                    @empty
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" colspan="6">
                                        TIADA REKOD PINJAMAN
                                    </td>
                                </tr>
                                    @endforelse
                            </tbody>
                        </table>
                </div>
                <br>
                <div class="section">
                    <strong>PENGESAHAN PENYATA KEWANGAN AHLI KOPERASI KAKITANGAN KADA KELANTAN BERHAD BAGI TAHUN BERAKHIR <strong>{{ date('t-m-Y') }}</strong></strong>
                    <p>Saya, <strong>{{ $member->name }}</strong>, No. Ahli: <strong>{{ $member->no_anggota }}</strong>, mengesahkan bahawa Penyata Kewangan Koperasi Kakitangan KADA Kelantan Berhad bagi tahun berakhir <strong>{{ date('t-m-Y') }}</strong> adalah seperti di atas.</p>
                    <p>Tarikh: <strong>{{ date('d-m-Y') }}</strong></p>
                </div>

                
                <p style="font-size: 12px;">Nota: Sekiranya pihak Koperasi tidak menerima maklum balas daripada tuan/puan sehingga <strong>{{ date('t-m-Y') }}</strong>, penyata ini dianggap diterima.</p>
                <p style="font-size: 12px;">Tuan/Puan dapat menghubungi pejabat Koperasi di talian 09-748 2000 untuk sebarang pertanyaan. Terima kasih.</p>
                
        </div>
    </body>
</html>
