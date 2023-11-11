@extends('layouts.main')
@section('title', 'Siswa')

@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                {{-- <div class="dropdown">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        Update Data Kelas Siswa
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label for="formGroupExampleInput">Example label</label>
                                                            <input type="text" class="form-control"
                                                                id="formGroupExampleInput" placeholder="Example input">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label>Kelas</label>
                                                                    <select class="custom-select form-control"
                                                                        id="kelas_edit" name="kelas_edit">
                                                                        @foreach (['X', 'XI', 'XII'] as $option)
                                                                            <option value="{{ $option }}">
                                                                                {{ $option }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label>Jurusan</label>
                                                                    <select class="custom-select form-control"
                                                                        id="jurusan_edit" name="jurusan_edit">
                                                                        @foreach (['DPIB', 'TITL', 'TJKT', 'TKR'] as $option)
                                                                            <option value="{{ $option }}">
                                                                                {{ $option }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                Pilih Jurusan
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item" href="#">DPIB</a>
                                                                <a class="dropdown-item" href="#">TITL</a>
                                                                <a class="dropdown-item" href="#">TJKT</a>
                                                                <a class="dropdown-item" href="#">TKR</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <h2 class="font-weight-bold">Data Siswa</h2>
                                <a href="{{ route('naik_kelas') }}"
                                    onclick="return confirm('Siswa akan dinaikan kelas selanjutnya')"
                                    class="btn btn-primary mb-3 run"><i class="bi bi-arrow-up-circle"></i> Naik Kelas</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="{{ route('create-student') }}" class="btn btn-primary mb-3"><i
                                    class="bi bi-plus-circle"></i> Tambah
                                Data</a>
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor Kartu</th>
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
                                            <td>{{ $data->nomor_kartu }}</td>
                                            <td>{{ $data->uid }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->kelas }}</td>
                                            <td>{{ $data->jurusan }}</td>
                                            <td>{{ $data->hp_ortu }}</td>
                                            <td>{{ $data->nis }}</td>
                                            <td><a href="{{ route('edit-student', $data->id) }}"
                                                    class="btn btn-sm btn-success"><i class="bi bi-pencil-square"></i>
                                                    Edit</a>
                                                <a href="{{ route('delete-student', $data->id) }}"
                                                    onclick="return confirm('data akan dihapus')"
                                                    class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i>
                                                    Delete</a>
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
