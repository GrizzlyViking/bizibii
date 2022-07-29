<!DOCTYPE html>
<html id="html" lang="en" data-layout="main" data-theme="main">
<head>

    <!-- Page title -->
    <title>@section('title', config('app.name'))</title>
    <!-- /Page title -->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- /Meta -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css?v=2') }}">
    <!-- /Styles -->

</head>
<body>
<!-- Brand -->
<a class="navbar-brand d-sm-inline-block w-auto col-lg-2" href="{{ route('home') }}">
    <img src="{{ asset('images/large_bizibii_text.png') }}" alt="logo_with_bee" class="embed-responsive h-100">
</a>
<!-- /Brand -->

<!-- Navigation -->
@include('clarity._partials.navigation')
<!-- /Navigation -->


<!-- Main Container -->
<main class="main-container">

    @yield('content')

    <!-- Footer -->
    @include('clarity._partials.footer')
    <!-- /Footer -->

</main>
<!-- /Main Container -->


<!-- Search -->
<div id="page-search" class="page-search bg-white">

    <!-- Close Button -->
    <div class="page-search-close button-close" data-toggle="class" data-target="#page-search" data-class="active">
        <span>close</span>
    </div>
    <!-- /Close Button -->

    <!-- Content Container -->
    <div class="container">

        <!-- Input Row -->
        <div class="row">
            <div class="col-12">

                <input type="text" class="page-search-control form-control form-control-lg" placeholder="Search..." aria-label="Search...">

            </div>
        </div>
        <!-- /Input Row -->

        <!-- Results Row -->
        <div class="row">
            <div class="col-12">

                <!-- Result Wrapper -->
                <div id="page-search-result">Something</div>
                <!-- /Result Wrapper -->

            </div>
        </div>
        <!-- /Results Row -->

    </div>
    <!-- /Content Container -->

</div>
<!-- Search -->


<!-- Scripts -->
<script src="assets/js/core.min.js"></script>
<script src="assets/js/theme.min.js"></script>
@livewireScripts
<!-- /Scripts -->

</body>
</html>
