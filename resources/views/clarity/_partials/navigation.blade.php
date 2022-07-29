<nav class="navbar navbar-fixed navbar-expand-lg bg-white">
    <div class="container position-relative">

        <!-- Navbar Toggler -->
        <div class="d-lg-none menu-toggle toggle-out" data-toggle="class" data-toggler-class-in="toggle-in" data-toggler-class-out="toggle-out" data-target="#html" data-class="navbar-open">
            <span class="hamburger"><span></span><span></span><span></span></span>
            <span class="cross"><span></span><span></span></span>
        </div>
        <!-- /Navbar Toggler -->

        <!-- Middle -->
        <div id="navbar-fullscreen" class="navbar-nav-fullscreen">
            <ul class="navbar-nav">

                <!-- Navbar Item -->
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
                <!-- Navbar Item -->

                <!-- Navbar Item -->
                @if (Route::has('register'))
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                </li>
                @endif
                <!-- Navbar Item -->

            </ul>
        </div>
        <!-- /Middle -->

    </div>
</nav>
