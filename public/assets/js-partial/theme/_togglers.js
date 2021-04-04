
    /* -------------------------------------------------------------------------------------------------------------- *
     * Togglers
     * -------------------------------------------------------------------------------------------------------------- */

    $(document).on('click', '[data-toggle="class"]', function(e) {

        e.preventDefault();

        // Current toggler element
        var $this = $(this);
        // Target element
        var tg    = $this.attr('data-target');
        // Class
        var cl    = $this.attr('data-class');
        // Element collection
        var $el;

        // Skip if required attributes not found
        if (typeof tg === 'undefined' || typeof cl === 'undefined') return;

        // Find elements
        $el = $(tg);

        // Return if elements not found
        if ($el.length === 0) return;

        // First element!!!
        if ($el.hasClass(cl)) {

            // Remove class from element
            $el.removeClass(cl);

            // Change togglers classes
            $('[data-target="' + tg + '"]').each(function() {

                var $_this = $(this);

                var togglerClassIn   = $_this.attr('data-toggler-class-in');
                var togglerClassOut  = $_this.attr('data-toggler-class-out');

                // Remove "in"-state class
                if (typeof togglerClassIn !== 'undefined') {
                    $_this.removeClass(togglerClassIn);
                }

                // Add "out"-state class
                if (typeof togglerClassOut !== 'undefined') {
                    $_this.addClass(togglerClassOut);
                }

            });

        } else {

            // Add class to element
            $el.addClass(cl);

            // Change togglers classes
            $('[data-target="' + tg + '"]').each(function() {

                var $_this = $(this);

                var togglerClassIn   = $_this.attr('data-toggler-class-in');
                var togglerClassOut  = $_this.attr('data-toggler-class-out');

                // Remove "out"-state classes
                if (typeof togglerClassOut !== 'undefined') {
                    $_this.removeClass(togglerClassOut);
                }

                // Add "in"-state classes
                if (typeof togglerClassIn !== 'undefined') {
                    $_this.addClass(togglerClassIn);
                }

            });
        }

    });
