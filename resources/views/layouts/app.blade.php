<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Default - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/css/bootstrap.css">

    @yield('ext_css')

    <link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset('mazer-1.0.0/dist')}}/assets/css/app.css">
</head>

<body>
    <div id="app">
        @include('layouts.sidebar')
        <div id="main" class='layout-navbar'>
            @include('layouts.top-nav')

            <div id="main-content">
                @include('flash::message')
                @yield('content')
                <section class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Default Layout</h4>
                        </div>
                        <div class="card-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, commodi? Ullam quaerat
                            similique iusto
                            temporibus, vero aliquam praesentium, odit deserunt eaque nihil saepe hic deleniti? Placeat
                            delectus
                            quibusdam ratione ullam!
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="{{asset('mazer-1.0.0/dist')}}/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{asset('mazer-1.0.0/dist')}}/assets/js/bootstrap.bundle.min.js"></script>
    @stack('ext_js')
    <script src="{{asset('mazer-1.0.0/dist')}}/assets/js/main.js"></script>
    @yield('script')
</body>

</html>