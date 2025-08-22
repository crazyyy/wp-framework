import { CheckCircleOutlined, ErrorOutlineOutlined } from "@mui/icons-material";
import { toast, ToastContainer } from "react-toastify";

const CF7AppsToastNotification = ({ message, type = "default", position = "top-right", autoClose = 4000, hideProgressBar = true, closeOnClick = true, pauseOnHover = true, draggable = true }) => {
    return (
        <ToastContainer 
            position={position}
            autoClose={autoClose} 
            className='cf7apps-toast-notification'
            hideProgressBar={hideProgressBar}
            icon={({ type, theme }) => {
                switch (type) {
                  case 'info':
                    return <Info className="stroke-indigo-400" />;
                  case 'error':
                    return <ErrorOutlineOutlined className="cf7apps-notification-icon-error" />;
                  case 'success':
                    return <CheckCircleOutlined className="cf7apps-notification-icon-success" />;
                  case 'warning':
                    return <TriangleAlert className="stroke-yellow-500" />;
                  default:
                    return null;
                }
              }}
        />
    );
};

export default CF7AppsToastNotification;