<?php
/**
 * Template part for displaying the featured posts section
 *
 * @link https://jetpack.com/support/featured-content/
 *
 * @package Fraise
 */
?>

<section class="featured-area">
	<?php
	$featured_posts = fraise_get_featured_posts();

	if ( 1 == count( $featured_posts ) ) :
		setup_postdata( $featured_posts[0] );
		get_template_part( 'template-parts/content', 'featured' );
	else :
	?>
		<div class="header-slider">
			<?php
			foreach ( $featured_posts as $post ) {
				setup_postdata( $post );
				get_template_part( 'template-parts/content', 'featured' );
			}
			?>
		</div><!-- .header-slider -->
	<?php 
	endif;
	
	wp_reset_postdata();
	?>
</section><!-- .featured-area -->
