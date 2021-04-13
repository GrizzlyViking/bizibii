
    /* -------------------------------------------------------------------------------------------------------------- *
     * Page Scroll
     * -------------------------------------------------------------------------------------------------------------- */

    // TODO:
    //   1. Add top/bottom offsets

    var lastScrollTop = $window.scrollTop();

    var eventScroll = function() {

        // Function variables
        var scrollTop      = $window.scrollTop();
        var windowHeight   = $window.height();
        var documentHeight = $document.height();

        // Page top event
        if (scrollTop === 0) {
            $window.trigger('page:top');
        }

        // Page bottom event
        if (scrollTop + windowHeight >= documentHeight) {
            $window.trigger('page:bottom');
        }

        // Page scroll event
        $window.trigger('page:scroll', {
            percents:  Math.round(scrollTop / (documentHeight - windowHeight) * 100)
        });

        // Scroll direction events
        if (scrollTop > lastScrollTop) {

            $window.trigger('page:scroll-down');

            if (lastScrollTop === 0) {
                $window.trigger('page:top-leave');
            }

        } else {

            $window.trigger('page:scroll-up');

            if (lastScrollTop === (documentHeight - windowHeight)) {
                $window.trigger('page:bottom-leave');
            }
        }

        // Update last scroll position
        lastScrollTop = scrollTop;
    };

    $window.on('scroll', eventScroll);
    $window.on('page:top',          function(e) { $body.addClass('page-top');       });
    $window.on('page:top-leave',    function(e) { $body.removeClass('page-top');    });
    // $window.on('page:bottom',       function(e) { $body.addClass('page-bottom');    });
    // $window.on('page:bottom-leave', function(e) { $body.removeClass('page-bottom'); });

    eventScroll();

    // $window.on('page:scroll-down',  function(e)    { console.log(e.type); });
    // $window.on('page:scroll-up',    function(e)    { console.log(e.type); });
    // $window.on('page:top',          function(e)    { console.log(e.type); });
    // $window.on('page:bottom',       function(e)    { console.log(e.type); });
    // $window.on('page:top-leave',    function(e)    { console.log(e.type); });
    // $window.on('page:bottom-leave', function(e)    { console.log(e.type); });
    // $window.on('page:scroll',       function(e, p) { console.log(e.type + ' percents: ' + p.percents); });


