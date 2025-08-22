import { __ } from "@wordpress/i18n";
import CF7AppsHelpText from "./CF7AppsHelpText";

const CF7AppsSelectField = ({ label, selected, description, onChange, className, options, name }) => {
    return (
        <div className="cf7apps-form-group cf7apps-settings">
            <div>
                <label><b>{label}</b></label>
            </div>
            <div>
                <select
                    className={`cf7apps-form-input ${className}`} 
                    name={name}
                    onChange={onChange}
                    defaultValue={selected}
                >
                    {
                        Object.keys(options).map((key, index) => {
                            return (
                                <option 
                                    key={index} 
                                    value={key}
                                >
                                    {options[key]}
                                </option>
                            )
                        })
                    }
                </select>
            </div>
            <CF7AppsHelpText description={description} />
        </div>
    );
}

export default CF7AppsSelectField;