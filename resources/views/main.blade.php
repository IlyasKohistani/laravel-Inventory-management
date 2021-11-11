<!doctype html>
<html @lang('en')>

<head>
    @include('partials._head')
    @include('partials._css')
</head>

<body id="page-top" class="position-relative">
    @include('components.loader')
    <div id="app">
        <div id="main" class="layout-horizontal">

            @include('components.loader')
            @include('partials._nav')

            <div class="content-wrapper container">
                @yield('content')
            </div>

            @include('partials._footer')
        </div>
    </div>

    @include('partials._script')
    @yield('script')
</body>

</html>
