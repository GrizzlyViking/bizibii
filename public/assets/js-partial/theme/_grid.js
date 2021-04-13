
    /* -------------------------------------------------------------------------------------------------------------- *
     * Grid
     * -------------------------------------------------------------------------------------------------------------- */

    function eventGridBreakpoints() {

        var width  = $window.width();
        var height = $window.height();

        for (var infix in app.gridBreakpoints) {

            if (!app.gridBreakpoints.hasOwnProperty(infix)) continue;

            if (width >= app.gridBreakpoints[infix]['min'] && width <= app.gridBreakpoints[infix]['max']) {
                $(window).trigger('grid:' + infix);
                break;
            }
        }

        var k  = div(height, app.gridYBreakpoints.step) + 1;
        var cl = app.gridYBreakpoints.prefix + (k * app.gridYBreakpoints.step);

        if ($body.hasClass(cl)) return;

        $body.removeClassByMask(app.gridYBreakpoints.prefix + '*');
        $body.addClass(cl);

    }

    // Add event listener
    $window.on('resize', eventGridBreakpoints);

    //
    // Grid Breakpoints Events Using:
    // ==============================

    // $window.on('grid:xs', function(e) { console.log(e.type); });
    // $window.on('grid:sm', function(e) { console.log(e.type); });
    // $window.on('grid:md', function(e) { console.log(e.type); });
    // $window.on('grid:lg', function(e) { console.log(e.type); });
    // $window.on('grid:xl', function(e) { console.log(e.type); });

    $window.on('grid:lg', function() {
        $html.removeClass('navbar-open');
    });
