<?php


remove_action( 'wp_head',             'wp_enqueue_scripts',              1     );
remove_action( 'wp_head',             'feed_links',                      2     );
remove_action( 'wp_head',             'feed_links_extra',                3     );
remove_action( 'wp_head',             'rsd_link'                               );
remove_action( 'wp_head',             'wlwmanifest_link'                       );
remove_action( 'wp_head',             'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head',             'locale_stylesheet'                      );
remove_action( 'wp_head',             'noindex',                          1    );
remove_action( 'wp_head',             'wp_print_styles',                  8    );
remove_action( 'wp_head',             'wp_print_head_scripts',            9    );
remove_action( 'wp_head',             'wp_generator'                           );
remove_action( 'wp_head',             'rel_canonical'                          );
remove_action( 'wp_head',             'wp_shortlink_wp_head',            10, 0 );
remove_action( 'wp_head',             'wp_no_robots'                           );


//add_theme_support( 'post-formats', array( 'aside', 'image', 'quote', 'link', 'status', 'video', 'gallery'));
require get_template_directory() . '/inc/template-tags.php';

function setup_styles () {
	wp_enqueue_style( 'reset_style',  get_template_directory_uri() . "/styles/reset.css" );
	wp_enqueue_style( 'font_style',  get_template_directory_uri() . "/font/font.css" );
	wp_enqueue_style( 'iconfont_style',  get_template_directory_uri() . "/styles/fontello.css" );
	wp_enqueue_style( 'bootstrap_style',  get_template_directory_uri() . "/bootstrap-3.2.0-dist/css/bootstrap.min.css" );
	wp_enqueue_style( 'common_style',  get_template_directory_uri() . "/style.css" );
}
add_action( 'wp_head', 'setup_styles' );

function setup_scripts () {
	wp_enqueue_script( 'jq_script',  get_template_directory_uri() . "/scripts/jquery-1.11.1.min.js" );
	wp_enqueue_script( 'jq_easing_script',  get_template_directory_uri() . "/scripts/jquery.easing-1.3.min.js" );
	wp_enqueue_script( 'jq_slimscroll_script',  get_template_directory_uri() . "/scripts/jquery.slimscroll-1.3.3.min.js" );
	wp_enqueue_script( 'jq_mousewheel_script',  get_template_directory_uri() . "/scripts/jquery.mousewheel-3.11.1.min.js" );
	wp_enqueue_script( 'bootstrap_script',  get_template_directory_uri() . "/bootstrap-3.2.0-dist/js/bootstrap.min.js" );
	wp_enqueue_script( 'jq_lazyload_script',  get_template_directory_uri() . "/scripts/jquery.lazyload.min.js" );
	wp_enqueue_script( 'jq_preload_script',  get_template_directory_uri() . "/scripts/jquery.preload.min.js" );
	wp_enqueue_script( 'common_script',  get_template_directory_uri() . "/scripts/common.js" );
}
add_action( 'wp_head', 'setup_scripts' );

function getClientInfo() {
	global $ip;
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else $ip = "Unknow";
	
 	date_default_timezone_set('Asia/Shanghai'); 
	$arr = array (
		'ip'=>$ip,
		'host'=>$_SERVER['REMOTE_HOST'] ? $_SERVER['REMOTE_HOST'] : "noname",
		'language'=>$_SERVER['HTTP_ACCEPT_LANGUAGE'],
		'reffer'=>$_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : "direct",
		'browser'=>$_SERVER['HTTP_USER_AGENT'],
		'time'=>date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']),
		'url'=>$_SERVER['REQUEST_URI']
		);
	return $arr;
}

function custom_excerpt_length( $length ) {
	return 300;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );



/**************************************************************
   *
   *    使用特定function对数组中所有元素做处理
   *    @param  string  &$array     要处理的字符串
   *    @param  string  $function   要执行的函数
   *    @return boolean $apply_to_keys_also     是否也应用到key上
   *    @access public
   *
 *************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else if(is_string($value)){
            $array[$key] = $function($value);
        }
 
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}
 
/**************************************************************
 *
 *    将数组转换为JSON字符串（兼容中文）
 *    @param  array   $array      要转换的数组
 *    @return string      转换得到的json字符串
 *    @access public
 *
 *************************************************************/
function JSON($array) {
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}


add_action("wp_ajax_nopriv_getposts", "imqx_getposts");
add_action("wp_ajax_getposts", "imqx_getposts");
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
	$current_id = $_POST["id"] && $_POST["id"] != "0" ? $_POST["id"] : "";
	$current_page = $_POST["current_page"] ? $_POST["current_page"] : 1;
	$pagesize = $_POST["pagesize"] ? $_POST["pagesize"] : 3;
	$offset = $pagesize * ( $current_page - 1 );
	$showpages = 3; //需为奇数
	$maxpages = get_category($current_id)->count % $pagesize == 0 ?
								floor(get_category($current_id)->count / $pagesize) : floor(get_category($current_id)->count / $pagesize) + 1;
	$exclude_ids = array();
	//common data
	$args = array( 'posts_per_page' => $pagesize, 
									'offset'=> $offset, 
									'category' => $current_id,
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
	global $post;
	foreach ( $postlist as $post ) {
		setup_postdata( $post ); 
		$tagarr = get_the_tags();
		$posttags = array();
		if($tagarr){
			foreach ( $tagarr as $key => $value ) {
				$posttags[$key] = urldecode($tagarr[$key]->slug);
			}
		}
		$postarr[] = array(
			"id" => get_the_ID(),
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
	
	die;
}

add_action("wp_ajax_nopriv_gettags", "imqx_gettags");
add_action("wp_ajax_gettags", "imqx_gettags");
function imqx_gettags(){
	$taglist = get_tags();
	echo "name".$taglist[0]->name;
	$tagarr = array();
	foreach($taglist as $tag){
		$tagarr[] = array(
			"id" => $tag->term_id,
			"name" => $tag->name,
			"count" => $tag->count
		);
	}
	echo JSON($tagarr);
	
	die;
}





?>