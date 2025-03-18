/* eslint-env browser */
/* global svgSettings, ForceInlineSVGActive, cssTarget, frontSanitizationEnabled, DOMPurify */

document.addEventListener("DOMContentLoaded", function(event) {

    let bodhisvgsReplacements = 0;
    let target;

    // Function to replace the img tag with the SVG
    function bodhisvgsReplace(img) {
        // Ensure it's an image
        if (img.nodeName !== 'IMG') {
            return;
        }

        const hasTargetClass = img.classList.contains(target);
        const parentHasTargetClass = img.parentElement.classList.contains(target);
        const insideTargetContainer = img.closest('.' + target) !== null;
        
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

        var imgID = img.id;
        var imgClass = img.className;
        var imgURL = img.src;

        // Ensure the URL ends with .svg before proceeding
        if (!imgURL.endsWith('svg')) {
            return;
        }

        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                var data = xmlHttp.responseText;

                // Parse the returned data to extract the SVG
                let parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');

                // Get the SVG tag from the parsed data
                var svg = doc.getElementsByTagName('svg')[0];

                var svgID = svg.id;

                // Add replaced image's ID to the new SVG if necessary
                if (typeof imgID === 'undefined' || imgID === '') {
                    if (typeof svgID === 'undefined' || svgID === '') {
                        imgID = 'svg-replaced-' + bodhisvgsReplacements;
                        svg.setAttribute('id', imgID);
                    } else {
                        imgID = svgID;
                    }
                } else {
                    svg.setAttribute('id', imgID);
                }

                // Add replaced image's classes to the new SVG
                if (typeof imgClass !== 'undefined' && imgClass !== '') {
                    svg.setAttribute('class', imgClass + ' replaced-svg svg-replaced-' + bodhisvgsReplacements);
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                svg.removeAttribute('xmlns:a');

                // If sanitization is enabled, sanitize the SVG code
                if (frontSanitizationEnabled === 'on' && svg.outerHTML !== "") {
                    var sanitizedSVG = DOMPurify.sanitize(svg.outerHTML);
                    img.outerHTML = sanitizedSVG;
                } else {
                    img.replaceWith(svg);
                }

                bodhisvgsReplacements++;

            } else if (xmlHttp.readyState === 4 && xmlHttp.status !== 200) {
                // Silently fail
            }
        };

        xmlHttp.open("GET", imgURL, true);
        xmlHttp.send(null);
    }

    // Function to iterate over nodes and replace images
    function bodhisvgsIterator(node) {
        if (node.childNodes.length > 0) {
            for (var i = 0; i < node.childNodes.length; i++) {
                if (node.childNodes[i].nodeName === 'IMG') {
                    var img = node.childNodes[i];
                    bodhisvgsReplace(img);
                } else {
                    bodhisvgsIterator(node.childNodes[i]);
                }
            }
        }
    }

    // Wrap in IIFE so that it can be called again later as bodhisvgsInlineSupport();
    (bodhisvgsInlineSupport = function() {
        // If force inline SVG option is active then add class
        if (ForceInlineSVGActive === 'true') {
            var allImages = document.getElementsByTagName('img');
            for (var i = 0; i < allImages.length; i++) {
                if (typeof allImages[i].src !== 'undefined') {
                    if (allImages[i].src.match(/\.(svg)/)) {
                        if (!allImages[i].classList.contains(cssTarget.ForceInlineSVG)) {
                            allImages[i].classList.add(cssTarget.ForceInlineSVG);
                        }
                    }
                }
            }
        }

        // Polyfill to support all older browsers
        if (!String.prototype.endsWith) {
            String.prototype.endsWith = function(searchString, position) {
                var subjectString = this.toString();
                if (typeof position !== 'number' || !isFinite(position) || Math.floor(position) !== position || position > subjectString.length) {
                    position = subjectString.length;
                }
                position -= searchString.length;
                var lastIndex = subjectString.lastIndexOf(searchString, position);
                return lastIndex !== -1 && lastIndex === position;
            };
        }

        // Another snippet to support IE11
        String.prototype.endsWith = function(pattern) {
            var d = this.length - pattern.length;
            return d >= 0 && this.lastIndexOf(pattern) === d;
        };

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
        document.querySelectorAll('.' + target).forEach(function(element) {
            if (element.nodeName === 'IMG') {
                bodhisvgsReplace(element);
            } else {
                bodhisvgsIterator(element);
            }
        });

    })(); // Execute immediately
});

