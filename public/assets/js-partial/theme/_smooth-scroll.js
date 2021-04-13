
    /* -------------------------------------------------------------------------------------------------------------- *
     * Smooth Scroll
     * -------------------------------------------------------------------------------------------------------------- */

    $('.smooth-scroll:not([href="#"])').on('click', function(e) {

        e.preventDefault();

        var $this = $(this),
            target = $this.attr('href');

        if (target === 'undefined') return;

        var $target = $(target);
        if ($target.length === 0) return;

        $.scrollWindow($target.offset().top || 0);

    });

    $.scrollWindow = function(offset) {

        $overlay.fadeIn();
        $bodyHTML.animate({ scrollTop: offset }, 750);
        $overlay.delay(300).fadeOut();

        if ($html.hasClass('mobile')) {
            $('.aside').removeClass('aside-expand');
        }
    };
