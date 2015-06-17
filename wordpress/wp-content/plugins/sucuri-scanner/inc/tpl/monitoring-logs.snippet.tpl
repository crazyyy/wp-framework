
<tr class="%%SUCURI.AuditLog.CssClass%%">
    <td>
        <span class="sucuriscan-denial-type">%%SUCURI.AuditLog.SucuriBlockReason%%</span><br>
        <span class="sucuriscan-denial-type-date">Date/Time: %%SUCURI.AuditLog.LocalRequestTime%%</span>
    </td>
    <td><span class="sucuriscan-monospace">%%SUCURI.AuditLog.RemoteAddr%%</span></td>
    <td>
        <div class="sucuriscan-wraptext">
            <a href="#TB_inline?width=600&height=300&inlineId=sucuriscan-reqsummary-%%SUCURI.AuditLog.Id%%" title="Access Log Summary" class="thickbox">
                <span class="sucuriscan-monospace">%%SUCURI.AuditLog.ResourcePath%%</span>
            </a>
        </div>

        <div id="sucuriscan-reqsummary-%%SUCURI.AuditLog.Id%%" style="display:none">
            <div class="sucuriscan-request-summary">
                <table class="wp-list-table widefat">
                    <thead>
                        <tr>
                            <th width="200">Information</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="alternate">
                            <td>Blocked Reason</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.SucuriBlockReason%%</td>
                        </tr>
                        <tr>
                            <td>Remote Address</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.RemoteAddr%%</td>
                        </tr>
                        <tr class="alternate">
                            <td>Date &amp; Time (Local Time)</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.LocalRequestTime%%</td>
                        </tr>
                        <tr>
                            <td>Resource Path</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.ResourcePath%%</td>
                        </tr>
                        <tr class="alternate">
                            <td>Request Method</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.RequestMethod%%</td>
                        </tr>
                        <tr>
                            <td>HTTP Protocol</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.HttpProtocol%%</td>
                        </tr>
                        <tr class="alternate">
                            <td>HTTP Status</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.HttpStatus%% %%SUCURI.AuditLog.HttpStatusTitle%%</td>
                        </tr>
                        <tr>
                            <td>HTTP Bytes Sent</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.HttpBytesSent%%</td>
                        </tr>
                        <tr class="alternate">
                            <td>HTTP Referer</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.HttpReferer%%</td>
                        </tr>
                        <tr>
                            <td>HTTP User Agent</td>
                            <td class="sucuriscan-monospace">%%SUCURI.AuditLog.HttpUserAgent%%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </td>
</tr>
