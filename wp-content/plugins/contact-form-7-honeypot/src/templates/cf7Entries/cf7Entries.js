import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import CF7AppsSkeletonLoader from '../../components/CF7AppsSkeletonLoader';
import CF7AppsPopup from '../../components/CF7AppsPopup';
import { deleteCF7Entries, getCF7Entries, getAllCF7Forms } from '../../api/api';
import CF7AppsSelectField from '../../components/CF7AppsSelectField';
import CF7AppsTextField from "../../components/CF7AppsTextField";
import CF7AppsCalendar from '../../components/CF7AppsCalendar';
import { toast } from 'react-toastify';
import { DeleteOutlined, VisibilityOutlined, CalendarMonthOutlined } from '@mui/icons-material';

/**
 * CF7Entries Component
 *
 * @since 3.1.0
 */
const Cf7Entries = () => {

    const [ cf7entries, setCf7entries ]     = useState( false );
    const [ loading, setLoading ]           = useState( false );
    const [ showDetails, setShowDetails ]   = useState( false );
    const [ entryData, setEntryData ]       = useState( false );
    const [ totalEntries, setTotalEntries ] = useState( 0 );
    const [ currentPage, setCurrentPage ]   = useState( 1 );
    const [ searchParam, setSearchParam ]   = useState( { form_id: 0, search: '' } );
    const [ forms, setForms ] = useState( {} );
    const [ selectedDate, setSelectedDate ] = useState( '' );
    const [ dateRange, setDateRange ] = useState( {
        startDate: new Date(),
        endDate: new Date(),
        key: 'selection',
    } );

    useEffect(() => {
        async function fetchEntries() {
            setLoading(true);

            const entries  = await getCF7Entries();
            const cf7forms = await getAllCF7Forms();

            setCf7entries( entries.entries );
            setTotalEntries( entries.total );
            setForms( cf7forms );

            setLoading( false );
        }

        fetchEntries();
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('page') === 'cf7apps' && urlParams.get('tab').startsWith('entries') ) {
            const submenuItems = document.querySelectorAll('#toplevel_page_wpcf7 .wp-submenu li');
            submenuItems.forEach(li => li.classList.remove('current'));
            const entriesMenu = Array.from(document.querySelectorAll('#toplevel_page_wpcf7 .wp-submenu a'))
                .find(link => link.textContent.trim() === 'Entries');
            if (entriesMenu) {
                entriesMenu.parentElement.classList.add('current');
            }
        }
    }, []);

    let handleViewButton = ( e, data ) => {
        e.preventDefault();
        setShowDetails( true );
        setEntryData( data );
    };
    let handleDeleteButton = ( e, id ) => {
        e.preventDefault();

        if ( ! confirm( __( 'Are you sure you want to delete this entry?', 'cf7apps' ) ) ) {
            return;
        }

        setLoading( true );

        deleteCF7Entries( [ id ] )
            .then( ( response ) => {
                if ( response ) {
                    toast.success( __( 'Entry deleted successfully', 'cf7apps' ) );
                    // Refresh the entries list
                    getCF7Entries( { page: currentPage, perPage: 10 } )
                        .then( ( entries ) => {
                            setCf7entries( entries.entries );
                            setTotalEntries( entries.total );
                        } )
                } else {
                    toast.error( __( 'Failed to delete entry', 'cf7apps' ) );
                }
            } )
            .catch( ( error ) => {
                toast.error( __( 'An error occurred while deleting the entry', 'cf7apps' ) );
            } );
    }

    let checkAllEntries = ( e ) => {
        const checkboxes = document.querySelectorAll( 'input[type="checkbox"]' );
        checkboxes.forEach( checkbox => {
            checkbox.checked = e.target.checked;
        } );
    }

    let handleBulkAction = ( action, entries ) => {
        if ( 'null' === action ) {
            toast.error( __( 'Please select an action', 'cf7apps' ) );
            return;
        }

        if ( 'delete' === action ) {
            if ( ! confirm( __( 'Are you sure you want to delete the selected entries?', 'cf7apps' ) ) ) {
                return;
            }

            deleteCF7Entries( entries )
                .then( ( response ) => {
                    if ( response ) {
                        toast.success( __( 'Entries deleted successfully', 'cf7apps' ) );
                        // Refresh the entries list
                        getCF7Entries()
                            .then( ( entries ) => {
                                setCf7entries( entries.entries );
                                setTotalEntries( entries.total );
                                // Uncheck the select all checkbox
                                document.querySelectorAll( 'input[type="checkbox"]' ).forEach( checkbox => {
                                    checkbox.checked = false;
                                } );
                            } )
                    } else {
                        toast.error( __( 'Failed to delete entries', 'cf7apps' ) );
                    }
                } )
                .catch( ( error ) => {
                    toast.error( __( 'An error occurred while deleting entries', 'cf7apps' ) );
                } );
        }


    }

    let handleSearchFrom = ( type, value ) => {
        if ( 'form' === type ) {
            searchParam['form_id'] = value;
            setSearchParam( searchParam )
        }

        if ( 'text' === type ) {
            searchParam['search'] = value;
            setSearchParam( searchParam );
        }

        if ( 'daterange' === type ) {
            setDateRange( value );
            searchParam['start_date'] = value.startDate.toISOString().split('T')[0];
            searchParam['end_date']   = value.endDate.toISOString().split('T')[0];
            setSearchParam( searchParam );
        }

        var entryParams = { page: currentPage, perPage: 10, search: searchParam.search, form_id: searchParam.form_id, start_date: searchParam.start_date, end_date: searchParam.end_date };

        getCF7Entries( entryParams )
            .then( ( entries ) => {
                setCf7entries( entries.entries );
                setTotalEntries( entries.total );
            } );
    };

    let handleDateRangeSelect = ( e ) => {
        handleSearchFrom( 'daterange', e.selection );
        var start_date = new Date( e.selection.startDate );
        var end_date   = new Date( e.selection.endDate );
        start_date = start_date.toLocaleString( 'en-US', { month: 'short', day: 'numeric', year: 'numeric' } );
        end_date   = end_date.toLocaleString( 'en-US', { month: 'short', day: 'numeric', year: 'numeric' } );
        setSelectedDate( start_date + ' - ' + end_date );
    }

    const CF7AppsPagination = ( { totalEntries } ) => {
        let pages = Math.ceil( totalEntries / 10 );
        // if pages = NaN or 0 or 1 then return null
        if ( ! pages || pages === 1 ) {
            pages = 1;
        }

        const handlePageClick = ( page ) => {
            getCF7Entries( {
                page: page,
                perPage: 10,
                search: searchParam.search,
                form_id: searchParam.form_id,
                start_date: searchParam.start_date,
                end_date: searchParam.end_date
            } ).then( ( entries ) => {
                setCurrentPage(page);
                setCf7entries( entries.entries );
            } );
        }

        const paginationItems = [];

        if ( totalEntries ) {
            if ( pages <= 5 ) {
                for ( let i = 1; i <= pages; i++ ) {
                    paginationItems.push(
                        <Button
                            key={ i }
                            className={ currentPage === i ? 'cf7apps-btn tertiary-secondary' : '' }
                            onClick={ () => handlePageClick( i ) }
                        >{ i }</Button>
                    );
                }
            } else {
                paginationItems.push(
                    <Button
                        key={ 1 }
                        className={ currentPage === 1 ? 'cf7apps-btn tertiary-secondary' : '' }
                        onClick={ () => handlePageClick( 1 ) }
                    >1</Button>
                );

                if ( currentPage > 3 ) {
                    paginationItems.push(
                        <Button key={ 'start-ellipsis' }>...</Button>
                    );
                }

                for ( let i = Math.max(2, currentPage - 1 ); i <= Math.min( pages -1, currentPage + 1 ); i++ ) {
                    paginationItems.push(
                        <Button
                            key={ i }
                            className={ currentPage === i ? 'cf7apps-btn tertiary-secondary' : '' }
                            onClick={ () => handlePageClick( i ) }
                        >{ i }</Button>
                    );
                }

                if ( currentPage < pages - 2 ) {
                    paginationItems.push(
                        <Button key={ 'end-ellipsis' } disabled>...</Button>
                    );
                }

                paginationItems.push(
                    <Button
                        key={ pages }
                        className={ currentPage === pages ? 'cf7apps-btn tertiary-secondary' : '' }
                        onClick={ () => handlePageClick( pages ) }
                    >{ pages }</Button>
                );
            }
        }

        return (
            <div className={ 'cf7apps-entries-pagination' }>
                <Button
                    className={ 'cf7apps-btn tertiary-secondary' }
                    disabled={ currentPage === 1 }
                    onClick={ () => handlePageClick( currentPage - 1 ) }
                >&lt;</Button>

                { paginationItems }

                <Button
                    className={ 'cf7apps-btn tertiary-secondary' }
                    disabled={ currentPage === pages }
                    onClick={ () => handlePageClick( currentPage + 1 ) }
                >&gt;</Button>
            </div>
        );
    };

    return (
        ! loading ?
                <div className={ 'cf7apps-template-cf7-entries' }>

                    {
                        showDetails && entryData && (
                            <CF7AppsPopup title={ __( 'Email Details', 'cf7apps' ) } onClose={ () => setShowDetails( false ) }>
                                <p className={ 'cf7apps-entry-date' }>
                                    <CalendarMonthOutlined style={ { marginBottom: '-2px', marinRight: '5px', } } fontSize={ '14px' } />
                                    { entryData.date_time }
                                </p>

                                <div className="cf7apps-template-cf7-entries">
                                    <table width={ '100%' }>
                                        <thead>
                                        <tr>
                                            <th style={ { textAlign: 'left' } }>{ __( 'Fields', 'cf7apps' ) }</th>
                                            <th style={ { textAlign: 'left' } }>{ __( 'Values', 'cf7apps' ) }</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        {
                                            entryData.data && Object.keys( entryData.data ).length > 0 ? (
                                                Object.keys( entryData.data ).map( ( key ) => {
                                                    return (
                                                        <tr key={ key }>
                                                            <td style={ { textAlign: 'left' } }>{ key }</td>
                                                            <td style={ { textAlign: 'left' } }>{ entryData.data[ key ] }</td>
                                                        </tr>
                                                    );
                                                } )
                                            ) : (
                                                <tr>
                                                    <td colSpan={ '2' }>{ __( 'No data found.', 'cf7apps' ) }</td>
                                                </tr>
                                            )
                                        }
                                        </tbody>
                                    </table>
                                </div>
                            </CF7AppsPopup>
                        )
                    }

                    <div className={ 'cf7apps-table-nav cf7apps-nav-header' }>

                        <div className={ 'cf7apps-bulk-action cf7apps-left' }>

                            <CF7AppsSelectField
                                className={ 'cf7apps-bulk-action-select-field' }
                                selected={ 'null' }
                                options={ {
                                    'null'   : __( 'Bulk Actions' ),
                                    'delete' : __( 'Delete', 'cf7apps' ),
                                } }
                            />

                            <Button
                                className={ 'cf7apps-btn tertiary-primary cf7apps-bulk-action-field' }
                                onClick={ () => {
                                    const selectedEntries = document.querySelectorAll( '.cf7apps-entry-checkbox:checked' );
                                    if ( selectedEntries.length === 0 ) {
                                        toast.error( __( 'Please select at least one entry', 'cf7apps' ) );
                                        return;
                                    }

                                    let entries = [];
                                    selectedEntries.forEach( entry => {
                                        entries.push( entry.value );
                                    } );

                                    const action = document.querySelector( '.cf7apps-bulk-action-select-field' ).value;
                                    handleBulkAction( action, entries );
                                } }
                            >{ __( 'Apply', 'cf7apps' ) }</Button>

                        </div>

                        <div className={ 'cf7apps-right cf7apps-filter' }>
                            <CF7AppsSelectField
                                className={ 'cf7apps-filter-select-field' }
                                selected={ searchParam.form_id }
                                options={ forms }
                                onChange={ e => handleSearchFrom( 'form', e.target.value ) }
                            />

                            <CF7AppsTextField
                                className={ 'cf7apps-filter-text-field' }
                                placeholder={ __( 'Search Form', 'cf7apps' ) }
                                onChange={ ( e ) => handleSearchFrom( 'text', e.target.value ) }
                            />

                            <CF7AppsCalendar
                                selectedDate={ selectedDate }
                                selection={ [ dateRange ] }
                                onSelect={ handleDateRangeSelect }
                                placeHolder={ __( 'Select Date Range', 'cf7apps' ) }
                            />

                            <Button
                                style={ { marginLeft: '10px' } }
                                onClick={ () => {
                                    setSearchParam( { form_id: 0, search: '' } );
                                    setSelectedDate( '' );
                                    document.querySelector( '.cf7apps-filter-select-field' ).value = 0;
                                    document.querySelector( '.cf7apps-filter-text-field' ).value = '';
                                    setDateRange( {
                                        startDate: new Date(),
                                        endDate: new Date(),
                                        key: 'selection',
                                    } );
                                    getCF7Entries( { page: currentPage, perPage: 10 } )
                                        .then( ( entries ) => {
                                            setCf7entries( entries.entries );
                                            setTotalEntries( entries.total );
                                        } );
                                } }
                                className={ 'cf7apps-btn tertiary-secondary' }
                            >{ __( 'Clear Filter', 'cf7apps' ) }</Button>


                        </div>

                    </div>

                    <table width="100%">
                        <thead>
                        <tr>
                            <th>
                                <input
                                    type={ 'checkbox' }
                                    onChange={ checkAllEntries }
                                />
                            </th>
                            <th>{ __( 'Form Name', 'cf7apps' ) }</th>
                            <th>{ __( 'Email', 'cf7apps' ) }</th>
                            <th>{ __( 'Date & Time', 'cf7apps' ) }</th>
                            <th>{ __( 'Action', 'cf7apps' ) }</th>
                        </tr>
                        </thead>

                        <tbody>
                        {
                            cf7entries && cf7entries.length > 0 ? (
                                <>
                                    { cf7entries.map( ( entry ) => {
                                        return (
                                            <tr key={ entry.id }>
                                                <td>
                                                    <input className={ 'cf7apps-entry-checkbox' } value={ entry.id } type={ 'checkbox' } />
                                                </td>
                                                <td>{ entry.form_name }</td>
                                                <td>{ entry.email }</td>
                                                <td>{ entry.date_time }</td>
                                                <td>
                                                    <span style={ { marginRight: '10px' } }>
                                                        <a onClick={ e => handleViewButton( e, entry ) } href={ '#' }>
                                                            <VisibilityOutlined fontSize={ '20px' } style={ { marginBottom: '-2px', marginRight: '5px', } } />
                                                            { __( 'View', 'cf7apps' ) }
                                                        </a>
                                                    </span>
                                                    <span style={ { marginRight: '10px' } }>
                                                        <a onClick={ e => handleDeleteButton( e, entry.id ) } href={ '#' }>
                                                            <DeleteOutlined fontSize={ '20px' } style={ { marginBottom: '-2px', marginRight: '5px', } } />
                                                            { __( 'Delete', 'cf7apps' ) }
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                        );
                                    } ) }
                                </>
                            ) : (
                                <tr>
                                    <td colSpan={ '4' }>{ __( 'No records found.', 'cf7apps' ) }</td>
                                </tr>
                            )
                        }
                        </tbody>
                    </table>

                    <div className={ 'cf7apps-table-nav cf7apps-nav-footer' }>

                        <div className="cf7apps-left">
                            <p className="cf7apps-datatable-count">
                                { __( 'Showing', 'cf7apps' ) } <b>{ cf7entries ? cf7entries.length : 0 }</b> of <b>{ totalEntries }</b> { __( 'entries', 'cf7apps' ) } | { __( 'Page', 'cf7apps' ) } <b>{ currentPage }</b>
                            </p>
                        </div>
                        <div className="cf7apps-right">
                            <CF7AppsPagination
                                totalEntries={ totalEntries }
                            />
                        </div>

                    </div>
                </div>
            :
            <>
                <CF7AppsSkeletonLoader count={ 1 } height={ 38 } />
                <CF7AppsSkeletonLoader count={ 2 } height={ 57 } />
            </>
    );
}

export default Cf7Entries;