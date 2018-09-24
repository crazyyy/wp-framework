/**
 * Request animation frame
 */
if (!window.requestAnimationFrame) {
    window.requestAnimationFrame = (function() {
        return window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            function( /* function FrameRequestCallback */ callback, /* DOMElement Element */ element) {
                window.setTimeout(callback, 1000 / 60);
            };
    })();
}

if (!window.requestIdleCallback) {
    window.requestIdleCallback = function(fn) {
        setTimeout(fn);
    };
}

jQuery(function($) {

    /**
     * Page selection menu
     */
    if (jQuery('select.wp-pageselect').length > 0 && typeof jQuery('select.wp-pageselect').selectize !== 'undefined') {
        var page_select_menu = jQuery('select.wp-pageselect').selectize({
            placeholder: "Search a post/page/category ID or name...",
            optgroupField: 'class',
            labelField: 'name',
            searchField: ['name'],
            optgroups: window.abtf_pagesearch_optgroups,
            onType: function(str) {
                if (/^http(s)?:\/\/[^\/]+\//.test(str)) {
                    var selectize = page_select_menu[0].selectize;
                    selectize.setTextboxValue(str.replace(/^http(s)?:\/\/[^\/]+\//, '/'));
                }
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'abtf_page_search',
                        query: query,
                        maxresults: 10
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res);
                    }
                });
            }
        });
    }

    /**
     * Extract CSS menu
     */
    if (jQuery('#fullcsspages').length > 0 && typeof jQuery('#fullcsspages').selectize !== 'undefined') {

        // download button
        jQuery('#fullcsspages_dl').on('click', function() {

            var href = jQuery('#fullcsspages').val();

            if (href === '') {
                alert('Select a page...');
                return;
            }

            if (/\?/.test(href)) {
                href += '&';
            } else {
                href += '?';
            }
            document.location.href = href + 'extract-css=' + jQuery('#fullcsspages_dl').attr('rel') + '&output=download';
        });

        // print button
        jQuery('#fullcsspages_print').on('click', function() {

            var href = jQuery('#fullcsspages').val();

            if (href === '') {
                alert('Select a page...');
                return;
            }

            if (/\?/.test(href)) {
                href += '&';
            } else {
                href += '?';
            }
            window.open(href + 'extract-css=' + jQuery('#fullcsspages_print').attr('rel') + '&output=print');
        });

    }

    /**
     * Compare Critical CSS menu
     */
    if (jQuery('#criticalcss-test-pages').length > 0 && typeof jQuery('#criticalcss-test-pages').selectize !== 'undefined') {

        // download button
        jQuery('#splitview').on('click', function() {

            var href = jQuery('#criticalcss-test-pages').val();

            if (href === '') {
                alert('Select a page...');
                return;
            }

            if (/\?/.test(href)) {
                href += '&';
            } else {
                href += '?';
            }
            window.open(href + 'critical-css-editor=1');
        });

        // download button
        jQuery('#editorview').on('click', function() {

            var href = jQuery('#criticalcss-test-pages').val();

            if (href === '') {
                alert('Select a page...');
                return;
            }

            if (/\?/.test(href)) {
                href += '&';
            } else {
                href += '?';
            }
            window.open(href + 'critical-css-editor=1#editor');
        });

        // print button
        jQuery('#fullview').on('click', function() {

            var href = jQuery('#criticalcss-test-pages').val();

            if (href === '') {
                alert('Select a page...');
                return;
            }

            if (/\?/.test(href)) {
                href += '&';
            } else {
                href += '?';
            }
            window.open(href + 'critical-css-view=1');
        });

    }


    // text selection
    $('.clickselect').on('click', function() {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText($(this)[0]);
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode($(this)[0]);
            window.getSelection().addRange(range);
        }
    });

    /**
     * Search/replace example
     */

    // example links
    $('[data-example]').each(function(index, el) {
        $(el).on('click', function(e) {
            var example = $('#' + $(this).data('example'));
            if (example.length > 0) {

                var original_text = example.data('example-text');
                var original_html = example.html();

                var example_html = $(this).data('example-html');
                if (typeof example_html !== 'string') {
                    example_html = JSON.stringify(example_html);
                }

                example.html(example_html);
                example.data('example-text', $(this).html());

                $(this).html(original_text);
                $(this).data('example-html', original_html);
            }
        });
    });

    /**
     * Github star button
     */
    if (jQuery('.github-button').length > 0) {

        window.requestIdleCallback(function() {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://buttons.github.io/buttons.js';
            document.getElementsByTagName('head')[0].appendChild(s);
        });

    }

    // instant app link
    $('.wp-submenu a[href]').each(function(i, el) {
        if ($(el).attr('href') === 'admin.php?page=pagespeed-instant') {
            $(el).attr('href', 'https://test.fastestwebsite.co/');
            $(el).attr('target', '_blank');
        }
    });
});