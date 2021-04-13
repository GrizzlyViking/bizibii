
    /* -------------------------------------------------------------------------------------------------------------- *
     * Additional Functions
     * -------------------------------------------------------------------------------------------------------------- */

    $.fn.removeClassByMask = function(mask) {
        return this.removeClass(function(index, cls) {
            var re = mask.replace(/\*/g, '\\S+');
            return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
        });
    };

