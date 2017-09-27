<?php
/**
 * Template part for displaying featured posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fraise
 */

$featured_background = '';
if ( has_post_thumbnail() ) {
	$featured_background = get_the_post_thumbnail_url();
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'featured' ); ?> style="<?php printf( 'background-image: url(%s);', esc_url( $featured_background ) ); ?>">	
	<header class="entry-header">
		<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
			<?php the_excerpt(); ?>
		</a>
	</header><!-- .entry-header -->
</article><!-- #post-<?php the_ID(); ?> -->
