import { useEffect, useState } from "@wordpress/element";
import CF7AppsSkeletonLoader from "../components/CF7AppsSkeletonLoader";
import { getMenu } from "../api/api";
import { Accordion, AccordionDetails, AccordionSummary, Typography } from "@mui/material";
import { NavLink } from "react-router";

const MenuBar = (props) => {
    const [isLoading, setIsLoading] = useState(true);
    const [menuItems, setMenuItems] = useState([]);

    useEffect( () => {
        async function fetchMenu() {
            setIsLoading(true);
            const response = await getMenu();
            if(response) {
                setMenuItems(response);
                setIsLoading(false);
            }
        }

        fetchMenu();
    }, []);

    const getParentMenu = (menu) => {
        switch (menu) {
            case 'Spam Protection':
                return (
                    <>
                        <img src={`${CF7Apps.assetsURL}/images/spam-protection.png`} width="23px" alt={menu} /> { menu }
                    </>
                );
            default:
                return menu;
        }
    }

    return (
        <>
            <div className="cf7apps-menu-bar">
            {
                isLoading
                ?
                <div style={{ padding: '20px', paddingTop: '5px' }}>
                    <CF7AppsSkeletonLoader count={1} height={40} width={205} />
                    <br />
                    <CF7AppsSkeletonLoader count={1} height={30} />
                    <br />
                    <CF7AppsSkeletonLoader count={1} height={20} />
                    <br />
                    <CF7AppsSkeletonLoader count={1} height={20} />
                    <br />
                    <CF7AppsSkeletonLoader count={1} height={20} />
                </div>
                :
                <div>
                    <div className="cf7apps-menu-container">
                        {
                            Object.keys(menuItems).map((parentMenu, parentIndex) => {
                                return (
                                    <Accordion key={parentIndex} defaultExpanded expanded={true} className="cf7apps-menu-accordion">
                                        <AccordionSummary
                                            expandIcon={false}
                                            >
                                                <Typography component="span" className="cf7apps-menu-heading">
                                                    { getParentMenu(parentMenu) }
                                                </Typography>
                                            </AccordionSummary>
                                            <AccordionDetails className="cf7apps-menu-routes-container">
                                                {
                                                    Object.entries(menuItems[parentMenu]).map(([route, subMenu], subMenuIndex) => {
                                                        return (
                                                            <div className='cf7apps-menu-route'>
                                                                <NavLink to={`/settings/${route}`}>{ subMenu }</NavLink>
                                                            </div>
                                                        )
                                                    })
                                                }
                                            </AccordionDetails>
                                    </Accordion>
                                )
                            })
                        }
                    </div>
                </div>
            }
            </div>
        </>
    );
}

export default MenuBar;