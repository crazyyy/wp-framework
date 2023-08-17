<?php

$shortcode_notice = $this->get_shortcode_notice();

?>

<h4><?php esc_html_e( "Widget as a Shortcode", "d4plib" ); ?></h4>
<table>
    <tbody>
    <tr>
        <td class="cell-singular">
            <p><?php esc_html_e( "This widget has a shortcode equivalent with all the same settings. The shortcode is displayed below, and you can copy and use it in your posts or pages. This shortcode reflects latest saved widget settings - if you make changes to widget settings, save it, before getting shortcode from this tab.", "d4plib" ); ?></p>
            <p><?php esc_html_e( "Shortcode doesn't include options from 'Extra' and 'Advanced' settings tabs, and it doesn't include 'Title' for the widget.", "d4plib" ); ?></p>
        </td>
    </tr>
    <tr>
        <td class="cell-singular">
            <div class="cell-shortcode">
                [<?php echo esc_html( $this->shortcode_name ); ?> <?php echo $this->the_shortcode( $instance ); ?>]
            </div>
        </td>
    </tr>
	<?php if ( ! empty( $shortcode_notice ) ) { ?>
        <tr>
            <td class="cell-singular">
                <h5><?php esc_html_e( "Notice", "d4plib" ); ?>:</h5>
				<?php echo $shortcode_notice; ?>
            </td>
        </tr>
	<?php } ?>
    </tbody>
</table>