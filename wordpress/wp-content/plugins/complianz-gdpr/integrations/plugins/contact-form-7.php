<?php
defined('ABSPATH') or die("you do not have acces to this page!");

/**
 * Customize the error message on submission of the form before consent
 * @param $message
 * @param $status
 * @return string
 */
function cmplz_contactform7_errormessage( $message, $status  ) {
    if ($status==='spam'){
        $accept_text = apply_filters('cmplz_accept_cookies_contactform7',__('Click to accept marketing cookies and enable this form','complianz-gdpr'));
        $message = '<div class="cmplz-blocked-content-notice cmplz-accept-cookies"><a href="#">'.$accept_text.'</a></div>';
    }
    return $message;
}
add_filter( 'wpcf7_display_message', 'cmplz_contactform7_errormessage', 20, 2 );

/**
 * Add the CF7 form type
 * @param $formtypes
 * @return mixed
 */
function cmplz_contactform7_form_types($formtypes){
    $formtypes['cf7_'] = 'contact-form-7';
    return $formtypes;
}
add_filter('cmplz_form_types', 'cmplz_contactform7_form_types');


/**
 * Conditionally add the dependency from the CF 7 inline script to the .js file
 */

add_filter('cmplz_dependencies', 'cmplz_contactform7_dependencies');
function cmplz_contactform7_dependencies($tags){
    $service = WPCF7_RECAPTCHA::get_instance();

    if ( $service->is_active() ) {
        $tags['recaptcha/api.js']='grecaptcha';
    }

    return $tags;
}


/**
 * Get list of CF7 contact forms
 * @param $input_forms
 * @return mixed
 */

function cmplz_contactform7_get_plugin_forms($input_forms)
{
    $forms = get_posts(array('post_type' => 'wpcf7_contact_form'));
    $forms = wp_list_pluck($forms, "post_title", "ID");
    foreach ($forms as $id => $title) {
        $input_forms['cf7_' . $id] = $title . " " . __('(Contact form 7)', 'complianz-gdpr');
    }
    return $input_forms;
}
add_filter('cmplz_get_forms', 'cmplz_contactform7_get_plugin_forms');

/**
 * Add consent checkbox to CF 7
 * @param $form_id
 */
function cmplz_contactform7_add_consent_checkbox($form_id)
{
    $form_id = str_replace('cf7_', '', $form_id);

    $warning = 'acceptance_as_validation: on';
    $label = sprintf(__('To submit this form, you need to accept our %sprivacy statement%s', 'complianz-gdpr'), '<a href="' . COMPLIANZ()->document->get_permalink('privacy-statement',true) . '">', '</a>');

    $tag = "\n" . '[acceptance cmplz-acceptance]' . $label . '[/acceptance]' . "\n\n";

    $contact_form = wpcf7_contact_form($form_id);

    if (!$contact_form) return;

    $properties = $contact_form->get_properties();
    $title = $contact_form->title();
    $locale = $contact_form->locale();

    //check if it's already there
    if (strpos($properties['form'], '[acceptance') === false) {
        $properties['form'] = str_replace('[submit', $tag . '[submit', $properties['form']);
    }

    if (strpos($properties['additional_settings'], $warning) === false) {
        $properties['additional_settings'] .= "\n" . $warning;
    }

    //replace [submit
    $args = array(
        'id' => $form_id,
        'title' => $title,
        'locale' => $locale,
        'form' => $properties['form'],
        'mail' => $properties['mail'],
        'mail_2' => $properties['mail_2'],
        'messages' => $properties['messages'],
        'additional_settings' => $properties['additional_settings'],
    );
    wpcf7_save_contact_form($args);
}
add_action("cmplz_add_consent_box_contact-form-7", 'cmplz_contactform7_add_consent_checkbox');


/**
 * Add services to the list of detected items, so it will get set as default, and will be added to the notice about it
 * @param $services
 * @return array
 */
function cmplz_contactform7_detected_services($services){
    $recaptcha = WPCF7_RECAPTCHA::get_instance();

    if ( $recaptcha->is_active() && !in_array('google-recaptcha', $services)) {
        $services[] = 'google-recaptcha';
    }

    return $services;
}
add_filter('cmplz_detected_services','cmplz_contactform7_detected_services' );
