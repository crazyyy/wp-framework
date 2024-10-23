// Wait for the document to be ready
document.addEventListener("DOMContentLoaded", function(event) {

    let bodhisvgsReplacements = 0;

    // Function to replace the img tag with the SVG
    function bodhisvgsReplace(img) {

        // Ensure it's an image
        if (img.nodeName !== 'IMG') {
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
                    var sanitizedSVG = DOMPurify.sanitize(svg.outerHTML); // Sanitize SVG code via DOMPurify library
                    img.outerHTML = sanitizedSVG; // Replace img tag with sanitized SVG content
                } else {
                    // Replace image with new SVG directly
                    img.replaceWith(svg);
                }

                bodhisvgsReplacements++;

            } else if (xmlHttp.readyState === 4 && xmlHttp.status !== 200) {
                console.error('Failed to load SVG:', imgURL);
            }

        };

        // Open the XMLHttpRequest with GET method
        xmlHttp.open("GET", imgURL, false);
        xmlHttp.send(null);

    }

    // Function to iterate over nodes and replace images
    function bodhisvgsIterator(node) {

        if (node.childNodes.length > 0) {

            for (var i = 0; i < node.childNodes.length; i++) {

                if (node.childNodes[i].nodeName === 'IMG') {

                    // It's an image... replace it too
                    var img = node.childNodes[i];
                    bodhisvgsReplace(img);

                } else {

                    // Go to another level
                    bodhisvgsIterator(node.childNodes[i]);

                }
            }

        }

    }

    // Wrap in IIFE so that it can be called again later as bodhisvgsInlineSupport();
    (bodhisvgsInlineSupport = function() {

        console.log('Running bodhisvgsInlineSupport');

        // If force inline SVG option is active then add class
        if (ForceInlineSVGActive === 'true') {

            var allImages = document.getElementsByTagName('img'); // Find all images on page

            // Loop on images
            for (var i = 0; i < allImages.length; i++) {

                if (typeof allImages[i].src !== 'undefined') {

                    // Check if it has SVG
                    if (allImages[i].src.match(/\.(svg)/)) {

                        // Add our class - if not already added
                        if (!allImages[i].classList.contains(cssTarget.ForceInlineSVG)) {

                            // Add class now
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
        } // end polyfill

        // Another snippet to support IE11
        String.prototype.endsWith = function(pattern) {
            var d = this.length - pattern.length;
            return d >= 0 && this.lastIndexOf(pattern) === d;
        };
        // End snippet to support IE11

		// Check to see if user set an alternate class
		var target;
		if (ForceInlineSVGActive === 'true') {
			target = (typeof cssTarget.Bodhi === 'string' ? cssTarget.ForceInlineSVG : 'style-svg');
		} else {
			target = (typeof cssTarget === 'string' ? cssTarget : 'style-svg');
		}

		// Ensure target is a string before attempting to use replace
		if (typeof target === 'string') {
			// Remove .img from class
			target = target.replace("img.", "");
		} else {
			console.error('Target is not a string:', target);
			return;
		}

        var allImages = document.getElementsByClassName(target); // find all images with force svg class

        for (var i = 0; i < allImages.length; i++) {

            if (typeof allImages[i].src === 'undefined') { // not an image

                bodhisvgsIterator(allImages[i]); // Iterate through child nodes

            } else {

                var img = allImages[i];
                bodhisvgsReplace(img);

            }

        }

    })(); // Execute immediately

});
