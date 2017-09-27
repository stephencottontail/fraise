<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fraise
 */

?>

<section class="no-results not-found">
	<header class="archive-header">
		<h1 class="archive-title">
			<?php
			if ( is_search() ) {
				/* translators: %s: search query. */
				printf( esc_html__( 'No results for &ldquo;%s&rdquo;', 'fraise' ), get_search_query() );
			} else {
				esc_html_e( 'Nothing Found', 'fraise' );
			}
			?>
		</h1>
	</header><!-- .page-header -->

	<?php
	if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php
			printf(
				wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'fraise' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				),
				esc_url( admin_url( 'post-new.php' ) )
			);
		?></p>

	<?php elseif ( is_search() ) : ?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fraise' ); ?></p>
		<?php
		get_search_form();

	else : ?>

		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fraise' ); ?></p>
		<?php
		get_search_form();

	endif; ?>
</section><!-- .no-results -->
