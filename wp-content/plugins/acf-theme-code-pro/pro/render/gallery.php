<?php
// Gallery field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$return_format = isset( $this->settings['return_format'] ) ? $this->settings['return_format'] : '';

if ( $return_format == 'array' ) {
    echo $this->indent . htmlspecialchars("<?php \$".$this->var_name."_images = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>"."\n");
    echo $this->indent . htmlspecialchars("<?php if ( \$".$this->var_name."_images ) :  ?>")."\n";
    echo $this->indent . htmlspecialchars("	<?php foreach ( \$".$this->var_name."_images as \$".$this->var_name."_image ): ?>")."\n";
    echo $this->indent . htmlspecialchars("		<a href=\"<?php echo esc_url( \$".$this->var_name."_image['url'] ); ?>\">")."\n";
    echo $this->indent . htmlspecialchars("			<img src=\"<?php echo esc_url( \$".$this->var_name."_image['sizes']['thumbnail'] ); ?>\" alt=\"<?php echo esc_attr( \$".$this->var_name."_image['alt'] ); ?>\" />")."\n";
    echo $this->indent . htmlspecialchars("		</a>")."\n";
    echo $this->indent . htmlspecialchars("		<p><?php echo esc_html( \$".$this->var_name."_image['caption'] ); ?></p>")."\n";
    echo $this->indent . htmlspecialchars("	<?php endforeach; ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php endif; ?>"."\n");
}

if ( $return_format == 'url' ) {
    echo $this->indent . htmlspecialchars("<?php \$".$this->var_name."_urls = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>"."\n");
    echo $this->indent . htmlspecialchars("<?php if ( \$".$this->var_name."_urls ) :  ?>")."\n";
    echo $this->indent . htmlspecialchars("	<?php foreach ( \$".$this->var_name."_urls as \$".$this->var_name."_url ): ?>")."\n";
    echo $this->indent . htmlspecialchars("		<img src=\"<?php echo esc_url( \$".$this->var_name."_url ); ?>\" />\n");
    echo $this->indent . htmlspecialchars("	<?php endforeach; ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php endif; ?>"."\n");
}

if ( $return_format == 'id' ) {
    echo $this->indent . htmlspecialchars("<?php \$".$this->var_name."_ids = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>"."\n");
	echo $this->indent . htmlspecialchars("<?php \$size = 'thumbnail'; ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php if ( \$".$this->var_name."_ids ) :  ?>")."\n";
    echo $this->indent . htmlspecialchars("	<?php foreach ( \$".$this->var_name."_ids as \$".$this->var_name."_id ): ?>")."\n";
    echo $this->indent . htmlspecialchars("		<?php echo wp_get_attachment_image( \$".$this->var_name."_id, \$size ); ?>")."\n";
    echo $this->indent . htmlspecialchars("	<?php endforeach; ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php endif; ?>"."\n");
}
