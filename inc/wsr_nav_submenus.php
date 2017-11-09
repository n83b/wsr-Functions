<?php 
/***********************************************************
 * Outputs submenus for the current page, based on wp_nav_menu
 */

function wsr_nav_submenus(){
	$menu = wp_get_nav_menu_items('main', array());
	global $post;
	$currentPostID = $post->ID;
	$menu_item_parent_id = 0;

	//Get current page menu parent
	foreach ($menu as $item):
		if ($item->object_id == $currentPostID):
			$menu_item_parent_id = $item->menu_item_parent;
		endif;
	endforeach; 

	//output sub menus
	if ($menu_item_parent_id > 0):
		echo '<ul>';
		foreach ($menu as $item):
			if ($item->menu_item_parent == $menu_item_parent_id):
				echo '<li><a href="' . $item->url . '" class="' . (($item->object_id == $currentPostID) ? 'active' : '' ) . '">' . $item->title . '</a></li>';
			endif;
		endforeach;
		echo '</ul>';
	endif;
}
?>