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
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="name_str" class="form-label">{{ __('Nama (Sesuai STR)') }}</label>
                                                    <input type="text" name="name_str" id="name_str" class="form-control"
                                                           wire:model='name_str'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="full_name" class="form-label">{{ __('Nama Lengkap') }}</label>
                                                    <input type="text" name="full_name" id="full_name" class="form-control" wire:model='full_name'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                                    <input type="email" name="email" id="email" class="form-control" wire:model='email'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="nik" class="form-label">{{ __('NIK') }}</label>
                                                    <input type="text" name="nik" id="nik" class="form-control" wire:model='nik'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="npa" class="form-label">{{ __('NPA') }}</label>
                                                    <input type="text" name="npa" id="npa" class="form-control" wire:model='npa'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="cabang_pdgi" class="form-label">{{ __('PDGI Cabang') }}</label>
                                                    <input type="text" name="cabang_pdgi" id="cabang_pdgi" class="form-control" wire:model='cabang_pdgi'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="phone_number" class="form-label">{{ __('Nomor Telepon') }}</label>
                                                    <input type="text" name="phone_number" id="phone_number" class="form-control" wire:model='phone_number'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="attended" class="form-label">{{ __('Hands On') }}</label>
                                                    <input type="text" name="attended" id="attended" class="form-control" wire:model='attended'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="amount" class="form-label">{{ __('Total Harga') }}</label>
                                                    <input type="text" name="amount" id="amount" class="form-control" wire:model='amount'>
                                                </div>
                                            </div>
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
