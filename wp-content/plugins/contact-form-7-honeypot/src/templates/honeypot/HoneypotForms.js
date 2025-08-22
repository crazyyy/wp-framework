import { useEffect, useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n"
import { getCF7Forms } from "../../api/api";
import { EditOutlined } from "@mui/icons-material";
import { Button } from "@wordpress/components";
import CF7AppsSkeletonLoader from "../../components/CF7AppsSkeletonLoader";

const CF7AppsHoneypotForms = () => {
    const [cf7forms, setCF7Forms] = useState(false);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        async function fetchForms() {
            setLoading(true);
            const forms = await getCF7Forms();

            setCF7Forms(forms);
            setLoading(false);
        }

        fetchForms();
    }, []);

    return (
        ! loading ?
            <div className="cf7apps-template-honeypot-forms">
                <table width="100%">
                    <thead>
                        <tr>
                            <th>{ __( 'Title', 'cf7apps' ) }</th>
                            <th>{ __( 'Shortcode', 'cf7apps' ) }</th>
                            <th>{ __( 'Honeypot', 'cf7apps' ) }</th>
                            <th>{ __( 'Date', 'cf7apps' ) }</th>
                            <th>{ __( 'Action', 'cf7apps' ) }</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            cf7forms && cf7forms.length > 0 ? (
                                cf7forms.map((form) => {
                                    return (
                                        <tr key={ form.id }>
                                            <td>{ form.title }</td>
                                            <td>{ form.shortcode }</td>
                                            <td>{ form.honeypot }</td>
                                            <td>{ form.date }</td>
                                            <td><Button href={ form.action } className="cf7apps-btn"><EditOutlined /> { __( 'Edit', 'cf7apps' ) }</Button></td>
                                        </tr>
                                    );
                                })
                            ) : (
                                <tr>
                                    <td colSpan="5">{ __( 'No forms found.', 'cf7apps' ) }</td>
                                </tr>
                            )
                        }
                    </tbody>
                </table>
            </div>
        :
        <>
            <CF7AppsSkeletonLoader count={ 1 } height={ 38 } />
            <CF7AppsSkeletonLoader count={ 2 } height={ 57 } />
        </>
    );
}

export default CF7AppsHoneypotForms;