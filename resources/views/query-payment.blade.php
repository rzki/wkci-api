@extends('app')

@section('title', 'YUKK Payment Status')

@section('content')
    <div class="row min-vh-100">
        <div class="col d-flex justify-content-center align-items-center">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="fw-bold text-center">Payment Status</h2>
                    <hr style="border border-3 pb-3">
                    <div class="status-box mb-3 mx-3">
                        <h5 class="text-center">Reference No.</h5>
                        <h5 class="fw-bold text-center">{{ $queryResult['originalReferenceNo'] }}</h5>
                        <br>
                        <h5 class="text-center">Status</h5>
                        <h5 class="fw-bold text-center">{{ $queryResult['transactionStatusDesc'] }}</h5>
                    </div>
                    <br>
                    <h3 class="fw-bold">Rp.{{ $queryResult['amount']['value'] }}</h3>
                    <a href="#" class="btn btn-success btn-block" onclick="window.location.reload()">Check Payment Status</a>
                </div>
            </div>
        </div>
    </div>
@endsection
