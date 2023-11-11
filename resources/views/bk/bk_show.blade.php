@extends('layouts.main')
@section('title', 'Bimbingan Konseling')

@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card mt-3">
                        <div class="card-header">
                            <h2 class="font-weight-bold">Data Siswa Telat/Terlambat(3x)</h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- <a href="{{ route('create-absen') }}" class="btn btn-primary mb-3"><i
                                    class="bi bi-plus-circle"></i> Tambah
                                Data</a> --}}
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Terlambat</th>
                                        <th>Alfa</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student as $data)
                                        <tr>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->kelas }}</td>
                                            <td>{{ $data->jurusan }}</td>
                                            <td>{{ $data->terlambat }}</td>
                                            <td>{{ $data->alfa }}</td>
                                            <td><a href="{{ route('restore_acc', $data->id) }}"
                                                    class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i>
                                                    Pulihkan Akun</a>
                                                {{-- <a href="{{ route('delete-absen', $data->id) }}"
                                                    onclick="return confirm('data akan dihapus')"
                                                    class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i>
                                                    Delete</a> --}}
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
