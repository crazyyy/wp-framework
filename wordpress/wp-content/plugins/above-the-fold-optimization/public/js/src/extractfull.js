/**
 * Above the fold Extract Full CSS Page Controller
 *
 * @package    abovethefold
 * @subpackage abovethefold/public
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */
var EXTRACTFULL = (function(window,document) {

    /**
     * Output human readeable file size
     */
    var humanFileSize = function(bytes, si) {
        var thresh = si ? 1000 : 1024;
        if(Math.abs(bytes) < thresh) {
            return bytes + ' B';
        }
        var units = si
            ? ['kB','MB','GB','TB','PB','EB','ZB','YB']
            : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
        var u = -1;
        do {
            bytes /= thresh;
            ++u;
        } while(Math.abs(bytes) >= thresh && u < units.length - 1);
        return bytes.toFixed(1)+' '+units[u];
    }

    /**
     * Update full CSS 
     */
    var UPDATE_FULLCSS = function() {

        var checked = jQuery('input[name=cssc]:checked');
        
        var css = '';
        jQuery.each(checked,function(i,el) {
            css += '/**\n *** @file ' + jQuery('#code'+jQuery(el).val()).attr('title') + '\n *** @size ' + humanFileSize(jQuery('#code'+jQuery(el).val()).data('size'),false) + '\n */\n ' + jQuery('#code'+jQuery(el).val()).val() + '\n\n';
        });
        jQuery('#fullcss').val(css);
        jQuery('#fullcsssize').html(humanFileSize(css.length,false));

        jQuery('.cssdownloadcount').html('('+checked.length+')');
    };

    /**
     * Show contents of inline javascript
     */
    var SHOW_INLINE = function(id) {
        var w = window.open();
        w.document.open('about:blank','cssdisplay');
        w.document.write('<!DOCTYPE html><html style="margin:0px;padding:0px;width:100%;height:100%;overflow:hidden;"><head><title>Inline: '+id+'</title></head><body scroll="no" style="overflow:none;width:100%;height:100%;margin:0px;padding:0px;border:0px;"><textarea style="border:0px;width:100%;height:100%;margin:0px;padding:1em;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box; "">' + document.getElementById(id).value + '</textarea></body></html>');
        w.document.close();
    };

    /**
     * Download full CSS
     */
    var DOWNLOAD = function() {
        var cssstr = '';
        jQuery.each(jQuery('input[name=cssc]:checked'),function(i,el) {
            if (cssstr) {
                cssstr += ',';
            }
            cssstr += jQuery(el).val();
        });
        document.location.href = jQuery('body').attr('rel') + cssstr;
    }

    // update on domready
    jQuery(function() {

        // update full css
        UPDATE_FULLCSS();

        /**
         * Update full css on file selection
         */
        jQuery('input[name=cssc]').on('change',function() {
             UPDATE_FULLCSS();
        });

        jQuery('.showinline').on('click',function(e) {
            e.preventDefault();
            SHOW_INLINE(jQuery(this).data('id'));
        })

        jQuery('.cssdownload').on('click', function(e) {
            e.preventDefault();
            DOWNLOAD();
            return false;
        })

    });

    // return public controller
    return {

        /**
         * Show contents of inline javascript
         */
        show_inline: function(id) {
            SHOW_INLINE(id);
        },

        /**
         * Download CSS
         */
        download: function() {
            DOWNLOAD();
        }
    };

})(window,document);