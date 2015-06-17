
<table class="wp-list-table widefat sucuriscan-table sucuriscan-table-quad-title sucuriscan-monitoring-logs">
    <thead>
        <tr>
            <th colspan="4" class="thead-with-button">
                <span>Search among the logs:</span>
                <div class="thead-topright-action">
                    <form action="%%SUCURI.URL.Monitoring%%#monitoring-logs" method="post" class="sucuriscan-monitoring-search-form">
                        <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                        <input type="text" name="sucuriscan_monitoring_log_filter" class="input-text" />
                        <input type="submit" value="Search" class="button button-primary" />
                    </form>
                </div>
            </th>
        </tr>

        <tr>
            <th colspan="4" class="thead-with-button">
                <span>Filter by the denial type:</span>
                <div class="thead-topright-action">
                    <form action="%%SUCURI.URL.Monitoring%%#monitoring-logs" method="post" class="sucuriscan-monitoring-denial-types-form">
                        <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                        <select name="sucuriscan_monitoring_denial_type">%%SUCURI.AuditLogs.DenialTypeOptions%%</select>
                        <input type="submit" value="Filter" class="button button-primary" />
                    </form>
                </div>
            </th>
        </tr>

        <tr>
            <th colspan="4" class="thead-with-button">
                <span>Filter by date:</span>
                <div class="thead-topright-action">
                    <form action="%%SUCURI.URL.Monitoring%%#monitoring-logs" method="post" class="sucuriscan-monitoring-date-form">
                        <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                        <input type="hidden" name="sucuriscan_monitoring_date" value="1" />
                        <em class="sucuriscan-target-date">(%%SUCURI.AuditLogs.TargetDate%%)</em>
                        <select name="sucuriscan_year">%%SUCURI.AuditLogs.DateYears%%</select>
                        <select name="sucuriscan_month">%%SUCURI.AuditLogs.DateMonths%%</select>
                        <select name="sucuriscan_day">%%SUCURI.AuditLogs.DateDays%%</select>
                        <input type="submit" value="Filter" class="button button-primary" />
                    </form>
                </div>
            </th>
        </tr>

        <tr>
            <th width="250">Denial Type</th>
            <th width="120">Remote Address</th>
            <th>Request Path</th>
        </tr>
    </thead>

    <tbody>
        %%SUCURI.AuditLogs.List%%

        <tr class="sucuriscan-%%SUCURI.AuditLogs.NoItemsVisibility%%">
            <td colspan="4">
                <em>Audit trails is empty.</em>
            </td>
        </tr>
    </tbody>

    <tfoot>
        <tr class="sucuriscan-%%SUCURI.AuditLogs.PaginationVisibility%%">
            <td colspan="4">
                <div class='pagination' style="float:right;">
                    %%SUCURI.AuditLogs.AuditPagination%%
                </div>
            </td>
        </tr>
    </tfoot>
</table>
