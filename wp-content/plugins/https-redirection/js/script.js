(function ($) {
    $(document).ready(function () {
	/* add notice about changing in the settings page */
	$(document).on('click', '.rewrite_add_item', function () {
	    $(this).each(function () {
		if ($(this).prev().val() != '') {
		    $(this).next().hide();
		    $(this).parents('.rewrite_new_item').removeClass('rewrite_new_item').clone().addClass('rewrite_new_item').appendTo($(this).parents("td")).find('input').val('');
		    $(this).addClass('rewrite_delete_item').removeClass('rewrite_add_item');
		} else {
		    $(this).next().show();
		}
	    });
	});
	$(document).on('click', '.rewrite_delete_item', function () {
	    $(this).each(function () {
		$(this).parent().remove();
	    });
	});
    });
})(jQuery);