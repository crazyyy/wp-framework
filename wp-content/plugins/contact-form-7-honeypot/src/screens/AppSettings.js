import { useEffect, useState } from "@wordpress/element";
import { __, sprintf } from "@wordpress/i18n";
import CF7AppsSkeletonLoader from "../components/CF7AppsSkeletonLoader";
import { useParams } from "react-router";
import { getApps, saveSettings } from "../api/api";
import { TabContext, TabList, TabPanel } from "@mui/lab";
import { Box, Tab } from "@mui/material";
import CF7AppsToggle from "../components/CF7AppsToggle";
import CF7AppsTextField from "../components/CF7AppsTextField";
import CF7AppsNumberField from "../components/CF7AppsNumberField";
import { Button } from "@wordpress/components";
import CF7AppsTemplates from "../templates/CF7AppsTemplates";
import { toast } from 'react-toastify';
import parse from 'html-react-parser';
import CF7AppsSelectField from "../components/CF7AppsSelectField";
import CF7AppsNotice from "../components/CF7AppsNotice";

const AppSettings = () => {
    let { app } = useParams();

    const [appSettings, setAppSettings] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [tabValue, setTabValue] = useState('1');
    const [hasTabs, setHasTabs] = useState(false);
    const [formData, setFormData] = useState(false);
    const [isSaving, setIsSaving] = useState(false);
    const [notice, setNotice] = useState({ show: false, text: '' });

    useEffect(() => {

        // need to set the tab value from the url hash
        const hash = window.location.hash;
        const explodedHash = hash.split('/');
        if(explodedHash.length > 3) {
            setTabValue(explodedHash[3]);
        }

        async function fetchAppSettings() {
            if(app !== undefined) {
                setIsLoading(true);
                
                const appSettings = await getApps(app);
                let hasTabs = Object.keys(appSettings.setting_tabs).length > 0 ? true : false;
                let _formData = {};
                
                setHasTabs(hasTabs);

                if(hasTabs) {
                    let settingsTabs = appSettings['setting_tabs'];
                    let settings = appSettings['admin_settings']['general'];

                    Object.keys(settingsTabs).map((tabKey, tabIndex) => {
                        Object.keys(settings['fields'][tabKey]).map((fieldKey, fieldIndex) => {
                            if(fieldKey !== 'template') {
                                if(settings['fields'][tabKey][fieldKey].type === 'text' || settings['fields'][tabKey][fieldKey].type === 'number') {
                                    _formData[fieldKey] = settings['fields'][tabKey][fieldKey].value;
                                }
                                else if(settings['fields'][tabKey][fieldKey].type === 'checkbox') {
                                    _formData[fieldKey] = settings['fields'][tabKey][fieldKey].checked;
                                }
                            }
                        });
                    });
                }
                else {
                    let settings = appSettings['admin_settings']['general'];

                    Object.keys(settings['fields']).map((fieldKey, fieldIndex) => {
                        if(fieldKey !== 'template') {
                            if(settings['fields'][fieldKey].type === 'text' || settings['fields'][fieldKey].type === 'number') {
                                _formData[fieldKey] = settings['fields'][fieldKey].value;
                            }
                            else if(settings['fields'][fieldKey].type === 'checkbox') {
                                _formData[fieldKey] = settings['fields'][fieldKey].checked;
                            }
                        }
                    });
                }
                
                setFormData(_formData);
                setAppSettings(appSettings);
                setIsLoading(false);
            }
        }
        
        const timer = setTimeout(() => {
            fetchAppSettings();
        }, 1);

        return () => clearTimeout(timer);
    }, [app]);

    /**
     * Handles the input change event.
     * 
     * @param {Object} e - The event object.
     * 
     * @returns {void}
     * 
     * @since 3.0.0
     */
    const handleInputChange = (e) => {
        const { name, value, required } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: value
        }));
    }

    /**
     * Saves the app settings.
     * 
     * @returns {void}
     * 
     * @since 3.0.0
     */
    const saveAppSettings = async () => {
        let missingRequired = false;
        let requiredMessage = '';

        // Check if the app is enabled (adjust the key if needed)
        // If your toggle field is named 'is_enabled', this will work:
        const isEnabled = ( formData.is_enabled === undefined || formData.is_enabled === false ) ? false : true;

        // Only validate required fields if app is enabled
        if (isEnabled) {
            if (hasTabs) {
                Object.keys(appSettings.setting_tabs).some((tabKey) => {
                    const tabSettings = appSettings.admin_settings['general']['fields'][tabKey];
                    return Object.keys(tabSettings).some((fieldKey) => {
                        const field = tabSettings[fieldKey];
                        if (field && field.required && (formData[fieldKey] === '' || formData[fieldKey] === undefined)) {
                            missingRequired = true;
                            requiredMessage = field.required_message || __( 'Please fill all required fields.', 'cf7apps' );
                            return true;
                        }
                        return false;
                    });
                });
            } else {
                const fields = appSettings.admin_settings['general']['fields'];
                Object.keys(fields).some((fieldKey) => {
                    const field = fields[fieldKey];
                    if (field && field.required && (formData[fieldKey] === '' || formData[fieldKey] === undefined)) {
                        missingRequired = true;
                        requiredMessage = field.required_message || __( 'Please fill all required fields.', 'cf7apps' );
                        return true;
                    }
                    return false;
                });
            }

            if (missingRequired) {
                setNotice({ show: true, text: requiredMessage });
                toast.error( __( 'Error! Please fill all required fields.', 'cf7apps' ) );
                setIsSaving(false);
                return;
            }
        }

        setNotice({ show: false, text: '' });
        setIsSaving(true);

        const response = await saveSettings(app, formData);

        if(response) {
            toast.success( __( 'Great! Settings Saved Successfully', 'cf7apps' ) );
        }
        else {
            toast.error( __( 'Error! Something Went Wrong', 'cf7apps' ) );
        }

        setIsSaving(false);
    }

    const handleTabChange = ( e, newValue ) => {
        setTabValue(newValue);
        const explodedHash = window.location.hash.split('/');
        explodedHash[3] = newValue;
        window.location.hash = explodedHash.join('/');
    };

    /**
     * Settings of the App.
     * 
     * @returns {JSX.Element}
     * 
     * @since 3.0.0
     */
    const Settings = () => {
        if(hasTabs) {
            // Tabs
            return (
                <div className="cf7apps-form">
                    <TabContext value={tabValue}>
                        <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
                            <TabList onChange={ handleTabChange } className="cf7apps-settings-tablist">
                                {
                                    Object.keys(appSettings.setting_tabs).map((tabKey, tabIndex) => {
                                        return (
                                            <Tab
                                                label={appSettings.setting_tabs[tabKey]}
                                                value={`${tabIndex + 1}`}
                                                className="cf7apps-settings-tab"
                                            />
                                        )
                                    })
                                }
                            </TabList>
                        </Box>
                        {
                            Object.keys(appSettings.setting_tabs).map((tabKey, tabIndex) => {
                                const tabSettings = appSettings.admin_settings['general']['fields'][tabKey];
                                
                                return (
                                    <TabPanel value={`${tabIndex + 1}`}>
                                        {
                                            Object.keys(tabSettings).map((fieldKey, fieldIndex) => {
                                                const field = tabSettings[fieldKey];
                                                const className = field.class === undefined ? '' : field.class;
                                                const help = field.help;
                                                const palceholder = field.placeholder === undefined ? '' : field.placeholder;

                                                if(field.type === 'notice') {
                                                    return (
                                                        <CF7AppsNotice
                                                            type={className}
                                                            text={field.text}
                                                        />
                                                    )
                                                }
                                                else if(fieldKey === 'title') {
                                                    return (
                                                        <h3>{tabSettings.title}</h3>
                                                    )
                                                }
                                                else if(fieldKey === 'description') {
                                                    return (
                                                        <p className="cf7apps-help-text">{tabSettings.description}</p>
                                                    )
                                                }
                                                else if(field.type === 'text') {
                                                    return (
                                                        <CF7AppsTextField
                                                            label={field.title}
                                                            description={ parse( String(field.description) ) }
                                                            className={className}
                                                            placeholder={palceholder}
                                                            value={formData[fieldKey]}
                                                            name={fieldKey}
                                                            onChange={handleInputChange}
                                                            required={field.required}
                                                        />
                                                    )
                                                }
                                                else if(field.type === 'number') {
                                                    return (
                                                        <CF7AppsNumberField
                                                            label={field.title}
                                                            description={ parse( String(field.description) ) }
                                                            className={className}
                                                            name={fieldKey}
                                                            placeholder={palceholder}
                                                            value={formData[fieldKey]}
                                                            onChange={handleInputChange}
                                                        />
                                                    )
                                                } 
                                                else if(field.type === 'checkbox') {
                                                    return (
                                                        <CF7AppsToggle
                                                            help={help} 
                                                            label={field.title}
                                                            className={className}
                                                            isSelected={formData[fieldKey]}
                                                            onChange={(e) => {
                                                                setFormData({
                                                                    ...formData,
                                                                    [fieldKey]: ! formData[fieldKey]
                                                                });
                                                            }}
                                                        />
                                                    )
                                                }
                                                else if(field.type === 'select') {
                                                    return (
                                                        <CF7AppsSelectField
                                                            label={field.title}
                                                            className={className}
                                                            name={fieldKey}
                                                            selected={formData['selected']}
                                                            options={field.options}
                                                            description={ parse( String(field.description) ) }
                                                        />
                                                    )
                                                }
                                                else if(field.type === 'save_button') {
                                                    return (
                                                        <div className="cf7apps-form-group">
                                                            <Button 
                                                                className="cf7apps-btn tertiary-primary"
                                                                onClick={saveAppSettings}
                                                                isBusy={isSaving}
                                                            >
                                                                { field.text }
                                                            </Button>
                                                        </div>
                                                    )    
                                                }
                                                else if(fieldKey === 'template') {
                                                    const Template = CF7AppsTemplates[field];

                                                    // passing app settings to template for enable and disable the entries app.
                                                    return(
                                                        <Template
                                                            appSettings={ appSettings }
                                                            formData={ formData }
                                                        />
                                                    )
                                                }
                                                else {
                                                    console.log(fieldKey);
                                                }
                                            })
                                        }
                                    </TabPanel>
                                )
                            })
                        }
                    </TabContext>
                </div>
            );
        } else {
            // No Tabs
            return (
                <div className="cf7apps-form">
                    <div className="MuiTabPanel-root">
                        {
                            notice.show && (
                                <CF7AppsNotice
                                    type='warning'
                                    text={ notice.text }
                                />
                            )
                        }
                        {
                            Object.keys(appSettings.admin_settings['general']['fields']).map((fieldKey, fieldIndex) => {
                                const field = appSettings.admin_settings['general']['fields'][fieldKey];
                                const className = field.class === undefined ? '' : field.class;
                                const help = field.help;
                                const palceholder = field.placeholder === undefined ? '' : field.placeholder;

                                if(fieldKey === 'title') {
                                    return (
                                        <h3>{appSettings.admin_settings['general']['fields'].title}</h3>
                                    )
                                }
                                else if(fieldKey === 'description') {
                                    return (
                                        <p className="cf7apps-help-text">{appSettings.admin_settings['general']['fields'].description}</p>
                                    )
                                }
                                else if(field.type === 'text') {
                                    return (
                                        <CF7AppsTextField
                                            label={field.title}
                                            description={ parse( String(field.description) ) }
                                            className={className}
                                            placeholder={palceholder}
                                            value={formData[fieldKey]}
                                            name={fieldKey}
                                            onChange={handleInputChange}
                                            required={field.required}
                                        />
                                    )
                                }
                                else if(field.type === 'number') {
                                    return (
                                        <CF7AppsNumberField
                                            label={field.title}
                                            description={ parse( String(field.description) ) }
                                            className={className}
                                            name={fieldKey}
                                            placeholder={palceholder}
                                            value={formData[fieldKey]}
                                            onChange={handleInputChange}
                                        />
                                    )
                                } 
                                else if(field.type === 'checkbox') {
                                    return (
                                        <CF7AppsToggle
                                            help={help} 
                                            label={field.title}
                                            className={className}
                                            isSelected={formData[fieldKey]}
                                            onChange={(e) => {
                                                setFormData({
                                                    ...formData,
                                                    [fieldKey]: ! formData[fieldKey]
                                                });
                                            }}
                                        />
                                    )
                                }
                                else if(field.type === 'select') { 
                                    return (
                                        <CF7AppsSelectField
                                            label={field.title}
                                            className={className}
                                            name={fieldKey}
                                            selected={field['selected']}
                                            options={field.options}
                                            onChange={handleInputChange}
                                            description={ parse( String(field.description) ) }
                                        />
                                    )
                                }
                                else if(field.type === 'save_button') {
                                    return (
                                        <div className="cf7apps-form-group">
                                            <Button 
                                                className="cf7apps-btn tertiary-primary"
                                                onClick={saveAppSettings}
                                                isBusy={isSaving}
                                            >
                                                { field.text }
                                            </Button>
                                        </div>
                                    )    
                                }
                                else if(fieldKey === 'template') {
                                    const Template = CF7AppsTemplates[field];
                                    return(
                                        <Template />
                                    )
                                }
                                else {
                                    console.log(field);
                                }
                            })
                        }
                    </div>
                </div>
            );
        }
    }

    return (
        ! isLoading && appSettings && appSettings.id === app
        ?
        <div className="cf7apps-body">
            <div className="cf7apps-app-setting-header">
                <div className="cf7apps-container">
                    <h1>{ sprintf( __( '%s Settings', 'cf7apps' ), appSettings.title ) }</h1>
                </div>
            </div>
            <div className="cf7apps-app-setting-section">
                <div className="cf7apps-container">
                    { Settings() }
                </div>
            </div>
        </div>
        :
        <div className="cf7apps-body-loading">
            <CF7AppsSkeletonLoader height={800} width='100%' />
        </div>
    );
}

export default AppSettings;