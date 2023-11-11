@extends('layouts.main')
@section('title', 'Whatsapp')

@section('container')
    @php
        $decodedData = json_decode($response['body'], true);
        $data = $decodedData['data'];
        $meta = $decodedData['meta'];
        // $image_qr = json_decode($qr['body'], true);
    @endphp
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="font-weight-bold">Whatsapp Status Device</h2>
                            </div>
                        </div>


                        <div class="card-body">
                            <a href="{{ route('qr-code') }}" class="btn btn-primary mb-3"><i
                                    class="bi bi-arrow-clockwise"></i>
                                Reconnect </a>
                            <table id="" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $data[0]['id'] }}</td>
                                        <td>{{ $data[0]['status'] }}</td>
                                        {{-- <td>
                                            <a href="{{ route('delete-devices') }}"
                                                onclick="return confirm('Data akan dihapus')" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash3"></i> Delete
                                            </a>
                                        </td> --}}
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
