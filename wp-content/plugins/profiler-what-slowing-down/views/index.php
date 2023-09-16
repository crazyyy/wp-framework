<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="wrap wpsd-wrap wpsd">
    <h1 class="wp-heading-inline"><?php echo __('Which Plugin Slowing Down?', 'profiler-what-slowing-down'); ?></h1>
    <br /><br />
    <div class="wpsd-body">
        <div class="postbox" style="display: block;">
            <div class="postbox-header">
                <h3><?php echo __('How plugin works?', 'profiler-what-slowing-down'); ?></h3>
            </div>
            <div class="inside">
                <div class="wpsd_multilingual-about">
                    <div class="wpsd_multilingual-about-info">
                        <div class="top-content">
                            <p class="plugin-description">
                                <?php echo __('Plugin allow you to run most important test for performance, request time, number of database queries, memory usage', 'profiler-what-slowing-down'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo __('You will be able to detect plugin which cause troubles and result with longer waiting time for request results', 'profiler-what-slowing-down'); ?>
                            </p>
                            <p class="plugin-description wpsd-alert">
                                <?php echo __('Testings are executed based on your homepage', 'profiler-what-slowing-down'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="postbox" style="display: block;">
            <div class="postbox-header">
                <h3><?php echo __('How to use it?', 'profiler-what-slowing-down'); ?></h3>
            </div>
            <div class="inside">
                <div class="wpsd_multilingual-about">
                    <div class="wpsd_multilingual-about-info">
                        <div class="top-content">
                            <p class="plugin-description">
                                <?php echo __('Click on "Run Quick Tests" button', 'profiler-what-slowing-down'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo __('or if you need manually:', 'profiler-what-slowing-down'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo __('Click on run test on "All Activated" plugins (first link) and then near wanted plugin, run few tests and compare results', 'profiler-what-slowing-down'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo __('If you get significantly lower results, means that this plugin causing slowness', 'profiler-what-slowing-down'); ?>
                            </p>
                            <p class="plugin-description wpsd-alert">
                                <?php echo __('Hint: ', 'profiler-what-slowing-down').'<strong class="red">'.__('Lower numbers are better, means that page load faster without this specific plugin', 'profiler-what-slowing-down').'</strong>'; ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo __('Results depends also on server resources, so you may try to run it few times', 'profiler-what-slowing-down'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wpsd_colors-container">
            <ul class="hidden">
                <li id="max_time"></li>
                <li id="max_db"></li>
                <li id="max_mem"></li>
            </ul>

            <div class="run_button"><a href="#" id="run_quick_tests"><img src="<?php echo WHICH_PLUGIN_SLOWING_DOWN_VERSION_URL; ?>admin/img/run_test.png" /></a></div>

            <div class="quick_test_report_wrap">
            <div id="quick_test_report">
            </div>
            </div>

            <table class="wp-list-table widefat fixed striped table-view-list pages">
<?php

global $wpdb;

$all_active_plugins = get_option('active_plugins');

if ( function_exists( 'get_plugins' ) ) {
    $existing_plugins = get_plugins();
}

//backup active plugins list
if(count($all_active_plugins) > 1)update_option('wpsd_backup_active_plugins', $all_active_plugins);

echo '<div class="lds-ellipsis hidden"></div>';

echo '<div class="postbox no-bottom"><div class="postbox-header no-bottom"><h3>'.__('Currently active plugins: ', 'profiler-what-slowing-down').'<strong>'.count($all_active_plugins).'</strong></h3></div></div>';

echo '<tr>';
echo '<th>'.__('Plugin Name', 'profiler-what-slowing-down').'</th>';
echo '<th>'.__('Run Test', 'profiler-what-slowing-down').'</th>';
echo '<th>'.__('Request Results', 'profiler-what-slowing-down').'</th>';
echo '</tr>';

echo '<tr id="plugin_all">';
echo '<td><span class="plugin_name hidden">ALL</span><span class="nice_name">'.__('All Activated', 'profiler-what-slowing-down').'</span></td>';
echo '<td><a class="wpsd_run_test" href="#">'.__('Run test with all active plugins', 'profiler-what-slowing-down').'</a></td>';
echo '<td><span class="timing hidden"></span><span class="color hidden"></span><span class="result" id="results_all"></span></td>';
echo '</tr>';

echo '<tr id="plugin_no">';
echo '<td><span class="plugin_name hidden">NONE</span><span class="nice_name">'.__('All Deactivated', 'profiler-what-slowing-down').'</span></td>';
echo '<td><a class="wpsd_run_test" href="#">'.__('Run test without any plugin', 'profiler-what-slowing-down').'</a></td>';
echo '<td><span class="timing hidden"></span><span class="color hidden"></span><span class="result" id="results_no"></span></td>';
echo '</tr>';

sort($all_active_plugins);

foreach($all_active_plugins as $key=>$plugin)
{
    if(strpos($plugin, 'profiler-what-slowing-down') !== FALSE)
        continue;

    $plugin_name = $plugin;

    if(isset($existing_plugins[$plugin_name]))
        $plugin_name = $existing_plugins[$plugin_name]["Name"];

    echo '<tr id="plugin_'.esc_attr($key).'">';
    echo '<td><span class="plugin_name hidden">'.esc_html($plugin).'</span><span class="nice_name">'.esc_html($plugin_name).'</span></td>';
    echo '<td><a class="wpsd_run_test" href="#">'.__('Run test without this plugin', 'profiler-what-slowing-down').'</a></td>';
    echo '<td><span class="timing hidden"></span><span class="color hidden"></span><span class="result" id="results_'.esc_attr($key).'"></span></td>';
    echo '</tr>';
}

?>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">

jQuery(document).ready(function($)
{
    var wpsd_allow_run = true;

    $('#run_quick_tests').on( "click", function() 
    {
        if(wpsd_allow_run == false)return false;

        var run_button_element = $(this);

        run_button_element.hide();

        $('.lds-ellipsis').removeClass('hidden');

        $('.wpsd table span.result').html('');
        $('#quick_test_report').html('');
        $('#quick_test_report').css('display', 'none');

        wpsd_allow_run = false;
        var elements_all_plugins = $("table.wp-list-table a.wpsd_run_test");
        var current_element = -1;

        var myInterval = setInterval(function() 
        {
            if(current_element == elements_all_plugins.length-1)
            {
                //console.log('run_quick_tests END');
                $('.lds-ellipsis').addClass('hidden');
                wpsd_allow_run = true;
                run_button_element.show();
                generate_report();
                clearInterval(myInterval);
                return false;
            }
            current_element++;
            run_test_specific(elements_all_plugins.eq(current_element));
        }, 1500);

        return false;
    });

    $('a.wpsd_run_test').on( "click", function() 
    {
        if(wpsd_allow_run == false)return false;

        wpsd_allow_run = false;

        console.log($(this));
        plugin_element = $(this);

        plugin_element.parent().parent().find('span.result').first().html('');
        $('.lds-ellipsis').removeClass('hidden');

        setTimeout(function() {
            run_test_specific(plugin_element);
            $('.lds-ellipsis').addClass('hidden');
            wpsd_allow_run = true;
        }, 100);

        return false;
    });

    function run_test_specific(plugin_element)
    {
        wpsd_allow_run = false;

        var plugin_file = plugin_element.parent().parent().find('span.plugin_name').text();
        var resultSpan = plugin_element.parent().parent().find('span.result').first();
        var resultColor = plugin_element.parent().parent().find('span.color').first();
        var queries_number = '';

        // 1. Disable only selected plugin
        jQuery.ajax({
            url: '<?php echo home_url();?>?wpsd=1&plugin='+plugin_file+'&time=<?php echo time(); ?>', // time at end is added because of possible caching
            type: "GET",
            success: function (result) {
            },
            async: false
        }).done(function () {
        });

        // 2. Run test

        var ajaxTime= new Date().getTime();

        jQuery.ajax({
            url: '<?php echo home_url();?>?wpsd=3&time=<?php echo time(); ?>', // time at end is added because of possible caching
            type: "GET",
            success: function (result) {
                var findStringQuery = "[QUERIES_NUMBER]";
                var startStringQuery = result.indexOf("[QUERIES_NUMBER]")+findStringQuery.length;
                var endStringQuery   = result.indexOf("[/QUERIES_NUMBER]");
                var queriesNumber = 0;

                if (startStringQuery >= 0)
                {
                    queriesNumber = result.substr(startStringQuery, endStringQuery-startStringQuery);
                    queries_number+= ', DB queries: ' + queriesNumber;
                }

                var findStringPMemory = "[PEAK_MEMORY_USAGE]";
                var startStringPMemory = result.indexOf("[PEAK_MEMORY_USAGE]")+findStringPMemory.length;
                var endStringPMemory   = result.indexOf("[/PEAK_MEMORY_USAGE]");
                var pMemory = 0;

                if (startStringPMemory >= 0)
                {
                    pMemory = result.substr(startStringPMemory, endStringPMemory-startStringPMemory);
                    queries_number+= ', Peak Memory: ' + pMemory+' MB';
                }

                if(plugin_file == 'ALL')
                {
                    $('#max_db').html(queriesNumber);
                    $('#max_mem').html(pMemory);
                }
            },
            async: false
        }).done(function () {
            var totalTime = new Date().getTime()-ajaxTime;

            if(plugin_file == 'ALL')$('#max_time').html(totalTime);

            var max_time = $('#max_time').html();

            resultSpan.parent().find('span.timing').html(totalTime);
            resultSpan.html('Request time: '+totalTime+'ms'+queries_number);

            if(plugin_file == 'ALL' || plugin_file == 'NONE')
            {
                resultSpan.removeClass('orange');
                resultSpan.removeClass('red');
                resultSpan.removeClass('green');

                if(totalTime < 1000){resultSpan.addClass('green');resultColor.html('green')}
                else if(totalTime < 2000){resultSpan.addClass('orange');resultColor.html('orange')}
                else {resultSpan.addClass('red');resultColor.html('red')}
            }
            else
            {
                resultSpan.removeClass('orange');
                resultSpan.removeClass('red');
                resultSpan.removeClass('green');

                if(totalTime > max_time*0.9){resultSpan.addClass('green');resultColor.html('green')}
                else if(totalTime > max_time*0.8){resultSpan.addClass('orange');resultColor.html('orange')}
                else {resultSpan.addClass('red');resultColor.html('red')}
            }
        });

        // 3. re-enable all backed-up plugins list

        jQuery.ajax({
            url: '<?php echo home_url();?>?wpsd=2&plugin='+plugin_file+'&time=<?php echo time(); ?>', // time at end is added because of possible caching
            type: "GET",
            success: function (result) {
            },
            async: false
        }).done(function () {
        });
    }

    function generate_report()
    {
        var reportText = '';

        reportText+= '<h3>Report from testing website <?php echo home_url(); ?></h3>';
        reportText+= 'You will get best results by disabling plugins, ordered from top:<br /><br />';

        var results = [];

        $("table.wp-list-table a.wpsd_run_test").each(function(){

            plugin_element = $(this);

            var niceName = plugin_element.parent().parent().find('span.nice_name').text();
            var resultSpan = plugin_element.parent().parent().find('span.result').first().html();
            var resultTiming = plugin_element.parent().parent().find('span.timing').first().html();
            var resultColor = plugin_element.parent().parent().find('span.color').first().html();

            results.push({timing: resultTiming, name: niceName, results: resultSpan, color: resultColor});
        });


        results.sort(function (x, y) {
            return x.timing - y.timing;
        });

        $('#quick_test_report').html(reportText+makeTableHTML(results));
        $('#quick_test_report').css('display', 'inline-block');
    }

    function makeTableHTML(myArray) {
        var result = "<table border=1>";

        jQuery.each( myArray, function(){
            result += "<tr>";

            myObject = $(this)[0];

            for (var p in myObject) {
                if(p != 'color')
                result += "<td class='"+(myObject['color']=='green'?'':myObject['color'])+"'>"+myObject[p]+"</td>";
            }

            result += "</tr>";
        });
        
        result += "</table>";

        return result;
    }

});



</script>