import { useEffect, useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import { getApps } from "../api/api";
import CF7AppsSkeletonLoader from "../components/CF7AppsSkeletonLoader";
import CF7AppsApp from "../components/CF7AppsApp";
import { useParams } from "react-router";

const Apps = () => {
    const [isLoading, setIsLoading] = useState(true);
    const [apps, setApps] = useState(false);
    const { parent } = useParams();

    useEffect( () => {
        async function fetchApps() {
            const apps = await getApps();
            setApps(apps);
            setIsLoading(false);
        }
        
        fetchApps();
    }, []);

    return (
        <div className="cf7apps-body">
            <div className="cf7apps-apps-header">
                <div className="cf7apps-container">
                    <div>
                        <h2>{ __( 'Unleash the full potential of Contact Form 7!', 'cf7apps' ) }</h2>
                        <p>
                            { __( 'Simplify, customize, and enhance your form building experience.', 'cf7apps' ) }
                        </p>
                    </div>
                </div>
            </div>
            <div className="cf7apps-apps-section">
                <div className="cf7apps-container">
                    <h2>{ __( 'General', 'cf7apps' ) }</h2>

                    <div className={ 'cf7apps-apps-container' }>
                        {
                            isLoading ?
                                <>
                                    <div className="cf7apps-app">
                                        <CF7AppsSkeletonLoader width="100%" height={250} />
                                    </div>
                                    <div className="cf7apps-app">
                                        <CF7AppsSkeletonLoader width="100%" height={250} />
                                    </div>
                                    <div className="cf7apps-app">
                                        <CF7AppsSkeletonLoader width="100%" height={250} />
                                    </div>
                                </> :
                                Object.keys( apps ).map( appIndex => {
                                    return (
                                        <>
                                            {
                                                'general' === String( apps[ appIndex ].parent_menu ).toLowerCase().replace( ' ', '-' )
                                                && <CF7AppsApp settings={ apps[ appIndex ] } />
                                            }
                                        </>
                                    )
                                } )
                        }
                    </div>

                    <h2>{ __( 'Spam Protection Apps', 'cf7apps' ) }</h2>
                    <div className="cf7apps-apps-container">
                        {
                            isLoading
                            ?
                            <>
                                <div className="cf7apps-app">
                                    <CF7AppsSkeletonLoader width="100%" height={250} />
                                </div>
                                <div className="cf7apps-app">
                                    <CF7AppsSkeletonLoader width="100%" height={250} />
                                </div>
                                <div className="cf7apps-app">
                                    <CF7AppsSkeletonLoader width="100%" height={250} />
                                </div>
                            </>
                            :
                            Object.keys(apps).map((appIndex) => {
                                return ( 
                                    apps.length - appIndex == 1 ? 
                                    <>
                                        <CF7AppsApp settings={apps[appIndex]} /> 
                                        <a href="https://cf7apps.com/submit-idea/?utm_source=plugin&utm_medium=apps&utm_campaign=click_to_submit_your_idea" target="_blank" className="cf7apps-app cf7apps-app-coming-soon">
                                            <div style={{ padding: 0 }}>
                                                <img 
                                                    src={`${CF7Apps.assetsURL}/images/more-apps-coming-soon.png`} 
                                                    alt='More Apps Coming soon!' 
                                                    className="more-apps-coming-soon" 
                                                    width='100%' 
                                                    style={{ verticalAlign: 'middle', marginTop: '10px' }} 
                                                />
                                            </div>
                                            <h1 className="cf7apps-coming-soon">
                                                { __( 'Click to submit', 'cf7apps' ) }
                                                <br />
                                                { __( 'Your idea!', 'cf7apps' ) }
                                            </h1>
                                        </a>
                                    </>
                                    :
                                        (
                                            <>
                                                {
                                                    'spam-protection' === String( apps[ appIndex ].parent_menu ).toLowerCase().replace( ' ', '-' )
                                                    && <CF7AppsApp settings={ apps[ appIndex ] } />
                                                }
                                            </>
                                        )
                                )                                  
                            })
                        }
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Apps;