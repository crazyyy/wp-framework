<h4><?php esc_html_e( "Results Caching", "d4plib" ); ?></h4>
<table>
    <tbody>
    <tr>
        <td class="cell-singular">
            <label for="<?php echo $this->get_field_id( '_cached' ); ?>"><?php esc_html_e( "Cache Period", "d4plib" ); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( '_cached' ); ?>" name="<?php echo $this->get_field_name( '_cached' ); ?>" type="number" min="0" step="1" value="<?php echo esc_attr( $instance[ '_cached' ] ); ?>"/>

            <em>
				<?php esc_html_e( "To use cache and speed up the widget, enter number of hours for cached results to be kept. Leave 0 to disable cache.", "d4plib" ); ?>
            </em>
        </td>
    </tr>
    </tbody>
</table>
