/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.dev4press = window.wp.dev4press || {};

    window.wp.dev4press.widgets = {
        init: function() {
            $(document).on("click", ".d4p-check-uncheck a", function(e) {
                e.preventDefault();

                var checkall = $(this).attr("href").substring(1) === "checkall";

                $(this).parent().parent().find("input[type=checkbox]").prop("checked", checkall);
            });

            $(document).on("click", ".d4plib-widget-tab", function(e) {
                e.preventDefault();

                var tabs = $(this).parent(),
                    content = tabs.next(),
                    tab = $(this).attr("href").substring(1),
                    tab_name = typeof $(this).data("tabname") !== 'undefined' ? $(this).data("tabname") : tab;

                $(".d4plib-widget-active-tab", tabs).val(tab_name);
                $(".d4plib-widget-tab", tabs).removeClass("d4plib-tab-active").attr("aria-selected", "false");
                $(".d4plib-tabname-" + tab, tabs).addClass("d4plib-tab-active").attr("aria-selected", "true");

                $(".d4plib-tab-content", content).removeClass("d4plib-content-active").attr("aria-hidden", "true");
                $(".d4plib-tabname-" + tab, content).addClass("d4plib-content-active").attr("aria-hidden", "false");
            });

            $(document).on("keydown", ".d4plib-widget-tab[role='tab']", function(e) {
                if (e.which === 13) {
                    $(this).click();
                } else if (e.which === 39) {
                    $(this).next().focus().click();
                } else if (e.which === 37) {
                    $(this).prev().focus().click();
                }
            });

            $(document).on("change", ".d4plib-widget-save", function() {
                $(this).closest("form").find(".widget-control-actions input.button").click();
            });

            $(document).on("change", ".d4plib-div-switch", function() {
                var method = $(this).val(),
                    prefix = $(this).data().hasOwnProperty("prefix") ? $(this).data("prefix") : '',
                    block = prefix === "" ? ".d4p-div-block" : ".d4p-div-block-" + prefix,
                    parent = $(this).closest(".widget-content");

                $(block, parent).hide();
                $(block + "-" + method, parent).show();
            });

            $(document).on("change", ".d4plib-block-switch", function() {
                var block = $(this).data("block"),
                    selected = $(this).val(),
                    parent = $(this).closest("table");

                $(".cellblock-" + block, parent).hide();
                $(".cellblockname-" + selected, parent).show();
            });

            $(document).ajaxStop(function() {
                wp.dev4press.widgets.settings();
            });
        },
        settings: function() {
            $(".d4p-color-picker:not(.wp-color-picker)").on("focus", function() {
                $(this).wpColorPicker();
            });
        }
    };

    $(document).ready(function() {
        wp.dev4press.widgets.init();
        wp.dev4press.widgets.settings();
    });
})(jQuery, window, document);
