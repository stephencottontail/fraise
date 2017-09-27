<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Fraise
 */

get_header(); ?>

<main id="primary" class="content-area">

	<section class="error-404 not-found">
		<header class="archive-header">
			<h1 class="archive-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'fraise' ); ?></h1>
		</header><!-- .page-header -->
		
		<p><?php printf( wp_kses( __( 'It looks like nothing was found at this location. Try <a href="%1$s">returning home</a> or performing a search.', 'fraise' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( home_url( '/' ) ) )
	?></p>

		<?php get_search_form(); ?>
	</section><!-- .error-404 -->

</main><!-- #primary -->

<?php
get_footer();
