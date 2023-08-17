/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

;(function ($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.dev4press = window.wp.dev4press || {};
    window.wp.dev4press.v42 = window.wp.dev4press.v42 || {};

    window.wp.dev4press.v42.metabox = {
        library: 'v42',
        init: function () {
            const wrapper = ".d4plib-" + wp.dev4press.v42.metabox.library + "-meta-box-wrapper";

            $(document).on("click", wrapper + " .d4p-check-uncheck a", function (e) {
                e.preventDefault();

                var checkall = $(this).attr("href").substring(1) === "checkall";

                $(this).parent().parent().find("input[type=checkbox]").prop("checked", checkall);
            });

            $(wrapper + " .wp-tab-bar button").click(function (e) {
                e.preventDefault();

                var name = $(this).data("tab"),
                    tab = $(this).parent(),
                    tabs = $(this).closest(".wp-tab-bar"),
                    wrap = $(this).closest(wrapper);

                tabs.find("li").removeClass("wp-tab-active");
                tab.addClass("wp-tab-active");

                wrap.find(".wp-tab-panel")
                    .removeClass("tabs-panel-active")
                    .addClass("tabs-panel-inactive");

                wrap.find("#" + name)
                    .removeClass("tabs-panel-inactive")
                    .addClass("tabs-panel-active");
            });
        }
    };

    $(document).ready(function () {
        wp.dev4press.v42.metabox.init();
    });
})(jQuery, window, document);
