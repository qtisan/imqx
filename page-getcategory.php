<?php
 /**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage IMQX
 * @since IMQX.COM 1.0
 * Template Name: Page_GetCategory
 */

/*

function linkedpager($pageid, $link){
	echo '<a href="'.$link.'">'.$pageid.'</a>';
}
function nolinkpager($pageid){
	echo '<a>'.$pageid.'</a>';
}
function prevpager($link){
	echo '<a href="'.$link.'">...</a>';
}
function nextpager($link){
	echo '<a href="'.$link.'">...</a>';
}
function pagelink( $id, $page ) {
	echo get_bloginfo("siteurl")."/getcategory?id=".$id."&current_page=".$page;
}
if ( $showpages >= $maxpages ) {
	for ( $i=1; $i<= $maxpages; $i++ ) {
		if ($current_page == $i) {
			nolinkpager($i);
		}
		else {
			linkedpager($i, pagelink($current_id, $i));
		}
	}
}
else {
	if ( $current_page <= floor($showpages/2)+1 ) {
		for ($i = 1; $i <= $showpages; $i++) {
			if ($current_page == $i) {
				nolinkpager($i);
			}
			else {
				linkedpager($i, pagelink($current_id, $i));
			}
		}
		nextpager(pagelink($current_id, $current_page+floor($showpages/2)));
	}
	else if ( $current_page >= $maxpages - floor($showpages/2) ) {
		prevpager(pagelink($current_id, $current_page-floor($showpages/2)));
		for ($i = $maxpages - $showpages + 1; $i <= $maxpages; $i++) {
			if ($current_page == $i) {
				nolinkpager($i);
			}
			else {
				linkedpager($i, pagelink($current_id, $i));
			}
		}
	}
	else {
		prevpager(pagelink($current_id, $current_page-floor($showpages/2)));
		for ($i = $current_page-floor($showpages/2); $i <= $current_page+floor($showpages/2); $i++) {
			if ($current_page == $i) {
				nolinkpager($i);
			}
			else {
				linkedpager($i, pagelink($current_id, $i));
			}
		}
		nextpager(pagelink($current_id, $current_page+floor($showpages/2)));
	}
}
*/

?>
