
    /* -------------------------------------------------------------------------------------------------------------- *
     * Navigation
     * -------------------------------------------------------------------------------------------------------------- */

    /*
    $document
        .on('show.bs.collapse', '.navbar-collapse', function () {
            $body.addClass('fix-scroll');
        })
        .on('hide.bs.collapse', '.navbar-collapse', function () {
            $body.removeClass('fix-scroll');
        });

    var updateNavigation = function (){

        var width = $window.width();

        if ($navbar.hasClass('navbar-expand-lg') && width >= app.gridBreakpoints.lg.min ||
            $navbar.hasClass('navbar-expand-md') && width >= app.gridBreakpoints.md.min ||
            $navbar.hasClass('navbar-expand-sm') && width >= app.gridBreakpoints.sm.min) {
            $body.removeClass('fix-scroll');
        } else {
            if ($navbarCollapse.hasClass('show')) {
                $body.addClass('fix-scroll');
            }
        }

        if (!$navbarCollapse.hasClass('show')) navbarHeight = $navbar.height();
        $navbarCollapse.css('max-height', $window.height() - navbarHeight);
    };

    var resizeTimer;
    $(window).on('resize', function(e) {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(updateNavigation, 250);
    });

    updateNavigation();
    */
