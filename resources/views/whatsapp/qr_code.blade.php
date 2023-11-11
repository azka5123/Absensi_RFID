@extends('layouts.main')
@section('title', 'Qr Code')

@section('container')
    @php
        $image_qr = json_decode($response['body'], true);

    @endphp
    <section class="content-wrapper">
        <div class="container">
            <br><br>
            <div class="embed-responsive embed-responsive-21by9">
                <iframe class="embed-responsive-item" src="{{ $image_qr['image_url'] }}" allowfullscreen></iframe>
            </div>
            <a href="{{ route('get-devices') }}" class="btn btn-primary btnback"><i class="bi bi-arrow-left-circle"></i>
                Kembali</a>
        </div>
    </section>


@endsection
