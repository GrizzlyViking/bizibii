
    /* -------------------------------------------------------------------------------------------------------------- *
     * Animate Numbers
     * -------------------------------------------------------------------------------------------------------------- */

    var $animateNumber = $('.animate-number');
    if ($animateNumber.length > 0) $animateNumber.appear();

    $body.on('appear', '.animate-number', function () {
        $animateNumber.each(function () {
            var $this = $(this);
            if ($this.hasClass('animate-stop')) return;
            $this.animateNumber({ number: $this.attr('data-value') }, 1500);
            $this.addClass('animate-stop');
        });
    });
