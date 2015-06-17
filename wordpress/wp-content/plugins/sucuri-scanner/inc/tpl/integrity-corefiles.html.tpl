
<div class="postbox sucuriscan-border sucuriscan-border-good sucuriscan-integrity-message sucuriscan-%%SUCURI.CoreFiles.GoodVisibility%%">
    <span class="sucuriscan-integrity-mark">OK</span>
    <h3>Core integrity</h3>

    <div class="inside">
        <p>Your WordPress core files are clean and were not modified.</p>
    </div>
</div>

<form action="%%SUCURI.URL.Home%%" method="post">
    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />

    <table class="wp-list-table widefat sucuriscan-table sucuriscan-corefiles sucuriscan-%%SUCURI.CoreFiles.BadVisibility%%">
        <thead>
            <tr>
                <th colspan="5" class="sucuriscan-clearfix thead-with-button">
                    <span>Core integrity (%%SUCURI.CoreFiles.ListCount%% files)</span>
                    <button id="sucuriscan-corefiles-show" class="button button-primary thead-topright-action" data-action="show">Show files</button>
                </th>
            </tr>

            <tr>
                <td colspan="5" class="sucuriscan-corefiles-warning">
                    <div>
                        <p>
                            Changes in the integrity of your core files were detected, you may want to check
                            each file to determine if they were infected with malicious code. The WordPress
                            core directories <code>/&lt;root&gt;</code>, <code>/wp-admin</code> and <code>
                            /wp-includes</code> are the only ones being scanned; the content, uploads, and
                            custom directories are not part of the official archives so you have to check
                            them manually.
                        </p>
                    </div>
                </td>
            </tr>

            <tr class="sucuriscan-hidden">
                <th class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th width="80" class="manage-column">Status</th>
                <th width="100" class="manage-column">File Size</th>
                <th width="170" class="manage-column">Modified At</th>
                <th class="manage-column">File Path</th>
            </tr>
        </thead>

        <tbody>
            %%SUCURI.CoreFiles.List%%
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5">
                    <p>
                        <strong>Note.</strong> This is not a malware scanner but an integrity checker
                        which is a completely different thing, if you want to check if your site is
                        generating malicious code then use the <a href="%%SUCURI.URL.Scanner%%">malware
                        scan</a> tool. If you see the text <em>"must be fixed manually"</em> in any of
                        these files that means that they do not have write permissions so you can not
                        fix them using this tool.
                    </p>

                    <label>
                        <select name="sucuriscan_integrity_action">
                            <option value="">Choose action</option>
                            <option value="restore">Restore file(s) content</option>
                            <option value="delete">Delete file(s)</option>
                            <option value="fixed">Mark as fixed</option>
                        </select>
                    </label>

                    <button type="submit" class="button button-primary">Send action</button>
                </td>
            </tr>
        </tfoot>
    </table>

</form>
