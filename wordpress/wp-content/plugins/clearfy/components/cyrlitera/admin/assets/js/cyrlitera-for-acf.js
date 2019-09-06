jQuery(function($){
    // transliterate field-name
    acf.addFilter('generate_field_object_name', function(val){
        return replace_field(val);
    });

    $(document).on('keyup change', '.acf-field .field-name', function(){
        if ( $(this).is(':focus') ){
            return false;
        }else{
            var val = $(this).val();
            val = replace_field( val );

            if ( val !== $(this).val() ) {
                $(this).val(val);
            }
        }

    });
    function replace_field( val ){
        console.log(val);
        val = $.trim(val);
        if(window.cyr_and_lat_dict === undefined){
            console.error('Cyrlitera for ACF: lang dictionary not loaded!')
            return val;
        }
        var table = window.cyr_and_lat_dict;

        $.each( table, function(k, v){
            var regex = new RegExp( k, 'g' );
            val = val.replace( regex, v );
        });

        val = val.replace( /[^\w\d-_]/g, '' );
        val = val.replace( /_+/g, '_' );
        val = val.replace( /^_?(.*)$/g, '$1' );
        val = val.replace( /^(.*)_$/g, '$1' );

        return val;
    }
});
