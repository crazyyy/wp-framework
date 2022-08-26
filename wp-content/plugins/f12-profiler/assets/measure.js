(function ($) {

    var resources = [];

    function addToolbar() {
        var tooltip = 'F12 Page Measure: Aggregated latency of fetching all resources linked to the page in a sequential order';

        $("#wp-admin-bar-f12_profiler_1").after(
            "<li id='wp-admin-bar-f12_profiler_2' class='menupop'>" +
            "<div class='ab-item ab-empty-item' aria-haspopup='true' title='" + tooltip + "'>" +
            "<span id='f12_profiler_2_js_time'></span> " +
            "(<span id='f12_profiler_2_js_count'></span>)" +
            "</div>\n" +
            "<div class='ab-sub-wrapper'>\n" +
            "<table id='wp-admin-bar-f12_profiler_2-default' class='ab-submenu'>\n" +
            "<tr class='f12-res-container'>" +
            "<th class='f12-link'>Resource</td>" +
            "<th class='f12-type'>Type</td>" +
            "<th class='f12-name'>Name</td>" +
            "<th class='f12-time'>Time&nbsp;&nbsp;&nbsp;</td>" +
            "</tr>\n" +
            "</table>\n" +
            "</div>\n" +
            "</li>\n"
        );

    }

    /**
     * Return the hostname of the current location
     * @returns {string}
     */
    function getHostname() {
        return window.location.hostname;
    }

    /**
     * Check if the link is on the same hostname
     *
     * @param link
     * @returns {boolean}
     */
    function isInternalScript(link) {
        if (link.search(getHostname()) != -1) {
            return true;
        }
        return false;
    }

    /**
     * Check if the link is counting as a core script from
     * wordpress.
     *
     * @param link
     */
    function isCoreScript(link) {
        if (link.search('/wp-admin/') != -1 || link.search('/wp-includes/') != -1) {
            return true;
        }
        return false;
    }

    /**
     * Check if the link is a plugin script
     * @param link
     */
    function isPluginScript(link) {
        if (link.search('/wp-content/plugins/') != -1) {
            return true;
        }
        return false;
    }

    /**
     * Try to receive the plugin name
     * @param link
     */
    function getPluginName(link) {
        link = link.split('/');
        var index = -1;
        for (var i = 0; i < link.length; i++) {
            if (link[i] === 'plugins') {
                index = i + 1;
                break;
            }
        }

        if (typeof (link[index]) !== 'undefined') {
            return link[index];
        }
        return false;
    }

    /**
     * check if the link is a theme script
     * @param link
     * @returns {boolean}
     */
    function isThemeScript(link) {
        if (link.search('/wp-content/themes/') != -1) {
            return true;
        }
        return false;
    }

    /**
     * Try to receive the plugin name
     * @param link
     */
    function getThemeName(link) {
        link = link.split('/');
        var index = -1;
        for (var i = 0; i < link.length; i++) {
            if (link[i] === 'themes') {
                index = i + 1;
                break;
            }
        }

        if (typeof (link[index]) !== 'undefined') {
            return link[index];
        }
        return false;
    }


    /**
     * Format the output of the seconds
     *
     * @param time
     * @returns {string}
     */
    function formatDecimals(time) {
        return (Math.round(time * 1000) / 1000).toFixed(4);
    }

    function addTime(time) {
        time = formatDecimals(time);
        $("#f12_profiler_2_js_time").html(time + 's');
    }

    function addCount(count) {
        $("#f12_profiler_2_js_count").html(count);
    }

    function formatTime(time) {
        time = formatDecimals(time);
        if (time >= 1) {
            return "<span class='f12-res-heavy'>" + time + "s</span>"
        } else if (time >= .5) {
            return "<span class='f12-res-medium'>" + time + "s</span>"
        } else {
            return "<span class='f12-res-light'>" + time + "s</span>"
        }
    }

    function formatName(name) {
        var src = name;
        var maxlength = 35;

        name = name.split("/");
        name = name[name.length - 1];

        if (name.indexOf("?") != -1) {
            name = name.split("?");
            name = name[0];
        }

        if (name.length > maxlength) {
            name = name.substr(0, maxlength - 3) + "...";
        }
        return "<a href='" + src + "' target='_blank' title='" + src + "'>" + name + "</a>";
    }

    /**
     * This function is used to gather additional informations about the resources.
     *
     * @param scriptname
     * @param time
     */
    function addToResources(scriptname, time) {
        var info = {
            async: false,
            link: formatName(scriptname),
            internal: false,
            core: false,
            plugin: false,
            plugin_name: '',
            theme: false,
            theme_name: '',
            failed: false,
            type: '',
            name: '',
            time: formatTime(time)
        };

        if (isInternalScript(scriptname)) {
            info.internal = true;

            if (isCoreScript(scriptname)) {
                info.core = true;
                info.type = 'core';
                info.name = 'Wordpress'
            } else {
                if (isPluginScript(scriptname)) {
                    info.plugin = true;
                    info.plugin_name = getPluginName(scriptname);
                    info.type = 'Plugin';
                    info.name = info.plugin_name;

                } else if (isThemeScript(scriptname)) {
                    info.theme = true;
                    info.theme_name = getThemeName(scriptname);
                    info.type = 'Theme';
                    info.name = info.theme_name;

                } else {
                    info.failed = true;
                    info.type = '';
                    info.name = '';
                }
            }
        } else {
            info.type = 'external';
            info.name = '';
        }

        resources.push(info);
    }

    /**
     * Update the Times after the Resource time has been added
     */
    function updateTimes() {
        // save the global time for all data
        var global_time = 0;

        // loop through the core and resources to sum up all times
        $("#wp-admin-bar-f12_profiler_1-default").find("li").each(function () {
            var time = 0;
            $(this).find(".f12-time").each(function () {
                time += parseFloat($(this).text());
            });
            $(this).find(".list-item:first-child").append("<span>&Sigma;</span><span title='Resources + Core'>" + formatDecimals(time) + "s</span>");

            // add the time to the global time
            global_time += time;
        });

        $("#wp-admin-bar-f12_profiler_1 div:first-child .f12-times").each(function () {
            $(this).html(formatDecimals(global_time) + "s");
        });
    }

    /**
     * finally add the resources to the toolbar. This step has been
     * separated to ensure that the resource are sorted by the time
     * the needed to be loaded.
     */
    function addToToolbar() {
        // sort the resources by the time spend to load
        resources.sort(function (a, b) {
            if (a.time > b.time) {
                return -1;
            } else if (a.time < b.time) {
                return 1;
            } else {
                return 0;
            }
        });

        for (var i = 0; i < resources.length; i++) {
            var info = resources[i];

            if (info.name.length > 0) {
                if ($("#wp-admin-bar-f12_profiler_1-default").find("#" + info.name).length > 0) {

                    $("#wp-admin-bar-f12_profiler_1-default").find("#" + info.name + " .list-item-resources table").append(
                        "<tr>" +
                        "<td class='f12-link'>" + info.link + "</td>" +
                        "<td class='f12-time'>" + info.time + "</td>" +
                        "</tr>"
                    );

                    $("#wp-admin-bar-f12_profiler_2-default").append(
                        "<tr class='f12-res-container'>" +
                        "<td class='f12-link'>" + info.link + "</td>" +
                        "<td class='f12-type'>" + info.type + "</td>" +
                        "<td class='f12-name' title='" + info.name + "'>" + info.name + "</td>" +
                        "<td class='f12-time'>" + info.time + "</td>" +
                        "</tr>");
                }
            }
        }

        /**
         * Add Times
         */
        updateTimes();

        // spread colored time labels to their parent container cell,
        // as a way to make layout more consistent with profiler
        $("#wp-admin-bar-f12_profiler_2-default .f12-time span")
            .css("background", function (index, value) {
                $(this).parent().css({"background": value});
                return value;
            });
    }

    $(document).ready(function () {
        //addToolbar();
        //console.log(window.performance.getEntries());

        /*
         * 'Resource' performance measures the latency of dependencies for rendering the screen,
         * like images, scripts and stylesheets. This is where caching makes a difference!
         * ref: https://css-tricks.com/breaking-performance-api/
         */
        var entries = window.performance.getEntriesByType('resource');
        //console.log(entries);

        var latency = 0, total_latency = 0, count = 0;

        entries.forEach(function (e, key) {
            // time to fetch a given resource
            // (tentative bug-fix according https://w3c.github.io/resource-timing/)
            latency = (e.responseEnd - e.requestStart) / 1000;

            // total time to fetch every resource on the page (if loaded sequentially *)
            //total_latency += latency;

            // count page resources
            count++;

            //console.log(e.name+": "+latency+"s");
            addToResources(e.name, latency);
        });
        addToToolbar();

        // * Frankly, 'total_latency' as exposed above feels more confusing than useful, IMHO,
        // as parallel resource load doesn't seem to be taken into account

        addTime(total_latency);

        addCount(count);
    });
    var timerStart = Date.now();

    $(window).load(function() {
        addTime((Date.now()-timerStart)/1000);
    });

})(jQuery);