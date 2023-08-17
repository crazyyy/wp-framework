/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

;(function($, window, document, undefined) {
    window.wp = window.wp || {};
    window.wp.dev4press = window.wp.dev4press || {};

    window.wp.dev4press.customizer = {
        run: function() {
            wp.dev4press.customizer.slider();
        },
        slider: function() {
            $(".d4p-slider-ctrl").each(function() {
                var newSlider = $(this).find(".slider"),
                    sliderValue = $(this).find(".customize-control-slider-value").val(),
                    sliderMinValue = parseFloat(newSlider.attr("slider-min-value")),
                    sliderMaxValue = parseFloat(newSlider.attr("slider-max-value")),
                    sliderStepValue = parseFloat(newSlider.attr("slider-step-value"));

                newSlider.slider({
                    value: sliderValue,
                    min: sliderMinValue,
                    max: sliderMaxValue,
                    step: sliderStepValue,
                    change: function(e, ui) {
                        $(this).parent().find(".customize-control-slider-value").trigger("change");
                    }
                });
            });

            $(".slider").on("slide", function(event, ui) {
                $(this).parent().find(".customize-control-slider-value").val(ui.value);
            });

            $(".slider-reset").on("click", function() {
                var resetValue = $(this).attr("slider-reset-value");

                $(this).parent().find(".customize-control-slider-value").val(resetValue);
                $(this).parent().find(".slider").slider("value", resetValue);
            });

            $(".customize-control-slider-value").blur(function() {
                var resetValue = $(this).val(),
                    slider = $(this).parent().find(".slider"),
                    sliderMinValue = parseInt(slider.attr("slider-min-value")),
                    sliderMaxValue = parseInt(slider.attr("slider-max-value"));

                if (resetValue < sliderMinValue) {
                    resetValue = sliderMinValue;

                    $(this).val(resetValue);
                }
                if (resetValue > sliderMaxValue) {
                    resetValue = sliderMaxValue;

                    $(this).val(resetValue);
                }

                $(this).parent().find(".slider").slider("value", resetValue);
            });
        }
    };

    wp.customize.bind('ready', wp.dev4press.customizer.run);
})(jQuery, window, document);

(function($, api) {
    api.sectionConstructor['d4p-section-link'] = api.Section.extend({
        attachEvents: function() {
        },
        isContextuallyActive: function() {
            return true;
        }
    });
})(jQuery, wp.customize);