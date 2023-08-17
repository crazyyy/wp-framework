<?php

/*
Name:    Dev4Press\v42\WordPress\Content\Taxonomy
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

namespace Dev4Press\v42\WordPress\Content;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Taxonomy {
	public function generate_capabilities() : array {
		return array(
			'manage_terms' => 'manage_categories',
			'edit_terms'   => 'manage_categories',
			'delete_terms' => 'manage_categories',
			'assign_terms' => 'edit_posts'
		);
	}

	public function generate_labels( $singular, $plural ) : array {
		$labels = array(
			'name'          => $plural,
			'singular_name' => $singular,
			'menu_name'     => $plural
		);

		$labels[ 'all_items' ]                  = sprintf( _x( "All %s", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'edit_item' ]                  = sprintf( _x( "Edit %s", "Taxonomy label", "d4plib" ), $singular );
		$labels[ 'view_item' ]                  = sprintf( _x( "View %s", "Taxonomy label", "d4plib" ), $singular );
		$labels[ 'update_item' ]                = sprintf( _x( "Update %s", "Taxonomy label", "d4plib" ), $singular );
		$labels[ 'add_new_item' ]               = sprintf( _x( "Add New %s", "Taxonomy label", "d4plib" ), $singular );
		$labels[ 'new_item_name' ]              = sprintf( _x( "New %s Name", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'parent_item' ]                = sprintf( _x( "Parent %s", "Taxonomy label", "d4plib" ), $singular );
		$labels[ 'parent_item_colon' ]          = sprintf( _x( "Parent %s:", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'search_items' ]               = sprintf( _x( "Search %s", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'popular_items' ]              = sprintf( _x( "Popular %s", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'separate_items_with_commas' ] = sprintf( _x( "Separate %s with commas", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'add_or_remove_items' ]        = sprintf( _x( "Add or remove %s", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'choose_from_most_used' ]      = sprintf( _x( "Choose from the most used %s", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'not_found' ]                  = sprintf( _x( "No %s found", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'no_terms' ]                   = sprintf( _x( "No %s", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'items_list_navigation' ]      = sprintf( _x( "%s list navigation", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'items_list' ]                 = sprintf( _x( "%s list", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'most_used' ]                  = _x( "Most Used", "Taxonomy label", "d4plib" );
		$labels[ 'back_to_items' ]              = sprintf( _x( "&larr; Back to %s", "Taxonomy label", "d4plib" ), $plural );
		$labels[ 'item_link' ]                  = sprintf( _x( "%s Link", "Taxonomy label", "d4plib" ), $singular );
		$labels[ 'item_link_description' ]      = sprintf( _x( "A link to a %s", "Taxonomy label", "d4plib" ), $singular );
		$labels[ 'name_field_description' ]     = _x( "The name is how it appears on your site.", "Taxonomy label", "d4plib" );
		$labels[ 'slug_field_description' ]     = _x( "The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "Taxonomy label", "d4plib" );
		$labels[ 'parent_field_description' ]   = _x( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "Taxonomy label", "d4plib" );
		$labels[ 'desc_field_description' ]     = _x( "The description is not prominent by default; however, some themes may show it.", "Taxonomy label", "d4plib" );

		return $labels;
	}
}
