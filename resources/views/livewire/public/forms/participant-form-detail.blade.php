<div>
    <div class="container">
        <div class="row min-vh-100">
            <div class="col d-flex justify-content-center align-items-center">
                <div class="card p-5">
                    <h2 class="fw-bold text-center">{{ __('Detail Peserta Pameran') }}</h2>
                    <!-- /.fw-bold -->
                    <div class="card-body mb-0">
                        <div class="barcode-img text-center mb-5">
                            <img src="{{ asset('storage/'. $participant->barcode) }}" alt="" class="text-center">
                        </div>
                        <!-- /.text-center -->
                        <div class="row d-flex justify-content-center">
                            <div class="participant-table w-50 d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Nama Lengkap') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $participant->full_name }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Email') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $participant->email }}</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Nomor Telepon') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $participant->phone }}</p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="fw-bolder mb-0 pb-0">
                                            {{ __('Asal Institusi/Perusahaan/Klinik') }}
                                        </p>
                                        <!-- /.mb-0 -->
                                    </div>
                                    <div class="col-lg-6">
                                        <p>{{ $participant->origin }}</p>
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
