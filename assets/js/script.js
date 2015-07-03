(function($) {
	$(function() {

		$(".catalog-item-image a").colorbox({
			maxWidth: '90%',
			maxHeight: '90%',
			href: $(this).attr('href'),
			current: "{current} / {total}"
		});

		Dialog = new BX.CDialog({
		   title: "Оформление заявки",
		   head: '',
		   content: '<form method="POST" style="overflow:hidden;" id="orderForm" class="orderForm">\
							<div><span>Вид техники</span> <select class="select" name="CATEGORY"></select></div>\
							<div><span>Техника</span> <select class="select" name="ELEMENT"></select></div>\
							<div><span>Форма оплаты</span> <select class="select" name="PAYTYPE">\
								<option>Выберите форму оплаты</option>\
								<option value="Наличная">Наличная</option>\
								<option value="Безналичная">Безналичная</option>\
							</select></div>\
							<div><span>Название компании</span> <input class="input" type="text" name="COMPANY_NAME" placeholder="Название компании"></div>\
							<div><span>Контактное лицо</span> <input class="input" type="text" name="CONTACT" placeholder="Контактное лицо"></div>\
							<div><span>Телефон *</span> <input class="input" type="text" name="PHONE" placeholder="Телефон"></div>\
							<div><span>Email</span> <input class="input" type="text" name="EMAIL" placeholder="Email"></div>\
							<div><span>Примечание</span><textarea class="textarea" name="TEXT" placeholder="Примечание"></textarea></div>\
						</div>\
			  </form>',
		   resizable: true,
		   draggable: true,
		   height: '410',
		   width: '550'
		});

		BX.addClass(Dialog.DIV, 'order-dialog');

		Dialog.SetButtons([
			{
				'title': 'Отправить', 
				'id': 'action_send', 
				'name': 'action_send', 
				'action': function(){ 
					var form_data=$("#orderForm").serialize();
					
					$.ajax({
						type: "POST",
						url: "/orderback.php",
						data: form_data,
						dataType: 'json',
						success: function(result){
							$("#orderForm *").removeClass("error");
							if (result['error']) {
								$("#orderForm [name="+result['error']+"]").addClass("error");
								switch (result['error']) {
								case 'CATEGORY':
									alert('Выберите вид техники')
									break
								case 'ELEMENT':
									alert('Выберите технику')
									break
								case 'PAYTYPE':
									alert('Выберите форму оплаты')
									break
								case 'CONTACT':
									alert('Введите контактное лицо')
									break
								case 'PHONE':
									alert('Введите номер телефона')
									break
								case 'EMAIL':
									alert('Введите Email')
									break
								default:
									alert('Неизвестная ошибка')
								}
							}
							else
							{
								Dialog.Close();
								$("#result_submitted_form").text(result);
								Thanx.Show();
							}
						}
					});
				} 
			}
		]);

		Thanx = new BX.CDialog({
		   title: "Спасибо",
		   head: '',
		   content: '<form method="POST" style="overflow:hidden;" class="orderForm">\
						<div class="bottom">\
							<div id="result_submitted_form" class="header"></div>\
						</div>\
			  </form>',
		   resizable: true,
		   draggable: true,
		   height: '100',
		   width: '650',
		   buttons: [BX.CDialog.prototype.btnClose]
		});

		BX.addClass(Thanx.DIV, 'order-dialog');

		function fillCategories(selectedCategory) {
			var val = "<option>Выберите вид техники</option>";
			for (var i in aCatalogItems)
				if (aCatalogItems.hasOwnProperty(i))
					val += "<option value=\""+i+"\">"+i+"</option>";
			$("#orderForm [name='CATEGORY']").html(val).val(selectedCategory);
			fillElements(selectedCategory);
		}

		function fillElements(selectedCategory) {
			var val = "<option>Выберите технику</option>";
			if (aCatalogItems[selectedCategory])
				for (var i in aCatalogItems[selectedCategory])
					if (aCatalogItems[selectedCategory].hasOwnProperty(i))
						val += "<option value=\""+aCatalogItems[selectedCategory][i]+"\">"+aCatalogItems[selectedCategory][i]+"</option>";
			$("#orderForm [name='ELEMENT']").html(val);
		}

		$(document).on('change', "#orderForm [name='CATEGORY']", function(){
			fillElements(this.value);
		});

		$("#masthead-wrapper a.btn").click(function(){
			fillCategories();
			Dialog.Show();
			return false;
		});
		$(".btn-order").click(function(){
			fillCategories($(this).attr('data-cat'));
			Dialog.Show();
			$("#orderForm [name='ELEMENT']").val($(this).attr('data-elem'));
			return false;
		});

	});
})(jQuery);
