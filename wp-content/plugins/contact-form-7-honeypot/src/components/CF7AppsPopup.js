import { __ } from '@wordpress/i18n';

const CF7AppsPopup = ( { children, title, onClose } ) => {
    return (
        <div className={ 'cf7apps-popup-container' }>
            <div className="cf7apps-popup-content">
                <button className="cf7apps-popup-close" onClick={ onClose } aria-label={ __( 'Close', 'cf7apps' ) }>
                    &times;
                </button>
                <h2>{ title }</h2>
                <div className="cf7apps-popup-data">
                    { children }
                </div>
            </div>
        </div>
    );
}

export default CF7AppsPopup;