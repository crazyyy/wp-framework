/*Admin options pannal data value*/
function weblizar_wsio_option_data_save(name) 
	{ 	//tinyMCE.triggerSave();
		var weblizar_settings_save= "#weblizar_wsio_settings_save_"+name;
		var weblizar_theme_options = "#weblizar_wsio_"+name;
		var weblizar_settings_save_success = ".success-msg";
		var weblizar_loding = ".msg-overlay";		
		jQuery(weblizar_loding).show();	
		jQuery(weblizar_settings_save).val("1");        
	    jQuery.ajax({
				url:'?page=wsio-weblizar',
				type:'post',
				data : jQuery(weblizar_theme_options).serialize(),
				 success : function(data)
				 { 
				 	jQuery(weblizar_loding+' #loading-image').hide();
				 	jQuery(weblizar_settings_save_success).fadeIn();
					jQuery(weblizar_settings_save_success).fadeOut(1000);
					jQuery(weblizar_loding).fadeOut(2000);					
					window.location = '?page=wsio-weblizar';
				 }			
		});
	}
	
/*Admin options value reset */
	function weblizar_wsio_option_data_reset(name) 
	{  
		var r=confirm("Do you want reset your theme setting!")
		if (r==true)
		{		var weblizar_settings_save= "#weblizar_wsio_settings_save_"+name;
				var weblizar_theme_options = "#weblizar_wsio_"+name;
				var weblizar_loding = ".msg-overlay";
				var weblizar_settings_save_reset = ".reset-msg";
				jQuery(weblizar_loding).show();
				jQuery(weblizar_settings_save).val("2");
				jQuery.ajax({
				   url:'?page=wsio-weblizar',
				   type:'post',
				   data : jQuery(weblizar_theme_options).serialize(),
				   success : function(data){
					jQuery(weblizar_loding+' #loading-image').hide();
					jQuery(weblizar_settings_save_reset).fadeIn();
					jQuery(weblizar_settings_save_reset).fadeOut(1000);
					jQuery(weblizar_loding).fadeOut(2000);
					window.location = '?page=wsio-weblizar';
				}			
			});
		} else  {
		alert("Cancel! reset theme setting process");  }		
	}

// js to active the link of option pannel
jQuery(document).ready(function(){	 
	/********media-upload******/
	// media upload js
	var uploadID = ''; /*setup the var*/
	var get_version ='';
	jQuery('.upload_image_button').click(function() {
		uploadID = jQuery(this).prev('input'); /*grab the specific input*/
		get_version =jQuery('#get_version').val();
		
		formfield = jQuery('.upload').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		
		window.send_to_editor = function(html)
		{	
		if (get_version => '4.5'){
			imgurl = jQuery(html).attr('src');
		}else{
			imgurl = jQuery('img',html).attr('src');
			}	
			uploadID.val(imgurl); /*assign the value to the input*/
			tb_remove();
		};		
		return false;
	});
	
	
	/* Script For cookie */	
	
	if(getCookie('wsio_currentab')!=""){
		jQuery('ul.options_tabs li a#'+getCookie('wsio_currentab')).parent().addClass('currunt active');
		jQuery('ul.options_tabs li a#'+getCookie('wsio_currentab')).addClass('active');
		jQuery('ul.options_tabs li:first-child').removeClass('active');
	}

	// menu click	
	jQuery('ul.options_tabs > li > a').click(function(){		
		if (jQuery(this).attr('class') != 'active')
		{ 		
			jQuery('ul.options_tabs li a').removeClass('active');
			jQuery(this).addClass('active');
			jQuery('.ui-tabs-panel').removeClass('currunt');
		  
			jQuery('ul.options_tabs li').removeClass('active');
			jQuery(this).parent().addClass('active');		
			var divid =  jQuery(this).attr("id");
			document.cookie="wsio_currentabChild=;expires="+Date(jQuery.now());
			document.cookie="wsio_currentab="+divid;
			var add="div#"+divid;
			var strlenght = add.length;
			
			if(strlenght<17)
			{	
				var add="div#option-ui-id-"+divid;
				var ulid ="#ui-id-"+divid;
				jQuery('ul.options_tabs li').removeClass('currunt');
				jQuery(ulid).parent().addClass('currunt');	
			}			
			jQuery('div.ui-tabs-panel').addClass('deactive');
			jQuery('div.ui-tabs-panel').removeClass('active');
			jQuery(add).removeClass('deactive');		
			jQuery(add).addClass('active');		
		}
	});
	
	
	if(getCookie('wsio_currentab')!=""){
			var divid = getCookie('wsio_currentab');
			var add="div#"+divid;
			var strlenght = add.length;
			
			if(strlenght<17)
			{	
				var add="div#option-ui-id-"+divid;
				var ulid ="#ui-id-"+divid;
				jQuery('ul.options_tabs li li ').removeClass('currunt');
				jQuery(ulid).parent().addClass('currunt');	
			}			
			jQuery('div.ui-tabs-panel').addClass('deactive');
			jQuery('div.ui-tabs-panel').removeClass('active');
			jQuery(add).removeClass('deactive');		
			jQuery(add).addClass('active');	
		}
		
	/* Function to get cookie */
	
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		}
		return "";
	}
	
	/* Tooltip js */
	jQuery('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
	var bg= jQuery('#predefine_bg_image').val();
		jQuery('.bg-image-selection img').click(function() {
			var imgLink= jQuery(this).attr('src');
			jQuery('.bg-image-selection img').removeClass('wsio_active');
			jQuery(this).addClass('wsio_active');
			jQuery('#predefine_bg_image').val(imgLink);
		});	
	jQuery('select[multiple]').multiselect({		
		placeholder: 'Select options'
	});	
	 
	/* compresstion level range js */
	var rangeval='';
	jQuery('.hc_range').on('change', function(){
		var p= jQuery(this).val(); 
		rangeval = jQuery(this).nextAll('input');
		rangeval.val(p);
	});
}); 