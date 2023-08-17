/*jslint esversion: 6, regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global d4plib_admin_data*/

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.sweeppress = window.wp.sweeppress || {};

    window.wp.sweeppress.helpers = {
        sizeFormat: function(size) {
            if (size === 0) {
                return "0 B";
            }

            const mod = Math.floor(Math.log(size) / Math.log(1024));

            return '<strong>' + (size / Math.pow(1024, mod)).toFixed(0) + '</strong> ' + ' KMGTP'.charAt(mod) + 'B';
        }
    };

    window.wp.sweeppress.admin = {
        init: function() {
            if (d4plib_admin_data.page.panel === "dashboard") {
                wp.sweeppress.admin.shared.init();
                wp.sweeppress.admin.dashboard.dialogs();
                wp.sweeppress.admin.dashboard.init();
            }

            if (d4plib_admin_data.page.panel === "sweep") {
                wp.sweeppress.admin.shared.init();
                wp.sweeppress.admin.sweep.init();
            }
        },
        dashboard: {
            init: function() {
                if ($(".sweeppress-sweeper-check").length > 0) {
                    $(".sweeppress-dashboard-check-all").show();
                }

                $(document).on("change", ".sweeppress-dashboard-check-all", function() {
                    const wrapper = $(this).closest(".sweeper-dashboard-overview"),
                        checked = $(this).is(":checked");

                    $(".sweeppress-sweeper-check", wrapper).prop("checked", checked).change();
                });

                $(document).on("change", ".sweeppress-task-check, .sweeppress-sweeper-check", function() {
                    const checked = $(".sweeppress-task-check:checked"), total = checked.length;
                    let records = 0, size = 0;

                    if (total > 0) {
                        checked.each(function() {
                            records += $(this).data("records");
                            size += $(this).data("size");
                        });
                    }

                    $(".sweeppress-sweeper-counters strong").html(records);
                    $(".sweeppress-sweeper-counters span").html(wp.sweeppress.helpers.sizeFormat(size));

                    $(".sweeppress-sweeper-wrapper input[type=submit]").prop("disabled", total === 0);
                });

                $(document).on("click", "#sweeppress-information-auto .button-secondary", function(e) {
                    e.preventDefault();

                    $(".sweeper-dashboard-auto").hide();
                    $(".sweeper-dashboard-overview").show();
                });

                $(document).on("click", "#sweeppress-information-auto .button-primary", function(e) {
                    e.preventDefault();

                    $("#sweeppress-dialog-dashboard-auto").wpdialog("open");
                });

                $("form#sweeppress-form-quick").on("submit", function(e) {
                    e.preventDefault();

                    if ($(this).data("status") !== "working") {
                        $(this).slideUp("slow").data("status", "working");
                        $(".sweeppress-dashboard-check-all").hide();
                        $("#sweeppress-results-quick").slideDown("slow");
                        $(window).scrollTop(0);

                        $(this).ajaxSubmit({
                            dataType: "html",
                            type: "post",
                            timeout: 5 * 60 * 1000,
                            url: ajaxurl + "?action=sweeppress-run-quick",
                            success: function(html) {
                                $("#sweeppress-results-quick").html(html);
                            },
                            error: function(request, status, error) {
                                $("#sweeppress-results-quick").html(error);
                            }
                        });
                    }
                });
            },
            auto: function() {
                var nonce = $("#sweeppress-information-auto .button-primary").data("nonce");

                $("#sweeppress-information-auto").remove();
                $("#sweeppress-results-auto").slideDown("slow");
                $(window).scrollTop(0);

                $.ajax({
                    dataType: "html",
                    type: "post",
                    timeout: 5 * 60 * 1000,
                    url: ajaxurl + "?action=sweeppress-run-auto&_wpnonce=" + nonce,
                    success: function(html) {
                        $("#sweeppress-results-auto").html(html);
                    },
                    error: function(request, status, error) {
                        $("#sweeppress-results-auto").html(error);
                    }
                });
            },
            dialogs: function() {
                var dialog_run = $.extend({}, wp.dev4press.dialogs.default_dialog(), {
                    dialogClass: wp.dev4press.dialogs.classes("sweeppress-dialog-hide-x"),
                    buttons: [
                        {
                            id: "sweeppress-dialog-auto-run",
                            class: "sweeppress-dialog-auto-button-run",
                            text: d4plib_admin_data.ui.buttons.start,
                            data: {icon: "ok"},
                            click: function() {
                                $("#sweeppress-dialog-dashboard-auto").wpdialog("close");
                                wp.sweeppress.admin.dashboard.auto();
                            }
                        },
                        {
                            id: "sweeppress-dialog-auto-cancel",
                            class: "sweeppress-dialog-auto-button-cancel button-has-focus",
                            text: d4plib_admin_data.ui.buttons.cancel,
                            data: {icon: "cancel"},
                            autofocus: true,
                            click: function() {
                                $("#sweeppress-dialog-dashboard-auto").wpdialog("close");
                            }
                        }
                    ]
                });

                $("#sweeppress-dialog-dashboard-auto").wpdialog(dialog_run);

                wp.dev4press.dialogs.icons("#sweeppress-dialog-dashboard-auto");
            }
        },
        sweep: {
            init: function() {
                $(document).on("click", "button.toggle-empty-tasks", function(e) {
                    e.preventDefault();

                    const status = $(this).attr("aria-expanded") === "true",
                        wrapper = $(this).closest(".sweeppress-sweepers-wrapper");

                    wrapper.find(".empty-sweeper").toggleClass("show-empty-sweeper");
                    wrapper.find(".empty-sweeper-category").toggleClass("show-empty-sweeper-category");

                    if (status) {
                        $(this).attr("aria-expanded", "false");
                    } else {
                        $(this).attr("aria-expanded", "true");
                    }
                });

                $(document).on("click", ".sweeppress-item-wrapper h5 button.toggle-empty", function(e) {
                    e.preventDefault();

                    const status = $(this).attr("aria-expanded") === "true";

                    $(this).closest(".sweeppress-item-wrapper").toggleClass("show-empty-tasks");

                    if (status) {
                        $(this).attr("aria-expanded", "false");
                    } else {
                        $(this).attr("aria-expanded", "true");
                    }
                });

                $(document).on("click", ".sweeppress-item-wrapper h5 button.toggle-section", function(e) {
                    e.preventDefault();

                    const id = "#" + $(this).attr("aria-controls"),
                        status = $(this).attr("aria-expanded") === "true";

                    if (status) {
                        $(this).attr("aria-expanded", "false");
                        $(id).prop("hidden", true);
                    } else {
                        $(this).attr("aria-expanded", "true");
                        $(id).prop("hidden", false);
                    }
                });

                $(document).on("change", ".sweeppress-task-check, .sweeppress-sweeper-check", function() {
                    const checked = $(".sweeppress-task-check:checked"), total = checked.length;
                    let records = 0, size = 0;

                    if (total > 0) {
                        checked.each(function() {
                            records += $(this).data("records");
                            size += $(this).data("size");
                        });
                    }

                    $(".sweeppress-sweeper-counters .sweeppress-sweep-tasks").html(total);
                    $(".sweeppress-sweeper-counters .sweeppress-sweep-records").html(records);
                    $(".sweeppress-sweeper-counters .sweeppress-sweep-size").html(wp.sweeppress.helpers.sizeFormat(size));

                    $("#sweeppress-sweep-run").prop("disabled", total === 0);
                });

                $("form#sweeppress-form-sweep").on("submit", function(e) {
                    e.preventDefault();

                    if ($(this).data("status") !== "working") {
                        $(this).data("status", "working");

                        $("#sweeppress-results-wrapper").slideDown("slow");
                        $(".sweeppress-sweepers-wrapper").slideUp("slow", function() {
                            $(this).remove();
                            $("#sweeppress-sweep-run").remove();
                        });
                        $(window).scrollTop(0);

                        $(this).ajaxSubmit({
                            dataType: "html",
                            type: "post",
                            timeout: 5 * 60 * 1000,
                            url: ajaxurl + "?action=sweeppress-run-sweep",
                            success: function(html) {
                                $("#sweeppress-results-sweeper").html(html);
                            },
                            error: function(request, status, error) {
                                $("#sweeppress-results-sweeper").html(error);
                            }
                        });
                    }
                });
            }
        },
        shared: {
            init: function() {
                $(document).on("change", ".sweeppress-sweeper-check", function() {
                    const wrapper = $(this).closest(".sweeppress-item-wrapper"),
                        checked = $(this).is(":checked");

                    $(".sweeppress-task-check", wrapper).prop("checked", checked).change();
                });
            }
        },
        storage: {
            url: ''
        }
    };

    $(document).ready(function() {
        wp.sweeppress.admin.init();
    });
})(jQuery, window, document);
