<div>
    <div class="container">
        <div class="row">
            <div class="card">
                <h2 class="fw-extrabold text-center py-3">Seminar Registration <br> Jakarta Dental Exhibition (JADE) 2024
                </h2>
                <div class="card-body">
                    <form wire:submit.prevent='submit'>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="name_str"
                                        class="form-label fw-bold">{{ __('Nama Sesuai STR (Tanpa Gelar)') }}</label>
                                    <input type="text" name="name_str" id="name_str" class="form-control"
                                        wire:model='name_str' required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="name_ktp"
                                        class="form-label fw-bold">{{ __('Nama Lengkap (Sesuai KTP)') }}</label>
                                    <input type="text" name="name_ktp" id="name_ktp" class="form-control"
                                        wire:model='name_ktp' required>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="email" class="form-label fw-bold">{{ __('Email Aktif') }}</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    wire:model='email' required>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="nik" class="form-label fw-bold">NIK</label>
                                    <input type="text" name="" id="" class="form-control"
                                        wire:model='nik' required maxlength="16" ">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="npa"
                                        class="form-label fw-bold">{{ __('Nomor NPA (6 digit terakhir)') }}</label>
                                    <input type="text" name="npa" id="npa" class="form-control"
                                        wire:model='npa' required maxlength="6" ">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="pdgi_cabang" class="form-label fw-bold">{{ __('PDGI Cabang (Opsional)') }}</label>
                                    <input type="text" name="pdgi_cabang" id="pdgi_cabang" class="form-control"
                                        wire:model='pdgi_cabang'>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="no_telepon" class="form-label fw-bold">{{ __('No Telepon') }}</label>
                                    <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                                        wire:model='no_telepon' required>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="seminar_type" class="form-label">{{ __('Tipe Peserta Seminar') }}</label>
                                <select name="seminars" id="seminars" class="form-control"
                                    wire:model='selectedSeminarId' wire:change='calculateTotalAmount'>
                                    <option value="">{{ __('Choose one...') }}</option>
                                    @foreach ($seminars as $sem)
                                        <option value="{{ $sem->id }}">{{ $sem->name }} -
                                            {{ 'Rp ' . number_format($sem->price, 2, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">{{ __('Daftar Hands-On') }}</label>
                                <div class="row gx-5">
                                    @foreach ($handsOn as $ho)
                                        <div class="col-lg-6">
                                            <div class="row mb-3 border border-3 border-black py-3 rounded-2">
                                                <div class="col-lg-1 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="isHandsOnChecked" id="isHandsOnChecked"
                                                        wire:model='isHandsOnChecked.{{ $ho->id }}' value="{{ $ho->id }}" wire:change='calculateTotalAmount' @if($ho->code ==
                                                        'HO10') disabled @endif>
                                                </div>
                                                <div class="col-lg-11">
                                                    <label for="checkedHandsOn">
                                                        <p class="fw-semibold text-uppercase mb-1">{{ $ho['code'] }}
                                                        </p>
                                                        <p class="fw-extrabold text-uppercase mb-1">{{ $ho['name'] }}
                                                        </p>
                                                        <p class="mb-1">Topic : {{ $ho['description'] }}</p>
                                                        <p class="fw-bold mb-1">
                                                            IDR.{{ number_format($ho['price'], 2, ',', '.') }}</p>
                                                        <p class="text-capitalize mb-1">
                                                            {{ date('l, d F Y', strtotime($ho['date'])) }}</p>
                                                        <p class="text-capitalize mb-1">Pukul :
                                                            {{ date('H:i', strtotime($ho['start_time'])) }} -
                                                            {{ date('H:i', strtotime($ho['end_time'])) }}</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-4">
                                        <label for="couponCode" class="form-label fw-bold">{{ __('Promo Code (Optional)') }}</label>
                                        <input type="text" name="couponCode" id="couponCode" class="form-control"
                                               wire:model.live='couponCode'>
                                        @if($messageSuccess)
                                            <p class="text-success">{{ $messageSuccess }}</p>
                                        @else
                                            <p class="text-danger">{{ $messageFailed }}</p>
                                        @endif
                                        <small class="text-muted">Enter valid promo code</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center mb-3">
                                <h5>Total: <h4 class="fw-extrabold" wire:model='totalAmount'>
                                        {{ 'Rp ' . number_format($totalAmount, 2, ',', '.') }}
                                    </h4>
                                </h5>
                            </div>
                            @if($discountedPrice)
                            <div class="form-group text-center mb-3">
                                <p>Discount: <h6 class="fw-extrabold" wire:model='discountedPrice'>
                                        {{ '- Rp ' . number_format($discountedPrice, 2, ',', '.') }}
                                    </h6>
                                </p>
                            </div>
                                <div class="form-group text-center mb-3">
                                    <h5>Total: <h4 class="fw-extrabold" wire:model='finalTotalAmount'>
                                            {{ 'Rp ' . number_format($finalTotalAmount, 2, ',', '.') }}
                                        </h4>
                                    </h5>
                                </div>
                            @endif
                            <div class="d-grid">
                                <button type="submit"
                                    class="btn btn-success text-white">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
