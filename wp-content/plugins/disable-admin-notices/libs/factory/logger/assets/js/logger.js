function wbcr_factory_logger_140_LogCleanup(element) {
    var btn = jQuery(element),
        currentBtnText = btn.html();

    console.log(btn.data('working'), btn);

    btn.text(btn.data('working'));

    jQuery.ajax({
        url: ajaxurl,
        method: 'post',
        data: {
            action: 'wbcr_factory_logger_140_'+wbcr_factory_logger_140.plugin_prefix+'logs_cleanup',
            nonce: wbcr_factory_logger_140.clean_logs_nonce
        },
        success: function (data) {
            btn.html(currentBtnText);

            jQuery('#wbcr-log-viewer').html('');
            jQuery('#wbcr-log-size').text('0B');
            jQuery.wbcr_factory_templates_127.app.showNotice(data.message, data.type);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            jQuery.wbcr_factory_templates_127.app.showNotice('Error: ' + errorThrown + ', status: ' + textStatus, 'danger');
            btn.html(currentBtnText);
        }
    });
}

jQuery(document).ready(function ($) {
    var wbcr_logger_hided = false;
    $('.wbcr_logger_level').on('click', function (e) {
        var level = $(this).text();

        if (wbcr_logger_hided) {
            $('.wbcr-log-row').show()
            wbcr_logger_hided = false;
        } else {
            $('.wbcr-log-row').hide()
            $('.wbcr-log-row.wbcr_logger_level_' + level).show();
            wbcr_logger_hided = true;
        }
    });
});