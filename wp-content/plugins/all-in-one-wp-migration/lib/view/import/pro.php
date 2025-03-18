<?php
/**
 * Copyright (C) 2014-2025 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Attribution: This code is part of the All-in-One WP Migration plugin, developed by
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}
?>

<p class="max-upload-size">
	<?php printf( __( 'Your host restricts uploads to <strong>%s</strong>.', AI1WM_PLUGIN_NAME ), esc_html( ai1wm_size_format( wp_max_upload_size() ) ) ); ?>
	<?php
		printf(
			__( 'Our <a href="%s" target="_blank">Unlimited Extension</a> bypasses this!', AI1WM_PLUGIN_NAME ),
			'https://servmask.com/products/unlimited-extension?utm_source=below-drag-drop&utm_medium=plugin&utm_campaign=ai1wm'
		);
		?>
</p>
<p>
	<?php
		printf(
			__( 'If you prefer a manual fix, follow our step-by-step guide on <a href="%s" target="_blank">raising your upload limit</a>.', AI1WM_PLUGIN_NAME ),
			'https://help.servmask.com/2018/10/27/how-to-increase-maximum-upload-file-size-in-wordpress/'
		);
		?>
</p>
