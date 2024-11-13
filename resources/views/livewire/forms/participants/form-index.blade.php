<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="fs-5 fw-bold mb-3">{{ __('All Forms Participants') }}</h2>
                            <div class="table-wrapper">
                                <div class="container-fluid px-3">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-end pb-3">
                                            <a href="{{ route('forms.participant.import') }}"
                                                class="btn btn-success ml-3 text-white" wire:navigate><i
                                                    class="fas fa-upload"
                                                    aria-hidden="true"></i>{{ __(' Import Data') }}</a>
                                        </div>
                                    </div>
                                    <div class="row filter">
                                        <div class="col">
                                            <div class="d-flex mb-3">
                                                <button class="btn btn-outline-primary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#filterDropdown"
                                                    aria-expanded="false" aria-controls="filterDropdown">
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
                                                                    <input type="date" name="end-date" id="end-date"
                                                                        class="form-control"
                                                                        wire:model.live.debounce.500ms='end_date'>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-4">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row search">
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
                                            <button wire:click="deleteSelected"
                                                class="btn btn-danger {{ count($selectedItems) ? '' : 'd-none' }}">{{ __('Delete Selected Data (' . count($selectedItems) . ')') }}</button>
                                            <button wire:click="sendBulkEmail"
                                                class="btn btn-success text-white {{ count($selectedItems) ? '' : 'd-none' }}">{{ __('Email Selected Data (' . count($selectedItems) . ')') }}</button>
                                        </div>
                                    </div>
                                    <div class="table-wrapper table-responsive">
                                        <div class="row my-4">
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
                                                {{ $forms->links() }}
                                            </div>
                                        </div>
                                        <table class="table striped-table text-black text-center">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" name="selectAll" id="selectAll"
                                                            wire:model.live='selectAll'>
                                                    </th>
                                                    <th style="width: 2em;">No</th>
                                                    <th>{{ __('Full Name') }}</th>
                                                    <th>{{ __('Email') }}</th>
                                                    <th>{{ __('Phone') }}</th>
                                                    <th>{{ __('Asal Institusi/Perusahaan/Klinik') }}</th>
                                                    <th>{{ __('Tanggal Registrasi') }}</th>
                                                    <th style="width: 5em;">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($forms->isEmpty())
                                                    <tr>
                                                        <td colspan='7' class="text-center">
                                                            {{ __('Data not found') }}
                                                        </td>
                                                    </tr>
                                                @else
                                                @endif
                                                @foreach ($forms as $form)
                                                    <tr>
                                                        <td><input type="checkbox" name="selectedItems"
                                                                id="selectedItems" wire:model.live="selectedItems"
                                                                value="{{ $form->id }}"></td>
                                                        <td>{{ $forms->firstItem() + $loop->index }}</td>
                                                        <td>{{ $form->full_name ?? '' }}</td>
                                                        <td>{{ $form->email ?? '' }}</td>
                                                        <td>{{ $form->phone ?? '' }}</td>
                                                        <td>{{ $form->origin ?? '' }}</td>
                                                        <td>{{ date('d/m/Y H:i:s', strtotime($form->submitted_date)) }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('forms.participant.detail', $form->formId) }}"
                                                                class="btn btn-primary">
                                                                <i class="fas fa-eye"></i>
                                                                <!-- /.fas -->
                                                            </a>
                                                            <a href="{{ route('forms.participant.edit', $form->formId) }}"
                                                                class="btn btn-info">
                                                                <i class="fas fa-edit"></i>
                                                                <!-- /.fas -->
                                                            </a>
                                                            <button class="btn btn-success"
                                                                wire:click.prevent="sendEmail('{{ $form->formId }}')"><i
                                                                    class="fas
                                                            fa-envelope"></i></button>
                                                            <button class="btn btn-danger"
                                                                wire:click.prevent="deleteConfirm('{{ $form->formId }}')"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row my-4">
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
                                                {{ $forms->links() }}
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
                text: "Form entry will be deleted permanently!",
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
