<!DOCTYPE html>
<html id="html" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="main" data-theme="main">
<head>

    <!-- Page title -->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- /Page title -->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- /Meta -->

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/core.min.css">
    <link rel="stylesheet" href="assets/css/theme.min.css">
    <!-- /Styles -->

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <!-- /Favicon -->

</head>
<body>


<!-- Navigation -->
@include('clarity._partials.navigation')
<!-- /Navigation -->


<!-- Main Container -->
<main class="main-container">

    <!-- Header -->
    <header id="header" class="header pb-0 text-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-8">

                    <!-- Header Title -->
                    <h1 class="title">We are Design Studio since 2010</h1>
                    <!-- /Header Title -->

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="#" class="link">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About</li>
                        </ol>
                    </nav>
                    <!-- /Breadcrumb -->

                    <!-- Header Subtitle -->
                    <p class="subtitle">
                        It is a long established fact that a reader will be distracted by the readable content of a page
                        when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                        distribution of letters, as opposed to using 'Content here, content here', making it look like
                        readable English.
                    </p>
                    <!-- /Header Subtitle -->

                </div>
            </div>
        </div>
    </header>
    <!-- /Header -->

    <!-- Section: About -->
    <section id="about" class="section section-about">
        <div class="container">

            <!-- Section Muted Title -->
            <div class="section-muted-title z-5" data-stellar-ratio=".9">
                <span>About</span>
            </div>
            <!-- /Section Muted Title -->

            <!-- Section Content Row -->
            <div class="row section-content">

                <!-- Column -->
                <div class="col-12 col-lg-5 bg-white owl-no-overflow-column-spacer">

                    <h3 class="mb-4">A few Words About Us</h3>
                    <p>
                        It is a long established fact that a reader will be distracted by the readable content of a page
                        when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                        distribution of letters, as opposed to using 'Content here, content here', making it look like
                        readable English. Many desktop publishing packages.
                    </p>
                    <p>
                        And web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                        ipsum' will uncover many web sites still in their infancy. Various versions have evolved over
                        the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                    </p>

                    <!-- OwlCarousel Navigation -->
                    <div class="about-carousel-navigation owl-navigation-custom">

                        <!-- Previous Slide -->
                        <button class="btn btn-circle btn-outline-light-custom mr-2" data-action="owl-prev" data-target="#about-carousel">
                            <i class="icon fa ti-angle-left"></i>
                        </button>
                        <!-- /Previous Slide -->

                        <!-- Next Slide -->
                        <button class="btn btn-circle btn-outline-light-custom" data-action="owl-next" data-target="#about-carousel">
                            <i class="icon fa ti-angle-right"></i>
                        </button>
                        <!-- /Next Slide -->

                    </div>
                    <!-- /OwlCarousel Navigation -->

                </div>
                <!-- /Column -->

                <!-- Column -->
                <div class="col-12 col-lg-7">

                    <!-- OwlCarousel -->
                    <div id="about-carousel" class="owl-carousel owl-theme owl-loop owl-no-overflow about-carousel">

                        <!-- Owl Item -->
                        <div class="owl-carousel-item py-gutter-half">
                            <img src="images/4x3/image-01.jpg" alt="" title="" class="img-fluid">
                        </div>
                        <!-- /Owl Item -->

                        <!-- Owl Item -->
                        <div class="owl-carousel-item py-gutter-half">
                            <img src="images/4x3/image-07.jpg" alt="" title="" class="img-fluid">
                        </div>
                        <!-- /Owl Item -->

                        <!-- Owl Item -->
                        <div class="owl-carousel-item py-gutter-half">
                            <img src="images/4x3/image-08.jpg" alt="" title="" class="img-fluid">
                        </div>
                        <!-- /Owl Item -->

                    </div>
                    <!-- /OwlCarousel -->

                </div>
                <!-- /Column -->

            </div>
            <!-- /Section Content Row -->

        </div>
    </section>
    <!-- /Section: About -->

    <!-- Section: Promo -->
    <section id="promo" class="section section-sm section-promo">
        <div class="container">

            <!-- Section Content Row -->
            <div class="row section-content">
                <div class="col-12">

                    <!-- Promo Link -->
                    <a href="#" class="thumb thumb-video">

                        <!-- Thumb Image -->
                        <img src="images/about-promo.jpg" alt="" title="" class="img-fluid">
                        <!-- /Thumb Image -->

                        <!-- Thumb Overlay Container -->
                        <div class="thumb-container d-flex align-items-center">
                            <div class="row w-100 d-flex justify-content-end">
                                <div class="col-12 col-lg-5">
                                    <div class="h1 text-white">See our Company <br> Promo Video</div>
                                    <div class="font-weight-bold text-white">about two minutes</div>
                                </div>
                            </div>
                        </div>
                        <!-- /Thumb Overlay Container -->

                    </a>
                    <!-- /Promo Link -->

                </div>
            </div>
            <!-- /Section Content Row -->

        </div>
    </section>
    <!-- /Section: Promo -->

    <!-- Section: Team -->
    <section id="our-team" class="section section-right section-our-team">
        <div class="container">

            <!-- Section Muted Title -->
            <div class="section-muted-title z-5" data-stellar-ratio=".9">
                <span>Team</span>
            </div>
            <!-- /Section Muted Title -->

            <!-- Section Content Row -->
            <div class="row section-content">

                <!-- Column -->
                <div class="col-12 col-lg-5">

                    <!-- OwlCarousel -->
                    <div id="our-team-carousel" class="owl-carousel owl-theme owl-loop owl-no-overflow about-carousel">

                        <!-- Owl Item -->
                        <div class="owl-carousel-item py-gutter-half">
                            <img src="images/3x4/image-04.jpg" alt="" title="" class="img-fluid">
                        </div>
                        <!-- /Owl Item -->

                        <!-- Owl Item -->
                        <div class="owl-carousel-item py-gutter-half">
                            <img src="images/3x4/image-05.jpg" alt="" title="" class="img-fluid">
                        </div>
                        <!-- /Owl Item -->

                        <!-- Owl Item -->
                        <div class="owl-carousel-item py-gutter-half">
                            <img src="images/3x4/image-06.jpg" alt="" title="" class="img-fluid">
                        </div>
                        <!-- /Owl Item -->

                    </div>
                    <!-- /OwlCarousel -->

                </div>
                <!-- /Column -->

                <!-- Column -->
                <div class="col-12 col-lg-7 bg-white owl-no-overflow-column-spacer owl-no-overflow-column-spacer-left">

                    <h3 class="mb-4">Our Team</h3>
                    <p>
                        It is a long established fact that a reader will be distracted by the readable content of a page
                        when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                        distribution of letters, as opposed to using 'Content here, content here', making it look like
                        readable English. Many desktop publishing packages.
                    </p>
                    <p>
                        And web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                        ipsum' will uncover many web sites still in their infancy. Various versions have evolved over
                        the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                    </p>

                    <!-- OwlCarousel Navigation -->
                    <div class="about-carousel-navigation owl-navigation-custom">

                        <!-- Previous Slide -->
                        <button class="btn btn-circle btn-outline-light-custom mr-2" data-action="owl-prev" data-target="#our-team-carousel">
                            <i class="icon fa ti-angle-left"></i>
                        </button>
                        <!-- /Previous Slide -->

                        <!-- Next Slide -->
                        <button class="btn btn-circle btn-outline-light-custom" data-action="owl-next" data-target="#our-team-carousel">
                            <i class="icon fa ti-angle-right"></i>
                        </button>
                        <!-- /Next Slide -->

                    </div>
                    <!-- /OwlCarousel Navigation -->

                </div>
                <!-- /Column -->

            </div>
            <!-- /Section Content Row -->

        </div>
    </section>
    <!-- /Section: Team -->

    <!-- Section: Partners -->
    <section id="partners" class="section section-partners">
        <div class="container">

            <!-- Section Muted Title -->
            <div class="section-muted-title z-5" data-stellar-ratio=".9">
                <span>Partners</span>
            </div>
            <!-- /Section Muted Title -->

            <!-- Section Content Row -->
            <div class="row section-content">

                <!-- Column -->
                <div class="col-12 col-lg-5">

                    <h3 class="mb-4">Our Partners</h3>
                    <p>
                        It is a long established fact that a reader will be distracted by the readable content of a page
                        when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                        distribution of letters, as opposed to using 'Content here, content here', making it look like
                        readable English. Many desktop publishing packages.
                    </p>
                    <p>
                        And web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                        ipsum' will uncover many web sites still in their infancy. Various versions have evolved over
                        the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                    </p>

                </div>
                <!-- /Column -->

                <!-- Column -->
                <div class="col-12 col-lg-7">

                    <!-- Row -->
                    <div class="row">

                        <!-- Column -->
                        <div class="col-6 col-lg-4">
                            <!-- Partner Link -->
                            <a href="#" class="partner">
                                <img src="images/partner-01.jpg" alt="" title="" class="img-fluid">
                            </a>
                            <!-- /Partner Link -->
                        </div>
                        <!-- /Column -->

                        <!-- Column -->
                        <div class="col-6 col-lg-4">
                            <!-- Partner Link -->
                            <a href="#">
                                <img src="images/partner-04.jpg" alt="" title="" class="img-fluid">
                            </a>
                            <!-- /Partner Link -->
                        </div>
                        <!-- /Column -->

                        <!-- Column -->
                        <div class="col-6 col-lg-4">
                            <!-- Partner Link -->
                            <a href="#">
                                <img src="images/partner-05.jpg" alt="" title="" class="img-fluid">
                            </a>
                            <!-- /Partner Link -->
                        </div>
                        <!-- /Column -->

                        <!-- Column -->
                        <div class="col-6 col-lg-4">
                            <!-- Partner Link -->
                            <a href="#">
                                <img src="images/partner-06.jpg" alt="" title="" class="img-fluid">
                            </a>
                            <!-- /Partner Link -->
                        </div>
                        <!-- /Column -->

                        <!-- Column -->
                        <div class="col-6 col-lg-4">
                            <!-- Partner Link -->
                            <a href="#">
                                <img src="images/partner-05.jpg" alt="" title="" class="img-fluid">
                            </a>
                            <!-- /Partner Link -->
                        </div>
                        <!-- /Column -->

                        <!-- Column -->
                        <div class="col-6 col-lg-4">
                            <!-- Partner Link -->
                            <a href="#">
                                <img src="images/partner-06.jpg" alt="" title="" class="img-fluid">
                            </a>
                            <!-- /Partner Link -->
                        </div>
                        <!-- /Column -->

                    </div>
                    <!-- /Row -->

                </div>
                <!-- /Column -->

            </div>
            <!-- /Section Content Row -->

        </div>
    </section>
    <!-- /Section: Partners -->

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
                <div id="page-search-result"></div>
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
<!-- /Scripts -->

</body>
</html>
