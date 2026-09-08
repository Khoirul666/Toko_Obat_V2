<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    {{ Html::style(url('guest/css/plugins/bootstrap.min.css')) }}
    {{ Html::style('guest/css/plugins/bootstrap-theme.min.css') }}
    @yield('ext_css')
    {{ Html::style(url('guest/css/app.custom.css')) }}

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>
    </script>
</head>

<body>
    <div class="container">
        @include('flash::message')
        @yield('content')
        <br>
    </div>

    <!-- Scripts -->
    {{ Html::script(url('guest/js/plugins/jquery.min.js')) }}
    {{ Html::script(url('guest/js/plugins/bootstrap.min.js')) }}
    @stack('ext_js')
    <script>
        $('div.notifier').not('.alert-important').delay(5000).fadeOut(350);
    </script>
    @yield('script')
</body>

</html>