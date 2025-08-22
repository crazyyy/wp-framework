import { __ } from "@wordpress/i18n";
import { Route, Routes } from "react-router";
import Apps from "../screens/Apps";
import AppSettings from "../screens/AppSettings";

const Body = () => {
    return (
        <Routes>
            <Route path='/' element={<Apps />} />
            <Route path='/:parent' element={<Apps />} />
            <Route path="/settings">
                <Route path=':app' element={<AppSettings />} />
            </Route>
        </Routes>
    );
}

export default Body;