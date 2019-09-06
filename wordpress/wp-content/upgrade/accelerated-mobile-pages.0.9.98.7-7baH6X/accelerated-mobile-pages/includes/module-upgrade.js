
jQuery(document).ready(function($){

    $('.ampforwp-activation-call-module-upgrade').click(function(e){
        if(pagenow == 'toplevel_page_amp_options' && $(this).hasClass('ampforwp-activation-call-module-upgrade')){// Check for current page
            var self = $(this);
            var nonce = self.attr('data-secure');
            self.addClass('updating-message');
            var currentId = self.attr('id');
            var activate = '';
            if(currentId=='ampforwp-pwa-activation-call'){
                activate = '&activate=pwa';
            }else if(currentId=='ampforwp-structure-data-activation-call'){
                activate = '&activate=structure_data';
            }else if(currentId=='ampforwp-adsforwp-activation-call'){
                activate = '&activate=adsforwp';
            }
            self.text( wp.updates.l10n.installing );
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: 'action=ampforwp_enable_modules_upgread'+activate+'&verify_nonce='+nonce,
                dataType: 'json',
                success: function (response){
                    if(response.status==200){
                    	//To installation
                    	wp.updates.installPlugin(
                        {
	                            slug: response.slug,
	                            success: function(pluginresponse){
	                            	//wp.updates.installPluginSuccess(pluginresponse);
	                                wpActivateModulesUpgrage(pluginresponse.activateUrl, self, response, nonce)
								}
							}
						);
                    }else{
                        alert(response.message)
                    }
                    
                }
            })//ajaxComplete(wpActivateModulesUpgrage(response.path, self, response));
            
        }
    });
   
    var wpActivateModulesUpgrage = function(url, self, response, nonce){
    	if (typeof url === 'undefined' || !url) {
            return;
        }
         self.text( 'Activating...' );
    	 jQuery.ajax(
            {
                async: true,
                type: 'GET',
                //data: dataString,
                url: url,
                success: function () {
                    self.removeClass('updating-message')
                    var msgplug = '';
                    if(self.attr('id')=='ampforwp-pwa-activation-call'){
                        msgplug = 'PWA';


						self.html('<a href="'+response.redirect_url+'" style="text-decoration: none;color: #555;">Installed! - Let\'s Go to '+msgplug+' Settings</a>')
						self.removeClass('ampforwp-activation-call-module-upgrade');
                    }else if(self.attr('id')=='ampforwp-structure-data-activation-call'){
                        msgplug = 'Structure Data';
                        self.text( 'Importing data...' );
                        //Import Data
                        jQuery.ajax({
			                url: ajaxurl,
			                type: 'post',
			                data: 'action=ampforwp_import_modules_scema&verify_nonce='+nonce,
			                success: function () {
			                	 self.html('<a href="'+response.redirect_url+'" style="text-decoration: none;color: #555;">Installed! - Let\'s Go to '+msgplug+' Settings</a>')
                    			self.removeClass('ampforwp-activation-call-module-upgrade');
			                }
			            });
                        }else if(self.attr('id')=='ampforwp-adsforwp-activation-call'){
                        msgplug = 'Ads for WP';
                        self.text( 'Importing data...' );
                        //Import Data
                        jQuery.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: 'action=ampforwp_import_modules_ads&verify_nonce='+nonce,
                            success: function () {
                                 self.html('<a href="'+response.redirect_url+'" style="text-decoration: none;color: #555;">Installed! - Let\'s Go to '+msgplug+' Settings</a>')
                                self.removeClass('ampforwp-activation-call-module-upgrade');
                            }
                        });
                    }
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status === 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status === 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.log(msg);
                },
            }
        );
    }

});//(document).ready Closed