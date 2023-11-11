<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi</title>
    <link rel="shortcut icon" href="{{ asset('dist/dist/img/Tilkam.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <body background="{{ asset('dist/dist/img/bg3.jpg') }}">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col col-12 col-lg-5 pt-5">
                    <form action="{{ route('signup-submit') }}" method="post">
                        @csrf
                        <div class="card pb-5 shadow rounded-5">
                            <div class="card-header">
                                <img src="{{ asset('dist/dist/img/Tilkam.png') }}" alt="" width="60px"
                                    class="img-fluid py-2">
                                <span class="ms-2 fs-4 fw-bold pt-2">Daftar Akun</span>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="py-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control form-control-sm" name='name'
                                            id="name">
                                    </div>
                                    <div class="py-3">
                                        <label class="form-label">Alamat Email</label>
                                        <input type="email" class="form-control form-control-sm" name='email'
                                            id="email" aria-describedby="emailHelp">
                                    </div>
                                    <div class="py-3">
                                        <label class="form-label">No HP</label>
                                        <input type="text" class="form-control form-control-sm" name='hp'
                                            id="hp">
                                    </div>
                                    <div class="py-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control form-control-sm" name='password'
                                            id="password">
                                    </div>
                                    <div class="pt-3">
                                        <label class="form-label">Ulangi Password</label>
                                        <input type="password" class="form-control form-control-sm"
                                            name='password_confirmation' id="password_confirmation">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn btn-sm btn-success btn-blue6 text-light mt-5 px-3"><span
                                                class="fs-6">Daftar</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
