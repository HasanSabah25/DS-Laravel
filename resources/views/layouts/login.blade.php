<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevSpace | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Dev</b>Space</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">

                <p class="login-box-msg">Log In</p>
                @if (\Session::has('message'))
                    <div class="aler alert-info">
                        {{ \Session::get('message') }}
                    </div>
                @endif
                <form action="{{ route('login.perform') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email">

                        <div class="input-group-append ">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    {{-- {{ app($errors) }} --}}

                    @if ($errors->has('email'))
                        <p class="text-danger ">{{ $errors->first('email') }}</p>
                    @else
                    @endif
                    <div class="input-group mb-4">
                        <input type="password" class="form-control" name="password" placeholder="Password">

                        <div class="input-group-append ">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @else
                    @endif
                    <div class="row">

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block mb-1 mt-2">Sign In</button>
                        </div>
                    </div>
                    <div clas5="mt-4 d-flex w-full justify-center items-center rounded-md bg-light hover: bg-sm">
                        <img src="https://www.freepnglogos.com/uploads/google-logo-png/google-logo-png-google-logos-vector-eps-cdr-svg-download-10.png"
                            width="40" alt="">
                        <a href="{{ route('google.login') }}" class="mt-3">
                            {{ __('Login with google') }}
                        </a>
                    </div>
                </form>
                <p class="mb-0">
                    <a href="{{ route('registerview') }}" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>
