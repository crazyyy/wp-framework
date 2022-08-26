/**
 * Used for the Snippet Library
 */
jQuery(document).ready(function($) {
    try {
        var clipboard = new Clipboard('.orb_ctc_copy_btn');

        // Change the button's label temporarily.
        clipboard.on('success', function(e) {
            // by default the copied text/container is highlighted and looks weird.
            e.clearSelection();
            var btn = $(e.trigger);
            var old_label = btn.text();

            btn.text('Copied!');

            setTimeout(function () {
                btn.text(old_label);
            }, 1500);
        });

        clipboard.on('error', function(e) {
            alert('copy failed');
        });
    } catch (e) {
        console && console.log("orbisius child theme creator addon: Clipboard.js wasn't loaded or there was a conflict");
    }
}); // (jQuery)