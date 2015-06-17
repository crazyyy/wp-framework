
<table class="wp-list-table widefat sucuriscan-table sucuriscan-monitoring-settings">
    <tbody>
        <tr>
            <td width="200"><label>CloudProxy API key</label></td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Monitoring%%#monitoring-settings" method="post" class="sucuriscan-monitoring-apikey-form">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_cloudproxy_apikey" value="%%SUCURI.Monitoring.APIKey%%" class="input-text" />
                    <input type="submit" value="Save" class="button button-primary" />
                </form>
            </td>
        </tr>

        %%SUCURI.Monitoring.SettingOptions%%

        <tr class="alternate sucuriscan-%%SUCURI.Monitoring.SettingsVisibility%%">
            <td><label>Clear cache</label></td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Monitoring%%#monitoring-settings" method="post" class="sucuriscan-monitoring-clear-cache-form">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="hidden" name="sucuriscan_clear_cache" value="1" />
                    <input type="submit" value="Clear Cache" class="button button-primary" />
                </form>
            </td>
        </tr>
    </tbody>
</table>
