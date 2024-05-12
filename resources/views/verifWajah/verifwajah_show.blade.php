@extends('layouts.main')
@section('title', 'Verifikasi Wajah')

@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="font-weight-bold">Verifikasi Wajah</h2>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- <form action="/verif-wajah/store-face" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>nama Siswa dan UID</label>
                                    <select class="custom-select form-control" id="idSiswa" name="idSiswa">
                                        @foreach ($user as $option)
                                            <option value="{{ $option->id }}"> {{ $option->name }} /
                                                {{ $option->uid }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Masukan gambar</label>
                                    <input type="file" class="form-control-file" name="image">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form> --}}
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>uid</th>
                                        <th>kelas dan jurusan</th>
                                        <th>face trained</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->uid }}</td>
                                            <td>{{ $data->kelas }} {{ $data->jurusan }}</td>
                                            @if ($data->face_trained != null)
                                                <td>{{ $data->face_trained }}X</td>
                                            @else
                                                <td>Wajah Belum Dikenali</td>
                                            @endif
                                            <td><button type="button" class="btn btn-primary btn-modal" data-toggle="modal"
                                                    data-target="#exampleModal" data-name="{{ $data->name }}"
                                                    data-uid="{{ $data->uid }}" data-id="{{ $data->id }}">
                                                    Train Face
                                                </button>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/verif-wajah/store-face" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>nama Siswa</label>
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="">UID</label>
                            <input type="text"class="form-control form-control-sm" name="uid" id="uid"
                                disabled>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="idSiswa" name="idSiswa">
                        </div>
                        <div class="form-group">
                            <label>Masukan gambar</label>
                            <input type="file" class="form-control-file" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btn-modal').click(function() {
                var name = $(this).data('name');
                var uid = $(this).data('uid');
                var id = $(this).data('id');
                console.log(id);

                // Setel nilai data dalam input teks
                $('#nama').val(name);
                $('#uid').val(uid);
                $('#idSiswa').val(id);
            });
        });
    </script>
@endsection
