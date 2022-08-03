(function($){
    $(function(){       
        if($('#enable_reroute').is(':checked')){
            $('.settings-tables').show();
        }

        $('.form-table').on('change', '#enable_reroute', function(){
            if($(this).is(':checked')){
                $('.settings-tables').slideDown();
            }
            else{
                $('.settings-tables').slideUp();
            }
        });
        
        if($('#enable_db_log').is(':checked')){
            $('.log-email-options').show();
        }

        $('.form-table').on('change', '#enable_db_log', function(){
            if($(this).is(':checked')){
                $('.log-email-options').slideDown();
            }
            else{
                $('.log-email-options').slideUp();
            }
        });
        
        $('#view-original').on('click', function(e){
            e.preventDefault();
            
            if($(this).hasClass('orgview')){
                $('#processed-message').hide();
                $('#original-message').show();
                $(this).html('Hide Original Message');
                $(this).removeClass('orgview');
            }
            else{
                $('#processed-message').show();
                $('#original-message').hide();
                $(this).html('View Original Message');
                $(this).addClass('orgview');
            }
        });
    });
})(jQuery);