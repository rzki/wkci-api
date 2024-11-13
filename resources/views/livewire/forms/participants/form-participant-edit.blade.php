<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="mb-1 fs-5 fw-bold mb-5">{{ __('Edit Form') }}</h2>
                            <div class="row mb-5">
                                <div class="col">
                                    <a href="{{ route('forms.index') }}" class="btn btn-primary text-white"
                                        wire:navigate><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <form wire:submit='update'>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="full_name" class="form-label">{{ __('Full Name') }}</label>
                                                    <input type="text" name="full_name" id="full_name" class="form-control" wire:model='full_name'>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                                    <input type="text" name="email" id="email" class="form-control" wire:model='email'>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                                    <input type="text" name="phone" id="phone" class="form-control" wire:model='phone'>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="origin" class="form-label">{{ __('Asal Institusi/Perusahaan/Klinik') }}</label>
                                                    <input type="text" name="origin" id="origin" class="form-control" wire:model='origin'>
                                                </div>
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit"
                                                    class="btn btn-success text-white">{{ __('Submit') }}</button>
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
