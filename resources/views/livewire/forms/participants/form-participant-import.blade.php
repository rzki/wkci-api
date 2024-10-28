<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="fs-5 fw-bold py-3">{{ __('Import Data Participant Forms') }}</h2>
                            <div class="table-wrapper">
                                <div class="container-fluid px-3">
                                    <div class="row mb-3">
                                        <div class="col d-flex justify-content-start pb-3">
                                            <a href="{{ route('forms.participant.index') }}"
                                               class="btn btn-primary ml-3 text-white" wire:navigate><i
                                                    class="fa fa-arrow-left" aria-hidden="true"></i>{{ __(' Back')
                                                }}</a>
                                        </div>
                                    </div>
                                    <form wire:submit='import' method="post" enctype="multipart/form-data">
                                        <div x-data="{uploading: false, progress: 0}" x-on:livewire-upload-start="{uploading: true}" x-on:livewire-upload-finish="{uploading: false}" x-on:livewire-upload-cancel="{uploading: false}" x-on:livewire-upload-error="{uploading: false}" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                            <div class="upload mb-3 justify-content-center text-center" wire:loading wire:target='users'>{{ __('Sedang mengunggah...') }}</div>
                                            <div class="row">
                                                <div class="form-group mb-4">
                                                    <label for="form_import" class="form-label fw-bold">{{ __('Choose file to upload') }}</label>
                                                    <input type="file" name="forms" id="forms" class="form-control"
                                                           wire:model='forms' required>
                                                    <small class="text-muted">{{ __('Supported file: xlsx') }}</small>
                                                <div class="upload mb-3 justify-content-center text-center" wire:loading wire:target='forms'>{{ __('Uploading...') }}</div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success text-white">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
            text: "Product will be deleted permanently!",
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
