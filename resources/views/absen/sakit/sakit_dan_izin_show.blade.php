@extends('layouts.main')
@section('title', 'Sakit dan Izin')

@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="font-weight-bold">Data Siswa</h2>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Nama Siswa</th>
                                        <th>kelas</th>
                                        <th>Jurusan</th>
                                        <th>Nomor Wa Ortu</th>
                                        <th>NIS</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student as $data)
                                        <tr>
                                            <td>{{ $data->uid }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->kelas }}</td>
                                            <td>{{ $data->jurusan }}</td>
                                            <td>{{ $data->hp_ortu }}</td>
                                            <td>{{ $data->nis }}</td>
                                            <td>
                                                <a href="{{ route('sakit', $data->id) }}" class="btn btn-sm btn-info"><i
                                                        class="bi bi-file-earmark-medical"></i>
                                                    Sakit</a>
                                                <a href="{{ route('izin', $data->id) }}" class="btn btn-sm btn-primary"><i
                                                        class="bi bi-envelope-check"></i>
                                                    Izin</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
