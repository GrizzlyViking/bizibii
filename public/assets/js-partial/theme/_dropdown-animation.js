
    /* -------------------------------------------------------------------------------------------------------------- *
     * Bootstrap Dropdown Animation
     * -------------------------------------------------------------------------------------------------------------- */

    var $dropdown = $('.dropdown');

    $dropdown.on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeIn('fast');
    });

    $dropdown.on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeOut('fast');
    });
