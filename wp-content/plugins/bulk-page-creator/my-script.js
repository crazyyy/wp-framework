var pageid = 0;

jQuery(document).ready(function(){
    if(jQuery('#page_id').size()==0){
        jQuery('#page_ids').append('<select id="page_id" name="page_id"><option value="">(No Parent)</option></select>');
    }
    
    jQuery('#pcontent').change(function(){
        if(jQuery(this).val()==1){
            jQuery('#sc-pages-content-div').hide();
        }else{
            jQuery('#sc-pages-content-div').show();
        }
    });
    
    jQuery('#sc-page-name, #page_ids').keypress(function(event){
        if(event.which==13){
            if(jQuery('#sc-page-name').val()!=''){
                sc_add_page();
            }
        }
    });
    
    //get the draft pages
    var valDrafts = jQuery('#pagesDraft').val();
    if(valDrafts && valDrafts!=''){
        if(valDrafts.match(',')){
            //its an array
            var arrDrafts = valDrafts.split(",");
            for(idraft=0;idraft<arrDrafts.length;idraft++){
                if(jQuery('ul.sc-pages li.page-item-' + arrDrafts[idraft]).children('ul').size()>0){
                   jQuery('ul.sc-pages li.page-item-' + arrDrafts[idraft]).children('ul').before(' - <b style="font-size:12px;color:red;">draft</b>'); 
                }else{
                    jQuery('ul.sc-pages li.page-item-' + arrDrafts[idraft]).append(' - <b style="font-size:12px;color:red;">draft</b>');   
                }
            }
        }else{
            if(jQuery('ul.sc-pages li.page-item-' + valDrafts).children('ul').size()>0){
                jQuery('ul.sc-pages li.page-item-' + valDrafts).children('ul').before(' - <b style="font-size:12px;color:red;">draft</b>'); 
            }else{
                jQuery('ul.sc-pages li.page-item-' + valDrafts).append(' - <b style="font-size:12px;color:red;">draft</b>');   
            }
        }
    }

    jQuery('form#sc-add-pages').on('submit', function(e){
        return jQuery('#sc-page-name').val().length>0 ? sc_add_page() : true;
    });
});

function sc_add_page(){
    //sc-page-name
    //page_id
    var chkfrm = '';
    if(jQuery('#sc-page-name').val()=='') chkfrm += 'Please enter a page name\n';
    
    if(chkfrm==''){
        if(jQuery('#multiPages').attr('checked')){
            if(jQuery('#sc-page-name').val().match(/,/)){
                //add multiple pages
                var pageNames = jQuery('#sc-page-name').val().split(",");
                for(ipnames=0;ipnames<pageNames.length;ipnames++){
                    jQuery('#sc-page-name').val(pageNames[ipnames]);
                    sc_add_page();
                }
                //exit the process
                return false;
            }
        }
        var parent = jQuery('#page_id').val();
        var template = jQuery('#page_template').val();
        var template_text = jQuery('#page_template option[value="'+ template +'"]').text();
        if(!template) template = '';
        if(!template_text) template_text = '';
        
        if(parent==''){
            parent = -1;
            jQuery('ul.sc-pages').append('<li class="page-item-new' + pageid + '">' + jQuery('#sc-page-name').val() + (template!='' ? ' (' + template_text + ')' : '') + ' <a href="JavaScript:sc_del_page(' + pageid + ');">Remove</a></li>');
            jQuery('#page_id').append('<option value="new' + pageid + '">' + jQuery('#sc-page-name').val() + '</option>');
        }else{
            var parentname = jQuery('#page_id option[value=' + parent + ']').html();
            var parentspace = '&nbsp;&nbsp;&nbsp;';
            if(parentname.match(/&nbsp;/g)){
                var nums = parentname.match(/&nbsp;/g).length;
                for(inums=0;inums<nums;inums++){
                    parentspace += '&nbsp;';
                }
            }
            jQuery('li.page-item-' + parent).append('<li class="page-item-new' + pageid + '">' + jQuery('#sc-page-name').val() + (template!='' ? ' (' + template_text + ')' : '') + ' <a href="JavaScript:sc_del_page(' + pageid + ');">Remove</a></li>');
            jQuery('#page_id option[value=' + parent + ']').after('<option class="p_' + parent + '" value="new' + pageid + '">' + parentspace + jQuery('#sc-page-name').val() + '</option>');
        }
        jQuery('#sc-pages').val(jQuery('#sc-pages').val() + pageid + '|' + parent + '|' + jQuery('#sc-page-name').val() + '|' + template + '\n');
                
        //reset the form
        pageid++;
        jQuery('#sc-page-name').val('');
        jQuery('#page_id').attr('selectedIndex', 0);
    }else{
        alert(chkfrm);
    }
}

function sc_del_page(pageid){
    jQuery('li.page-item-new' + pageid).remove();
    jQuery('#page_id option[value=new' + pageid + ']').remove();
    jQuery('#page_id option.p_new' + pageid).remove();
    
    var maintext = jQuery('#sc-pages').val();
    //remove the page
    maintext = maintext.replace(new RegExp(pageid + '\\|[^\\n]*\\n', "i"), "");
    //remove the children
    maintext = maintext.replace(new RegExp('\\d*\\|new' + pageid + '\\|[^\\n]*\\n', "i"), "");
    jQuery('#sc-pages').val(maintext);
}