<?php
// Advanced Custom Fields: Table Field
// https://wordpress.org/plugins/advanced-custom-fields-table-field/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Support for table field
echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method} ( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
echo $this->indent . htmlspecialchars("<?php if ( \${$this->var_name} ) : ?>\n");
echo $this->indent . htmlspecialchars("	<table>\n");
echo $this->indent . htmlspecialchars("		<?php if ( \${$this->var_name}['caption'] ) : ?>\n");
echo $this->indent . htmlspecialchars("			<caption><?php echo esc_html( \${$this->var_name}['caption'] ); ?></caption>\n");
echo $this->indent . htmlspecialchars("		<?php endif; ?>\n");
echo $this->indent . htmlspecialchars("		<?php if ( \${$this->var_name}['header'] ) : ?>\n");
echo $this->indent . htmlspecialchars("			<thead>\n");
echo $this->indent . htmlspecialchars("				<tr>\n");
echo $this->indent . htmlspecialchars("					<?php foreach ( \${$this->var_name}['header'] as \$th ) : ?>\n");
echo $this->indent . htmlspecialchars("						<th><?php echo esc_html( \$th['c'] ); ?></th>\n");
echo $this->indent . htmlspecialchars("					<?php endforeach; ?>\n");
echo $this->indent . htmlspecialchars("				</tr>\n");
echo $this->indent . htmlspecialchars("			</thead>\n");
echo $this->indent . htmlspecialchars("		<?php endif; ?>\n");
echo $this->indent . htmlspecialchars("		<tbody>\n");
echo $this->indent . htmlspecialchars("			<?php foreach ( \${$this->var_name}['body'] as \$tr ) : ?>\n");
echo $this->indent . htmlspecialchars("				<tr>\n");
echo $this->indent . htmlspecialchars("					<?php foreach ( \$tr as \$td ) : ?>\n");
echo $this->indent . htmlspecialchars("						<td><?php echo esc_html( \$td['c'] ); ?></td>\n");
echo $this->indent . htmlspecialchars("					<?php endforeach; ?>\n");
echo $this->indent . htmlspecialchars("				</tr>\n");
echo $this->indent . htmlspecialchars("			<?php endforeach; ?>\n");
echo $this->indent . htmlspecialchars("		</tbody>\n");
echo $this->indent . htmlspecialchars("	</table>\n");
echo $this->indent . htmlspecialchars("<?php endif; ?>\n");
