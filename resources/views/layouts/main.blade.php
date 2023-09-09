@include('partials.head')

<body>
    @include('sweetalert::alert')
    
    <div class="max-w-screen-sm min-h-screen bg-sky-950  mx-auto flex flex-col">

        @include('partials.navbar')
        @yield('body')
    </div>

    @stack('footer-script')
</body>

</html>