<div>
    <div class="container">
        <div class="row min-vh-100">
            <div class="col d-flex justify-content-center align-items-center">
                <div class="card p-5">
                    <h2 class="fw-bold text-center">{{ __('Detail Peserta Hands-On') }}</h2>
                    <!-- /.fw-bold -->
                    <div class="card-body mb-0">
                        <div class="barcode-img text-center mb-5">
                            <img src="{{ asset('storage/'. $forms->barcode) }}" alt="" class="text-center">
                        </div>
                        <!-- /.text-center -->
                        <div class="row d-flex justify-content-center">
                            <div class="participant-table w-50 d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Nama Sesuai STR') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->name_str }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Nama Sesuai KTP') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->full_name }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Email') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->email }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('NIK') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->nik }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('NPA') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->npa }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('PDGI Cabang') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->cabang_pdgi ?? '' }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Nomor Telepon') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->phone_number }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Seminar & HO') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $forms->attended ?? '' }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                </div>
                                <!-- /.row -->
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            <!-- /.col -->
            <!-- /.card -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</div>
