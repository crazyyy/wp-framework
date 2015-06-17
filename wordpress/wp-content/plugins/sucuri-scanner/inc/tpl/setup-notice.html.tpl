
<div class="updated sucuriscan-setup-notice sucuriscan-clearfix">
    <a href="http://sucuri.net/" target="_blank" class="sucuriscan-pull-left sucuriscan-setup-image">
        <img src="%%SUCURI.SucuriURL%%/inc/images/logo.png" alt="Sucuri Scanner" />
    </a>

    <div class="sucuriscan-pull-left">
        <p>
            Plugin not fully activated yet. Please generate the free API key to<br>
            enable audit logging, integrity checking, email alerts and other tools.
        </p>
    </div>

    <div class="sucuriscan-pull-right sucuriscan-setup-form">
        <form action="%%SUCURI.URL.Settings%%" method="post">
            <input type="hidden" name="sucuriscan_page_nonce" value="%%SUCURI.PageNonce%%" />
            <button type="submit" name="sucuriscan_plugin_api_key" class="button button-primary button-hero">
                <span class="sucuriscan-button-title">Generate API key</span>
                <span class="sucuriscan-button-subtitle">for <b>%%SUCURI.CleanDomain%%</b> / <b>%%SUCURI.AdminEmail%%</b></span>
            </button>
        </form>
    </div>
</div>
