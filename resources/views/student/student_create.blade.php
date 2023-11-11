@extends('layouts.main')
@section('title', 'Student')
@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card mt-3">
                        <div class="card-header">
                            <h2 class="font-weight-bold">Tambah Data Siswa</h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('store-student') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col col-6">
                                        <div class="form-group">
                                            <label>Nomor Kartu</label>
                                            <input type="text" class="form-control form-control-sm" id="nomor_kartu"
                                                name="nomor_kartu">
                                        </div>
                                        <div class="form-group">
                                            <label>UID</label>
                                            <input type="text" class="form-control form-control-sm" id="uid"
                                                name="uid" value="">
                                        </div>
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
                                            <label>Kelas</label>
                                            <select class="custom-select form-control" id="kelas" name="kelas">
                                                @foreach (['X', 'XI', 'XII'] as $option)
                                                    <option value="{{ $option }}"> {{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Jurusan</label>
                                            <select class="custom-select form-control" id="jurusan" name="jurusan">
                                                @foreach (['DPIB', 'TITL', 'TJKT', 'TKR'] as $option)
                                                    <option value="{{ $option }}"> {{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor Wa Ortu (62)</label>
                                            <input type="text" class="form-control form-control-sm" id="hp_ortu"
                                                name="hp_ortu" placeholder="Gunakan 62 untuk awalan: 62xxxxx">
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
