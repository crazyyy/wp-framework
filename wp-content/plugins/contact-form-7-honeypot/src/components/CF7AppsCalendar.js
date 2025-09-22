import { useState } from "@wordpress/element";
import { DateRangePicker } from 'react-date-range';

const CF7AppsCalendar = ( { selection, onSelect, selectedDate, placeHolder } ) => {
    const [ active, setActive ] = useState( false );
    let handleSelect = ( e ) => {
        onSelect( e );
    }

    // close the calendar when clicking outside
    document.addEventListener( 'click', ( e ) => {
        if ( active && ! e.target.closest( '.cf7apps-calendar-wrapper' ) ) {
            setActive( false );
        }
    } );
    return (
        <div className={ 'cf7apps-calendar-wrapper' } style={ { display: "inline-block", position: 'relative' } } >
            <input
                type="text"
                onClick={ e => { e.preventDefault(); setActive( ! active ) } }
                readOnly
                className={`cf7apps-form-input`}
                value={ selectedDate }
                placeholder={ placeHolder }
            />
            {
                active && (
                    <div style={ { position: 'absolute', top: '40px', right: 0, zIndex: 1000 } }>
                        <DateRangePicker
                            onChange={ handleSelect }
                            ranges={ selection }
                        />
                    </div>
                )
            }
        </div>
    )
}

export default CF7AppsCalendar;