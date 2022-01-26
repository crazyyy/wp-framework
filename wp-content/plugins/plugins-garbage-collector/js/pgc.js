/*
 * Plugins Garbage Collector
 */

var pgc_scan_active = false;
var pgc_plugins_list = null;
var pgc_current_plugin = -1;
var pgc_current_file = 0;
var pgc_total_files = 0;


jQuery(function() {
    var progressbar = jQuery('#progressbar'),
    progress_label = jQuery( '#progress_label');
    progressbar.hide();
 
    progressbar.progressbar({
      value: false,
      change: function() {
        progress_label.text( progressbar.progressbar( "value" ) + "%" );
      },
      complete: function() {
        progress_label.text( "Complete!" );
        }
    });
});


function pgc_stop_progressbar() {

  pgc_scan_active = false;
  pgc_current_plugin = -1;
  jQuery('#progressbar').progressbar({
      value: 0
  });
  jQuery('#progressbar').hide();
  var el = jQuery('#statusbar');
  el.hide();
  el.html('');

}


function pgc_update_progressbar() {
    
    if ( pgc_plugins_list.length>0 ) {
        var percents = Math.round(100 * pgc_current_plugin / pgc_plugins_list.length); 
    } else {
        var percents = 100;
    }
    jQuery('#progressbar').progressbar({
            value: percents
    });
    if ( pgc_current_plugin<pgc_plugins_list.length ) {
        var status = pgcSettings.checking_plugin + ': '+ pgc_plugins_list[pgc_current_plugin].title;
        if ( pgc_current_file>0 ) {
            status += ' ('+ pgc_current_file + '/'+ pgc_total_files + ') . . .';
        }
        jQuery('#statusbar').html( status ); 
    }

}
// end of pgc_update_progressbar()



function pgc_get_plugins_scan_results() {
    var show_hidden_tables = 0;
    if (jQuery('#show_hidden_tables').is(':checked')) {
        show_hidden_tables = 1;
    }
    
    jQuery.ajax({
        type: "POST",
        url: pgcSettings.ajax_url,
        data: {
            action: 'plugins_garbage_collector',
            subaction: 'get-plugins-scan-results',
            show_hidden_tables: show_hidden_tables,
            _ajax_nonce: pgcSettings.ajax_nonce
        },
        success: function (response) {                        
            pgc_stop_progressbar();            
            if (response=='') {
                alert('Empty answer from server');
                return;
            }
            var data = JSON.parse(response);
            if (data.result=='error') {
                alert(data.message);
                return;
            }            
            jQuery('#scanresults').html(data.html);
            jQuery('#scanresults').show();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            pgc_stop_progressbar();
            alert(textStatus + ' - ' + errorThrown);
        }
    });
    
}
// end of pgc_get_plugins_scan_results()


function pgc_process_plugins() {

    if ( pgc_current_file>=pgc_total_files-1 ) {
        pgc_current_plugin++;
        pgc_current_file = 0;
        pgc_total_files = 0;
    }
    pgc_update_progressbar();
    
    if ( pgc_current_plugin>=pgc_plugins_list.length ) {
        pgc_get_plugins_scan_results();
        return;
    }            
    
    jQuery.ajax({
        type: "POST",
        url: pgcSettings.ajax_url,
        data: {
            action: 'plugins_garbage_collector',
            subaction: 'scan-plugin-for-db-tables-use',
            plugin: pgc_plugins_list[pgc_current_plugin],
            current_file: pgc_current_file,
            _ajax_nonce: pgcSettings.ajax_nonce
        },
        success: function (response) {                        
            if (response=='') {
                alert('Empty answer from server');
                return;
            }
            var data = JSON.parse(response);
            if (data.result=='error') {
                alert(data.message);
                return;
            }
            pgc_current_file = data.current_file;
            pgc_total_files = data.total_files;
            pgc_process_plugins();            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            pgc_stop_progressbar();
            alert(textStatus + ' - ' + errorThrown);
        }
    });
    
}
// end of pgc_process_plugins()


function pgc_get_plugins_list() {
    pgc_current_plugin = -1;
    pgc_plugins_list = [];    
    var statusbar = jQuery('#statusbar');
    statusbar.html(pgcSettings.receive_plugins_list);
    statusbar.show();
    jQuery('#progressbar').progressbar({
            value: 0
    });
    jQuery('#progressbar').show();
    
    jQuery.ajax({
        type: "POST",
        url: pgcSettings.ajax_url,
        data: {
            action: 'plugins_garbage_collector',
            subaction: 'get-plugins-list',
            _ajax_nonce: pgcSettings.ajax_nonce
        },
        success: function (response) {                        
            if (response=='') {
                alert('Empty answer from server');
                return;
            }
            var data = JSON.parse(response);
            if (data.result=='error') {
                alert(data.message);
                return;
            }
            
            pgc_plugins_list = data.plugins_list;
            pgc_current_plugin = -1;
            pgc_process_plugins();            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            pgc_stop_progressbar();
            alert(textStatus + ' - ' + errorThrown);
        }
    });
}


