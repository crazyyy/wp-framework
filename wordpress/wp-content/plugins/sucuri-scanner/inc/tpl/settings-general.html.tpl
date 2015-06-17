
%%SUCURI.ModalWhenAPIRegistered%%

<table class="wp-list-table widefat sucuriscan-table sucuriscan-settings">
    <thead>
        <tr>
            <th colspan="3" class="thead-with-button">
                <span>General Settings</span>
                <form action="%%SUCURI.URL.Settings%%" method="post" class="thead-topright-action">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <button type="submit" name="sucuriscan_reset_options" class="button-primary">Reset plugin options</button>
                </form>
            </th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td colspan="3">
                <p>
                    Most of the tools in this plugin can be used without a specific configuration,
                    but the core features <strong>require an API key</strong> to communicate with
                    the Sucuri services. The key is generated using your administrator e-mail and
                    the domain of this site, this will allow you to have access to our free
                    monitoring tool forever even if you remove the API key and generate it again.
                </p>

                <div class="sucuriscan-inline-alert-info">
                    <p>
                        All the HTTP requests used to communicate with the API service are being sent
                        using the WordPress built-in functions, so <em>(almost)</em> all its official
                        features are inherited, this is useful if you need to pass these HTTP requests
                        through a proxy. According to the <a href="http://codex.wordpress.org/HTTP_API"
                        target="_blank">official documentation</a> you have to add some constants to the
                        main configuration file: <em>WP_PROXY_HOST, WP_PROXY_PORT, WP_PROXY_USERNAME,
                        WP_PROXY_PASSWORD</em>.
                    </p>
                </div>

                <div class="sucuriscan-inline-alert-warning sucuriscan-%%SUCURI.InvalidDomainVisibility%%">
                    <p>
                        Your domain <code>%%SUCURI.CleanDomain%%</code> does not seems to have a DNS
                        <code>A</code> record so it will be considered as <em>invalid</em> by the API
                        interface when you request the generation of a new key. Adding <code>www</code>
                        at the beginning of the domain name may fix this issue.
                    </p>
                </div>
            </td>
        </tr>

        <tr class="alternate">
            <td width="200">Sucuri API key</td>
            <td>
                <span class="sucuriscan-monospace">%%SUCURI.APIKey%%</span>
            </td>
            <td width="350" class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post" class="sucuriscan-%%SUCURI.APIKey.RecoverVisibility%%">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <button type="submit" name="sucuriscan_recover_key" class="button-primary">Recover</button>
                </form>

                <form action="%%SUCURI.URL.Settings%%" method="post" class="sucuriscan-%%SUCURI.APIKey.ManualKeyFormVisibility%%">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_manual_api_key" class="input-text" placeholder="API key sent to your email" />
                    <button type="submit" class="button-primary">Save</button>
                </form>

                <form action="%%SUCURI.URL.Settings%%" method="post" class="sucuriscan-%%SUCURI.APIKey.RemoveVisibility%%">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <button type="submit" name="sucuriscan_remove_api_key" class="button-primary button-danger">Remove</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>Log storage path</td>
            <td class="sucuriscan-wraptext"><span class="sucuriscan-monospace" title="%%SUCURI.DatastorePath%%">%%SUCURI.DatastorePath%%</span></td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_datastore_path" class="input-text" placeholder="Directory to save logs..." />
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr class="alternate">
            <td>Send plugin alerts to</td>
            <td>%%SUCURI.NotifyTo%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_notify_to" class="input-text" placeholder="Separated by commas" />
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>Maximum alerts per hour</td>
            <td>%%SUCURI.EmailsPerHour%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <select name="sucuriscan_emails_per_hour">
                        %%SUCURI.EmailsPerHourOptions%%
                    </select>
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr class="alternate">
            <td>Consider brute-force after</td>
            <td>%%SUCURI.MaximumFailedLogins%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <select name="sucuriscan_maximum_failed_logins">
                        %%SUCURI.MaximumFailedLoginsOptions%%
                    </select>
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>API request with SSL</td>
            <td>%%SUCURI.VerifySSLCert%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <select name="sucuriscan_verify_ssl_cert">
                        %%SUCURI.VerifySSLCertOptions%%
                    </select>
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr class="alternate">
            <td>API request timeout</td>
            <td>%%SUCURI.RequestTimeout%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_request_timeout" class="input-text" placeholder="Timeout in seconds..." />
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>API proxy <em>(host:port)</em></td>
            <td><span class="sucuriscan-monospace">%%SUCURI.APIProxy.Host%%:%%SUCURI.APIProxy.Port%%</span></td>
            <td>&nbsp;</td>
        </tr>

        <tr class="alternate">
            <td>API proxy <em>(auth)</em></td>
            <td>
                <span class="sucuriscan-monospace">%%SUCURI.APIProxy.Username%%</span>
                <span class="sucuriscan-label-%%SUCURI.APIProxy.PasswordType%%">
                    <em>password is %%SUCURI.APIProxy.PasswordText%%</em>
                </span>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>API test request</td>
            <td><em>(Test ability to send HTTP requests)</em></td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="hidden" name="sucuriscan_debug_request" value="1" />
                    <button type="submit" class="button-primary">Proceed</button>
                </form>
            </td>
        </tr>

        <tr class="alternate">
            <td>Support reverse proxy</td>
            <td>%%SUCURI.ReverseProxyStatus%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="hidden" name="sucuriscan_revproxy" value="%%SUCURI.ReverseProxySwitchValue%%" />
                    <button type="submit" class="button-primary %%SUCURI.ReverseProxySwitchCssClass%%">%%SUCURI.ReverseProxySwitchText%%</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>Display audit report</td>
            <td>%%SUCURI.AuditReportStatus%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="hidden" name="sucuriscan_audit_report" value="%%SUCURI.AuditReportSwitchValue%%" />
                    <button type="submit" class="button-primary %%SUCURI.AuditReportSwitchCssClass%%">%%SUCURI.AuditReportSwitchText%%</button>
                </form>
            </td>
        </tr>

        <tr class="alternate">
            <td>Audit report limit</td>
            <td>Process latest %%SUCURI.AuditReportLimit%% logs</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_logs4report" class="input-text" placeholder="e.g. 500" />
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>Collect failed passwords</td>
            <td>%%SUCURI.CollectWrongPasswords%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_collect_wrong_passwords" class="input-text" placeholder="Type: YES or NO" />
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

        <tr class="alternate">
            <td>Plugin advertisement</td>
            <td>%%SUCURI.AdsVisibility%%</td>
            <td class="td-with-button">
                <form action="%%SUCURI.URL.Settings%%" method="post">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <input type="text" name="sucuriscan_ads_visibility" class="input-text" placeholder="Type: SHOW or HIDE" />
                    <button type="submit" class="button-primary">Change</button>
                </form>
            </td>
        </tr>

    </tbody>
</table>
