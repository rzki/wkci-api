<div>
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="mb-1 fs-5 fw-bold mb-5">{{ __('Create Manual Transaction') }}</h2>
                            <div class="row mb-5">
                                <div class="col">
                                    <a href="{{ route('transactions.index') }}" class="btn btn-primary text-white"
                                    wire:navigate><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <form wire:submit='submitData'>
                                        <div class="row">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                                <input type="text" name="name" id="name" class="form-control" wire:model='name'>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-3">
                                                <label for="amount" class="form-label">{{ __('Amount') }}</label>
                                                <input type="amount" name="amount" id="amount" class="form-control" wire:model='amount'>
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
