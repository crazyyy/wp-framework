function expand_group(rule, group_name, group_members) 
{
    (jQuery)('#rule_' + rule + '_domain_' + group_name).change(function(){
        if ((jQuery)(this).attr('checked'))
        {
            for(var i = 0; i < group_members.length; i++) {
                (jQuery)('#rule_' + rule + '_domain_' + group_members[i]).attr('checked', true);
                (jQuery)('#rule_' + rule + '_domain_' + group_members[i]).attr('disabled', true);
                if (group_members[i] == 'date')
                {
                    var subgroups = ['year', 'month', 'day', 'time'];
                    for(var j = 0; j < subgroups.length; j++) {
                        (jQuery)('#rule_' + rule + '_domain_' + subgroups[j]).attr('checked', true);
                        (jQuery)('#rule_' + rule + '_domain_' + subgroups[j]).attr('disabled', true);
                    }
                }
            }
        }
        else
        {
            for(var i = 0; i < group_members.length; i++) {
                (jQuery)('#rule_' + rule + '_domain_' + group_members[i]).attr('disabled', false);
                (jQuery)('#rule_' + rule + '_domain_' + group_members[i]).attr('checked', false);
                if (group_members[i] == 'date')
                {
                    var subgroups = ['year', 'month', 'day', 'time'];
                    for(var j = 0; j < subgroups.length; j++) {
                        (jQuery)('#rule_' + rule + '_domain_' + subgroups[j]).attr('checked', false);
                        (jQuery)('#rule_' + rule + '_domain_' + subgroups[j]).attr('disabled', false);
                    }
                }
            }
        }
    });
}

function expand_cbox(rule)
{
    var prefix = 'default';
    if (rule != 0)
    {
        prefix = 'rule_' + rule;
    }
    if ((jQuery)('#' + prefix + '_attach_internal_images').val() == 'img')
        (jQuery)('#' + prefix + '_colorbox_internal_images_div').show();
    else
        (jQuery)('#' + prefix + '_colorbox_internal_images_div').hide();
    (jQuery)('#' + prefix + '_attach_internal_images').change(function(){
        if ((jQuery)(this).val() == 'img') 
            (jQuery)('#' + prefix + '_colorbox_internal_images_div').show();
        else
            (jQuery)('#' + prefix + '_colorbox_internal_images_div').hide();
    });
    
    if ((jQuery)('#' + prefix + '_attach_external_images').val() == 'img') 
        (jQuery)('#' + prefix + '_colorbox_external_images_div').show();
    else
        (jQuery)('#' + prefix + '_colorbox_external_images_div').hide();
    (jQuery)('#' + prefix + '_attach_external_images').change(function(){
        if ((jQuery)(this).val() == 'img') 
           (jQuery)('#' + prefix + '_colorbox_external_images_div').show();
        else
           (jQuery)('#' + prefix + '_colorbox_external_images_div').hide();
    });
}

function load_js(rule, start) 
{       
    if ((jQuery)('#rule_' + rule + '_attach_internal_images').val() == 'img') 
        (jQuery)('#rule_' + rule + '_colorbox_internal_images_div').show();
    else
        (jQuery)('#rule_' + rule + '_colorbox_internal_images_div').hide();
    (jQuery)('#rule_' + rule + '_attach_internal_images').change(function(){
        if ((jQuery)(this).val() == 'img') 
            (jQuery)('#rule_' + rule + '_colorbox_internal_images_div').show();
        else
            (jQuery)('#rule_' + rule + '_colorbox_internal_images_div').hide();
    });

    if ((jQuery)('#rule_' + rule + '_attach_external_images').val() == 'img') 
        (jQuery)('#rule_' + rule + '_colorbox_external_images_div').show();
    else
        (jQuery)('#rule_' + rule + '_colorbox_external_images_div').hide();
    (jQuery)('#rule_' + rule + '_attach_external_images').change(function(){
        if ((jQuery)(this).val() == 'img') 
            (jQuery)('#rule_' + rule + '_colorbox_external_images_div').show();
        else
            (jQuery)('#rule_' + rule + '_colorbox_external_images_div').hide();
    });
    
    expand_cbox(rule);
    expand_group(rule, 'main', ['home', 'front']);
    expand_group(rule, 'archive', ['category', 'tag', 'taxonomy', 'author', 'date']);
    expand_group(rule, 'singular', ['post', 'page', 'attachment']);
    expand_group(rule, 'date', ['year', 'month', 'day', 'time']);
    
    if (!start)
    {
        (jQuery)('#rule_' + rule + '_domain_main').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_home').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_home').attr('disabled', true);
        (jQuery)('#rule_' + rule + '_domain_front').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_front').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_archive').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_category').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_category').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_tag').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_tag').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_taxonomy').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_taxonomy').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_author').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_author').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_date').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_date').attr('disabled', true);
        (jQuery)('#rule_' + rule + '_domain_year').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_year').attr('disabled', true);
        (jQuery)('#rule_' + rule + '_domain_month').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_month').attr('disabled', true);
        (jQuery)('#rule_' + rule + '_domain_day').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_day').attr('disabled', true);
        (jQuery)('#rule_' + rule + '_domain_time').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_time').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_singular').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_post').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_post').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_page').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_page').attr('disabled', true);
        
        (jQuery)('#rule_' + rule + '_domain_attachment').attr('checked', true);
        (jQuery)('#rule_' + rule + '_domain_attachment').attr('disabled', true);
    }
    
    (jQuery)("input[name='rule_" + rule + "_enable']").change(function(){
        if ((jQuery)("input[name='rule_" + rule + "_enable']:checked").val() == 'enabled')
        {
            var base = (jQuery)(this).attr('id');
            base = base.substring(0, base.length - 6);
            (jQuery)('#' + base + 'rules_div').show();
        }
        else
        {
            var base = (jQuery)(this).attr('id');
            base = base.substring(0, base.length - 6);
            (jQuery)('#' + base + 'rules_div').hide();
        }
    });
}
