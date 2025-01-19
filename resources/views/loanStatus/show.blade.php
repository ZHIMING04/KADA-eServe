<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pinjaman') }} <strong>{{$loan->loan_type->loan_type}}</strong></h2>
            <a href="{{ route('loan.display') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded">
                KEMBALI
            </a>
        </div>
    </x-slot>

    <style>
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
        .info-card {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem; /* Add margin to create gap between cards */
        }
        .info-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }
        .info-card h3 i {
            margin-right: 0.5rem;
        }
        .info-card p {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .status-bar {
            display: flex;
            justify-content: center; /* Center the status bar */
            align-items: center;
            margin-top: 1rem;
        }
        .status-step {
            display: flex;
            align-items: center;
        }
        .status-step .icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .status-step .line {
            height: 0.25rem;
            flex: 1;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.875rem;
        }
        .section {
            margin-bottom: 2rem;
        }
        .section-header {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1f2937;
            display: flex;
            align-items: center;
        }
        .section-header i {
            margin-right: 0.5rem;
            
            

        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }
        .details-grid p {
            margin: 0;
        }
    </style>

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Loan Details -->
            <div class="info-card">
                <div class="flex justify-between items-center">
                    <h3 class="section-header"><i class="fas fa-info-circle"></i>Maklumat Pinjaman</h3>
                    <p><strong>Status:</strong>
                        <span class="status-badge bg-{{ $loan->status == 'pending' ? 'yellow' : ($loan->status == 'rejected' ? 'red' : 'green') }}-100 text-{{ $loan->status == 'pending' ? 'yellow' : ($loan->status == 'rejected' ? 'red' : 'green') }}-800">
                            {{ $loan->status == 'pending' ? 'SEDANG DIPROSES' : ($loan->status == 'rejected' ? 'DITOLAK' : 'DILULUSKAN') }}
                        </span>
                    </p>
                </div>
                    <div class="details-grid">
                        <p><strong>Pinjaman ID:</strong> {{$loan->loan_id}}</p>
                        <p><strong>Amaun:</strong> RM {{number_format($loan->loan_amount, 2)}}</p>
                        <p><strong>Bayaran Bulanan:</strong> RM {{number_format($loan->monthly_repayment, 2)}}</p>
                        <p><strong>Kadar:</strong> {{$loan->interest_rate}}%</p>
                        <p><strong>Tempoh:</strong> {{$loan->loan_period}} bulan</p>
                        <p><strong>Gaji Kasar:</strong> RM {{number_format($loan->monthly_gross_salary, 2)}}</p>
                        <p><strong>Gaji Bersih:</strong> RM {{number_format($loan->monthly_net_salary, 2)}}</p>
                        <p><strong>Tarikh Pinjaman:</strong> {{$loan->created_at}}</p>
                    </div>
            </div>

            <!-- Bank Details -->
            <div class="info-card">
                <h3 class="section-header"><i class="fas fa-university"></i>Maklumat Bank</h3>
                <div class="details-grid">
                    <p><strong>Nama Bank:</strong> {{$loan->bank->bank_name}}</p>
                    <p><strong>Akaun No:</strong> {{$loan->bank->bank_account}}</p>
                </div>
            </div>

            <!-- Guarantor Details -->
            <div class="info-card">
                <h3 class="section-header"><i class="fas fa-user-shield"></i>Maklumat Penjamin</h3>
                @foreach($loan->guarantors as $guarantor)
                    <div class="details-grid">
                        <p><strong>Nama:</strong> {{$guarantor->name}}</p>
                        <p><strong>IC:</strong> {{$guarantor->ic}}</p>
                        <p><strong>No Tel:</strong> {{$guarantor->phone}}</p>
                        <p><strong>Hubungan:</strong> {{$guarantor->relationship}}</p>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>