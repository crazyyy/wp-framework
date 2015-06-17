
<tr class="%%SUCURI.CoreFiles.CssClass%% sucuriscan-hidden">
    <td class="check-column">
        <input type="checkbox" name="sucuriscan_integrity_files[]"
        value="%%SUCURI.CoreFiles.FilePath%%" %%SUCURI.CoreFiles.IsFixtableFile%% />
        <input type="hidden" name="sucuriscan_integrity_types[]"
        value="%%SUCURI.CoreFiles.StatusType%%" %%SUCURI.CoreFiles.IsFixtableFile%% />
    </td>
    <td><span class="sucuriscan-label sucuriscan-label-%%SUCURI.CoreFiles.StatusType%%">%%SUCURI.CoreFiles.StatusType%%</span></td>
    <td><em title="%%SUCURI.CoreFiles.FileSizeNumber%% bytes">~%%SUCURI.CoreFiles.FileSizeHuman%%</em></td>
    <td>%%SUCURI.CoreFiles.ModifiedAt%%</td>
    <td>
        <span class="sucuriscan-monospace sucuriscan-wraptext">%%SUCURI.CoreFiles.FilePath%%</span>
        <em>%%SUCURI.CoreFiles.IsNotFixable%%</em>
    </td>
</tr>
