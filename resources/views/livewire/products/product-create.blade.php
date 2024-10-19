<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="mb-1 fs-5 fw-bold mb-5">{{ __('Add New Product') }}</h2>
                            <div class="row mb-5">
                                <div class="col">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary text-white"
                                        wire:navigate><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <form wire:submit='create'>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                                    <input type="text" name="name" id="name" class="form-control" wire:model='name'>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="name" class="form-label">{{ __('Day') }}</label>
                                                    <select name="day" id="day" class="form-control" wire:model='day'>
                                                        <option value="">{{ __('Choose one...') }}</option>
                                                        <option value="Day 1">{{ __('Day 1') }}</option>
                                                        <option value="Day 2">{{ __('Day 2') }}</option>
                                                        <option value="Day 3">{{ __('Day 3') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="type" class="form-label">{{ __('Type') }}</label>
                                                    <select name="type" id="type" class="form-control" wire:model='type'>
                                                        <option value="">{{ __('Choose one...') }}</option>
                                                        <option value="Hands-On">{{ __('Hands-On') }}</option>
                                                        <option value="Seminar">{{ __('Seminar') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="date" class="form-label">{{ __('Date') }}</label>
                                                    <input type="date" name="date" id="date" class="form-control" wire:model='date'>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="price" class="form-label">{{ __('Price') }}</label>
                                                    <input type="text" name="price" id="price" class="form-control" wire:model='price'>
                                                </div>
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
