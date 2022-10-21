<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>{{ $title ?? 'Quản lý' }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="{{ asset('admin/css/light-bootstrap-dashboard.css? v=1.4.1') }}" rel="stylesheet" />

    <!--  css for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('admin/css/demo.css') }}" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('admin/css/pe-icon-7-stroke.css') }}" rel="stylesheet" />
    @stack('css')
</head>

<body>

    <div class="wrapper">
        @include('layout.sidebar')

        <div class="main-panel">

            @include('layout.header')

            <div class="main-content">
                <div class="container-fluid">
                    <div class="row">
                       <div class="col-12">
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                       </div>
                    </div>
                    @yield('main')

                </div>
            </div>

            @include('layout.footer')

        </div>
    </div>


</body>
<!--   Core JS Files  -->
<script src="{{ asset('admin/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>


<!--  Forms Validations Plugin -->
<script src="{{ asset('admin/js/jquery.validate.min.js') }}"></script>

<!--  Select Picker Plugin -->
<script src="{{ asset('admin/js/bootstrap-selectpicker.js') }}"></script>

<!--  Checkbox, Radio, Switch and Tags Input Plugins -->
<script src="{{ asset('admin/js/bootstrap-switch-tags.min.js') }}"></script>

<!--  Charts Plugin -->
<script src="{{ asset('admin/js/chartist.min.js') }}"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset('admin/js/bootstrap-notify.js') }}"></script>

<!-- Sweet Alert 2 plugin -->
<script src="{{ asset('admin/js/sweetalert2.js') }}"></script>

<!-- Wizard Plugin    -->
<script src="{{ asset('admin/js/jquery.bootstrap.wizard.min.js') }}"></script>

<!--  bootstrap Table Plugin    -->
<script src="{{ asset('admin/js/bootstrap-table.js') }}"></script>

<!-- Light Bootstrap Dashboard Core javascript and methods -->
<script src="{{ asset('admin/js/light-bootstrap-dashboard.js?v=1.4.1') }}"></script>
@stack('js')

</html>