! function(e) {
    "use strict";
    redux.field_objects = redux.field_objects || {}, redux.field_objects.import_export = redux.field_objects.import_export || {}, redux.field_objects.import_export.init = function(i) {
        i || (i = e(document).find(".redux-group-tab:visible").find(".redux-container-import_export:visible")), e(i).each(function() {
            var i = e(this),
                t = i;
            i.hasClass("redux-field-container") || (t = i.parents(".redux-field-container:first")), t.is(":hidden") || t.hasClass("redux-field-init") && (t.removeClass("redux-field-init"), i.each(function() {
                e("#redux-import").click(function(i) {
                    return "" === e("#import-code-value").val() && "" === e("#import-link-value").val() ? (i.preventDefault(), !1) : (window.onbeforeunload = null, void(redux.args.ajax_save = !1))
                }), e(this).find("#redux-import-code-button").click(function() {
                    var i = e("#redux-import-code-wrapper");
                    e("#redux-import-link-wrapper").is(":visible") ? (e("#import-link-value").text(""), e("#redux-import-link-wrapper").slideUp("fast", function() {
                        i.slideDown("fast", function() {
                            e("#import-code-value").focus()
                        })
                    })) : i.is(":visible") ? i.slideUp() : i.slideDown("medium", function() {
                        e("#import-code-value").focus()
                    })
                }), e(this).find("#redux-import-link-button").click(function() {
                    var i = e("#redux-import-link-wrapper");
                    e("#redux-import-code-wrapper").is(":visible") ? (e("#import-code-value").text(""), e("#redux-import-code-wrapper").slideUp("fast", function() {
                        i.slideDown("fast", function() {
                            e("#import-link-value").focus()
                        })
                    })) : i.is(":visible") ? i.slideUp() : i.slideDown("medium", function() {
                        e("#import-link-value").focus()
                    })
                }), e(this).find("#redux-export-code-copy").click(function() {
                    var i = e("#redux-export-code");
                    e("#redux-export-link-value").is(":visible") ? e("#redux-export-link-value").slideUp("fast", function() {
                        i.slideDown("medium", function() {
                            var i = redux.options;
                            i["redux-backup"] = 1, e(this).text(JSON.stringify(i)).focus().select()
                        })
                    }) : i.is(":visible") ? i.slideUp().text("") : i.slideDown("medium", function() {
                        var i = redux.options;
                        i["redux-backup"] = 1, e(this).text(JSON.stringify(i)).focus().select()
                    })
                }), e(this).find("textarea").focusout(function() {
                    e(this).attr("id"), e(this)
                }), e(this).find("#redux-export-link").click(function() {
                    var i = e("#redux-export-link-value");
                    e("#redux-export-code").is(":visible") ? e("#redux-export-code").slideUp("fast", function() {
                        i.slideDown().focus().select()
                    }) : i.is(":visible") ? i.slideUp() : i.slideDown("medium", function() {
                        e(this).focus().select()
                    })
                });
                var i = document.getElementById("redux-export-code");
                i.onfocus = function() {
                    i.select(), i.onmouseup = function() {
                        return i.onmouseup = null, !1
                    }
                };
                var t = document.getElementById("import-code-value");
                t.onfocus = function() {
                    t.select(), t.onmouseup = function() {
                        return t.onmouseup = null, !1
                    }
                }, e("#redux-import-from-file").click(function() {
                    e("#redux-import-file-type").trigger("click")
                }), e("#redux-import-file-type").on("change", function() {
                    if (1 == confirm("Are you sure! You want import the file. Please make sure to take backup of your AMP Settings before importing, it will override your AMP Settings.")) {
                        var i = e("#ampforwp_import_nonce").val(),
                            t = e("#redux-import-file-type").prop("files")[0],
                            o = new FormData;
                        o.append("file", t), o.append("action", "ampforwp_import_file_from_file"), o.append("security", i), e.ajax({
                            url: ajaxurl,
                            cache: !1,
                            contentType: !1,
                            processData: !1,
                            data: o,
                            type: "post",
                            success: function(i) {
                                "0" != (i = i.replace(/}0/i, "}")) ? (e("#import-code-value").hide(), e("#import-code-value").val(i), e("#redux-import").trigger("click")) : e("#admin-import-file-name").html("Unable to import the file.")
                            }
                        })
                    } else location.reload()
                })
            }))
        })
    }
}(jQuery);