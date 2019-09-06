(function($){

	$(function(){

		/*** Tabs ***/
		var tabs = $('.wrap-tabs .tabs .tab'),
			tabsContent = $('.wrap-tabs .content .tab-content');

		$('.wrap-tabs .tabs').on('click', '.tab', function(){

			tabs.removeClass('active');
			tabsContent.removeClass('active');

			$(this).addClass('active');
			tabsContent.eq($(this).index()).addClass('active');

			return false;
		});
		/* END Tabs */

		/*** Checkbox ***/
		$('.tab-content').on('click', '.checkbox', function(){

			var checkbox = $(this).find('input[type="checkbox"]');

			if(!$(this).hasClass('active')){

				$(this).addClass('active');
				checkbox.attr('checked', 'checked').val(1);

				return true;
			}else{

				$(this).removeClass('active');
				checkbox.removeAttr('checked').val(0);
			};

			return false;
		});
		/* END Checkbox */

		/*** Spoiler ***/
		$('.spoiler').on('click', '.name', function(){

			var data = $(this).next('.data');

			if(!$(this).hasClass('active')){

				$(this).addClass('active');
				data.slideDown();
			}else{

				$(this).removeClass('active');
				data.slideUp();
			};

			return false;
		});
		/* END Spoiler */

		/*** Fast setup ***/
		$('.fast-setup').on('click', '.recommend', function(){

			var recommend = $('.tab-content .field .name .recommend'),
				checkbox = recommend.parents('.field').find('.checkbox');
				input = checkbox.find('input[type="checkbox"]');

			checkbox.addClass('active');
			input.attr('checked', 'checked').val(1);

			$('.fast-setup-message .recommend').show();
			$('.fast-setup-message .reset').hide();

			return false;
		});

		$('.fast-setup').on('click', '.reset', function(){

			var checkbox = $('.tab-content .field .checkbox'),
				input = checkbox.find('input[type="checkbox"]');

			checkbox.removeClass('active');
			input.removeAttr('checked').val(0);

			$('.fast-setup-message .reset').show();
			$('.fast-setup-message .recommend').hide();

			return false;
		});
		/* END Fast setup */
	});
})(jQuery);