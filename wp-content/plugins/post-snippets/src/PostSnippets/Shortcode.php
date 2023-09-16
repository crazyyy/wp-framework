<?php
namespace PostSnippets;

/**
 * Shortcode Handling.
 *
 */
class Shortcode
{
    public function __construct()
    {
        $this->create();
    }

    /**
     * Create the functions for shortcodes dynamically and register them
     */
    public function create()
    {
        global $wpdb;
        
        $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;

        $snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE snippet_shortcode = %d AND snippet_status = 1 AND snippet_content != ''", 1), ARRAY_A );

        foreach ($snippets as $snippet) {
            add_shortcode( $snippet['snippet_title'], 
            function ( $atts, $content = null ) use ( $snippet ){
                return $this->evaluateSnippet($snippet, $atts, $content);
            });
        }    
    }

    public static function evaluateSnippet($snippet, $atts = array(), $content = null){

        if( !empty($snippet) ){

            $default_atts = self::filterVars( $snippet['snippet_vars'] );

            $texturize = $snippet["snippet_wptexturize"]?? false;

            $short_atts = shortcode_atts( $default_atts, $atts );

            $snippet_content =  $snippet['snippet_content'];

            if ( $content != null ) {
                $short_atts["content"] = $content;
            }
            foreach ($short_atts as $key => $val) {
                $snippet_content = str_replace( "{" . $key . "}", $val, $snippet_content );
            }

            // There might be the case that a snippet contains
            // the post snippets reserved variable {content} to
            // capture the content in enclosed shortcodes, but
            // the shortcode is used without enclosing it. To
            // avoid outputting {content} as part of the string
            // lets remove possible occurences.
            $snippet_content = str_replace( "{content}", "", $snippet_content );

            // Handle PHP shortcodes
            if ( $snippet['snippet_php'] == 1 ) {
                $snippet_content = self::phpEval( $snippet_content );
                
                // WPTexturize the Snippet
                if ( !empty($snippet['snippet_wptexturize']) && ( $snippet['snippet_wptexturize'] == true ) ) {
                    
                    $snippet_content = html_entity_decode( addslashes ( wptexturize ( htmlentities( stripslashes ( $snippet_content ), ENT_NOQUOTES ) ) ) );

                }

            }
            else{

                if ( !empty($snippet['snippet_wptexturize']) && ( $snippet['snippet_wptexturize'] == true ) ) {

                    $snippet_content = html_entity_decode ( addslashes ( wptexturize ( htmlentities( stripslashes ( $snippet_content ), ENT_NOQUOTES ) ) ) );
                }
                else{

                    $snippet_content =  $snippet_content ;
                }
            }            
            
            $snippet_content = do_shortcode( stripslashes( $snippet_content ) );
            
            return  $snippet_content;
        }
    }

    /**
     * Evaluate a snippet as PHP code.
     *
     * @since   Post Snippets 1.9
     * @param   string  $content    The snippet to evaluate
     * @return  string              The result of the evaluation
     */
    public static function phpEval($content)
    {
        if (defined('POST_SNIPPETS_DISABLE_PHP')) {
            return $content;
        }

        $content = stripslashes($content);

        /**Removing Initial PHP Tag */
        $content = ltrim($content, "<?php<?PHP<?=");
        
        ob_start();
        eval($content);
        $content = ob_get_clean();

        return addslashes($content);
    }

    /**
     * Filters Snippet Variables
     * of Undesired Text.
     *
     * @since   Post Snippets 3.1.4
     * @param   string  $vars       The snippet variable string
     * @return  array               The result of the evaluation
     */
    public static function filterVars($vars = '')
    {
        if( !empty($vars) ){

            $vars = explode(",", $vars );

            $default_atts = array();
            
            foreach ($vars as $var) {

                $attribute = explode('=', $var);        /**This Results in array seperated by = sign */

                foreach ($attribute as $key => $value) {    //Filtering Empty Values generated with such variable texts one,two=,,,=xx=one,,==two
                    if( empty($value) ) unset($attribute[$key]);
                }

                if( empty($attribute) ) continue;   /**After Unsetting Empty values above, any empty array still remains, so this line is skipping that */

                $attribute = array_values($attribute);      //resetting index to start with zero

                $default_value = (count($attribute) > 1) ? $attribute[1] : '';      /**Default values of vars, if set any */
                
                $default_atts[$attribute[0]] = $default_value;      /**Setting Default Atts for shortcode_atts  */
                
            }

            return $default_atts;
        }
        else{
            return array();
        }
    }
}
