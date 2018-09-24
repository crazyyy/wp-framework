jQuery(function() {

    /**
     * Add conditional critical CSS
     */
    if (jQuery('#addcriticalcss-form').length > 0) {

        /**
         * Show form
         */
        jQuery('#addcriticalcss').on('click', function() {

            if (!jQuery('#addcriticalcss-form').is(':visible')) {

                var select = jQuery('#addcc_conditions');

                if (!select.data('conditions-loaded')) {

                    select.data('conditions-loaded',1);

                    window.loadConditionSelect(jQuery('#addcc_conditions'));
                }
            }

            jQuery('#addcriticalcss-form').toggle();

        });

        /**
         * Save new conditional CSS
         */
        
        jQuery('#addcc_save').on('click', function() {

            var name = jQuery.trim(jQuery('#addcc_name').val());
            var conditions = jQuery('#addcc_conditions').val();

            if (name === '') {
                alert('Enter a name (admin reference)...');
                jQuery('#addcc_name').focus();
                return;
            }

            if (!/^[a-zA-Z0-9\-\_ ]+$/.test(name)) {
                alert('The name contains invalid characters.');
                jQuery('#addcc_name').focus();
                return;
            }

            // create add form
            var form = jQuery('<form />');
            form.attr('method','post');
            form.attr('action',jQuery('#abtf_settings_form').data('addccss'));

            var input = jQuery('<input type="hidden" name="name" />');
            input.val(name);
            form.append(input);

            var input = jQuery('<input type="hidden" name="conditions" />');
            input.val(conditions);
            form.append(input);

            var input = jQuery('<input type="hidden" name="_wpnonce" />');
            input.val(jQuery('#_wpnonce').val());
            form.append(input);


            jQuery('body').append(form);

            jQuery(form).submit();

        });

    }

    
});