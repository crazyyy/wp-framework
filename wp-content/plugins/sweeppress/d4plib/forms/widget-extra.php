<h4><?php esc_html_e( "Before and After Content", "d4plib" ); ?></h4>
<table>
    <tbody>
    <tr>
        <td class="cell-singular">
            <label for="<?php echo $this->get_field_id( '_before' ); ?>"><?php esc_html_e( "Before", "d4plib" ); ?>:</label>
            <textarea class="widefat half-height" id="<?php echo $this->get_field_id( '_before' ); ?>" name="<?php echo $this->get_field_name( '_before' ); ?>"><?php echo esc_textarea( $instance[ '_before' ] ); ?></textarea>
        </td>
    </tr>
    <tr>
        <td class="cell-singular">
            <label for="<?php echo $this->get_field_id( '_after' ); ?>"><?php esc_html_e( "After", "d4plib" ); ?>:</label>
            <textarea class="widefat half-height" id="<?php echo $this->get_field_id( '_after' ); ?>" name="<?php echo $this->get_field_name( '_after' ); ?>"><?php echo esc_textarea( $instance[ '_after' ] ); ?></textarea>
        </td>
    </tr>
    </tbody>
</table>

<h4><?php esc_html_e( "For Developers", "d4plib" ); ?></h4>
<table>
    <tbody>
    <tr>
        <td class="cell-singular">
            <label for="<?php echo $this->get_field_id( '_devid' ); ?>"><?php esc_html_e( "Developer ID", "d4plib" ); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( '_devid' ); ?>" name="<?php echo $this->get_field_name( '_devid' ); ?>" type="text" value="<?php echo esc_attr( $instance[ '_devid' ] ); ?>"/>

            <em>
				<?php esc_html_e( "This is custom string (alphanumeric, underscore and minus signs allowed) that can be used to identify the widget in code, and it can be useful for developers customizing the website.", "d4plib" ); ?>
            </em>
        </td>
    </tr>
    </tbody>
</table>
