import 'react-loading-skeleton/dist/skeleton.css';
import Skeleton from "react-loading-skeleton";

const CF7AppsSkeletonLoader = ({ height, count, width }) => {
    return (
        <Skeleton height={height} count={count} width={width} baseColor="#d9e4ea" highlightColor="#f1f7fb" />
    );
}

export default CF7AppsSkeletonLoader;