jQuery(document).ready(function ($) {
    //Export page
    //$('#bulk-action-selector-top option[value="exportsnp"]').css('color', '#999').prop('disabled', true);

    //
    $("a#winp-snippet-status-switch").on('click', function (e) {
        e.preventDefault();
        var href = $(this);
        href.addClass('winp-snippet-switch-loader');
        jQuery.post(ajaxurl, {
            action: 'change_snippet_status',
            snippet_id: href.data('snippet-id'),
            _ajax_nonce: winp_ajax.nonce,
        }).done(function (result) {
            href.removeClass('winp-snippet-switch-loader');
            if (result.error_message) {
                if (result.alert) {
                    alert(result.error_message);
                }
                console.error(result.error_message);

                href.removeClass('winp-snippet-switch-loader');
            } else {
                console.log(result.message);
                href.toggleClass('winp-inactive');
            }
        });
    });

    $("input.wbcr_inp_input_priority").on('change', function (e) {
        var previous = e.currentTarget.defaultValue;
        var input = $(this);
        input.attr('disabled', true);
        input.addClass('winp-loader');
        jQuery.post(ajaxurl, {
            action: 'change_priority',
            snippet_id: input.data('snippet-id'),
            priority: input.val(),
            _ajax_nonce: winp_ajax.nonce,
        }).done(function (result) {
            //console.log(result);
            if (result.error_message) {
                console.error(result.error_message);
                input.val(previous);
            } else {
                console.log(result.message);
            }
            input.removeAttr('disabled');
            input.removeClass('winp-loader');
        });
    });

    $("input.wbcr_inp_input_priority").on('keydown', stop_enter);
    $("input.wbcr_inp_input_priority").on('keyup', stop_enter);
    $("input.wbcr_inp_input_priority").on('keypress', stop_enter);
});

function stop_enter(e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        jQuery(this).blur();
    }
}