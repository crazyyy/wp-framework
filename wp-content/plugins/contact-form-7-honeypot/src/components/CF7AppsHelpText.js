import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";

const CF7AppsHelpText = (props) => {
    const [showMore, setShowMore] = useState(false);
    const { description } = props;
    
    return (
        <>
            { 
                ( description !== undefined && description != 'undefined' ) && (
                    <p>
                        {description.length > 90 && description.length > 100 ? (
                            <>
                                {showMore ? description : `${description.substring(0, 90)} ...`}
                                <span className="cf7apps-show-more-text" onClick={() => setShowMore(!showMore)}>
                                    {showMore ? ` ${ __( 'Show Less', 'cf7apps' ) }` : ` ${ __( 'Show More', 'cf7apps' ) }`}
                                </span>
                            </>
                        ) : (
                            description
                        )}
                    </p>
                )
            }
        </>
    );
}

export default CF7AppsHelpText;