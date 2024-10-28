<div>
    <div class="py-4 main">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="px-0 col-12">
                    <div class="border-0 shadow card">
                        <div class="card-body">
                            <h2 class="mb-1 fs-5 fw-bold mb-5">{{ __('My Profile') }}</h2>
                            <div class="row">
                                <div class="col">
                                    <form wire:submit='updateProfile'>
                                        <div class="form-group mb-3">
                                            <label for="nama" class="form-label">{{ __('Name') }}</label>
                                            <input type="text" class="form-control" wire:model='nama'>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="email" class="form-control" wire:model='email'>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <input type="password" name="password" id="password" class="form-control" wire:model='password'>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Password') }}</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success text-white">{{ __('Submit') }}</button>
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
