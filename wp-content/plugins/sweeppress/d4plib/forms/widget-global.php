<h4><?php esc_html_e( "Basic", "d4plib" ); ?></h4>
<table>
    <tbody>
    <tr>
        <td class="cell-singular">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( "Title", "d4plib" ); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>"/>
        </td>
    </tr>
    <tr>
        <td class="cell-singular" colspan="2">
            <label for="<?php echo $this->get_field_id( '_class' ); ?>"><?php esc_html_e( "Additional CSS Class", "d4plib" ); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( '_class' ); ?>" name="<?php echo $this->get_field_name( '_class' ); ?>" type="text" value="<?php echo esc_attr( $instance[ '_class' ] ); ?>"/>
        </td>
    </tr>
    </tbody>
</table>
