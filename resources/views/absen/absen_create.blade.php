@extends('layouts.main')
@section('title', 'Add Absensi')

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
                            @csrf
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col col-6">
                                        <div class="form-group">
                                            <label>Nama Siswa</label>
                                            <input type="text" class="form-control form-control-sm" id="nama"
                                                name="nama">
                                        </div>
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" class="form-control form-control-sm" id="nis"
                                                name="nis">
                                        </div>
                                        <div class="form-group">
                                            <label>Jurusan</label>
                                            <input type="text" class="form-control form-control-sm" id="jurusan"
                                                name="jurusan">
                                        </div>
                                        <div class="form-group">
                                            <label>Jam Masuk</label>
                                            <input type="datetime-local" class="form-control form-control-sm" id="masuk"
                                                name="masuk">
                                        </div>
                                        <div class="form-group">
                                            <label>Jam Keluar</label>
                                            <input type="datetime-local" class="form-control form-control-sm" id="keluar"
                                                name="keluar">
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <input type="text" class="form-control form-control-sm" id="ket"
                                                name="ket">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Tambahkan</button>
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
