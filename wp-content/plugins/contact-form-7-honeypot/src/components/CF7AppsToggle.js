import { ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import CF7AppsHelpText from "./CF7AppsHelpText";

const CF7AppsToggle = ({ label, isSelected, help, onChange, className, name }) => {
    return (
        <div className="cf7apps-form-group">
            <div className="cf7apps-settings-toggle">
                <label>{label}</label>
                <div>
                    <ToggleControl 
                        checked={isSelected} 
                        onChange={onChange} 
                        className={`cf7apps-app-switch ${className}`}
                    />
                </div>
            </div>
            <CF7AppsHelpText description={help} />
        </div>
    )
}

export default CF7AppsToggle;