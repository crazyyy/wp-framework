<div class = "postbox">
    <div class = "inside">

        <form method = "post" action = "options.php">

            <h3>Plugin information</h3>

            <h4>Description</h4>

            <p>
                The &quot;<?php echo $plugin->get_title(); ?>&quot; plugin monitors each and every request that reaches your WordPress installation, be it a theme (frontend), admin (wp-admin), cron (wp-cron) or AJAX request. For each request the plugin logs its the resource consumption in its own table in the database. The information the plugin logs in the database is the <strong>type</strong> of the request, the <strong>url</strong> that was requested, the <strong>timestamp</strong> it was made, the <strong>maximum RAM</strong> usage, the <strong>number of queries</strong> made to the database, the <strong>duration</strong> of the request in the server side, and so on.
            </p>

            <h4>Purpose</h4>

            <p>
                The main purpose of the plugin is to log the above data and provide a basis for an inside the WordPress resource monitoring and basic analytics facility. It is not meant to be used as a substitution for one&apos;s server monitoring tools or analytics tools like Google Analytics or Piwik. However, in a world where managed hosting is becoming more and more popular, the web developer has less and less access to the core server resources.
            </p>

            <p>
                As of version 0.1.0 the plugin exoses some basic information on maximum, minimum and average resource consumption values (RAM usage, request duration, number of queries). In future versions the monitoring functions will become more complete and provide alerts.
            </p>

            <h4>Cron requests</h4>

            <p>
                Depending on your installation setup, the WordPress cron functionality may be executed in independent requests via calls to the <code>wp-cron.php</code> script, which is triggered by the system cron jobs, or via the <em>faux cron</em>, which is triggered inside reqular user requests. One needs to know their specific installation setup, in order to estimate which requests can actually be attributed to independent cron requests or combined user requests which triggered WordPress -faux- cron jobs. 
            </p>

        </form>

    </div> <!-- .inside -->
</div> <!-- .postbox -->