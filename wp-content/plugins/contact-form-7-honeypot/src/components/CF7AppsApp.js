import { Settings } from "@mui/icons-material";
import { ToggleControl } from "@wordpress/components";
import { useEffect, useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import { Link } from "react-router";
import { saveSettings } from "../api/api";
import { toast } from "react-toastify";

const CF7AppsApp = ({ settings }) => {
    const [isEnabled, setIsEnabled] = useState(false);

    useEffect(() => {
        setIsEnabled(settings.is_enabled);
    }, []);

    /**
     * Switches the app on or off.
     * 
     * @returns {void}
     * 
     * @since 3.0.0
     */
    const switchApp = () => {
        let app_settings = {};
        app_settings.is_enabled = !isEnabled;

        saveSettings(settings.id, app_settings);

        if( !isEnabled ) {
            toast.success( __( 'App enabled', 'cf7apps' ) );
        }
        else {
            toast.success( __( 'App disabled', 'cf7apps' ) );
        }
        
        setIsEnabled(!isEnabled);
    }

    return (
        <div className={`cf7apps-app cf7apps-app-${settings.id}`}>
            <div>
                <div className="cf7apps-app-container">
                    <div className="cf7apps-app-header">
                        <div>
                            <img 
                                src={settings.icon} 
                                alt={settings.title} 
                                height={28} 
                                style={ isEnabled ? { filter: 'none' } : { filter: 'grayscale(100%)' } }
                            />
                        </div>
                        {settings.has_admin_settings && (
                            <div className="cf7apps-app-settings">
                                <Link to={ `settings/${settings.id}`}>
                                    <Settings />
                                    { __( 'Settings', 'cf7apps' ) }
                                </Link>
                            </div>
                        )}
                    </div>
                    <div className="cf7apps-app-section">
                        <h3>{settings.title}</h3>
                        <p>{settings.description}</p>
                    </div>
                    <div className="cf7apps-app-footer">
                        <div className="cf7apps-app-container">
                            <a href={settings.documentation_url} target="_blank">
                                { __( 'Learn more', 'cf7apps' ) }
                            </a>
                        </div>
                        <div className="cf7apps-app-btn-container">
                            <div className="cf7apps-app-container">
                                <div className="cf7apps-app-switch-container">
                                    <span className={isEnabled ? 'cf7apps-app-status cf7apps-app-status-active' : 'cf7apps-app-status'}>
                                        { isEnabled ? __( 'Enabled', 'cf7apps' ) : __( 'Disabled', 'cf7apps' ) }
                                    </span>
                                    <ToggleControl
                                        className="cf7apps-app-switch"
                                        __nextHasNoMarginBottom={true}
                                        checked={isEnabled}
                                        onChange={() => switchApp()}
                                    />
                                </div>
                                <div className="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CF7AppsApp;
