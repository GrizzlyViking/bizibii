
    /* -------------------------------------------------------------------------------------------------------------- *
     * Is Mobile
     * -------------------------------------------------------------------------------------------------------------- */

    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    $html.addClass(isMobile ? 'mobile' : 'no-mobile');

