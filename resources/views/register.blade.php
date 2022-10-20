<!DOCTYPE html>
<html lang="en" class="perfect-scrollbar-on">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Đăng ký</title>

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
          name="viewport">
    <meta name="viewport" content="width=device-width">



    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />

    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="{{ asset('css/light-bootstrap-dashboard.css? v=1.4.1') }}" rel="stylesheet" />

    <!--  css for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"
          rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet'
          type='text/css'>
    <link href="{{ asset('css/pe-icon-7-stroke.css') }}" rel="stylesheet" />

    <script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/50/10/common.js">
    </script>
    <script type="text/javascript" charset="UTF-8" src="https://maps.googleapis.com/maps-api-v3/api/js/50/10/util.js">
    </script>
</head>

<body>

<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">
        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="login.html">
                        Looking to login?
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper wrapper-full-page">
    <div class="full-page register-page" data-color="azure"
         data-image="../../assets/img/full-screen-image-2.jpg">

        <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="header-text">
                            <h2>Light Bootstrap Dashboard PRO</h2>
                            <h4>Register for free and experience the dashboard today</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-2">
                        <div class="media">
                            <div class="media-left">
                                <div class="icon">
                                    <i class="pe-7s-user"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4>Free Account</h4>
                                Here you can write a feature description for your dashboard, let
                                the users know what is the value that you give them.
                            </div>
                        </div>

                        <div class="media">
                            <div class="media-left">
                                <div class="icon">
                                    <i class="pe-7s-graph1"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4>Awesome Performances</h4>
                                Here you can write a feature description for your dashboard, let
                                the users know what is the value that you give them.

                            </div>
                        </div>

                        <div class="media">
                            <div class="media-left">
                                <div class="icon">
                                    <i class="pe-7s-headphones"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4>Global Support</h4>
                                Here you can write a feature description for your dashboard, let
                                the users know what is the value that you give them.

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 col-md-offset-s1">
                        <form action="{{ route('registering') }}" method="post"
                              novalidate="novalidate">
                            <div class="card card-plain">
                                @csrf
                                @auth
                                    <div class="content">
                                        <div class="form-group">
                                            <input class="form-control" name="email"
                                                   type="text"
                                                   value="{{ auth()->user()->email }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" name="name"
                                                   type="text" value="{{ auth()->user()->name }}"
                                                   readonly>
                                        </div>
                                        @endauth
                                        @guest
                                            <div class="form-group">
                                                <input class="form-control" name="email"
                                                       type="email">
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" name="name"
                                                       type="text">
                                            </div>
                                        @endguest
                                        <div class="form-group">
                                            <input class="form-control" name="password"
                                                   type="password">
                                        </div>
                                        <div class="footer text-center">
                                            <button type="submit"
                                                    class="btn btn-fill btn-neutral btn-wd">Create Free
                                                Account</button>
                                        </div>
                                    </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <footer class="footer footer-transparent">
            <div class="container">
                <p class="copyright text-center">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>2022 <a
                        href="http://www.creative-tim.com">Creative Tim</a>, made with love for
                    a better web
                </p>
            </div>
        </footer>

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
