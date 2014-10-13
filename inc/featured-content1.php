<?php
/**
 * IMQX GETPOSTS FUNCTIONS
 *
 * 获取文章列表，给定参数 ajax模式下
 *
 * @package WordPress
 * @subpackage IMQX
 * @since IMQX.COM 1.0
 */

/**************************************************************
   *
   *    获取post列表
   *    @param  none
   *    @return string 输出流
   *    @access action
   *
 *************************************************************/

add_action("wp_ajax_nopriv_getposts", "imqx_getposts");
function imqx_getposts(){
	
	$meta = $_POST["meta"] ? $_POST["meta"] : "";
	if ( $meta == "" ) {
	 	$metakey = "";
	 	$metavalue = "";
	}
	else {
		list($metakey, $metavalue) = explode("-", $meta, 2);
	}
	$order = $_POST["asc"] ? "ASC" : "DESC";
	$orderby = $_POST["orderby"] ? $_POST["orderby"] : "post_date";
	$current_id = $_POST["id"] ? $_POST["id"] : 0;
	$current_page = $_POST["current_page"] ? $_POST["current_page"] : 1;
	$pagesize = $_POST["pagesize"] ? $_POST["pagesize"] : 5;
	$offset = $pagesize * ( $current_page - 1 );
	$showpages = 3; //需为奇数
	$maxpages = get_category($_POST["id"])->count % $pagesize == 0 ?
								floor(get_category($_POST["id"])->count / $pagesize) : floor(get_category($_POST["id"])->count / $pagesize) + 1;
	
	/*
	//index extra data
	if ($current_id == 0) {
		$exclude_ids = array();
		//silder data
		$slider_args = array( 
						'posts_per_page' => 4, 
						'orderby' => "meta_value",
						'meta_key' => "index"
		      );
		$slider_itemlist = get_posts( $slider_args );
		
		
	}
	*/
	//common data
	$args = array( 'posts_per_page' => $pagesize, 
									'offset'=> $offset, 
									'category' => $current_id == 0 ? "" : $current_id,
									'orderby' => $orderby,
									'order' => $order,
									'include' => '',
									'exclude' => $exclude_ids,
									'meta_key' => $metakey,
									'meta_value' => $metavalue,
									'post_type' => 'post',
									'post_mime_type' => '',
									'post_parent' => '',
									'post_status' => 'publish',
									'suppress_filters' => true );
	$postlist = get_posts( $args );
	$postarr = array();
	foreach ( $postlist as $post ) {
		setup_postdata( $post ); 
		$tagarr = get_the_tags();
		$posttags = array();
		if($tagarr){
			foreach ( $tagarr as $key => $value ) {
				$posttags[$key] = urldecode($tagarr[$key]->slug);
			}
		}
		$postarr[get_the_ID()] = array(
			"title" => get_the_title(),
			"link" => get_permalink(get_the_ID()),
			"date" => (string)get_the_date(),
			"excerpt" => get_the_excerpt(),
			"image" => get_first_image(),
			"tags" => $posttags
		);
	}
	wp_reset_postdata();
	
	$postarr["current_id"] = $current_id;
	$postarr["current_page"] = $current_page;
	$postarr["pagesize"] = $pagesize;
	$postarr["showpages"] = $showpages;
	$postarr["maxpages"] = $maxpages;
	
	echo JSON($postarr);
}


?>