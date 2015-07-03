//jQuery.noConflict();
(function($) {
    $(function() {
        $(".backcall").fancybox();
        $(".order_services").fancybox();

        //$( ".img-capcha").on( "click", function() { update_capcha(); });

        get_token();

        $('.backformer form').on('submit', function(e) {
            e.preventDefault(); 
 
            $(this).ajaxSubmit(
                jQuery.proxy(
                    function(data){ 
                        if(data['status'] > 0) {
                            $(this).parent().parent().find('.bf-status').show()
                            .html(data['value']).css('background', 'green'); 

                            $(this).parent().hide();
                            $(this).resetForm();

                            setTimeout(
                                jQuery.proxy(
                                    function(){
                                        $('.fancybox-close').click(); 
                                        
                                    } , this
                                ), 2000
                            );

                            setTimeout(
                                jQuery.proxy(
                                    function(){ 
                                        $(this).parent().show();
                                        $(this).parent().parent().find('.bf-status').hide();
                                        
                                    } , this
                                ), 3000
                            );

                            //update_capcha();
                            get_token(); 
                        } else {
                            $(this).parent().parent().find('.bf-status').show()
                            .html(data['value']).css('background', 'red');
                        }
                }, this)
            );
        });
    });
})(jQuery); 
/*
function update_capcha() {
    $.post("/backformer/model/kcaptcha/index.php");
    $('.img-capcha').attr('src','/backformer/model/kcaptcha/index.php?'+Math.random())
}
*/
function get_token() {
    $.post(
        "/backformer/index.php",
        {
            type: 1 
        },
        function(data) {
           $('.bf-token').val(data['token'])
        }
    );
}