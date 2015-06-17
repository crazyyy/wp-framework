/**
 * Sucuri Security - SiteCheck Malware Scanner
 * Copyright (C) 2010-2015 Sucuri Security - http://sucuri.net
 * Released under the GPL - see LICENSE file for details.
 */

function sucuriscan_alert_close(id){
    var element = document.getElementById('sucuriscan-alert-'+id);
    element.parentNode.removeChild(element);
}

jQuery(document).ready(function($){
    if( $('.sucuriscan-tabs').length ){
        var hidden_class = 'sucuriscan-hidden';
        var active_class = 'sucuriscan-tab-active';
        var anchor = location.href.split('#')[1];

        $('.sucuriscan-tabs > ul a').on('click', function(e){
            e.preventDefault();

            var button = $(this);
            var container_id = button.data('tabname');
            var container = $('.sucuriscan-tab-containers > #sucuriscan-'+container_id);

            if( container.length ){
                var current_href = location.href.replace(location.hash, '');
                var new_location_href = current_href + '#' + container_id;
                window.history.pushState( {}, document.title, new_location_href );

                $('.sucuriscan-tabs > ul a').removeClass(active_class);
                $('.sucuriscan-tab-containers > div').addClass(hidden_class);
                button.addClass(active_class);
                container.removeClass(hidden_class)
            }
        });

        $('.sucuriscan-tab-containers > div').addClass(hidden_class);

        if( anchor != undefined ){
            $('.sucuriscan-tabs > ul li a').each(function(i, el){
                if( $(el).data('tabname') == anchor ){
                    $(el).trigger('click');
                }
            });
        } else {
            $('.sucuriscan-tabs > ul li:first-child a').trigger('click');
        }
    }

    $('#sucuriscan-corefiles-show').on('click', function(e){
        e.preventDefault();

        var this_button = $(this);
        var action = this_button.data('action');

        if( action == 'show' ){
            $('.sucuriscan-corefiles thead tr:last-child, .sucuriscan-corefiles tbody > tr').removeClass('sucuriscan-hidden');
            this_button.html('Hide files').data('action', 'hide');
        } else {
            $('.sucuriscan-corefiles thead tr:last-child, .sucuriscan-corefiles tbody > tr').addClass('sucuriscan-hidden');
            this_button.html('Show files').data('action', 'show');
        }
    });

    $('#sucuriscan_last_days').on('change', function(){
        $(this).closest('form').submit();
    });
});
