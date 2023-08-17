<?php

/*
Name:    Dev4Press\v42\Core\UI\Icons
Version: v4.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com/

== Copyright ==
Copyright 2008 - 2023 Milan Petrovic (email: support@dev4press.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

namespace Dev4Press\v42\Core\UI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Icons {
	protected $base = 'd4p-icon';
	protected $prefix = 'd4p-';
	protected $prefix_control = 'd4p-icon-';

	protected $icons = array(
		'brand-deviantart',
		'brand-facebook',
		'brand-github',
		'brand-github-alt',
		'brand-gravityforms',
		'brand-instagram',
		'brand-linkedin',
		'brand-reddit',
		'brand-stack-exchange',
		'brand-stack-overflow',
		'brand-twitter',
		'brand-wordpress',
		'brand-youtube',
		'club-bbpress',
		'club-dev4press',
		'club-gd-bbpress-club',
		'club-gd-dev4press-plugins',
		'club-gd-rating-club',
		'club-icon-bbpress',
		'club-icon-dev4press',
		'club-icon-gd-bbpress-club',
		'club-icon-gd-dev4press-plugins',
		'club-icon-gd-rating-club',
		'club-icon-rating',
		'club-rating',
		'file-archive',
		'file-blank',
		'file-certificate',
		'file-chart-line',
		'file-contract',
		'file-export',
		'file-import',
		'file-lock',
		'file-signature',
		'file-spreadsheet',
		'file-text',
		'logo-bbpress',
		'logo-buddypress',
		'logo-dev4press',
		'logo-dev4press-full',
		'logo-dev4press-full-fill',
		'logo-dev4press-light',
		'logo-jquery',
		'logo-php',
		'logo-woo',
		'plugin-archivespress',
		'plugin-breadcrumbspress',
		'plugin-coreactivity',
		'plugin-coresecurity',
		'plugin-coreseo',
		'plugin-coresocial',
		'plugin-debugpress',
		'plugin-demopress',
		'plugin-dev4press-updater',
		'plugin-gd-bbpress-attachments',
		'plugin-gd-bbpress-toolbox',
		'plugin-gd-bbpress-tools',
		'plugin-gd-content-tools',
		'plugin-gd-forum-manager',
		'plugin-gd-forum-manager-for-bbpress',
		'plugin-gd-forum-notices',
		'plugin-gd-forum-notices-for-bbpress',
		'plugin-gd-knowledge-base',
		'plugin-gd-mail-queue',
		'plugin-gd-members-directory',
		'plugin-gd-members-directory-for-bbpress',
		'plugin-gd-pages-navigator',
		'plugin-gd-power-search',
		'plugin-gd-power-search-for-bbpress',
		'plugin-gd-power-search-for-bbpress-lite',
		'plugin-gd-press-tools',
		'plugin-gd-quantum-theme',
		'plugin-gd-quantum-theme-for-bbpress',
		'plugin-gd-rating-system',
		'plugin-gd-rating-system-lite',
		'plugin-gd-security-headers',
		'plugin-gd-security-toolbox',
		'plugin-gd-seo-toolbox',
		'plugin-gd-topic-polls',
		'plugin-gd-topic-polls-for-bbpress',
		'plugin-gd-topic-polls-lite',
		'plugin-gd-topic-prefix',
		'plugin-gd-topic-prefix-for-bbpress',
		'plugin-sweeppress',
		'ui-alarm',
		'ui-analytics',
		'ui-angles-down',
		'ui-angles-left',
		'ui-angles-right',
		'ui-angles-up',
		'ui-archive',
		'ui-arrow-down',
		'ui-arrow-left',
		'ui-arrow-right',
		'ui-arrow-up',
		'ui-arrows-v',
		'ui-assistive-listening-systems',
		'ui-badge',
		'ui-badge-check',
		'ui-badge-percent',
		'ui-barcode',
		'ui-bars',
		'ui-bee',
		'ui-bell',
		'ui-bell-school',
		'ui-book',
		'ui-book-spells',
		'ui-bookmark',
		'ui-box',
		'ui-brackets',
		'ui-briefcase',
		'ui-browser',
		'ui-bug',
		'ui-bullhorn',
		'ui-cabinet',
		'ui-cake-candles',
		'ui-calendar',
		'ui-calendar-day',
		'ui-calendar-pen',
		'ui-camera',
		'ui-camera-movie',
		'ui-cancel',
		'ui-candy',
		'ui-caret-down',
		'ui-caret-left',
		'ui-caret-right',
		'ui-caret-up',
		'ui-certificate',
		'ui-chart-area',
		'ui-chart-bar',
		'ui-chart-line',
		'ui-chart-network',
		'ui-chart-pie',
		'ui-check',
		'ui-check-square',
		'ui-chevron-down',
		'ui-chevron-left',
		'ui-chevron-right',
		'ui-chevron-square-down',
		'ui-chevron-square-left',
		'ui-chevron-square-right',
		'ui-chevron-square-up',
		'ui-chevron-up',
		'ui-clear',
		'ui-clipboard-list',
		'ui-clock',
		'ui-close-square',
		'ui-cloud',
		'ui-cloud-download',
		'ui-cloud-upload',
		'ui-code',
		'ui-code-rec',
		'ui-cog',
		'ui-cog-slash',
		'ui-cogs',
		'ui-columns',
		'ui-comment',
		'ui-comment-dots',
		'ui-comments',
		'ui-comments-question',
		'ui-copy',
		'ui-dashboard',
		'ui-database',
		'ui-desktop',
		'ui-dots-square',
		'ui-download',
		'ui-droplet',
		'ui-edit',
		'ui-elephant',
		'ui-envelope',
		'ui-envelope-open',
		'ui-envelopes',
		'ui-eraser',
		'ui-exclamation',
		'ui-exclamation-square',
		'ui-external-link',
		'ui-eye',
		'ui-eye-slash',
		'ui-filter',
		'ui-filters',
		'ui-flag',
		'ui-flask',
		'ui-folder',
		'ui-folder-search',
		'ui-folders',
		'ui-friends',
		'ui-gift',
		'ui-gift-card',
		'ui-globe',
		'ui-graduation-cap',
		'ui-hammer',
		'ui-hand-pointer',
		'ui-hashtag',
		'ui-heart',
		'ui-hexagon',
		'ui-home',
		'ui-honey',
		'ui-icons',
		'ui-id-card',
		'ui-info',
		'ui-jack-o-lantern',
		'ui-key',
		'ui-language',
		'ui-layout',
		'ui-life-ring',
		'ui-lightbulb',
		'ui-lightbulb-on',
		'ui-lightbulb-slash',
		'ui-link',
		'ui-list',
		'ui-lock',
		'ui-magic',
		'ui-magnet',
		'ui-memo-pad',
		'ui-minus',
		'ui-minus-square',
		'ui-mobile-phone',
		'ui-network',
		'ui-newspaper',
		'ui-object-ungroup',
		'ui-paint-brush',
		'ui-palette',
		'ui-paper-plane',
		'ui-paper-plane-top',
		'ui-paperclip',
		'ui-paste',
		'ui-pause',
		'ui-pen-nib',
		'ui-pencil',
		'ui-photo',
		'ui-play',
		'ui-plug',
		'ui-plus',
		'ui-plus-square',
		'ui-poll',
		'ui-poll-horizontal',
		'ui-puzzle',
		'ui-qrcode',
		'ui-question',
		'ui-question-sqaure',
		'ui-quote-left',
		'ui-quote-right',
		'ui-radar',
		'ui-reply',
		'ui-ribbon',
		'ui-rocket',
		'ui-rss',
		'ui-search',
		'ui-search-plus',
		'ui-server',
		'ui-share',
		'ui-shield',
		'ui-shield-check',
		'ui-shield-slash',
		'ui-shopping-bag',
		'ui-shopping-cart',
		'ui-shortcode',
		'ui-sidebar',
		'ui-signal',
		'ui-sitemap',
		'ui-sliders',
		'ui-sliders-base',
		'ui-sliders-base-hor',
		'ui-sliders-hor',
		'ui-spider',
		'ui-spinner',
		'ui-square-share',
		'ui-star',
		'ui-sun',
		'ui-sync',
		'ui-table',
		'ui-tablet',
		'ui-tag',
		'ui-tags',
		'ui-tasks',
		'ui-term',
		'ui-terms',
		'ui-thumbs-up',
		'ui-thumbtack',
		'ui-times',
		'ui-toggle-off',
		'ui-toggle-on',
		'ui-toggle-slash',
		'ui-toolbox',
		'ui-tools',
		'ui-traffic',
		'ui-trash',
		'ui-tree-christmas',
		'ui-umbrella-beach',
		'ui-unlock',
		'ui-upload',
		'ui-user',
		'ui-user-circle',
		'ui-user-group',
		'ui-user-secret',
		'ui-user-square',
		'ui-user-tag',
		'ui-users',
		'ui-video',
		'ui-vote-nay',
		'ui-vote-yea',
		'ui-warning',
		'ui-warning-octagon',
		'ui-warning-triangle',
		'ui-wrench'
	);

	protected $bool_args = array(
		'full' => 'fw',
		'spin' => 'spin'
	);
	protected $valid_args = array(
		'size'   => array( 'lg', '1x', '2x', '3x', '4x', '5x', '6x', '7x', '8x', '9x', '10x' ),
		'pull'   => array( 'left', 'right' ),
		'flip'   => array( 'vertical', 'horizontal', 'both' ),
		'rotate' => array( '45', '90', '270' )
	);

	public function __construct() {

	}

	public static function instance() : Icons {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new Icons();
		}

		return $instance;
	}

	public function icons_list() {
		return $this->icons;
	}

	public function icon_class( $name, $args = array() ) {
		$defaults = array(
			'size'   => false,
			'pull'   => false,
			'flip'   => false,
			'full'   => false,
			'spin'   => false,
			'rotate' => false
		);

		$args = wp_parse_args( $args, $defaults );

		$classes = array();

		if ( in_array( $name, $this->icons ) ) {
			$classes[] = $this->base;
			$classes[] = $this->prefix . $name;
		}

		foreach ( $args as $arg => $value ) {
			if ( $value !== false && is_string( $value ) ) {
				if ( isset( $this->bool_args[ $arg ] ) ) {
					$classes[] = $this->prefix_control . $this->bool_args[ $arg ];
				} else if ( isset( $this->valid_args[ $arg ] ) ) {
					if ( in_array( $value, $this->valid_args[ $arg ] ) ) {
						$classes[] = $this->prefix_control . $value;
					}
				}
			}
		}

		return $classes;
	}

	public function icon( $name, $tag = 'i', $args = array(), $attr = array() ) {
		$render     = '';
		$properties = array();
		$classes    = $this->icon_class( $name, $args );

		if ( ! empty( $classes ) ) {
			$defaults = array(
				'title'       => '',
				'style'       => '',
				'class'       => '',
				'aria-hidden' => 'true'
			);

			$attr = shortcode_atts( $defaults, $attr );

			if ( ! empty( $attr[ 'class' ] ) ) {
				$classes[] = $attr[ 'class' ];
			}

			$attr[ 'class' ] = join( ' ', $classes );

			foreach ( $attr as $key => $value ) {
				if ( ! empty( $value ) && is_string( $value ) ) {
					$properties[] = $key . '="' . esc_attr( $value ) . '"';
				}
			}

			$render = '<' . $tag . ' ' . join( ' ', $properties ) . '></' . $tag . '>';
		}

		return $render;
	}

	public function icons( $list = false, $tag = 'i', $args = array(), $attr = array() ) {
		$out  = array();
		$list = $list === false ? $this->icons : $list;

		foreach ( $list as $icon ) {
			$render = $this->icon( $icon, $tag, $args, $attr );

			if ( ! empty( $render ) ) {
				$out[ $icon ] = $render;
			}
		}

		return $out;
	}
}
