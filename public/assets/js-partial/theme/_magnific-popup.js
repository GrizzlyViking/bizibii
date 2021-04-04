
    /* -------------------------------------------------------------------------------------------------------------- *
     * Magnific Popup
     * -------------------------------------------------------------------------------------------------------------- */

    $('.popup-image').magnificPopup({
        closeBtnInside: true,
        type          : 'image',
        mainClass     : 'mfp-fade',
        gallery       : {
            enabled: true
        }
    });

    $('.popup-iframe').magnificPopup({
        type      : 'iframe',
        mainClass : 'mfp-fade'
    });

    $('.popup-modal').magnificPopup({
        type      : 'inline',
        modal     : true,
        mainClass : 'mfp-fade'
    });

    $(document).on('click', '.popup-modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });
