<!DOCTYPE html>
<html lang="en">
    @include('includes.header')
<body>
    @include('includes.sidebar')
    <div class="container mx-auto">
        @yield('content')
    </div>
    @include('includes.footer')
</body>
</html>