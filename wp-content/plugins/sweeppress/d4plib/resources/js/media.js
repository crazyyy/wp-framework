/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global d4plib_media_data*/

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.dev4press = window.wp.dev4press || {};
    window.wp.dev4press.media = window.wp.dev4press.media || {};

    window.wp.dev4press.media.image = {
        handler: null,
        init: function() {
            if (wp && wp.media && wp.media.frames) {
                if (typeof wp.media.frames.dev4press === "undefined") {
                    wp.media.frames.dev4press = {media: {}};
                }

                if (typeof wp.media.frames.dev4press === "undefined" || typeof wp.media.frames.dev4press.media.image_frame === "undefined") {
                    wp.media.frames.dev4press.media.image_frame = wp.media({
                        title: d4plib_media_data.strings.image_title,
                        className: "media-frame d4plib-media-image-frame",
                        frame: "post",
                        multiple: false,
                        library: {
                            type: "image"
                        },
                        button: {
                            text: d4plib_media_data.strings.image_button
                        }
                    });

                    wp.media.frames.dev4press.media.image_frame.on("insert", function() {
                        var image = wp.media.frames.dev4press.media.image_frame.state().get("selection").first().toJSON();

                        if (wp.dev4press.media.image.handler) {
                            wp.dev4press.media.image.handler(image);
                        }
                    });
                }
            }
        },
        open: function(handler, hide_menu) {
            wp.dev4press.media.image.handler = handler;

            wp.media.frames.dev4press.media.image_frame.open();

            $(".d4plib-media-image-frame .media-frame-title h1").html(d4plib_media_data.strings.image_title);
            $(".d4plib-media-image-frame .media-frame-toolbar .media-toolbar-primary .media-button-insert").html(d4plib_media_data.strings.image_button);

            if (hide_menu) {
                $(".d4plib-media-image-frame").addClass("hide-menu");
            }
        }
    };

    window.wp.dev4press.media.control = {
        active_element: null,
        init: function() {
            wp.dev4press.media.image.init();

            wp.dev4press.media.control.image();
            wp.dev4press.media.control.images();
        },
        image: function() {
            $(document).on("click", ".d4plib-image-preview", function(e) {
                e.preventDefault();

                $(this).parent().find("img").slideToggle(function() {
                    if ($(this).is(":visible")) {
                        $(this).css("display", "block");
                    }
                });
            });

            $(document).on("click", ".d4plib-image-remove", function(e) {
                e.preventDefault();

                if (confirm(d4plib_media_data.strings.are_you_sure)) {
                    $(this).parent().find(".d4plib-image").val("0");
                    $(this).parent().find("img").attr("src", "").hide();
                    $(this).parent().find(".d4plib-image-name").html(d4plib_media_data.strings.image_not_selected);

                    $(this).parent().find(".d4plib-image-preview, .d4plib-image-remove").hide();
                }
            });

            $(document).on("click", ".d4plib-image-add", function(e) {
                e.preventDefault();

                wp.dev4press.media.control.active_element = $(this).parent();
                wp.dev4press.media.image.open(wp.dev4press.media.control.handlers.image, true);
            });
        },
        images: function() {
            $(document).on("click", ".d4plib-images-preview", function(e) {
                e.preventDefault();

                $(this).parent().find("img").slideToggle(function() {
                    if ($(this).is(":visible")) {
                        $(this).css("display", "block");
                    }
                });
            });

            $(document).on("click", ".d4plib-images-remove", function(e) {
                e.preventDefault();

                if (confirm(d4plib_media_data.strings.are_you_sure)) {
                    if ($(this).parent().parent().find(".d4plib-images-image").length === 1) {
                        $(this).parent().parent().find(".d4plib-images-none").show();
                    }

                    $(this).parent().remove();
                }
            });

            $(document).on("click", ".d4plib-images-add", function(e) {
                e.preventDefault();

                wp.dev4press.media.control.active_element = $(this).parent();
                wp.dev4press.media.image.open(wp.dev4press.media.control.handlers.images, true);
            });
        },
        handlers: {
            image: function(obj) {
                var $this = wp.dev4press.media.control.active_element;

                $(".d4plib-image", $this).val(obj.id);
                $(".d4plib-image-name", $this).html("(" + obj.id + ") " + obj.name);
                $("img", $this).attr("src", obj.url).hide();

                $(".d4plib-image-preview, .d4plib-image-remove", $this).show();
            },
            images: function(obj) {
                var $this = wp.dev4press.media.control.active_element,
                    name = $($this).find(".d4plib-selected-image").data("name");

                var div = $("<div class='d4plib-images-image'>");
                div.append("<input type='hidden' value='" + obj.id + "' name='" + name + "[]' />");
                div.append("<a class='button d4plib-button-action d4plib-images-remove' aria-label='" + d4plib_media_data.strings.image_remove + "'>" + d4plib_media_data.icons.remove + "</a>");
                div.append("<a class='button d4plib-button-action d4plib-images-preview' aria-label='" + d4plib_media_data.strings.image_preview + "'>" + d4plib_media_data.icons.preview + "</a>");
                div.append("<span class='d4plib-image-name'>(" + obj.id + ") " + obj.name + '</span>');
                div.append("<img src='" + obj.url + "' />");

                $(".d4plib-selected-image", $this).append(div);

                $(".d4plib-images-none", $this).hide();
            }
        }
    };

    $(document).ready(function() {
        wp.dev4press.media.control.init();
    });
})(jQuery, window, document);
