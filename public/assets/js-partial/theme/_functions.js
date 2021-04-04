/* ------------------------------------------------------------------------------------------------------------------ *
 *                                                                                                                    *
 * Functions                                                                                                          *
 *                                                                                                                    *
 * ------------------------------------------------------------------------------------------------------------------ */

/**
 * Extends Date
 * @returns {number}
 */
Date.prototype.daysInMonth = function() {
    return 33 - new Date(this.getFullYear(), this.getMonth(), 33).getDate();
};

/**
 * Returns the integral quotient
 *
 * @param val
 * @param by
 * @returns {number}
 */
function div(val, by){
    return (val - val % by) / by;
}

/**
 * Returns random number
 *
 * @param min
 * @param max
 * @returns {*}
 */
function getRandomNumber(min, max)  {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
