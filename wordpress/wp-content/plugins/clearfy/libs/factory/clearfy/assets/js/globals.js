/*!
 * Глобальный JS файл, который регистрирует глобальные переменные с общими методами для всех компонентов Clearfy
 * и самого Clearfy.
 *
 * $.wbcr_factory_clearfy_206.app - методы для работы с приложением. Скрыть, показать уведомления.
 * $.wbcr_factory_clearfy_206.hooks - это иммитация хуков и фильтров аналогично тем, что используются в Wordpress
 *
 * Copyright 2018, Webcraftic, http://webcraftic.com
 * 
 * @since 2.0.5
 * @pacakge clearfy
 */
(function($) {
	'use strict';

	if( !$.wbcr_factory_clearfy_206 ) {
		$.wbcr_factory_clearfy_206 = {};
	}

	$.wbcr_factory_clearfy_206.app = $.wbcr_factory_clearfy_206.app || {
		/**
		 * Создает и показывает уведомление внутри интерфейса Clearfy
		 *
		 * @param {string} message - сообщение об ошибке или предупреждение
		 * @param {string} type - тип уведомления (error, warning, success)
		 */
		showNotice: function(message, type) {
			var noticeContanier = $('<div></div>'),
				noticeInnerWrap = $('<p></p>'),
				dashicon = $('<span></span>'),
				dashiconClass,
				noticeId = this.makeid();

			if( !type ) {
				type = 'warning';
			}

			noticeContanier.addClass('alert', 'wbcr-factory-warning-notice')
				.addClass('alert-' + type).addClass('wbcr-factory-' + type + '-notice');

			noticeContanier.append(noticeInnerWrap);
			noticeContanier.attr('id', 'uq-' + noticeId);

			if( type == 'success' ) {
				dashiconClass = 'dashicons-plus';
			} else if( type == 'error' ) {
				dashiconClass = 'dashicons-no';
			} else {
				dashiconClass = 'dashicons-warning';
			}

			dashicon.addClass('dashicons').addClass(dashiconClass);
			noticeInnerWrap.prepend(dashicon);
			dashicon.after(message);

			$([document.documentElement, document.body]).animate({
				scrollTop: $('.wbcr-factory-content').offset().top - 100
			}, 300, function() {
				noticeContanier.hide();
				$('.wbcr-factory-content').prepend(noticeContanier);
				noticeContanier.fadeIn();

				/**
				 * Хук выполняет проивольную функцию, после того как уведомление отображено
				 * Реализация системы фильтров и хуков в файле libs/clearfy/admin/assests/js/global.js
				 * Пример регистрации хука $.wbcr_factory_clearfy_206.hooks.add('wbcr/factory_clearfy_206/updated',
				 * function(noticeId) {});
				 * @param {string} noticeId - id уведомления
				 */
				$.wbcr_factory_clearfy_206.hooks.run('wbcr/factory_clearfy_206/showed_notice', [noticeId]);
				$.wbcr_factory_clearfy_206.hooks.run('wbcr/clearfy/showed_notice', [noticeId]);
			});

			return noticeId;
		},

		/**
		 * Удаляет уведомление из интерфейса Clearfy
		 *
		 * @param {string} noticeId - id уведомления
		 */
		hideNotice: function(noticeId) {
			var el;
			if( !noticeId ) {
				el = $('.wbcr-factory-content').find('.alert');
			} else {
				el = $('#uq-' + noticeId);
			}

			el.fadeOut(500, function(e) {
				$(e).remove();

				/**
				 * Хук выполняет проивольную функцию, после того как уведомление скрыто
				 * Реализация системы фильтров и хуков в файле libs/clearfy/admin/assests/js/global.js
				 * Пример регистрации хука $.wbcr_factory_clearfy_206.hooks.add('wbcr/factory_clearfy_206/updated',
				 * function(noticeId)
				 * {});
				 * @param {string} noticeId - id уведомления
				 */
				$.wbcr_factory_clearfy_206.hooks.run('wbcr/factory_clearfy_206/hidded_notice', [noticeId]);
				$.wbcr_factory_clearfy_206.hooks.run('wbcr/clearfy/hidded_notice', [noticeId]);
			});
		},

		makeid: function() {
			var text = "";
			var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

			for( var i = 0; i < 32; i++ ) {
				text += possible.charAt(Math.floor(Math.random() * possible.length));
			}

			return text;
		}

	};

	$.wbcr_factory_clearfy_206.filters = $.wbcr_factory_clearfy_206.filters || {

		/**
		 * A set of registered filters.
		 */
		_items: {},

		/**
		 * A set of priorities of registered filters.
		 */
		_priorities: {},

		/**
		 * Applies filters to a given input value.
		 */
		run: function(filterName, args) {
			var input = args && args.length > 0 ? args[0] : null;
			if( !this._items[filterName] ) {
				return input;
			}

			for( var i in this._priorities[filterName] ) {
				if( !this._priorities[filterName].hasOwnProperty(i) ) {
					continue;
				}

				var priority = this._priorities[filterName][i];

				for( var k = 0; k < this._items[filterName][priority].length; k++ ) {
					var f = this._items[filterName][priority][k];
					input = f.apply(f, args);
				}
			}

			return input;
		},

		/**
		 * Registers a new filter.
		 */
		add: function(filterName, callback, priority) {

			if( !priority ) {
				priority = 10;
			}

			if( !this._items[filterName] ) {
				this._items[filterName] = {};
			}
			if( !this._items[filterName][priority] ) {
				this._items[filterName][priority] = [];
			}
			this._items[filterName][priority].push(callback);

			if( !this._priorities[filterName] ) {
				this._priorities[filterName] = [];
			}
			if( $.inArray(priority, this._priorities[filterName]) === -1 ) {
				this._priorities[filterName].push(priority);
			}

			this._priorities[filterName].sort(function(a, b) {
				return a - b;
			});
		}
	};

	$.wbcr_factory_clearfy_206.hooks = $.wbcr_factory_clearfy_206.hooks || {

		/**
		 * Applies filters to a given input value.
		 */
		run: function(filterName, args) {
			$.wbcr_factory_clearfy_206.filters.run(filterName, args);
		},

		/**
		 * Registers a new filter.
		 */
		add: function(filterName, callback, priority) {
			$.wbcr_factory_clearfy_206.filters.add(filterName, callback, priority);
		}
	};

})(jQuery);