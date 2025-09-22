import { createRoot, StrictMode, useEffect, useState } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import { HashRouter } from 'react-router';
import '../src/index.css';
import CF7AppsHeader from './components/CF7AppsHeader';
import MenuBar from './layout/MenuBar';
import Body from './layout/Body';
import RightBar from './layout/RightBar';
import { hasMigrated, migrate } from './api/api';
import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import { toast } from 'react-toastify';
import CF7AppsToastNotification from './components/CF7AppsToastNotification';

const CF7AppsView = () => {
    const [migrated, setMigrated] = useState(true);
    const [isMigrating, setIsMigrating] = useState(false);

    useEffect(() => {
        async function fetchMigration() {
            const response = await hasMigrated();

            setMigrated( response.has_migrated );
        }

        fetchMigration();
    }, []);

    /**
     * Migrates from old structure to new structure.
     * 
     * @returns {void}
     * 
     * @since 3.0.0
     */
    const updateDatabase = async () => {
        setIsMigrating( true );

        const response = await migrate();
        
        if(response) {
            toast.success( __( 'Great! Migration completed successfully, Enjoy CF7 Apps 🥳.', 'cf7apps' ) );
            
            setMigrated( true );
        }
        else {
            toast.error( __( 'Oops! Migration failed, please try again.', 'cf7apps' ) );

            setMigrated( false );
        }

        setIsMigrating( false );
    }

    return (
        <>
            <CF7AppsToastNotification />
            {
                ! migrated ? (
                    <div style={{ backgroundImage: `url(${CF7Apps.assetsURL}/images/dashboard.png)` }} className="cf7apps-migration">
                        <div className="cf7apps-migration-modal-container">
                            <div className="cf7apps-migration-modal">
                                <div className="cf7apps-modal-content">
                                    <img src={`${CF7Apps.assetsURL}/images/logo.png`} width="180px" alt="CF7 Apps Logo" />
                                    <h2>{ __( 'Attention: Introducing CF7 Apps 🎉', 'cf7apps' ) }</h2>
                                    <p>{ __( 'For enhanced security and additional features, we have developed CF7 Apps. You can now move your Honeypot settings to the new Honeypot App inside CF7 Apps.', 'cf7apps' ) }</p>
                                    <p>{ __( 'You can still use both, but we recommend switching now.', 'cf7apps' ) }</p>
                                    <Button onClick={updateDatabase} isBusy={isMigrating} className="cf7apps-btn tertiary-primary">{ __( 'Yes, Migrate to CF7 Apps', 'cf7apps' ) }</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                ) : (
                    <div className="cf7apps-main-content"> 
                        <CF7AppsHeader />
                        <div className="cf7apps-layout">
                            <MenuBar />
                            <Body />
                            {/* <RightBar /> */}
                            <div className="clearfix"></div>
                        </div>
                    </div>
                )
            }
        </>
    );
};

domReady(() => {
    const rootElement = document.getElementById('root');
    if (!rootElement) {
        console.error("Root element with id 'root' not found.");
        return;
    }

    const root = createRoot(rootElement);

    root.render(
        <HashRouter>
            <StrictMode>
                <CF7AppsView />
            </StrictMode>
        </HashRouter>
    );
});
