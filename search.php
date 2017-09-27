<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Fraise
 */

get_header(); ?>

<main id="primary" class="content-area">

	<?php
	if ( have_posts() ) : ?>

		<header class="archive-header">
			<h1 class="archive-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search results for &ldquo;%s&rdquo;', 'fraise' ), get_search_query() );
				?>
			</h1>
			<p class="archive-description">
				<?php
				printf( esc_html( _nx( '1 Result', '%s Results', $wp_query->found_posts, 'number of search results', 'fraise' ) ), $wp_query->found_posts );
				?>
			</p>
		</header><!-- .page-header -->

		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );

		endwhile;

		the_posts_navigation();

	else : 

		get_template_part( 'template-parts/content', 'none' );

	endif; ?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
