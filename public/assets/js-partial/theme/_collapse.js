
    /* -------------------------------------------------------------------------------------------------------------- *
     * Collapse
     * -------------------------------------------------------------------------------------------------------------- */

    $(document).on('show.bs.collapse', '.collapse', function () {
        $('[data-toggle="collapse"][data-target="#' + $(this).attr('id') + '"]').addClass('toggle-in');
    });

    $(document).on('hide.bs.collapse', '.collapse', function () {
        $('[data-toggle="collapse"][data-target="#' + $(this).attr('id') + '"]').removeClass('toggle-in');
    });

