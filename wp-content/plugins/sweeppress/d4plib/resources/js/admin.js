/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global d4plib_admin_data*/

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.dev4press = window.wp.dev4press || {};

    window.wp.dev4press.admin = {
        scroll_offset: 40,
        active_element: null,
        init: function() {
            wp.dev4press.admin.components.scroller.run();
            wp.dev4press.admin.components.interface.run();
            wp.dev4press.admin.components.notices.run();

            if (d4plib_admin_data.page.panel === 'settings' || d4plib_admin_data.page.panel === 'tools') {
                wp.dev4press.admin.panels.settings.run();
            }

            if (d4plib_admin_data.page.panel === 'features') {
                wp.dev4press.admin.panels.settings.run();
                wp.dev4press.admin.panels.features.run();
            }

            $(window).on("load resize orientationchange", function() {
                wp.dev4press.admin.components.scroller.resize();
            });
        },
        panels: {
            features: {
                run: function() {
                    $(document).on("click", ".d4p-features-filter-buttons button", function(e) {
                        e.preventDefault();

                        var button = $(this),
                            buttons = $(".d4p-features-filter-buttons button");

                        buttons.removeClass("is-selected");
                        button.addClass("is-selected");

                        wp.dev4press.admin.panels.features.filter();
                    });

                    $(document).on("change", ".d4p-feature-box ._activation input", function() {
                        var active = $(this).is(":checked"),
                            feature = $(this).closest(".d4p-feature-box"),
                            name = $(this).data("feature");

                        if (active) {
                            feature.addClass("_is-active");
                        } else {
                            feature.removeClass("_is-active");
                        }

                        wp.dev4press.admin.panels.features.ajax([name], active);
                        wp.dev4press.admin.panels.features.filter();
                        wp.dev4press.admin.panels.features.counters();
                    });

                    $(document).on("click", ".d4p-features-bulk-ctrl-options button", function(e) {
                        e.preventDefault();

                        var action = $(this).data("action"),
                            list = [];

                        $(".d4p-feature-box ._activation input").each(function() {
                            var active = $(this).is(":checked"),
                                feature = $(this).closest(".d4p-feature-box"),
                                name = $(this).data("feature");

                            if (action === "enable") {
                                if (!active) {
                                    $(this).prop("checked", true);
                                    feature.addClass("_is-active");
                                    list.push(name);
                                }
                            } else {
                                if (active) {
                                    $(this).prop("checked", false);
                                    feature.removeClass("_is-active");
                                    list.push(name);
                                }
                            }
                        });

                        $(".d4p-features-bulk-ctrl").trigger("click");

                        wp.dev4press.admin.panels.features.ajax(list, action === "enable");
                        wp.dev4press.admin.panels.features.filter();
                        wp.dev4press.admin.panels.features.counters();
                    });

                    $(document).on("click", ".d4p-features-bulk-ctrl", function(e) {
                        e.preventDefault();

                        if ($(this).hasClass("button-secondary")) {
                            $(this).removeClass("button-secondary").addClass("button-primary");
                            $(this).next().hide();
                        } else {
                            $(this).removeClass("button-primary").addClass("button-secondary");
                            $(this).next().show();
                        }
                    });

                    $(document).on("click", ".d4p-feature-more-ctrl", function(e) {
                        e.preventDefault();

                        if ($(this).hasClass("_is-open")) {
                            $(this).removeClass("_is-open");
                            $(this).next().hide();
                            $(this).next().next().show();
                        } else {
                            $(this).addClass("_is-open");
                            $(this).next().show();
                            $(this).next().next().hide();
                        }
                    });

                    $(".d4p-features-filter-search input").on("keyup", function(e) {
                        var search = $(this).val(), block = $(this).parent();

                        if (search.length > 0) {
                            block.addClass("is-active");
                        } else {
                            block.removeClass("is-active");
                        }

                        wp.dev4press.admin.panels.features.filter();
                    });

                    $(document).on("click", ".d4p-features-filter-search i", function(e) {
                        $(".d4p-features-filter-search input").val("").trigger("keyup");
                        $(".d4p-features-filter-search").removeClass("is-active");
                    });

                    wp.dev4press.admin.panels.features.counters();
                },
                filter: function() {
                    var button = $(".d4p-features-filter-buttons button.is-selected"),
                        wrapper = $(".d4p-features-wrapper"),
                        selector = button.data("selector"),
                        search = $(".d4p-features-filter-search input").val().toLowerCase();

                    if (search.length < 2) {
                        search = '';
                    }

                    wrapper.find("._is-feature").addClass("hide-feature").removeClass("search-result search-result-title search-result-description");
                    wrapper.find(selector).removeClass("hide-feature");

                    if (search.length > 1) {
                        $("._is-feature:not(.hide-feature)", wrapper).each(function() {
                            var title = $(this).find("._title").html().toLowerCase(),
                                description = $(this).find("._description").html().toLowerCase(),
                                in_title = title.includes(search),
                                in_description = description.includes(search),
                                classes = "search-result";

                            if (in_title || in_description) {
                                if (in_title) {
                                    classes+= " search-result-title";
                                }

                                if (in_description) {
                                    classes+= " search-result-description";
                                }

                                $(this).addClass(classes);
                            } else {
                                $(this).addClass("hide-feature");
                            }
                        });
                    }
                },
                ajax: function(list, active) {
                    var request = "?action=" + d4plib_admin_data.plugin.prefix + "_feature_activation&_ajax_nonce=" + d4plib_admin_data.content.nonce,
                        args = {
                            url: ajaxurl + request,
                            type: "post",
                            dataType: "json",
                            data: {
                                feature: list,
                                status: active ? 'on' : 'off'
                            }
                        };

                    $.ajax(args);
                },
                counters: function() {
                    var wrapper = $(".d4p-features-wrapper"),
                        counters = $(".d4p-panel-features-counts div");

                    counters.each(function() {
                        var sel = $(this).data("selector"),
                            cnt = wrapper.find(sel).length;

                        $(this).find("span").html(cnt);
                    });
                }
            },
            settings: {
                run: function() {
                    wp.dev4press.admin.settings.init();

                    $("#" + d4plib_admin_data.plugin.prefix + "-form-settings").confirmsubmit();

                    if ($("#d4p-settings-mark").length === 1) {
                        wp.dev4press.admin.panels.settings.mark();
                    }
                },
                mark: function() {
                    $(document).on("click", ".d4p-panel-mark button", function() {
                        $("#d4p-settings-mark").val("").trigger("input");
                    });

                    var $groups = $(".d4p-group"),
                        $titles = $(".d4p-group > h3"),
                        $sections = $(".d4p-settings-section > h4"),
                        $content = $(".d4p-settings-table > tbody > tr");

                    $("#d4p-settings-mark").on("input", function() {
                        var term = $(this).val();

                        $groups.show();
                        $titles.unmark();
                        $sections.show().unmark();
                        $content.show().unmark();

                        if (term) {
                            $content.mark(term, {
                                done: function() {
                                    $content.not(":has(mark)").hide();
                                }
                            });

                            $sections.mark(term, {
                                done: function() {
                                    $sections.each(function(idx, el) {
                                        if ($(el).find("mark").length > 0) {
                                            $(el).parent().find(".d4p-settings-table > tbody > tr").show();
                                        } else {
                                            $(el).hide();
                                        }
                                    });
                                }
                            });

                            $titles.mark(term, {
                                done: function() {
                                    $titles.each(function(idx, el) {
                                        if ($(el).find("mark").length > 0) {
                                            $(el).parent().find(".d4p-settings-table > tbody > tr").show();
                                        }
                                    });
                                }
                            });

                            $titles.each(function(idx, el) {
                                var $group = $(el).parent(), height = 0,
                                    $elements = $(".d4p-settings-section", $group);

                                $elements.each(function(i, e) {
                                    if ($(e).height() > 0) {
                                        height += $(e).height();
                                    }
                                });

                                if (height === 0) {
                                    $group.hide();
                                }
                            });
                        }
                    });
                }
            }
        },
        components: {
            scroller: {
                run: function() {
                    var $sidebar = $(".d4p-panel-scroller"),
                        $window = $(window);

                    if ($sidebar.length > 0) {
                        var offset = $sidebar.offset();

                        $window.scroll(function() {
                            if ($window.scrollTop() > offset.top && $sidebar.hasClass("d4p-scroll-active")) {
                                $sidebar.stop().animate({
                                    marginTop: $window.scrollTop() - offset.top + wp.dev4press.admin.scroll_offset
                                });
                            } else {
                                $sidebar.stop().animate({
                                    marginTop: 0
                                });
                            }
                        });
                    }
                },
                resize: function() {
                    if (document.body.clientWidth < 800) {
                        wp.dev4press.admin.scroll_offset = 60;
                    } else {
                        wp.dev4press.admin.scroll_offset = 40;
                    }

                    if (document.body.clientWidth < 640) {
                        $(".d4p-panel-scroller").removeClass("d4p-scroll-active").stop().css("margin-top", 0);
                    } else {
                        $(".d4p-panel-scroller").addClass("d4p-scroll-active");
                    }
                }
            },
            interface: {
                run: function() {
                    $(document).on("click", ".d4p-nav-button > a", function(e) {
                        e.preventDefault();

                        $(this).next().slideToggle("fast");
                    });

                    if ($(".d4p-wrap .d4p-message .notice").length > 0) {
                        setTimeout(function() {
                            $(".d4p-wrap .d4p-message .notice").slideUp("slow");
                        }, 10000);
                    }
                }
            },
            notices: {
                run: function() {
                    $("#wpbody-content > div.notice").detach().prependTo(".d4p-wrap");
                }
            }
        },
        settings: {
            init: function() {
                wp.dev4press.admin.settings.color_picker.run();
                wp.dev4press.admin.settings.expandables.run();
                wp.dev4press.admin.settings.check_uncheck.run();
                wp.dev4press.admin.settings.switch.run();
            },
            color_picker: {
                run: function() {
                    var picker = $(".d4p-color-picker");

                    if (picker.length > 0) {
                        picker.wpColorPicker();
                    }
                }
            },
            check_uncheck: {
                run: function() {
                    $(document).on("click", ".d4p-check-uncheck a", function(e) {
                        e.preventDefault();

                        var checkall = $(this).attr("href").substring(1) === "checkall";

                        $(this).parent().parent().find("input[type=checkbox]").prop("checked", checkall);
                    });
                }
            },
            expandables: {
                run: function() {
                    $(document).on("click", ".d4p-setting-expandable_pairs .button-secondary", function(e) {
                        e.preventDefault();

                        var li = $(this).parent();

                        li.fadeOut(200, function() {
                            li.remove();
                        });
                    });

                    $(document).on("click", ".d4p-setting-expandable_text .button-secondary", function(e) {
                        wp.dev4press.admin.settings.expandables.remove(this, e);
                        wp.dev4press.admin.settings.expandables.remove(this, e);
                    });

                    $(document).on("click", ".d4p-setting-expandable_raw .button-secondary", function(e) {
                        wp.dev4press.admin.settings.expandables.remove(this, e);
                    });

                    $(document).on("click", ".d4p-setting-expandable_pairs a.button-primary", function(e) {
                        e.preventDefault();

                        var list = $(this).closest(".d4p-setting-expandable_pairs"),
                            next = $(".d4p-next-id", list),
                            next_id = next.val(),
                            el = $(".pair-element-0", list).clone();

                        $("input", el).each(function() {
                            var id = $(this).attr("id").replace("_0_", "_" + next_id + "_"),
                                name = $(this).attr("name").replace("[0]", "[" + next_id + "]");

                            $(this).attr("id", id).attr("name", name);
                        });

                        el.attr("class", "pair-element-" + next_id).fadeIn();
                        $(this).before(el);

                        next_id++;
                        next.val(next_id);
                    });

                    $(document).on("click", ".d4p-setting-expandable_text a.button-primary", function(e) {
                        wp.dev4press.admin.settings.expandables.add(this, e, ".d4p-setting-expandable_text");
                    });

                    $(document).on("click", ".d4p-setting-expandable_raw a.button-primary", function(e) {
                        wp.dev4press.admin.settings.expandables.add(this, e, ".d4p-setting-expandable_raw");
                    });
                },
                add: function(ths, e, cls) {
                    e.preventDefault();

                    var list = $(ths).closest(cls),
                        next = $(".d4p-next-id", list),
                        next_id = next.val(),
                        el = $(".exp-text-element-0", list).clone();

                    $("input", el).each(function() {
                        var id = $(this).attr("id").replace("_0_", "_" + next_id + "_"),
                            name = $(this).attr("name").replace("[0]", "[" + next_id + "]");

                        $(this).attr("id", id).attr("name", name);
                    });

                    el.attr("class", "exp-text-element exp-text-element-" + next_id).fadeIn();
                    $("ol", list).append(el);

                    next_id++;
                    next.val(next_id);
                },
                remove: function(ths, e) {
                    e.preventDefault();

                    var li = $(ths).parent();

                    li.fadeOut(200, function() {
                        li.remove();
                    });
                }
            },
            switch: {
                run: function() {
                    $(".d4p-switch-control-option select").change(function() {
                        var any, active, value = $(this).val(),
                            option = $(this).closest("tr").data("switch"),
                            type = $(this).closest("tr").data("switch-type");

                        if (type === 'option') {
                            any = ".d4p-switch-value-" + option;
                            active = ".d4p-switch-option-value-" + value;

                            $(any).addClass("d4p-switch-option-is-hidden");
                            $(any + active).removeClass("d4p-switch-option-is-hidden");
                        } else if (type === 'section') {
                            any = ".d4p-switch-section-" + option;
                            active = ".d4p-switch-section-value-" + value;

                            $(any).addClass("d4p-switch-section-is-hidden");
                            $(any + active).removeClass("d4p-switch-section-is-hidden");
                        }
                    });
                }
            }
        }
    };

    window.wp.dev4press.dialogs = {
        storage: {
            url: ''
        },
        classes: function(extra, hide_close) {
            var cls = "wp-dialog d4p-dialog d4p-dialog-modal";

            if (extra !== "") {
                cls += " " + extra;
            }

            if (typeof hide_close !== "undefined") {
                if (hide_close) {
                    cls += " d4p-dialog-hidex";
                }
            }

            return cls;
        },
        default_button: function(button, has_focus, button_text) {
            var id = "d4p-dialog-button-id-" + button,
                cls = "d4p-dialog-button-" + button + (has_focus ? " button-has-focus" : ""),
                text = typeof button_text !== "undefined" ? button_text : d4plib_admin_data.ui.buttons[button];

            return {
                id: id,
                class: cls,
                text: text,
                data: {
                    icon: button
                }
            };
        },
        default_dialog: function() {
            return {
                width: 480,
                height: "auto",
                minHeight: 24,
                autoOpen: false,
                resizable: false,
                modal: true,
                closeOnEscape: false,
                zIndex: 300000,
                open: function() {
                    $(".button-has-focus").focus();
                }
            };
        },
        icons: function(id, icon_html) {
            $(id).next().find(".ui-dialog-buttonset button").each(function() {
                if ($(this).find("span.ui-button-text").length === 0) {
                    $(this).html("<span class='ui-button-text'>" + $(this).html() + "</span>");
                }

                if (typeof icon_html === "undefined") {
                    var icon = $(this).data("icon");

                    if (icon !== "") {
                        $(this).find("span.ui-button-text").prepend(d4plib_admin_data.ui.icons[icon]);
                    }
                } else {
                    $(this).find("span.ui-button-text").prepend(icon_html);
                }
            });
        }
    };

    window.wp.dev4press.ajaxtask = {
        prefix: '',
        button: '',
        handler: '',
        nonce: '',
        progres: {
            active: false,
            stop: false,
            done: 0,
            total: 0
        },
        init: function(prefix, button, handler, nonce) {
            this.prefix = prefix;
            this.button = button;
            this.handler = handler;
            this.nonce = nonce;

            $(document).on("click", this.button, function() {
                if (wp.dev4press.ajaxtask.progres.active) {
                    wp.dev4press.ajaxtask.stop();
                } else {
                    wp.dev4press.ajaxtask.start();
                }
            });
        },
        start: function() {
            this.progres.active = true;

            $(this.button).val(d4plib_admin_data.ui.buttons.stop);

            $("#" + this.prefix + "-process").slideDown();
            $("#" + this.prefix + "-progress pre").html("");

            this._call({operation: "start"}, this._callback.start);
        },
        stop: function() {
            this.progres.stop = true;

            $(this.button).attr("disabled", true);
        },
        run: function() {
            this._call({operation: "run"}, this._callback.process);
        },
        _call: function(data, callback) {
            var args = {
                url: ajaxurl + "?action=" + this.handler + "&_ajax_nonce=" + this.nonce,
                type: "post",
                dataType: "json",
                data: data,
                success: callback
            };

            $.ajax(args);
        },
        _write: function(message) {
            $("#" + this.prefix + "-progress pre").append(message + "\r\n");
        },
        _callback: {
            start: function(json) {
                var p = wp.dev4press.ajaxtask.progres;

                p.current = 0;
                p.total = json.total;

                wp.dev4press.ajaxtask._write(json.message);

                wp.dev4press.ajaxtask.run();
            },
            stop: function(json) {
                wp.dev4press.ajaxtask.progres.active = false;
                wp.dev4press.ajaxtask._write(json.message);
            },
            process: function(json) {
                if (wp.dev4press.ajaxtask.progres.stop) {
                    wp.dev4press.ajaxtask._call({operation: "break"}, wp.dev4press.ajaxtask._callback.stop);
                } else {
                    wp.dev4press.ajaxtask.progres.done = json.done;

                    wp.dev4press.ajaxtask._write(json.message);

                    if (wp.dev4press.ajaxtask.progres.done < wp.dev4press.ajaxtask.progres.total) {
                        wp.dev4press.ajaxtask.run();
                    } else {
                        wp.dev4press.ajaxtask.stop();
                        wp.dev4press.ajaxtask._call({operation: "stop"}, wp.dev4press.ajaxtask._callback.stop);
                    }
                }
            }
        }
    };

    $(document).ready(function() {
        wp.dev4press.admin.init();
    });
})(jQuery, window, document);
