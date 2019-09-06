/**
 * Этот файл содержит скрипт исполняелся во время процедур с формой лицензирования.
 * Его основная роль отправка ajax запросов на проверку, активацию, деактивацию лицензии
 * и вывод уведомлений об ошибка или успешно выполнении проверок.
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 05.10.2018, Webcraftic
 * @version 1.1
 * @since 1.4.0
 */


jQuery(function($) {

	var allNotices = [];

	$(document).on('click', '.wcl-control-btn', function() {

		// Скрываем все открытые этим событием уведомления
		// Глобальные уведомления не трогаем

		for( i = 0; i < allNotices.length; i++ ) {
			$.wbcr_factory_clearfy_206.app.hideNotice(allNotices[i]);
		}

		$('.wcl-control-btn').hide();

		var wrapper = $('#wcl-license-wrapper'),
			loader = wrapper.data('loader');

		$(this).after('<img class="wcl-loader" src="' + loader + '">');

		var data = {
			action: 'wbcr-clearfy-check-license',
			_wpnonce: $('#_wpnonce').val(),
			license_action: $(this).data('action'),
			licensekey: ''
		};

		if( $(this).data('action') == 'activate' ) {
			data.licensekey = $('#license-key').val();
		}

		$.ajax(ajaxurl, {
			type: 'post',
			dataType: 'json',
			data: data,
			success: function(response) {
				var noticeId;

				if( !response || !response.success ) {

					$('.wcl-control-btn').show();
					$('.wcl-loader').remove();

					if( response.data ) {
						console.log(response.data.error_message);
						noticeId = $.wbcr_factory_clearfy_206.app.showNotice('Error: [' + response.data.error_message + ']', 'danger');
						allNotices.push(noticeId);
					} else {
						console.log(response);
					}

					return;
				}

				if( response.data && response.data.message ) {
					noticeId = $.wbcr_factory_clearfy_206.app.showNotice(response.data.message, 'success');
					allNotices.push(noticeId);

					// todo: доработать генерацию формы, вместо перезагрузки страницы
					window.location.reload();
				}

			},
			error: function(xhr, ajaxOptions, thrownError) {

				$('.wcl-control-btn').show();
				$('.wcl-loader').remove();

				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);

				var noticeId = $.wbcr_factory_clearfy_206.app.showNotice('Error: [' + thrownError + '] Status: [' + xhr.status + '] Error massage: [' + xhr.responseText + ']', 'danger');

				allNotices.push(noticeId);
			}
		});

		return false;
	});

});
