<!--Tags start-->
<div id="TagBlock">
	<h2>分类标签</h2>
	<div class="innertags">
	
	
<?php 
	$taglist = get_tags();
	foreach($taglist as $tag){
?>
		<button href="<?php echo bloginfo('siteurl').'/functions/'.$tag->slug; ?>" 
			title="<?php echo $tag->name; ?>" class="btn btn-primary" type="button">
			<span><?php echo $tag->name; ?></span>
			<span class="badge"><?php echo $tag->count; ?></span>
		</button>
		
<?php
	}
?>
	
	</div>
</div><!--Tags end-->