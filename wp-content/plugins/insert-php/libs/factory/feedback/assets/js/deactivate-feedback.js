(function($) {
	'use strict';

	var redirectLink = '';
	var plugin_slug = '';

	$(document).ready(function() {
		var modal = $('#wbcr-factory-feedback-112-deactivate-form');
		var deact_button = $('#the-list .deactivate > .wbcr-factory-feedback-112-plugin-slug').prev();
		var deact_button_close = modal.find('a.button-close');
		var selectedReasonID = false;

		deact_button.click(function(event) {
			event.preventDefault();
			redirectLink = $(this).attr('href');
			plugin_slug = $(this).next().attr('data-plugin');
			modal.addClass('active');
		});
		deact_button_close.click(function(event) {
			event.preventDefault();
			modal.removeClass('active');
		});

		// If the user has clicked outside the window, cancel it.
		modal.click(function(evt) {
			var $target = $(evt.target);

			// If the user has clicked anywhere in the modal dialog, just return.
			if( $target.hasClass('wbcr-factory-feedback-112-modal-body') || $target.hasClass('wbcr-factory-feedback-112-modal-footer') ) {
				return;
			}

			// If the user has not clicked the close button and the clicked element is inside the modal dialog, just
			// return.
			if(
				!$target.hasClass('button-close') &&
				($target.parents('.wbcr-factory-feedback-112-modal-body').length > 0 || $target.parents('.wbcr-factory-feedback-112-modal-footer').length > 0)
			) {
				return;
			}

			modal.removeClass('active');

			return false;
		});

		// Если кликнуть на одну из радиокнопок, изменится текст кнопки
		modal.on('click', 'input[type="radio"]', function(e) {
			var $selectedReasonOption = $(this);
			$selectedReasonOption.attr('checked');
			var $target = $(e.target);
			$target.attr('checked');

			// If the selection has not changed, do not proceed.
			if( selectedReasonID === $selectedReasonOption.val() ) {
				return;
			}

			selectedReasonID = $selectedReasonOption.val();

			var _parent = $(this).parents('li:first');

			modal.find('.reason-input').remove();
			modal.find('.internal-message').hide();
			modal.find('.button-deactivate').html('Send');

			if( _parent.hasClass('has-internal-message') ) {
				_parent.find('.internal-message').show();
			}

			if( _parent.hasClass('has-input') ) {
				var inputType = _parent.data('input-type'),
					inputPlaceholder = _parent.data('input-placeholder'),
					reasonInputHtml = '<div class="reason-input"><span class="message"></span>' + (('textfield' === inputType)
					                                                                               ? '<input type="text" maxlength="128" />'
					                                                                               : '<textarea rows="5" maxlength="128"></textarea>') + '</div>';

				_parent.append($(reasonInputHtml));
				_parent.find('input, textarea').attr('placeholder', inputPlaceholder).focus();
			}
		});

		//-----------------------------------------------------------

		modal.on('click', '.wbcr-factory-feedback-112-modal-footer .button', function(evt) {
			evt.preventDefault();
			if( $(this).hasClass('disabled') ) {
				return;
			}

			var _parent = $(this).parents('.wbcr-factory-feedback-112-modal:first');
			var _this = $(this);

			if( _this.hasClass('allow-deactivate') ) {
				var $radio = modal.find('input[type="radio"]:checked');

				var $selected_reason = $radio.parents('li:first'),
					$input = $selected_reason.find('textarea, input[type="text"]'),
					userReason = (0 !== $input.length) ? $input.val().trim() : '';

				if( '' === userReason ) {
					//return;
				}

				if( $radio.val() ) {
					$.ajax({
						url: ajaxurl,
						method: 'POST',
						data: {
							action: 'wbcr-factory-feedback-112-save_' + plugin_slug,
							plugin: plugin_slug,
							reason_id: $radio.val(),
							reason_more: userReason,
							anonymous: modal.find('#wbcr-factory-feedback-112-anonymous-checkbox').is(':checked')
							           ? 1
							           : 0,
							_wpnonce: modal.data('nonce')
						},
						beforeSend: function() {
							_parent.find('.wbcr-factory-feedback-112-modal-footer .button').addClass('disabled');
							_parent.find('.wbcr-factory-feedback-112-modal-footer .button-secondary').text('Processing...');
						},
						error: function() {
							window.location.href = redirectLink;
						},
						complete: function(d, status) {
							window.location.href = redirectLink;
						}
					});
				} else {
					window.location.href = redirectLink;
				}
			} else if( _this.hasClass('button-deactivate') ) {
				// Change the Deactivate button's text and show the reasons panel.
				_parent.find('.button-deactivate').addClass('allow-deactivate');
			}
		});
	});

})(jQuery);
