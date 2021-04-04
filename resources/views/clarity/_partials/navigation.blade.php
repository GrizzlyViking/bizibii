<nav class="navbar navbar-fixed navbar-expand-lg bg-white">
    <div class="container position-relative">

        <!-- Navbar Toggler -->
        <div class="d-lg-none menu-toggle toggle-out" data-toggle="class" data-toggler-class-in="toggle-in" data-toggler-class-out="toggle-out" data-target="#html" data-class="navbar-open">
            <span class="hamburger"><span></span><span></span><span></span></span>
            <span class="cross"><span></span><span></span></span>
        </div>
        <!-- /Navbar Toggler -->

        <!-- Brand -->
        <a class="navbar-brand d-sm-inline-block w-auto col-lg-2" href="{{ route('home') }}">
            <img src="{{ asset('images/large_bizibii_text.png') }}" alt="logo_with_bee" class="embed-responsive h-100">
        </a>
        <!-- /Brand -->

        <!-- Right -->
        <ul class="navbar-nav col-lg-2 justify-content-lg-end d-none d-lg-flex">

            <!-- Navbar Item -->
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="icon fa fa-sign-in"></i>
                </a>
            </li>
            <!-- /Navbar Item -->

            <!-- Navbar Item -->
            @if (Route::has('register'))
            <li class="nav-item">
                <a href="{{ route('register') }}" class="nav-link">
                    <i class="icon fa fa-user"></i>
                </a>
            </li>
            @endif
            <!-- /Navbar Item -->

        </ul>
        <!-- /Right -->

    </div>
</nav>
