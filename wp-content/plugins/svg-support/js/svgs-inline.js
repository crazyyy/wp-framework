/* eslint-env jquery */
/* global svgSettings, ForceInlineSVGActive, cssTarget, frontSanitizationEnabled, DOMPurify, jQuery */

jQuery(document).ready(function ($) {

    let bodhisvgsReplacements = 0;
    let target;

    // Function to replace the img tag with the SVG
    function bodhisvgsReplace(img) {
        const hasTargetClass = img.hasClass(target);
        const parentHasTargetClass = img.parent().hasClass(target);
        const insideTargetContainer = img.closest('.' + target).length > 0;
        
        // First check if we should process at all
        if (ForceInlineSVGActive !== 'true' && !hasTargetClass && !insideTargetContainer) {
            return;
        }

        // If skip nested is enabled, only skip if:
        // 1. Image doesn't have target class AND
        // 2. Image's parent is not the target container but is inside one
        if (svgSettings.skipNested && !hasTargetClass && !parentHasTargetClass && insideTargetContainer) {
            return;
        }

        var imgID = img.attr('id');
        var imgClass = img.attr('class');
        var imgURL = img.attr('src');

        // Ensure the URL ends with .svg before proceeding
        if (!imgURL.endsWith('svg')) {
            return;
        }

        // Use jQuery's get method to fetch the SVG
        $.get(imgURL, function(data) {

            // Get the SVG tag, ignore the rest
            var $svg = $(data).find('svg');

            var svgID = $svg.attr('id');

            // Add replaced image's ID to the new SVG if necessary
            if (typeof imgID === 'undefined') {
                if (typeof svgID === 'undefined') {
                    imgID = 'svg-replaced-' + bodhisvgsReplacements;
                    $svg = $svg.attr('id', imgID);
                } else {
                    imgID = svgID;
                }
            } else {
                $svg = $svg.attr('id', imgID);
            }

            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg svg-replaced-' + bodhisvgsReplacements);
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // If sanitization is enabled, sanitize the SVG code
            if (frontSanitizationEnabled === 'on' && $svg[0]['outerHTML'] != "") {
                $svg = DOMPurify.sanitize($svg[0]['outerHTML']);
            }

            // Replace image with new SVG
            img.replaceWith($svg);

            // Increment the replacements counter
            bodhisvgsReplacements++;

            // Trigger custom event after SVG is loaded
            $(document).trigger('svg.loaded', [imgID]);

        }, 'xml').fail(function() {
            // Silently fail
        });

    }

    // Wrap in IIFE so that it can be called again later as bodhisvgsInlineSupport();
    (bodhisvgsInlineSupport = function () {

        // If force inline SVG option is active then add class
        if (ForceInlineSVGActive === 'true') {

            // Find all SVG inside img and add class if it hasn't got it
            jQuery('img').each(function () {

                // Check if the SRC attribute is present at all
                if (typeof jQuery(this).attr('src') !== typeof undefined && jQuery(this).attr('src') !== false) {

                    // Pick only those with the extension we want
                    if (jQuery(this).attr('src').match(/\.(svg)/)) {

                        // Add our class name
                        if (!jQuery(this).hasClass(cssTarget.ForceInlineSVG)) {
                            jQuery(this).addClass(cssTarget.ForceInlineSVG);
                        }
                    }
                }
            });
        }

        // Polyfill to support all older browsers
        // delete when not needed in the future
        if (!String.prototype.endsWith) {
            String.prototype.endsWith = function (searchString, position) {
                var subjectString = this.toString();
                if (typeof position !== 'number' || !isFinite(position) || Math.floor(position) !== position || position > subjectString.length) {
                    position = subjectString.length;
                }
                position -= searchString.length;
                var lastIndex = subjectString.lastIndexOf(searchString, position);
                return lastIndex !== -1 && lastIndex === position;
            };
        } // end polyfill

        // Another snippet to support IE11
        String.prototype.endsWith = function (pattern) {
            var d = this.length - pattern.length;
            return d >= 0 && this.lastIndexOf(pattern) === d;
        };
        // End snippet to support IE11

        // Set target before we use it
        if (ForceInlineSVGActive === 'true') {
            target = cssTarget.Bodhi !== 'img.' ? cssTarget.ForceInlineSVG : 'style-svg';
        } else {
            target = cssTarget.Bodhi !== 'img.' ? cssTarget.Bodhi : 'style-svg';
        }

        // Ensure target is a string before applying replace method
        if (typeof target === 'string') {
            target = target.replace("img.", "");
        } else {
            return;
        }

        // Replace images with SVGs based on the target class
        $('.' + target).each(function (index) {

            // If image then send for replacement
            if (typeof $(this).attr('src') !== typeof undefined && $(this).attr('src') !== false) {
                bodhisvgsReplace($(this));
            } else {

                // Look for SVG children and send for replacement
                $(this).find("img").each(function (i) {

                    if (typeof $(this).attr('src') !== typeof undefined && $(this).attr('src') !== false) {
                        bodhisvgsReplace($(this));
                    }

                });

            }

        });

    })(); // Execute immediately

});
