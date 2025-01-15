<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <!-- View button -->
    <a href="{{ route('admin.members.show', $member->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
        <i class="fas fa-eye"></i>
    </a>

    <!-- Add Transaction button -->
    <button onclick="openTransactionModal({{ $member->id }})" class="text-green-600 hover:text-green-900 mr-3">
        <i class="fas fa-money-bill"></i>
    </button>
</td>

<!-- Transaction Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="transactionForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Transaction Type</label>
                        <select class="form-select" id="transactionType" name="type" required>
                            <option value="savings">Savings Deposit</option>
                            <option value="loan">Loan Repayment</option>
                        </select>
                    </div>

                    <div class="mb-3" id="savingsTypeDiv">
                        <label class="form-label">Savings Type</label>
                        <select class="form-select" name="savings_type">
                            <option value="share_capital">Share Capital</option>
                            <option value="subscription_capital">Subscription Capital</option>
                            <option value="member_deposit">Member Deposit</option>
                            <option value="welfare_fund">Welfare Fund</option>
                            <option value="fixed_savings">Fixed Savings</option>
                        </select>
                    </div>

                    <div class="mb-3" id="loanDiv" style="display: none;">
                        <label class="form-label">Select Loan</label>
                        <select class="form-select" name="loan_id">
                            <!-- Will be populated dynamically -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount (RM)</label>
                        <input type="number" class="form-control" name="amount" step="0.01" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitTransaction()">Submit</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentMemberId = null;

function openTransactionModal(memberId) {
    currentMemberId = memberId;
    if ($('#transactionType').val() === 'loan') {
        fetchMemberLoans(memberId);
    }
    $('#transactionModal').modal('show');
}

function fetchMemberLoans(memberId) {
    fetch(`/admin/members/${memberId}/loans`)
        .then(response => response.json())
        .then(loans => {
            const loanSelect = $('select[name="loan_id"]');
            loanSelect.empty();
            loans.forEach(loan => {
                loanSelect.append(`<option value="${loan.id}">Loan #${loan.loan_id} (RM${loan.loan_amount})</option>`);
            });
        });
}

$('#transactionType').change(function() {
    if (this.value === 'savings') {
        $('#savingsTypeDiv').show();
        $('#loanDiv').hide();
    } else {
        $('#savingsTypeDiv').hide();
        $('#loanDiv').show();
        if (currentMemberId) {
            fetchMemberLoans(currentMemberId);
        }
    }
});

function submitTransaction() {
    const form = $('#transactionForm');
    const data = new FormData(form[0]);

    fetch(`/admin/members/${currentMemberId}/transaction`, {
        method: 'POST',
        body: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
        } else {
            alert('Transaction successful');
            $('#transactionModal').modal('hide');
            // Optionally refresh the page or update the display
            location.reload();
        }
    })
    .catch(error => {
        alert('Error: ' + error);
    });
}
</script>
@endpush 