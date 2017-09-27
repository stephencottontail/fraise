<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fraise
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( has_post_thumbnail() ) :
		if ( is_single() ) {
			$destination = get_attachment_link( get_post_thumbnail_id() );
		} else {
			$destination = get_permalink();
		}
		?>
		<figure class="entry-thumbnail">
			<a href="<?php echo esc_url( $destination ); ?>" rel="bookmark">
				<?php the_post_thumbnail(); ?>
			</a>
		</figure>
	<?php endif; ?>
	
	<header class="entry-header">
		<?php
		$categories = get_the_category();
		
		if ( $categories ) {
			$first_category = $categories[0];
			
			printf( '<a class="first-cat-link" href="%1$s">%2$s</a>',
				esc_url( get_category_link( $first_category->term_id ) ),
				esc_html( $first_category->name )
			);
		}
			
		fraise_entry_meta();
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading <span class="screen-reader-text">%s</span>', 'fraise' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'      => sprintf( '<div class="page-links">%s', esc_html__( 'Pages:', 'fraise' ) ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>'
		) );
		
		if ( is_single() ) :
		?>
			<footer class="entry-footer">
				<?php fraise_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>			
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
