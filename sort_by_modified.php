<?php
/*
Plugin Name: sort by modified
Plugin URI: http://creeksidesystems.com
Description: Plugin adds a sortable modified date column to posts & pages within wordpress.
Version: 1.0
Author: Robert Drake
Author URI: http://creeksidesystems.com
*/

/*
Sort by Modified (Wordpress Plugin)
Copyright (C) 2012 Robert Drake
Contact me at http://creeksidesystems.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.  <http://www.gnu.org/licenses/>.
*/


// Register Modified Date Column for both posts & pages
function modified_column_register( $columns ) {
	$columns['Modified'] = __( 'Modified Date', 'modified' );
 
	return $columns;
}
add_filter( 'manage_posts_columns', 'modified_column_register' );
add_filter( 'manage_pages_columns', 'modified_column_register' );

// Display the modified date of each post
function modified_column_display( $column_name, $post_id ) {
	global $post; 
	$modified = the_modified_date();
	echo $modified;
}
add_action( 'manage_posts_custom_column', 'modified_column_display', 10, 2 );
add_action( 'manage_pages_custom_column', 'modified_column_display', 10, 2 );

// Register the column as sortable
function modified_column_register_sortable( $columns ) {
	$columns['Modified'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'modified_column_register_sortable' );
add_filter( 'manage_edit-page_sortable_columns', 'modified_column_register_sortable' );

// Support for Custom Post Types
add_action('wp', 'add_sortable_views_for_custom_post_types');

function add_sortable_views_for_custom_post_types(){
	$args=array(
	  'public'   => true,
	  '_builtin' => false
	); 
	$post_types=get_post_types($args); 
	foreach ($post_types  as $post_type ) {
		add_filter( 'manage_edit-'.$post_type.'_sortable_columns', 'modified_column_register_sortable' );
	}
}