function pgc_check_wp_tables_structure() {
    jQuery.ajax({
        type: "POST",
        url: pgcSettings.ajax_url,
        data: {
            action: 'plugins_garbage_collector',
            subaction: 'check-wp-tables-structure',
            _ajax_nonce: pgcSettings.ajax_nonce
        },
        success: function (response) {            
            pgc_stop_progressbar();
            if (response=='') {
                alert('Empty answer from server');
                return;
            }
            var data = JSON.parse(response);
            if (data.result=='error') {
                alert(data.message);
            } else {                    
                jQuery('#scanresults').html(data.html);
                jQuery('#scanresults').show();
            }            
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            pgc_stop_progressbar();
            alert(textStatus + ' - ' + errorThrown);
        }
    });    
}


function pgc_scan_button_click() {
    jQuery('#scanresults').hide();
    pgc_scan_active = true;    
        
    if (jQuery('#search_nonewp_tables').is(':checked')) {   // scan DB for non-wp tables
        pgc_get_plugins_list();
    } else if (jQuery('#search_wptables_structure_changes').is(':checked')) {
        pgc_check_wp_tables_structure();
    }            
    
}
// end of pgc_scan_button_click()


function pgc_hide_table(element, table_name) {

ajaxEl = document.getElementById('ajax_'+ table_name);
ajaxEl.style.visibility = 'visible';
if (document.getElementById('hidden_'+ table_name).checked) {
  action = 'hide-table';
} else {
  action = 'show-table';  
}
jQuery.ajax({
   type: "POST",   
   url: pgcSettings.ajax_url,
   data: {
       action: 'plugins_garbage_collector',
       subaction: action,
       table_name: table_name,
       _ajax_nonce: pgcSettings.ajax_nonce
   },
   success: function(response) {
     ajaxEl.style.visibility = 'hidden';
     if (response=='') {
         alert('Error: Empty answer is received from server');
         return;
     }
     var data = JSON.parse(response);
     if (data.result=='success') {
         if (action=='hide-table') {
             jQuery(element).parent().parent().remove();
             jQuery('#pgc_plugin_tables tbody tr:odd').removeClass('pgc_even');
             jQuery('#pgc_plugin_tables tbody tr:odd').addClass('pgc_odd');
             jQuery('#pgc_plugin_tables tbody tr:even').removeClass('pgc_odd');
             jQuery('#pgc_plugin_tables tbody tr:even').addClass('pgc_even');
         } else if (action=='showtable') {
          // place holder
         }
     } else {
          alert('Error: '+ data.message);
     }     
   },
   error: function(jqXHR, textStatus, errorThrown) {
     pgc_stop_progressbar();
     alert(textStatus +' - '+ errorThrown);     
   }
 });

}
// end of pgc_hide_table()


function pgc_actions(action) {
    if (action == 'scan') {
        if (document.getElementById('search_nonewp_tables').checked) {
            searchNoneWpTables = 1;
        } else {
            searchNoneWpTables = 0;
        }
        if (document.getElementById('search_wptables_structure_changes').checked) {
            searchWpTablesStructureChanges = 1;
        } else {
            searchWpTablesStructureChanges = 0;
        }
        if (searchNoneWpTables + searchWpTablesStructureChanges == 0) {
            alert(pgcSettings.turn_on_cb_before_scan);
            return false;
        }

        actionTxt = pgcSettings.scanning;
    } else {
        actionTxt = action;
    }
    if (!confirm(actionTxt + ' ' + pgcSettings.take_some_time)) {
        return false;
    }
    if (action == 'scan') {
        pgc_scan_button_click();
    } else {
        document.location = pgcSettings.redirect_url + action;
    }

}
// end of pgc_actions()


function pgc_onsubmit() {
    var checkBoxes = new Array();
    checkBoxes = document.getElementsByTagName('input');
    var checkedFound = false;
    for (var i = 0; i < checkBoxes.length; i++) {
        if (checkBoxes[i].type == 'checkbox' && checkBoxes[i].checked) {
            checkedFound = true;
            break;
        }
    }
    if (!checkedFound) {
        alert(pgcSettings.select_table_before_delete);
        return false;
    }
    if (!confirm(pgcSettings.confirm_before_table_delete)) {
        return false;
    }
    
    return true;
}
// end of pgc_onsubmit()
