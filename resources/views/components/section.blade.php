<section id="about" class="section {{ $alignment === 'right' ? 'section-right ' : '' }}section-{{ $title }}">
    <div class="container">

        <!-- Section Muted Title -->
        <div class="section-muted-title" data-stellar-ratio=".9">
            <span>{{ ucwords($title) }}</span>
        </div>
        <!-- /Section Muted Title -->

        <!-- Section Header Row -->
        <div class="row">
            <div class="col-12">
                <header class="section-header">

                    <!-- Section Navigation -->
                    <div class="section-navigation">
                        <a href="#{{ $prev_section }}" class="smooth-scroll">{{ sprintf('%02d', $section_number - 1) }} <span>{{ ucwords($prev_section) }}</span></a>
                        <a href="#{{ $next_section }}" class="smooth-scroll">{{ sprintf('%02d', $section_number + 1) }} <span>{{ ucwords($next_section) }}</span></a>
                    </div>
                    <!-- /Section Navigation -->

                    <!-- Section Heading -->
                    <div class="section-heading">
                        <div class="section-title">{{ $section_title }}</div>
                        <p class="section-subtitle">{{ $section_subtitle }}</p>
                    </div>
                    <!-- /Section Heading -->

                </header>
            </div>
        </div>
        <!-- /Section Header Row -->

        <!-- Section Content Row -->
        <div class="row section-content">
            <div class="col-12 col-lg-10">
                {{ $slot }}
            </div>
        </div>
        <!-- /Section Content Row -->

    </div>
</section>
