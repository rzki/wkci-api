@extends('app')

@section('title', 'YUKK QR Payment')

@section('content')
    <div class="row min-vh-100">
        <div class="col d-flex justify-content-center align-items-center">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-center d-flex justify-content-center">{!! $qr !!}</div>
                    <hr style="border border-3">
                    <h2 class="fw-bold text-center">QRIS YUKK</h2>
                    <br class="pb-3">
                    <h4 class="fw-bold mb-3">Please scan QR code above to pay</h4>
                    <h5>Click button below to check the status of your order</h5>
                    <br>
                    <a href="" class="btn btn-success btn-block">Check Payment Status</a>
                </div>
            </div>
        </div>
    </div>
@endsection
