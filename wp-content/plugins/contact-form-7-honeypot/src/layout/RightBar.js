import { useEffect, useState } from "@wordpress/element";
import CF7AppsSkeletonLoader from "../components/CF7AppsSkeletonLoader";

const RightBar = () => {
    const [isLoading, setIsLoading] = useState(true);
    useEffect(() => {
        const timer = setTimeout(() => {
            setIsLoading(false);
        }, 500);
        
        return () => clearTimeout(timer);
        }, []);

    return (
        <div className="cf7apps-right-bar">
            {
                isLoading
                ?
                <div>
                    <CF7AppsSkeletonLoader count={1} height={221} width={180} />
                </div>
                :
                <a href="https://postmansmtp.com/pricing/?utm_source=CF7_Perks&utm_medium=Banner&utm_id=CF7_Perks_Baner&utm_content=side_banner" target="_blank">
                    <img src={`${CF7Apps.assetsURL}/images/ad-1.png`} alt="Right Bar" width="100%" />
                </a>
            }
        </div>
    );
}

export default RightBar;