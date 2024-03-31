; (function ($) {
	$(document).on('ready', function () {
		window.onloadTurnstileCallback = function(){
		var notifierFormID = document.querySelectorAll('#notifier-turnstile-container');
		if (notifierFormID) {
			notifierFormID.forEach(function (notifierID) {
				turnstile.render(notifierID, {
					sitekey: window.NOTIFIER_TURNSTILE_OBJ.CF_SITE_KEY,
					callback: function (token) {
						const submitButtons = document.querySelectorAll('.submit input[type="submit"], input[name="wc_reset_password"] + button.woocommerce-Button, .woocommerce button[type="submit"], .form-submit ');
						submitButtons.forEach(button => {
							button.style.pointerEvents = 'auto';
							button.style.opacity = 1;
						});
					}
				});
			});
		};
	}
	});
})(jQuery);


var NotifierWidSize = document.querySelectorAll('.nf-turnstile-container');
if (NotifierWidSize) {
	function isViewportSmall() {
		return window.innerWidth <= 425;
	}
	function updateNotifierWidSize() {
		NotifierWidSize.forEach(function (element) {
			if (isViewportSmall()) {
				element.setAttribute('data-size', 'compact');
			} else {
				element.setAttribute('data-size', 'normal');
			}
		});
	}
	updateNotifierWidSize();
}
window.addEventListener('resize', updateNotifierWidSize);