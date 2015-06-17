
<div id="poststuff">
    <div class="postbox sucuriscan-border sucuriscan-table-description">
        <h3>Alert Settings</h3>

        <div class="inside">
            <p>
                Check the boxes bellow to receive alerts via email of the events explained in
                the table, by the default the notifications will be sent to the address
                configured during the installation of your site, you can change this in the
                <em>General Settings</em> panel. You can specify multiple recipients separating
                each address with a comma.
            </p>

            <div class="sucuriscan-inline-alert-warning sucuriscan-%%SUCURI.PrettifyMailsWarningVisibility%%">
                <p>
                    Some emails sent by this plugin will be rejected outright by some popular email
                    services. To fix this you will need to use a third-party email service, or use a
                    plugin to force the site to use SMTP <em>(Simple Mail Transfer Protocol)</em>
                    for sending emails, and then configure your SMTP server to properly handle
                    messages. You can also <strong>disable HTML alerts</strong> to get notifications
                    in <em>text/plain</em> format.
                </p>
            </div>
        </div>
    </div>
</div>

<form action="%%SUCURI.URL.Settings%%#settings-notifications" method="post">
    <table class="wp-list-table widefat sucuriscan-table sucuriscan-settings-notifications">
        <thead>
            <tr>
                <th class="thead-with-button">
                    <span>Alert Settings</span>
                    <div class="thead-topright-action">
                        <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                        <button type="submit" name="sucuriscan_save_notification_settings" class="button-primary">Save</button>
                    </div>
                </th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>
                    <p>
                        Format of the subject for the email alerts, by default the plugin will use the
                        domain of the site, and the event that is going to be reported, you can change
                        this to also report the remote address of the user involved in the operation
                        that is being reported to quickly determine if the event is valid or not reading
                        the subject of the email.
                    </p>

                    <ul class="sucuriscan-subject-formats">

                        %%SUCURI.EmailSubjectOptions%%

                        <li>
                            <label>
                                <input type="radio" name="sucuriscan_email_subject" value="custom" %%SUCURI.EmailSubjectCustom.Checked%% />
                                <span>Custom format</span>
                                <input type="text" name="sucuriscan_custom_email_subject" value="%%SUCURI.EmailSubjectCustom.Value%%" />
                            </label>
                        </li>

                    </ul>
                </td>
            </tr>

            %%SUCURI.NotificationOptions%%

        </tbody>
    </table>
</form>
