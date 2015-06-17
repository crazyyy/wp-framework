
<div id="poststuff">
    <div class="postbox sucuriscan-border sucuriscan-table-description">
        <h3>Modified Files</h3>

        <div class="inside">

            <p>
                If your site was recently attacked, you can see which files were modified to
                assist with any investigation. Note that in most Unix file systems, a file is
                considered modified when its inode data is changed; that is, when the
                permissions, owner, group, or other metadata from the inode is updated.
            </p>

            <div class="sucuriscan-inline-alert-error sucuriscan-%%SUCURI.ModifiedFiles.DisabledVisibility%%">
                <p>
                    The scanner that searches for modified files under the content directory is
                    disabled. This tool is disabled by default to prevent an overflow in the memory
                    of the PHP interpreter in the majority of websites that have too many files in
                    their projects, but you can enable this scanner from
                    <a href="%%SUCURI.URL.Settings%%#settings-scanner">here</a> though, and if you
                    experience issues like <em>"Internal Server Error"</em> messages or blank pages
                    just disable the scanner again.
                </p>
            </div>

        </div>
    </div>
</div>

<table class="wp-list-table widefat sucuriscan-table sucuriscan-table-double-title sucuriscan-modifiedfiles">
    <thead>
        <tr>
            <th colspan="3" class="thead-with-button">
                <span>Modified files <em>(inside the content directory)</em></span>

                <form action="%%SUCURI.CurrentURL%%#modified-files" method="post" class="thead-topright-action">
                    <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
                    <label>
                        Modified in the last
                        <select name="sucuriscan_last_days" id="sucuriscan_last_days">
                        %%SUCURI.ModifiedFiles.SelectOptions%%
                        </select>
                        days
                    </label>

                    <!-- This field was added to give backward compatibility with the SiteCheck form. -->
                    <input type="hidden" name="sucuriscan_malware_scan" value="1" />
                </form>
            </th>
        </tr>

        <tr>
            <th>File Path</th>
            <th width="100">File Size</th>
            <th width="190">Modified at</th>
        </tr>
    </thead>

    <tbody>
        %%SUCURI.ModifiedFiles.List%%

        <tr class="sucuriscan-%%SUCURI.ModifiedFiles.NoFilesVisibility%%">
            <td colspan="3">
                <em>No files modified in the last %%SUCURI.ModifiedFiles.Days%% days</em>
            </td>
        </tr>
    </tbody>
</table>
