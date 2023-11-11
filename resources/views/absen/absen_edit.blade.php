@extends('layouts.main')
@section('title', 'Edit Absensi')

@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card mt-3">
                        <div class="card-header">
                            <h2 class="font-weight-bold">Tambah Data Absensi</h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('update-absen', $edit->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col col-6">
                                        <div class="form-group">
                                            <label>Nama Siswa</label>
                                            <input type="text" class="form-control form-control-sm" id="nama"
                                                name="nama" value="{{ $edit->rStudent->name }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" class="form-control form-control-sm" id="nis"
                                                name="nis" value="{{ $edit->rStudent->nis }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Jurusan</label>
                                            <input type="text" class="form-control form-control-sm" id="jurusan"
                                                name="jurusan" value="{{ $edit->rStudent->jurusan }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Jam Masuk</label>
                                            <input type="datetime-local" class="form-control form-control-sm" id="masuk"
                                                name="masuk" value="{{ $edit->jam_masuk }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Jam Keluar</label>
                                            <input type="datetime-local" class="form-control form-control-sm" id="keluar"
                                                name="keluar" value="{{ $edit->jam_keluar }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <select class="custom-select form-control" id="keterangan" name="keterangan">
                                                @foreach (['Hadir', 'Terlambat', 'Alfa', 'Izin', 'Sakit'] as $option)
                                                    <option value="{{ $option }}"
                                                        {{ $edit->keterangan == $option ? 'selected' : '' }}>
                                                        {{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </div>
                                </div>
                            </form>
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
