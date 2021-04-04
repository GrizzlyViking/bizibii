
    /* -------------------------------------------------------------------------------------------------------------- *
     * Material Controls
     * -------------------------------------------------------------------------------------------------------------- */

    $('.md-form-control')
        .each(function() {
            var $this = $(this);
            if ($this.val() !== '') $this.parent().addClass('md-completed');
        })
        .on('focus', function() {
            $(this).parent().addClass('focus');
        })
        .on('blur', function() {

            var $this = $(this);
            var $parent = $this.parent();

            $parent.removeClass('focus');

            if ($(this).val() !== '') $parent.addClass('md-completed');
            else $parent.removeClass('md-completed');
        })
        .on('input, change', function() {

            var $parent = $(this).parent();

            if ($(this).val() !== '') $parent.addClass('md-completed');
            else $parent.removeClass('md-completed');
        });
