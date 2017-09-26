/**
 * Website Application.
 *
 * @class
 */
var Application = new function () {

    'use strict';

    /**
     * Application object alias.
     *
     * @alias Application
     */
    var app = this;

    /**
     * Application widgets.
     *
     * @namespace
     */
    this.widgets = {};

    /**
     * Application mobile.
     * Check is it mobile phone.
     *
     * @method
     */
    this.isMobile = (function () {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    })();

    /**
     * Application init.
     * Each and add widgets.
     *
     * @method
     */

    this.init = function (widgets) {
        if (widgets) {
            jQuery.each(widgets, function (key, value) {
                value.call(app);
                app.widgets[key] = value;
            });
        }
    }
};


