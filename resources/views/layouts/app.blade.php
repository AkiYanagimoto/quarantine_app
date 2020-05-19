<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- 個別のjavaScript読み込み -->
    @yield('javascript-head')
    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css', $is_production) }}" rel="stylesheet">
    <!-- Bootstrap Themeの読み込み -->
    <link href="{{ asset('css/bootstrap.min.css', $is_production) }}" rel="stylesheet"> 
    <!-- Original Themeの読み込み -->
    <link href="{{ asset('css/style.css', $is_production) }}" rel="stylesheet">
    

</head>

<body>

    <div id="app">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-bottom">
            @include('common.navbar01')
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    
    {{-- javascript 読み込み --}}
    {{-- <script src="/js/app.js"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>

    {{-- 個別のjavaScript読み込み --}}
    @yield('javascript-footer')
</body>
</html>
