<!--Slider start-->
<?php 
	$args = array( 'posts_per_page' => 5, 
									'orderby' => 'meta_value',
									'meta_key' => 'index');
	$postlist = get_posts( $args );
	global $post;
	
?>
<div id="SliderBlock">
	<div class="slider-container">
		<ul class="thumbs clearfix">
<?php
	foreach( $postlist as $post) {
		setup_postdata($post);	
?>
			<li>
				
			</li>

<?php	
	}
?>
		</ul>
		<div class="main-slider">  
<?php	
	foreach( $postlist as $post) {
		setup_postdata($post);	
?>
			<div class="slide-item">
				<div class="slide-img">
					<img src="<?php the_first_image(); ?>" /> 
				</div>
				<div class="slide-cont">
					<a href="<?php the_permalink(); ?>">
					<h1>
						<span><?php the_tags(); ?></span><br />
						<?php the_title(); ?>
					</h1> 
					<p><?php the_excerpt(); ?></p> 
					<p><?php the_date(); ?></p></a> 
				</div> 
			</div>
<?php	
	}
?>
		</div>
	</div>
</div><!--Slider end-->