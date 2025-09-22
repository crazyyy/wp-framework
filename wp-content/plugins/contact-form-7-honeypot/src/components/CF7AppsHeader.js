import { useEffect, useState } from "@wordpress/element";
import CF7AppsSkeletonLoader from "./CF7AppsSkeletonLoader";
import { Link, useLocation, useNavigate } from "react-router";
import { Button, Flex, FlexItem } from "@wordpress/components";
import { KeyboardArrowLeft } from "@mui/icons-material";
import { __ } from "@wordpress/i18n";

const CF7AppsHeader = () => {
    let path = useLocation();
    const navigate = useNavigate();

    const [isLoading, setIsLoading] = useState(true);
    
    useEffect(() => {
        const timer = setTimeout(() => {
            setIsLoading(false);
        }, 500);
        
        return () => clearTimeout(timer);
    }, []);

    const handleBackClick = () => {
        navigate(-1); // Go to previous screen
    };

    return (
        <div>
            {
                isLoading
                ?
                <div>
                    <CF7AppsSkeletonLoader count={1} height={85} />
                </div>
                :
                <div className="cf7apps-header">
                    <div className="container">
                        <Flex>
                            <FlexItem>
                                <Link to='/'>
                                    <img src={`${CF7Apps.assetsURL}/images/logo.png`} width="250px" alt="CF7 Apps Logo" />
                                </Link>
                            </FlexItem>
                            {
                                path.pathname !== undefined && path.pathname !== '/'
                                && (
                                    <FlexItem>
                                        <Button onClick={handleBackClick} className="cf7apps-btn icon tertiary-secondary">
                                            <KeyboardArrowLeft />{ __( 'Back', 'cf7apps' ) }
                                        </Button>
                                    </FlexItem>
                                )
                            }
                        </Flex>
                    </div>
                </div>
            }
        </div>
    )
}

export default CF7AppsHeader;