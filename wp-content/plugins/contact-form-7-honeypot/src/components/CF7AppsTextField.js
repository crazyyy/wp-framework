import { __ } from "@wordpress/i18n";
import CF7AppsHelpText from "./CF7AppsHelpText";

const CF7AppsTextField = ({ label, value, description, onChange, className, placeholder, name, required }) => {
    return (
        <div className="cf7apps-form-group cf7apps-settings">
            <div>
                <label><b>{label}</b></label>
            </div>
            <div>
                <input 
                    type="text" 
                    value={value} 
                    onChange={onChange} 
                    name={name}
                    className={`cf7apps-form-input ${className}`} 
                    placeholder={placeholder}
                    {...required ? { required: true } : {}}
                />
            </div>
            <CF7AppsHelpText description={description} />
        </div>
    );
}

export default CF7AppsTextField;