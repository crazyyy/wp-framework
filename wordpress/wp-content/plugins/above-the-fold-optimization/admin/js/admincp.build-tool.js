jQuery(function() {

    if (jQuery('.abtf-bt-builder').length === 0) {
        return;
    }
    
    jQuery('.abtf-bt-builder input[name="taskname"]').on('keyup change', function() {
        var name = jQuery(this).val();
        if (name === '') {
            name = 'task-name';
        }
        if (!/^critical-/.test(name)) {
            name = 'critical-';
            jQuery(this).val(name);
        }
        if (!/^[a-z0-9\-]+$/.test(name)) {
            var r = new RegExp('[^a-z0-9\-]+','g');
            name = name.replace(r,'');
            jQuery(this).val(name);
        }
        if (name.length > 50) {
            name = name.substring(0, 50);
            jQuery(this).val(name);
            alert('Maximum name length is 50');
        }
        jQuery('.gulp-task-name').html(name);
    });
    jQuery('.abtf-bt-builder input[name="taskname"]').on('blur', function() {
        var name = jQuery(this).val();

        if (name === 'critical-') {
            name = '';
            jQuery(this).val(name);
            jQuery('.gulp-task-name').html('task-name');
            return;
        }
        var newname = name.replace(/^-+/g,'').replace(/-+$/g,'');

        if (name !== newname) {
            jQuery(this).val(newname);
            jQuery('.gulp-task-name').html(newname);
        }
    });
    jQuery('.abtf-bt-builder input[name="taskname"]').on('focus', function() {
        var name = jQuery(this).val();
        if (name === '') {
            jQuery(this).val('critical-');
        }
    });
    jQuery('.abtf-bt-builder input[name="taskname"]').on('click', function() {
         jQuery(this).blur().focus().val(jQuery(this).val());
    });
});