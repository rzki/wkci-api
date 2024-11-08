<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="fs-5 fw-bold mb-3">{{ __('Transaction History') }}</h2>
                            <div class="table-wrapper">
                                <div class="container-fluid px-3">
                                     <div class="row mb-3 add-button">
                                        <div class="col d-flex justify-content-end pb-3">
                                            <a href="{{ route('transactions.qr_manual') }}"
                                                class="btn btn-success ml-3 text-white" wire:navigate><i
                                                    class="fa fa-plus" aria-hidden="true"></i>{{ __(' Create Manual Transaction')
                                                }}</a>
                                        </div>
                                    </div>
                                    <div class="row filter">
                                        <div class="col">
                                            <div class="d-flex mb-3">
                                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#filterDropdown" aria-expanded="false"
                                                        aria-controls="filterDropdown">
                                                    {{ __('Date Filter') }}
                                                </button>
                                            </div>
                                            <div class="collapse" id="filterDropdown">
                                                <div class="card card-body border-0">
                                                    <div class="row">
                                                        <div class="col-lg-4">

                                                        </div>
                                                        <div class="col-lg-4">
                                                            {{-- <form wire:submit='dateFilter' method="get"> --}}
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <p class="text-center mb-1">{{ __('Start') }}</p>
                                                                    <input type="date" name="start-date"
                                                                           id="start-date" class="form-control"
                                                                           wire:model='start_date'>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <p class="text-center mb-1">{{ __('End') }}</p>
                                                                    <input type="date" name="end-date"
                                                                           id="end-date" class="form-control"
                                                                           wire:model.live.debounce.500ms='end_date'>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="row mt-3">
                                                                <button type="submit" class="btn btn-success text-white">Submit</button>
                                                            </div> --}}
                                                            {{-- </form> --}}
                                                        </div>
                                                        <div class="col-lg-4">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input wire:model.live.debounce.250ms='search' type="text" name="search"
                                                   id="search" class="form-control mb-3 w-25" placeholder="Search...">
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>
                                    <div class="row export">
                                        <div class="col">
                                            <a href="#export" class="btn btn-primary" wire:click='export'>XLS</a>
                                            <button wire:click="deleteSelected" class="btn btn-danger {{ count($selectedItems) ? '' : 'd-none' }}" >{{ __('Delete Selected Data')
                                            }}</button>
                                            <button wire:click="bulkUpdatePaymentStatus" class="btn btn-success text-white {{ count($selectedItems) ? '' : 'd-none' }}" >{{ __('Update payment status selected data')
                                            }}</button>
                                        </div>
                                    </div>
                                    <div class="table-wrapper table-responsive">
                                        <table class="table striped-table text-black text-center">
                                            <thead>
                                            <tr>
                                                <th>
{{--                                                    <input type="checkbox" name="selectAll" id="selectAll" wire:model="selectAll">--}}
                                                </th>
                                                <th style="width: 2em;">No</th>
                                                <th>{{ __('Ref. No') }}</th>
                                                <th>{{ __('Partner Ref. No') }}</th>
                                                <th>{{ __('Participant Name') }}</th>
                                                <th>{{ __('Nominal') }}</th>
                                                <th>{{ __('Bukti Transfer') }}</th>
                                                <th>{{ __('Paid At') }}</th>
                                                <th>{{ __('Payment Status') }}</th>
                                                <th style="width: 5em;">{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($transactions->isEmpty())
                                                <tr>
                                                    <td colspan='13' class="text-center">
                                                        {{ __('Data not found') }}
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($transactions as $trx)
                                                    <tr>
                                                        <td><input type="checkbox" name="selectedItems" id="selectedItems" wire:key="{{ $trx->id }}" value="{{
                                                        $trx->id }}" wire:model.live="selectedItems"></td>
                                                        <td>{{ $transactions->firstItem() + $loop->index }}</td>
                                                        <td>{{ $trx->trx_ref_no ?? '' }}</td>
                                                        <td>{{ $trx->partner_ref_no ?? '' }}</td>
                                                        <td>{{ $trx->participant_name }}</td>
                                                        @if($trx->amount == null)
                                                            <td>{{ "IDR 0,00" }}</td>
                                                        @elseif($trx->amount == '0,00')
                                                            <td>{{ "IDR 0,00" }}</td>
                                                        @else
                                                            <td>{{ "IDR ".number_format($trx->amount, 2, '.', ',') }}</td>
                                                        @endif
                                                        @if($trx->trx_proof != null)
                                                            <td>
                                                                <a href="{{ $trx->trx_proof }}" target="_blank" class="text-decoration-underline text-info"><i class="fas
                                                        fa-up-right-from-square"></i> {{ __(' Lihat Bukti Transfer')}}</a>
                                                            </td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        <td>{{ date('d/m/Y H:i:s', strtotime($trx->paid_at)) ?? '' }}</td>
                                                        <td>{{ $trx->payment_status ?? '' }}</td>
                                                        <td>
                                                            <button class="btn btn-info"
                                                                    wire:click.prevent="updatePaymentStatus('{{ $trx->transactionId }}')"><i
                                                                    class="fas fa-rotate-right" title="Update Payment"></i></button>
                                                            <button class="btn btn-danger"
                                                                    wire:click.prevent="deleteConfirm('{{ $trx->transactionId }}')"><i
                                                                    class="fas fa-trash" title="Delete Entry"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <div class="row mt-4">
                                            <div class="col-lg-6 d-flex align-items-center">
                                                <label class="text-black font-bold form-label me-3 mb-0">Per
                                                    Page</label>
                                                <select wire:model.live='perPage'
                                                        class="form-control text-black per-page" style="width: 7%">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 d-flex align-items-center justify-content-end">
                                                {{ $transactions->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@script
<script>
    window.addEventListener('delete-confirmation', event => {
        Swal.fire({
            title: "Are you sure?",
            text: "Transaction history will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.dispatch('deleteConfirmed');
            }
        });
    })
</script>
<script>
    window.addEventListener('print-qr', event => {
        $wire.dispatch('printThisQR');
    })
</script>
@endscript
@if (session()->has('alert'))
    @script
    <script>
        const alerts = @json(session()->get('alert'));
        const title = alerts.title;
        const icon = alerts.type;
        const toast = alerts.toast;
        const position = alerts.position;
        const timer = alerts.timer;
        const progbar = alerts.progbar;
        const confirm = alerts.showConfirmButton;

        Swal.fire({
            title: title,
            icon: icon,
            toast: toast,
            position: position,
            timer: timer,
            timerProgressBar: progbar,
            showConfirmButton: confirm
        });
    </script>
    @endscript
@endif
