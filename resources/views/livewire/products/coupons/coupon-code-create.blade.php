<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="mb-1 fs-5 fw-bold mb-5">{{ __('Add New Coupon') }}</h2>
                            <div class="row mb-5">
                                <div class="col">
                                    <a href="{{ route('coupons.index') }}" class="btn btn-primary text-white"
                                       wire:navigate><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <form wire:submit='create'>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="code" class="form-label">{{ __('Code') }}</label>
                                                    <input type="text" name="code" id="code" class="form-control"
                                                           wire:model='code'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <input type="text" name="name" id="name" class="form-control" wire:model='name'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="discount" class="form-label">{{ __('Discount') }}</label>
                                                    <input type="text" name="discount" id="discount" class="form-control" wire:model='discount'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                                                    <input type="number" name="quantity" id="quantity" class="form-control" wire:model='quantity'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="valid_from" class="form-label">{{ __('Valid From') }}</label>
                                                    <input type="date" name="valid_from" id="valid_from" class="form-control" wire:model='from'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="valid_to" class="form-label">{{ __('Valid To') }}</label>
                                                    <input type="date" name="valid_to" id="valid_to" class="form-control" wire:model='to'>
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
