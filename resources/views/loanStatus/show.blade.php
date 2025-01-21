<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pinjaman') }} <strong>{{$loan->loan_type->loan_type}}</strong></h2>
                <a href="{{ route('loan.export', $loan->loan_id) }}" class="ml-4">
                    <x-primary-button type="submit" class="bg-green-500 hover:bg-green-700">{{ __('EXPORT') }}</x-primary-button>
                </a>
            </div>
            <a href="{{ route('loan.display') }}">
                <x-primary-button type="submit" class="bg-blue-100 hover:bg-blue-700">{{ __('KEMBALI') }}</x-primary-button>
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
                
                    <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                            <i class="fas fa-info-circle"></i>Maklumat Pinjaman
                        </h3>
                        <p class="text-white" style="margin-top: 10px;">
                            <strong>Status:</strong>
                            <span class="status-badge bg-{{ $loan->status == 'pending' ? 'yellow' : ($loan->status == 'rejected' ? 'red' : 'green') }}-100 text-{{ $loan->status == 'pending' ? 'yellow' : ($loan->status == 'rejected' ? 'red' : 'green') }}-800">
                                {{ $loan->status == 'pending' ? 'SEDANG DIPROSES' : ($loan->status == 'rejected' ? 'DITOLAK' : 'DILULUSKAN') }}
                            </span>
                        </p>
                    </div>
                    <br>

                    <div class="flex">
                        <div class="w-1/2 pr-2">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Pinjaman ID</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:{{$loan->loan_id}}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Amaun</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:RM {{number_format($loan->loan_amount, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Bayaran Bulanan</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:RM {{number_format($loan->monthly_repayment, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Tempoh</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:{{$loan->loan_period}} bulan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="w-1/2 pl-2">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Gaji Bersih</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:RM {{number_format($loan->monthly_net_salary, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Gaji Kasar</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:RM {{number_format($loan->monthly_gross_salary, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Kadar</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:{{$loan->interest_rate}}%</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Tarikh Pinjaman</strong></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">:{{$loan->created_at}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>

            <!-- Bank Details -->
            <div class="info-card">
                <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                            <i class="fas fa-university"></i>Maklumat Bank
                        </h3>
                </div>
                <br>

                <div class="details-grid">
                    <div class="w-1/2 pr-2">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/2"><strong>Nama Bank</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-1/2">: {{$loan->bank->bank_name}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="w-1/2 pl-2">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/2"><strong>Akaun No</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-1/2">: {{$loan->bank->bank_account}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Guarantor Details -->
            <div class="info-card">
                <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                            <i class="fas fa-user-shield"></i>Maklumat Penjamin
                        </h3>
                </div>

                <br>

            <div class="details-grid">
                <div class="border-r pr-4">
                    <h4 class="font-semibold text-lg">Penjamin Pertama</h4>
                    @if(isset($loan->guarantors[0]))
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Nama</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[0]->name}}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>IC</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[0]->ic}}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>No Tel</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[0]->phone}}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Hubungan</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[0]->relationship}}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p>Tiada maklumat penjamin 1.</p>
                    @endif
                </div>
                <div class="pl-4">
                    <h4 class="font-semibold text-lg">Penjamin Kedua</h4>
                    @if(isset($loan->guarantors[1]))
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Nama</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[1]->name}}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>IC</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[1]->ic}}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>No Tel</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[1]->phone}}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/5"><strong>Hubungan</strong></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 w-4/5">: {{$loan->guarantors[1]->relationship}}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p>Tiada maklumat penjamin 2.</p>
                    @endif
                </div>
            </div>
            </div>

        </div>
    </div>
</x-app-layout>