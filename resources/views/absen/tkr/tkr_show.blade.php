@extends('layouts.main')
@section('title', 'Absensi')

@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="font-weight-bold">Data Absensi TKR</h2>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Keterangan</th>
                                        <th>Izin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absen_tkr as $data)
                                        <tr>
                                            <td>{{ $data->rStudent->name }}</td>
                                            <td>{{ $data->rStudent->kelas }}</td>
                                            <td>{{ $data->rStudent->jurusan }}</td>
                                            <td>
                                                @if ($data->jam_masuk != null)
                                                    {{ Carbon\Carbon::parse($data->jam_masuk)->format('d-m-Y / H:i') }}
                                                @else
                                                    {{ $data->jam_masuk }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->jam_keluar != null)
                                                    {{ Carbon\Carbon::parse($data->jam_keluar)->format('d-m-Y / H:i') }}
                                                @else
                                                    {{ $data->jam_keluar }}
                                                @endif
                                            </td>
                                            <td>{{ $data->keterangan }}</td>
                                            <td>{{ $data->izin }}</td>
                                            <td><a href="{{ route('edit-absen', $data->id) }}"
                                                    class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i>
                                                    Edit</a>
                                            </td>
                                            {{-- <td><a href="{{ route('edit-absen', $data->id) }}"
                                                    class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i>
                                                    Edit</a>
                                                <a href="{{ route('delete-absen', $data->id) }}"
                                                    onclick="return confirm('data akan dihapus')"
                                                    class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i>
                                                    Delete</a>
                                            </td> --}}
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
