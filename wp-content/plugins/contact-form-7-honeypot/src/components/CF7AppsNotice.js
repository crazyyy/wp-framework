import { CheckCircleOutlineSharp, ErrorOutlineSharp, ReportGmailerrorredRounded, WarningAmberTwoTone } from "@mui/icons-material";

const CF7AppsNotice = ({ type = 'success', text = '' }) => {
    const getIcon = (type) => {
        switch (type) {
            case 'danger':
                return <WarningAmberTwoTone />;
            case 'warning':
                return <ReportGmailerrorredRounded />;
            case 'info':
                return <ErrorOutlineSharp />;
            case 'success':
                return <CheckCircleOutlineSharp />;
            default:
                return null;
        }
    };

    return (
        <div className={`cf7apps-notice cf7apps-notice-${type}`}>
            <p>{getIcon(type)} {text}</p>
        </div>
    );
}

export default CF7AppsNotice;