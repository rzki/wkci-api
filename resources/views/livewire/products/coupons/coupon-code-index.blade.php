<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="fs-5 fw-bold mb-3">{{ __('All Coupons') }}</h2>
                            <div class="table-wrapper">
                                <div class="container-fluid px-3">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end pb-3">
                                            <a href="{{ route('coupons.create') }}"
                                               class="btn btn-success ml-3 text-white" wire:navigate><i
                                                    class="fa fa-plus"
                                                    aria-hidden="true"></i>{{ __(' New Coupons') }}</a>
                                        </div>
                                    </div>
                                    <div class="table-wrapper table-responsive">
                                        <table class="table striped-table text-black text-center">
                                            <thead>
                                            <tr>
                                                <th style="width: 2em;">No</th>
                                                <th>{{ __('Code') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Discount') }}</th>
                                                <th>{{ __('Valid From') }}</th>
                                                <th>{{ __('Valid To') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($coupons as $coupon)
                                                <tr>
                                                    <td>{{ $coupons->firstItem() + $loop->index }}</td>
                                                    <td>{{ $coupon->code ?? '' }}</td>
                                                    <td>{{ $coupon->name ?? '' }}</td>
                                                    <td>{{ $coupon->quantity ?? '' }}</td>
                                                    <td>{{ $coupon->discount ?? '' }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($coupon->valid_from)) }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($coupon->valid_to)) }}</td>
                                                    <td>
                                                        <a href="{{ route('coupons.edit', $coupon->couponId) }}"
                                                           class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        <button class="btn btn-danger"
                                                                wire:click.prevent="deleteConfirm('{{ $coupon->couponId }}')"><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                                                {{ $coupons->links() }}
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
            text: "Coupon will be deleted permanently!",
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
