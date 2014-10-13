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
 * Template Name: DefaultTemplate
 */

get_header(); ?>

	<div class="loading-a1 h5"><div>loading</div></div>
	
	<div id="IndexPage" class="onlyhome">
		
		<?php get_template_part("index", "main"); ?>

	
	</div><!--IndexPage end-->

	<!--DetailPage start-->
	<div id="DetailPage" class="container fullheight onlydetail">
		<!--TopMenu start-->
		<div id="TopMenu">
			<?php get_template_part("menu", "top"); ?>
		</div><!--TopMenu end-->
		
		<!--LeftMenu start-->
		<div id="LeftMenu">
			<?php get_template_part("menu", "left"); ?>
		</div><!--LeftMenu end-->
		
		<!--InnerContent start-->
		<div id="InnerContent">
			
			<div id="InnerRight">
				<?php get_template_part("inner", "sidebar"); ?>
			</div>
			
			
			<div id="InnerLeft">
				

				<?php get_template_part("inner", "slider"); ?>
				<?php get_template_part("inner", "tags"); ?>
				
			</div>
			
		</div><!--InnerContent end-->
	</div><!--DetailPage end-->
	
	<!--modal start-->
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="mySmallModalLabel"><i class="icon-share-1"></i><label>顺便给朕分享一下</label></h4>
        
	      </div>
	      
	      <div class="modal-body">

	      </div>
	    </div>
	  </div>
	</div><!--modal end-->
									
									
<?php get_footer(); ?>