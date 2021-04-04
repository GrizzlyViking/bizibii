
    /* -------------------------------------------------------------------------------------------------------------- *
     * OWLCarousel2
     * -------------------------------------------------------------------------------------------------------------- */

    function initOwlCarousel($carousel) {

        $carousel.owlCarousel('destroy');

        var owl_parameters = {
            dots: false,
            navText: [
                '<i class="icon ti-angle-left"></i>',
                '<i class="icon ti-angle-right"></i>'
            ]
        };

        var data_items = $carousel.data('owl-items') || 1,
            items_count = parseInt(data_items, 10);

        // Set to config
        owl_parameters['items'] = items_count;

        // Disable mouse drag
        if ($carousel.hasClass('owl-no-mousedrag')) owl_parameters['mouseDrag'] = false;
        // Show prev/next navigation
        if ($carousel.hasClass('owl-navigation')) owl_parameters['nav'] = true;
        // Show dots navigation
        if ($carousel.hasClass('owl-pagination')) owl_parameters['dots'] = true;
        // Loop
        if ($carousel.hasClass('owl-loop')) owl_parameters['loop'] = true;

        // Enable autoplay
        if ($carousel.hasClass('owl-autoplay')) {
            owl_parameters['loop'] = true;
            owl_parameters['autoplay'] = true;
            owl_parameters['autoplayTimeout'] = $carousel.data('owl-autoplay-timeout') || 5000;
        }

        // Responsive Items Count
        var data_items_responsive = $carousel.data('owl-items-responsive');
        if (typeof data_items_responsive !== 'undefined') {

            var arr = data_items_responsive.split(';'),
                responsive = {};

            responsive[1000] = { items: items_count };
            responsive[0] = { items: 1 };

            for (var i = 0, j = arr.length; i < j; i++) {

                var _arr = arr[i].split(':');
                if (typeof _arr[0] === 'undefined' || typeof _arr[1] === 'undefined') continue;

                var max_w = parseInt((_arr[0]).trim(), 10),
                    items_cnt = parseInt((_arr[1]).trim(), 10);

                responsive[max_w] = { items: items_cnt }
            }

            owl_parameters['responsive'] = responsive;
            owl_parameters['responsiveClass'] = true;
        }

        // Custom Animation
        var animate_in = $carousel.attr('data-owl-animate-in'),
            animate_out = $carousel.attr('data-owl-animate-out');

        if (typeof animate_in !== 'undefined') owl_parameters['animateIn'] = animate_in;
        if (typeof animate_out !== 'undefined') owl_parameters['animateOut'] = animate_out;

        // Initialize OWL Carousel
        $carousel.owlCarousel(owl_parameters);
    }

    $('.owl-carousel').each(function() {
        initOwlCarousel($(this));
    });

    //
    // Custom API
    //

    $(document).on('click', '[data-action="owl-prev"]', function() {
        $($(this).attr('data-target')).trigger('prev.owl.carousel');
    });

    $(document).on('click', '[data-action="owl-next"]', function() {
        $($(this).attr('data-target')).trigger('next.owl.carousel');
    });
