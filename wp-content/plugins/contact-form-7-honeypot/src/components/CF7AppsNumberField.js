import { __ } from "@wordpress/i18n";
import CF7AppsHelpText from "./CF7AppsHelpText";

const CF7AppsNumberField = ({ label, value, name, description, onChange, className, placeholder }) => {
    return (
        <div className="cf7apps-form-group cf7apps-settings">
            <div>
                <label><b>{label}</b></label>
            </div>
            <div>
                <input 
                    type="number"
                    value={value}
                    name={name}
                    onChange={onChange}
                    className={`cf7apps-form-input ${className}`}
                    placeholder={placeholder}
                />
            </div>
            <CF7AppsHelpText description={description} />
        </div>
    );
}

export default CF7AppsNumberField;