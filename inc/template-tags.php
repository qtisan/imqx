<?php
/**
 * Custom template tags for IMQX
 *
 * @package WordPress
 * @subpackage IMQX
 * @since IMQX.COM 1.0
 */
 
function get_first_image(){
	global $post, $posts; 
	$first_img = ''; 
	ob_start(); 
	ob_end_clean(); 
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); 
	$first_img = $matches[1][0]; 
	
	if(empty($first_img)){  
		$first_img = get_template_directory_uri(). '/images/myhead.jpg'; 
	}
	
	return $first_img;   
} 
function the_first_image(){
	echo get_first_image();
}


function the_hot_posts(){
	$args = array( 'posts_per_page' => 7, 
									'meta_key' => 'view',
									'orderby' => 'meta_value',
									'order' => 'DESC' );
	$postlist = get_posts( $args );
	global $post;
	?>
	<ul>
	<?php
	foreach($postlist as $post){
		setup_postdata($post);
		?>
		<li post="#<?php the_ID(); ?>" href="<?php the_permalink ?>">
			<div class="hotthumb"><img src="<?php the_first_image(); ?>" title="<?php the_title ?>" /></div>
			<div class="hotcontent">
				<h5><?php the_title(); ?></h5>
				<span><?php the_date(); ?></span>
				<em><i class="icon-eye"></i><?php echo get_post_meta(get_the_ID(), 'view', true); ?></em>
			</div>
		</li>
		<?php
	}
	?>
	</ul>
	<?php
}

 
?>