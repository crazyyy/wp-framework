jQuery(function($){
    window.um_add_theme_actions = function(name, url){
        var btn = '<a href="'+ url +'" class="hide-if-no-js page-title-action">'+ name +'</a>';
        $(btn).insertBefore('#wpbody .search-form');
        $('#wpbody .search-form').addClass('hide-placeholder');
    }
});