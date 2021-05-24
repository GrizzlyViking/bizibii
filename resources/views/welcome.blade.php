@extends('layouts.clarity')

@section('content')
    <!-- Hero -->
    <header id="home" class="hero" style="background-image: url({{ asset('images/home.png') }});" data-stellar-background-ratio=".5">

        <!-- Hero Middle Parallax Wrapper -->
        <div class="hero-content-wrapper" data-stellar-ratio=".75">
            <div class="hero-content">

                <!-- Content Container -->
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">

                            <!-- Hero Title -->
                            <h1 class="hero-title fw-light">{{ ucwords(config('app.name')) }}</h1>
                            <!-- /Hero Title -->

                        </div>
                    </div>
                </div>
                <!-- /Content Container -->

            </div>
        </div>
        <!-- /Hero Middle Parallax Wrapper -->

        <!-- Scroll Button -->
        <a href="#about" class="hero-scroll smooth-scroll"></a>
        <!-- /Scroll Button -->

        <!-- Copyright Button -->
        <a href="https://www.freepik.com/free-photos-vectors/mockup" target="_blank" class="hero-copyright">Plant created by qeaql-studio</a>
        <!-- /Copyright Button -->

    </header>
    <!-- /Hero -->

    <!-- Section: About -->
    <x-section
        title="about"
        sectionTitle="About Company"
        sectionSubtitle="Just a few words will give you an idea of our company"
        prevSection="home"
        nextSection="projects"
    >
        <div class="row">

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Feature Box -->
                <div class="feature-box mb-8 mb-lg-0">
                    <div class="title">Web-Design</div>
                    <p class="text">
                        It is a long established fact that a reader will be distracted by the readable
                        content of a page when looking.
                    </p>
                    <a href="#" class="link">Read More</a>
                </div>
                <!-- /Feature Box -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Feature Box -->
                <div class="feature-box mb-8 mb-lg-0">
                    <div class="title">Photography</div>
                    <p class="text">
                        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                        piece of classical.
                    </p>
                    <a href="#" class="link">Read More</a>
                </div>
                <!-- /Feature Box -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Feature Box -->
                <div class="feature-box">
                    <div class="title">Software Development</div>
                    <p class="text">
                        There are many variations of passages of Lorem Ipsum available, but the majority
                        have suffered alteration.
                    </p>
                    <a href="#" class="link">Read More</a>
                </div>
                <!-- /Feature Box -->
            </div>
            <!-- /Column -->

        </div>
    </x-section>
    <!-- /Section: About -->

    <!-- Section: Projects -->
    <x-section
        title="projects"
        sectionTitle="Our Best Works"
        sectionSubtitle="Here are our latest projects in which we have invested our love"
        prevSection="about"
        nextSection="best"
        alignment="right"
        sectionNumber="2"
    >
        <div class="row">

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Gallery Item -->
                <a href="images/3x4/image-01.jpg" class="gallery-image popup-image mb-4">
                    <img src="images/3x4/image-01.jpg" alt="" title="" class="img-fluid">
                </a>
                <!-- /Gallery Item -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Gallery Item -->
                <a href="images/3x4/image-02.jpg" class="gallery-image popup-image mb-4">
                    <img src="images/3x4/image-02.jpg" alt="" title="" class="img-fluid">
                </a>
                <!-- /Gallery Item -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Gallery Item -->
                <a href="images/3x4/image-03.jpg" class="gallery-image popup-image mb-4">
                    <img src="images/3x4/image-03.jpg" alt="" title="" class="img-fluid">
                </a>
                <!-- /Gallery Item -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Gallery Item -->
                <a href="images/3x4/image-04.jpg" class="gallery-image popup-image mb-4">
                    <img src="images/3x4/image-04.jpg" alt="" title="" class="img-fluid">
                </a>
                <!-- /Gallery Item -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Gallery Item -->
                <a href="images/3x4/image-05.jpg" class="gallery-image popup-image mb-4">
                    <img src="images/3x4/image-05.jpg" alt="" title="" class="img-fluid">
                </a>
                <!-- /Gallery Item -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- Gallery Item -->
                <a href="images/3x4/image-06.jpg" class="gallery-image popup-image">
                    <img src="images/3x4/image-06.jpg" alt="" title="" class="img-fluid">
                </a>
                <!-- /Gallery Item -->
            </div>
            <!-- /Column -->

        </div>
    </x-section>
    <!-- /Section: Projects -->

    <!-- Section: Features -->
    <x-section
        title="best"
        sectionTitle="Nice Features"
        sectionSubtitle="We provide you with a wide range of services. Here are some features"
        prevSection="works"
        nextSection="clients"
        alignment="left"
        sectionNumber="3"
    >
        <div class="row">

            <!-- Column -->
            <div class="col-lg-4">
                <!-- Feature box -->
                <div class="feature-box mb-8 mb-lg-0 text-center">
                    <i class="icon icon-paintbrush"></i>
                    <div class="title">Clean Design</div>
                    <p class="text">
                        We try to maintain a very clean minimalistic design for this template.
                    </p>
                </div>
                <!-- /Feature box -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-lg-4">
                <!-- Feature box -->
                <div class="feature-box mb-8 mb-lg-0 text-center">
                    <i class="icon icon-mobile"></i>
                    <div class="title">Mobile Friendly</div>
                    <p class="text">
                        This template is equally well displayed on all possible devices.
                    </p>
                </div>
                <!-- /Feature box -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-lg-4">
                <!-- Feature box -->
                <div class="feature-box text-center">
                    <i class="icon icon-heart"></i>
                    <div class="title">Made with <span class="text-danger">Love</span></div>
                    <p class="text">
                        We invest a lot of energy and love to develop our products to make you like.
                    </p>
                </div>
                <!-- /Feature box -->
            </div>
            <!-- /Column -->

        </div>
    </x-section>
    <!-- /Section: Features -->

    <!-- Section: Testimonials -->
    <x-section
        title="clients"
        sectionTitle="Clients Say"
        sectionSubtitle="We really appreciate our customers and this is what they say about us"
        prevSection="best"
        nextSection="price"
        alignment="right"
        sectionNumber="4"
    >
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="row">

                    <!-- Column -->
                    <div class="col-12">

                        <!-- OwlCarousel -->
                        <div class="owl-carousel owl-theme owl-navigation" data-items="1">

                            <!-- OwlSlide Item -->
                            <div class="owl-slide">
                                <!-- Testimonial Item -->
                                <div class="testimonial-item">

                                    <!-- Avatar -->
                                    <div class="avatar">
                                        <img src="images/avatar-01.jpg" alt="" title="">
                                    </div>
                                    <!-- /Avatar -->

                                    <!-- Information -->
                                    <div class="body">

                                        <!-- Text -->
                                        <div class="text">
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.
                                        </div>
                                        <!-- /Text -->

                                        <!-- Name -->
                                        <div class="name">Anna Estrada</div>
                                        <!-- /Name -->

                                        <!-- Additional -->
                                        <div class="additional">Company Founder & CEO</div>
                                        <!-- /Additional -->

                                    </div>
                                    <!-- /Information -->

                                </div>
                                <!-- /Testimonial Item -->
                            </div>
                            <!-- /OwlSlide Item -->

                            <!-- OwlSlide Item -->
                            <div class="owl-slide">
                                <!-- Testimonial Item -->
                                <div class="testimonial-item">

                                    <!-- Avatar -->
                                    <div class="avatar">
                                        <img src="images/avatar-02.jpg" alt="" title="">
                                    </div>
                                    <!-- /Avatar -->

                                    <!-- Information -->
                                    <div class="body">

                                        <!-- Text -->
                                        <div class="text">
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.
                                        </div>
                                        <!-- /Text -->

                                        <!-- Name -->
                                        <div class="name">Julie Warren</div>
                                        <!-- /Name -->

                                        <!-- Additional -->
                                        <div class="additional">SEO Specialist</div>
                                        <!-- /Additional -->

                                    </div>
                                    <!-- /Information -->

                                </div>
                                <!-- /Testimonial Item -->
                            </div>
                            <!-- /OwlSlide Item -->

                            <!-- OwlSlide Item -->
                            <div class="owl-slide">
                                <!-- Testimonial Item -->
                                <div class="testimonial-item">

                                    <!-- Avatar -->
                                    <div class="avatar">
                                        <img src="images/avatar-03.jpg" alt="" title="">
                                    </div>
                                    <!-- /Avatar -->

                                    <!-- Information -->
                                    <div class="body">

                                        <!-- Text -->
                                        <div class="text">
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.
                                        </div>
                                        <!-- /Text -->

                                        <!-- Name -->
                                        <div class="name">Samantha Evans</div>
                                        <!-- /Name -->

                                        <!-- Additional -->
                                        <div class="additional">Account Manager</div>
                                        <!-- /Additional -->

                                    </div>
                                    <!-- /Information -->

                                </div>
                                <!-- /Testimonial Item -->
                            </div>
                            <!-- /OwlSlide Item -->

                        </div>
                        <!-- /OwlCarousel -->

                    </div>
                    <!-- /Column -->

                </div>
            </div>
        </div>
    </x-section>
    <!-- /Section: Testimonials -->

    <!-- Section: Price -->
    <x-section
        title="price"
        sectionTitle="Special Offers"
        sectionSubtitle="We offer you the best solutions at the best prices"
        prevSection="clients"
        nextSection="contact"
        alignment="left"
        sectionNumber="5"
    >
        <div class="row justify-content-end">

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- PriceBox -->
                <div class="price-box mb-8 mb-lg-0">
                    <div class="title">Basic</div>
                    <div class="value">
                        $
                        <span class="int">9</span>
                        <span class="real">99</span>
                        <span class="divider">/ month</span>
                    </div>
                    <div class="content text-center">
                        <div class="feature"><span data-toggle="tooltip" data-title="It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.">3GB</span> Disk Storage</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="As opposed to using 'Content here, content here', making it look like readable English.">512MB</span> RAM</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.">3</span> Sites</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).">10</span> Databases</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="There are many variations of passages of Lorem Ipsum available, but the majority.">3</span> Mail</div>
                    </div>
                    <button class="btn btn-outline-primary">Select Plan</button>
                </div>
                <!-- /PriceBox -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- PriceBox -->
                <div class="price-box mb-8 mb-lg-0 featured">
                    <div class="title">Extended</div>
                    <div class="value">
                        $
                        <span class="int">19</span>
                        <span class="real">99</span>
                        <span class="divider">/ month</span>
                    </div>
                    <div class="content text-center">
                        <div class="feature"><span data-toggle="tooltip" data-title="It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.">10GB</span> Disk Storage</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="As opposed to using 'Content here, content here', making it look like readable English.">2048MB</span> RAM</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.">10</span> Sites</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).">Unlimited</span> Databases</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="There are many variations of passages of Lorem Ipsum available, but the majority.">Unlimited</span> Mail</div>
                    </div>
                    <button class="btn btn-primary">Select Plan</button>
                </div>
                <!-- /PriceBox -->
            </div>
            <!-- /Column -->

            <!-- Column -->
            <div class="col-12 col-lg-4">
                <!-- PriceBox -->
                <div class="price-box">
                    <div class="title">Ultra</div>
                    <div class="value">
                        $
                        <span class="int">59</span>
                        <span class="real">99</span>
                        <span class="divider">/ month</span>
                    </div>
                    <div class="content text-center">
                        <div class="feature"><span data-toggle="tooltip" data-title="It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.">100GB</span> Disk Storage</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="As opposed to using 'Content here, content here', making it look like readable English.">4048MB</span> RAM</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.">Unlimited</span> Sites</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).">Unlimited</span> Databases</div>
                        <div class="feature"><span data-toggle="tooltip" data-title="There are many variations of passages of Lorem Ipsum available, but the majority.">Unlimited</span> Mail</div>
                    </div>
                    <button class="btn btn-outline-primary">Select Plan</button>
                </div>
                <!-- /PriceBox -->
            </div>
            <!-- /Column -->

        </div>
    </x-section>
    <!-- /Section: Price -->

    <!-- Section: Contact -->
    <x-section
        title="contact"
        sectionTitle="Contact Us"
        sectionSubtitle="Contact us in any convenient way and we will reply to you"
        prevSection="price"
        nextSection="home"
        alignment="right"
        sectionNumber="6"
    >
        <!-- Form Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-12 pt-5">

                <!-- Form -->
                @livewire('contact-form')
                <!-- Form -->

            </div>
            <!-- /Column -->
        </div>
        <!-- /Form Row -->
    </x-section>
    <!-- /Section: Contact -->
@endsection
