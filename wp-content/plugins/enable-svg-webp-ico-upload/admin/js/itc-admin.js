(function($) {
    'use strict';
    $(document).ready(function() {
        $(document).on('click', '.itc_svg_upload_dismissed .notice-dismiss', function() {
            var data = {
                action: 'itc_svg_upload_dismissed',
            };

            $.ajax({
                url: ITC_SVG_Upload_Admin.ajaxurl,
                type: "POST",
                dataType: 'html',
                data: data,
                success: function() {

                }
            });
        });

        $(document).on('click', '.itc_svg_upload_dismissed_alert .notice-dismiss', function() {
            var data = {
                action: 'itc_svg_upload_dismissed_alert',
            };

            $.ajax({
                url: ITC_SVG_Upload_Admin.ajaxurl,
                type: "POST",
                dataType: 'html',
                data: data,
                success: function() {

                }
            });
        });

    });
})(jQuery);