<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>{{ $title ?? 'Quản lý' }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />

    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="{{ asset('css/light-bootstrap-dashboard.css? v=1.4.1') }}" rel="stylesheet" />

    <!--  css for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/pe-icon-7-stroke.css') }}" rel="stylesheet" />
    <style>
        .wrapper {
            background: linear-gradient(to bottom, #23CCEF 0%, rgba(64, 145, 255, 0.7) 100%);
            background-size: 150% 150%;
            display: grid;
            place-items: center;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="col-md-4">
            <div class="card">
                <div class="content">
                    <form action="{{ route('registering') }}" method="post" novalidate="novalidate">
                        <div class="header text-center">Đăng ký</div>
                        <div class="content">
                            @csrf
                            @auth
                                <div class="form-group">
                                    <label class="control-label">Địa chỉ email<star>*</star></label>
                                    <input class="form-control" name="email" type="text" value="{{ auth()->user()->email }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Tên<star>*</star></label>
                                    <input class="form-control" name="name" type="text" value="{{ auth()->user()->name }}" readonly>
                                </div>
                            @endauth
                            @guest
                                <div class="form-group">
                                    <label class="control-label">Địa chỉ email<star>*</star></label>
                                    <input class="form-control" name="email" type="text" email="true" required="true"
                                        aria-required="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Tên<star>*</star></label>
                                    <input class="form-control" name="name" type="text" required="true"
                                        aria-required="true">
                                </div>
                            @endguest
                            <div class="form-group">
                                <label class="control-label">Mật khẩu <star>*</star></label>
                                <input class="form-control" name="password" id="registerPassword" type="password"
                                    required="true" aria-required="true">
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit" class="btn btn-info btn-fill btn-wd">Đăng ký</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <h5>Đăng nhập với</h5>
                        <a href="{{ route('auth.redirect', 'google') }}"
                            class="btn btn-social btn-round btn-google mb-2">
                            <i class="fa fa-google"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--   Core JS Files  -->
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>


    <!--  Forms Validations Plugin -->
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>

    <!--  Select Picker Plugin -->
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>

    <!--  Checkbox, Radio, Switch and Tags Input Plugins -->
    <script src="{{ asset('js/bootstrap-switch-tags.min.js') }}"></script>

    <!--  Charts Plugin -->
    <script src="{{ asset('js/chartist.min.js') }}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>

    <!-- Sweet Alert 2 plugin -->
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    <!-- Wizard Plugin    -->
    <script src="{{ asset('js/jquery.bootstrap.wizard.min.js') }}"></script>

    <!--  bootstrap Table Plugin    -->
    <script src="{{ asset('js/bootstrap-table.js') }}"></script>

    <!-- Light Bootstrap Dashboard Core javascript and methods -->
    <script src="{{ asset('js/light-bootstrap-dashboard.js?v=1.4.1') }}"></script>
</body>

</html>
