@extends('app')

@section('title', 'YUKK Payment Status')

@section('content')
    <div class="row min-vh-100">
        <div class="col d-flex justify-content-center align-items-center">
            <div class="card">
                <div class="card-body text-center">
                    <div class="status-box mb-3 mx-3">
                        <h2 class="fw-bold text-center mb-5">Payment Successful</h2>
                        <img src="{{ asset('images/icons/circle-check-solid.png') }}" alt="" class="mb-5 w-25">
                        <!-- /.fas -->
                        <h5 class="text-center">Reference No.</h5>
                        <h5 class="fw-bold text-center">{{ $queryResult['originalReferenceNo'] }}</h5>
                        <br>
                        <h5 class="text-center">Status</h5>
                        <h5 class="fw-bold text-center">{{ $queryResult['transactionStatusDesc'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        {{-- {{ json_encode($queryResult) }} --}}
    </div>
@endsection
