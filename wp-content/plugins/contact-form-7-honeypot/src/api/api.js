const headers =  {
    'X-WP-Nonce': CF7Apps.nonce
};

/**
 * Fetches the menu items from the server.
 * 
 * @since 3.0.0
 */
export async function getMenu() {
    const response = await fetch(`${CF7Apps.restURL}cf7apps/v1/get-menu-items`, {
        headers: headers
    });

    if (!response.ok) {
        return false;
    }

    const json = await response.json();

    return json.data;
}

/**
 * Fetches the app settings from the server.
 * 
 * @param {string} id The ID of the app.
 * 
 * @since 3.0.0
 */
export async function getApps( id = '' ) {
    // Use REST route with optional /id param, e.g. .../get-apps or .../get-apps/123
    let url = `${CF7Apps.restURL}cf7apps/v1/get-apps`;
    if (id) {
        url += `/${encodeURIComponent(id)}`;
    }

    const response = await fetch(url, {
        headers: headers,
        method: 'GET'
    });

    if (!response.ok) {
        return false;
    }

    const json = await response.json();

    return json.data;
}

/**
 * Saves the App settings to the server.
 * 
 * @param {string} id The ID of the app. 
 * @param {object} app_settings The app settings to save.
 *  
 * @returns 
 * 
 * @since 3.0.0
 */
export async function saveSettings(id, app_settings) {
    const response = await fetch(
        `${CF7Apps.restURL}cf7apps/v1/save-app-settings`, {
            headers: headers,
            method: 'POST',
            body: JSON.stringify({ 
                id: id,
                app_settings
            })
        }
    );

    if (!response.ok) {
        return false;
    }

    const json = await response.json();

    return json.data;
}

/**
 * Fetches the CF7 forms from the server.
 *  
 * @since 3.0.0
 * 
 * @returns {array} The CF7 forms.
 */
export async function getCF7Forms() {
    const response = await fetch(
        `${CF7Apps.restURL}cf7apps/v1/get-cf7-forms`, {
            headers: headers,
            method: 'GET'
        }
    );

    if (!response.ok) {
        return false;
    }

    const json = await response.json();
    
    return json.data;
}

/**
 * If the app has migrated or not.
 * 
 * @returns {boolean} True if the app has migrated, false otherwise.
 * 
 * @since 3.0.0
 */
export async function hasMigrated() {
    const response = await fetch(
        `${CF7Apps.restURL}cf7apps/v1/has-migrated`, {
            headers: headers,
            method: 'GET'
        }
    );

    if (!response.ok) {
        return false;
    }

    const json = await response.json();
    
    return json.data;
}

/**
 * Migrates the app from old structure to new structure.
 * 
 * @returns {boolean} True if the migration was successful, false otherwise.
 * 
 * @since 3.0.0
 */
export async function migrate() {
    const response = await fetch(
        `${CF7Apps.restURL}cf7apps/v1/migrate`, {
            headers: headers,
            method: 'POST'
        }
    );

    if (!response.ok) {
        return false;
    }

    const json = await response.json();
    
    return json.data;
}