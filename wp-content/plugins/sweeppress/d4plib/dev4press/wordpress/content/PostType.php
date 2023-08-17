<?php

/*
Name:    Dev4Press\v42\WordPress\Content\PostType
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

trait PostType {
	public function generate_labels( $singular, $plural ) : array {
		$labels = array(
			'name'           => $plural,
			'singular_name'  => $singular,
			'menu_name'      => $plural,
			'name_admin_bar' => $singular
		);

		$labels[ 'add_new' ]                  = _x( "Add New", "Post type label", "d4plib" );
		$labels[ 'add_new_item' ]             = sprintf( _x( "Add New %s", "Post type label", "d4plib" ), $singular );
		$labels[ 'edit_item' ]                = sprintf( _x( "Edit %s", "Post type label", "d4plib" ), $singular );
		$labels[ 'new_item' ]                 = sprintf( _x( "New %s", "Post type label", "d4plib" ), $singular );
		$labels[ 'view_item' ]                = sprintf( _x( "View %s", "Post type label", "d4plib" ), $singular );
		$labels[ 'search_items' ]             = sprintf( _x( "Search %s", "Post type label", "d4plib" ), $plural );
		$labels[ 'not_found' ]                = sprintf( _x( "No %s found", "Post type label", "d4plib" ), $plural );
		$labels[ 'not_found_in_trash' ]       = sprintf( _x( "No %s found in Trash", "Post type label", "d4plib" ), $plural );
		$labels[ 'parent_item_colon' ]        = sprintf( _x( "Parent %s:", "Post type label", "d4plib" ), $plural );
		$labels[ 'all_items' ]                = sprintf( _x( "All %s", "Post type label", "d4plib" ), $plural );
		$labels[ 'archives' ]                 = sprintf( _x( "%s Archives", "Post type label", "d4plib" ), $singular );
		$labels[ 'insert_into_item' ]         = sprintf( _x( "Insert into %s", "Post type label", "d4plib" ), $singular );
		$labels[ 'uploaded_to_this_item' ]    = sprintf( _x( "Uploaded to this %s", "Post type label", "d4plib" ), $singular );
		$labels[ 'featured_image' ]           = _x( "Featured Image", "Post type label", "d4plib" );
		$labels[ 'set_featured_image' ]       = _x( "Set featured Image", "Post type label", "d4plib" );
		$labels[ 'remove_featured_image' ]    = _x( "Remove featured Image", "Post type label", "d4plib" );
		$labels[ 'use_featured_image' ]       = _x( "Use featured Image", "Post type label", "d4plib" );
		$labels[ 'filter_items_list' ]        = sprintf( _x( "Filter %s list", "Post type label", "d4plib" ), $plural );
		$labels[ 'items_list_navigation' ]    = sprintf( _x( "%s list navigation", "Post type label", "d4plib" ), $plural );
		$labels[ 'items_list' ]               = sprintf( _x( "%s list", "Post type label", "d4plib" ), $plural );
		$labels[ 'view_items' ]               = sprintf( _x( "View %s", "Post type label", "d4plib" ), $plural );
		$labels[ 'attributes' ]               = sprintf( _x( "%s Attributes", "Post type label", "d4plib" ), $singular );
		$labels[ 'item_published' ]           = sprintf( _x( "%s published", "Post type label", "d4plib" ), $singular );
		$labels[ 'item_published_privately' ] = sprintf( _x( "%s published privately", "Post type label", "d4plib" ), $singular );
		$labels[ 'item_reverted_to_draft' ]   = sprintf( _x( "%s reverted to draft", "Post type label", "d4plib" ), $singular );
		$labels[ 'item_scheduled' ]           = sprintf( _x( "%s scheduled", "Post type label", "d4plib" ), $singular );
		$labels[ 'item_updated' ]             = sprintf( _x( "%s updated", "Post type label", "d4plib" ), $singular );
		$labels[ 'filter_by_date' ]           = _x( "Filter by Date", "Post type label", "d4plib" );
		$labels[ 'item_link' ]                = sprintf( _x( "%s Link", "Post type label", "d4plib" ), $singular );
		$labels[ 'item_link_description' ]    = sprintf( _x( "A link to a %s", "Post type label", "d4plib" ), $singular );

		return $labels;
	}
}
