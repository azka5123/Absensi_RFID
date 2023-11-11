@extends('layouts.main')
@section('title', 'Edit User')
@section('container')
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card mt-3">
                        <div class="card-header">
                            <h2 class="font-weight-bold">Edit Data User</h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('update-user', $edit->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col col-6">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control form-control-sm" id="nama"
                                                name="nama" value="{{ $edit->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control form-control-sm" id="email"
                                                name="email" value="{{ $edit->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control form-control-sm" id="password"
                                                name="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="custom-select form-control" id="role" name="role">
                                                @foreach (['Bimbingan Konseling', 'Operator'] as $option)
                                                    <option value="{{ $option }}"
                                                        {{ $edit->role == $option ? 'selected' : '' }}> {{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor HP (62)</label>
                                            <input type="text" class="form-control form-control-sm" id="hp"
                                                name="hp" placeholder="Gunakan 62 untuk awalan: 62xxxxx">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Update data</button>
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
