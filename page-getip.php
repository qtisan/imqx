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
 * Template Name: GetIP
 */
 

		
	echo json_encode(getClientInfo());
	
 ?>