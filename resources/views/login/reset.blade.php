<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forget Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <body background="{{ asset('dist/dist/img/bg3.jpg') }}">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col col-12 col-lg-5 pt-5">
                    <form action="{{ route('reset-submit') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="card pb-5 shadow rounded-5">
                            <div class="card-header">
                                <img src="{{ asset('dist/dist/img/Tilkam.png') }}" alt="" width="60px"
                                    class="img-fluid py-2">
                                <span class="ms-2 fs-4 fw-bold pt-2 text-dark">Reset Password</span>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="py-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control form-control-sm" name='password'
                                            id="password">
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="py-3">
                                        <label class="form-label">Retype Password</label>
                                        <input type="password" class="form-control form-control-sm" name='new_password'
                                            id="new_password">
                                        @error('new_password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit"
                                            class="btn btn-success btn-sm form-control form-control-sm">Change
                                            Password</button>
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
