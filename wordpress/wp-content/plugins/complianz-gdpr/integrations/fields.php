<?php
defined('ABSPATH') or die("you do not have acces to this page!");

add_filter('cmplz_fields', 'cmplz_filter_integration_fields', 10, 1);
function cmplz_filter_integration_fields($fields)
{
    global $cmplz_integrations_list;
    $plugin_fields = array();
    $disabled_plugin_fields = array();
    $enabled_plugin_fields = array();
    foreach($cmplz_integrations_list as $plugin => $details){

        if (file_exists(cmplz_path."integrations/plugins/$plugin.php")){
            $plugin_fields[$plugin] =   array(
                'source' => 'integrations',
                'type' => 'checkbox',
                'default' => false,
                'revoke_consent_onchange' => false,
                'label' => $details['label'],
                'table' =>true,
                'disabled' => true,
            );

            if (isset($details['callback_condition'])){
                $plugin_fields[$plugin]['callback_condition'] = $details['callback_condition'];
            }

            if ((defined($details['constant_or_function']) || function_exists($details['constant_or_function']) || class_exists($details['constant_or_function']))){
                $plugin_fields[$plugin]['disabled'] = false;
                $plugin_fields[$plugin]['default'] = true;
                $enabled_plugin_fields[$plugin] = $plugin_fields[$plugin];
            } else {
                $disabled_plugin_fields[$plugin] = $plugin_fields[$plugin];
            }
        }
    }

    //now make sure enabled ones are first
    $fields = $fields + $enabled_plugin_fields;
    return $fields;

}