jQuery(document).ready(function ($) {

    let bodhisvgsReplacements = 0;

    // Function to replace the img tag with the SVG
    function bodhisvgsReplace(img) {

        var imgID = img.attr('id');
        var imgClass = img.attr('class');
        var imgURL = img.attr('src');

        // Set svg size to the original img size
        // var imgWidth = $img.attr('width');
        // var imgHeight = $img.attr('height');

        // Ensure the URL ends with .svg before proceeding
        if (!imgURL.endsWith('svg')) {
            console.log('Not an SVG:', imgURL);
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
                console.log('Sanitizing SVG:', imgURL);
                $svg = DOMPurify.sanitize($svg[0]['outerHTML']);
            }

            // Replace image with new SVG
            img.replaceWith($svg);

            // Trigger custom event after SVG is loaded
            $(document).trigger('svg.loaded', [imgID]);

            // Increment the replacements counter
            bodhisvgsReplacements++;

        }, 'xml').fail(function() {
            console.error('Failed to load SVG:', imgURL);
        });

    }

    // Wrap in IIFE so that it can be called again later as bodhisvgsInlineSupport();
    (bodhisvgsInlineSupport = function () {

        console.log('Running bodhisvgsInlineSupport');

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

        // Check to see if user set alternate class
        var target;
        if (ForceInlineSVGActive === 'true') {
            target = cssTarget.Bodhi !== 'img.' ? cssTarget.Bodhi : 'img.style-svg';
        } else {
            target = cssTarget !== 'img.' ? cssTarget.Bodhi : 'img.style-svg';
        }

        console.log('Initial target:', target);

        // Ensure target is a string before applying replace method
        if (typeof target === 'string') {
            target = target.replace("img", "");
            console.log('Modified target:', target);
        } else {
            console.error('Target is not a string:', target);
            return;
        }

        // Replace images with SVGs based on the target class
        $(target).each(function (index) {

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
