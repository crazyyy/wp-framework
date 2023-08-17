/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.dev4press = window.wp.dev4press || {};

    window.wp.dev4press.wizard = {
        init: function() {
            $(".gdbbx-wizard-connect-switch").change(function() {
                var connect = $(this).val() === "yes",
                    the_id = $(this).data("connect");

                if (connect) {
                    $("#" + the_id).slideDown("slow");
                } else {
                    $("#" + the_id).slideUp("fast");
                }
            });
        }
    };

    $(document).ready(function() {
        window.wp.dev4press.wizard.init();
    });
})(jQuery, window, document);
