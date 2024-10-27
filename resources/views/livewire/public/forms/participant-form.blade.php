<div>
    <div class="container">
        <div class="row">
            <div class="card">
                <h2 class="fw-extrabold text-center py-3">Participant Registration <br> Jakarta Dental Exhibition (JADE)
                    2024
                </h2>
                <div class="card-body">
                    <form wire:submit.prevent='create'>
                        <div class="row">
                            <div class="form-group mb-4">
                                <label for="email" class="form-label fw-bold">{{ __('Email Aktif') }}</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    wire:model='email' required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="full_name" class="form-label fw-bold">{{ __('Nama Lengkap') }}</label>
                                <input type="text" name="" id="" class="form-control"
                                    wire:model='full_name' required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="no_telepon" class="form-label fw-bold">{{ __('No Telepon') }}</label>
                                <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                                    wire:model='no_telepon' required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="origin" class="form-label fw-bold">{{ __('Asal Institusi/Perusahaan/Klinik') }}</label>
                                <input type="text" name="origin" id="origin" class="form-control"
                                    wire:model='origin' required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success text-white">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
