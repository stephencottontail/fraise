<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fraise
 */

if ( ! function_exists( 'fraise_entry_meta' ) ) :
/**
 * Prints HTML with complete meta information, including title
 */
function fraise_entry_meta() {
	if ( is_singular() ) :
		the_title( '<h1 class="entry-title">', '</h1>' );
	else :
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	endif;
		
	$author_id = get_the_author_meta( 'ID' );
	echo get_avatar( $author_id, 32 );
	
	$author_link = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
		esc_url( get_author_posts_url( $author_id ) ),
		esc_html( get_the_author() )
	);
	
	/* translators: %s = post author */
	printf( esc_html_x( 'by %s', 'post author', 'fraise' ), $author_link );
	
	printf( '<span class="posted-on meta-info"><time class="entry-date published" datetime="%1$s"><a href="%2$s" rel="bookmark">%3$s</a></time></span>',
		esc_attr( get_the_date( 'c' ) ),
		esc_url( get_permalink() ),
		esc_html( get_the_date() )
	);
	
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'fraise' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link meta-info">',
		'</span>'
	);
}
endif;

if ( ! function_exists( 'fraise_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories and tags
 */
function fraise_entry_footer() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'fraise' ) );
	if ( $categories_list ) {
		printf( '<div class="meta-wrapper category-wrapper"><span class="meta-title">%1$s</span>%2$s</div>',
			esc_html_x( 'Category', 'used as a label in a post footer', 'fraise' ),
			$categories_list
		);
	}

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'fraise' ) );
	if ( $tags_list ) {
		printf( '<div class="meta-wrapper tag-wrapper"><span class="meta-title">%1$s</span>%2$s</div>',
			esc_html_x( 'Tags', 'used as a label in a post footer', 'fraise' ),
			$tags_list
		);
	}
}
endif;

if ( ! function_exists( 'fraise_show_comments' ) ) :
/**
 * Custom function to display comments
 */
function fraise_show_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $post;
  
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>
		<li id="div-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<article class="pingback-body">
				<header class="pingback-header">
					<?php esc_html_e( 'Pingback', 'fraise' ); ?>
				</header><!-- .pingback-header -->
				
				<div class="pingback-content">
					<cite><?php comment_author_link(); ?></cite>
					<?php edit_comment_link( esc_html__( 'Edit', 'fraise' ), '<span class="pingback-edit comment-action">', '</span>' ); ?>
				</div>
			</article>
	
	<?php else : ?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article class="comment-body">
				<header class="comment-header">
					<?php
					if ( '0' != $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
			
					<cite class="fn"><?php echo get_comment_author_link(); ?></cite>
					
					<?php
					if ( ! empty( $comment->comment_parent ) ) :
						$parent_comment = get_comment( $comment->comment_parent );
						
						$reply_to = sprintf( '<a href="%1$s">%2$s</a>',
							esc_url( get_comment_link( $parent_comment ) ),
							esc_html( $parent_comment->comment_author )
						);
						?>
						<span class="in-reply-to"><?php printf( esc_html__( 'In reply to %s', 'fraise' ), $reply_to ); ?></span>
					<?php endif; ?>
				</header><!-- .comment-header -->
				
				<div class="comment-content">
					<?php
					if ( '0' == $comment->comment_approved ) : ?>
						<span class="awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'fraise' ); ?></span>
					<?php
					endif;
					
					comment_text();
					?>
				</div><!-- .comment-content -->
				
				<footer class="comment-footer">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-time meta-info"><time datetime="<?php comment_time( 'c' ); ?>"><?php printf( esc_html_x( '%1$s, %2$s', '1: comment date, 2: commment time', 'fraise' ),
						get_comment_date(), /* %1$s */
						get_comment_time() /* %2$s */
					); ?></time></a>
					
					<div class="comment-actions">
						<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="comment-reply comment-action">',
							'after'     => '</span>',
						) ) );
						
						edit_post_link( esc_html__( 'Edit', 'fraise' ), '<span class="comment-edit comment-action">', '</span>' );
						?>
					</div><!-- .comment-actions -->
				</footer><!-- .comment-footer -->
			</article>
			
	<?php
	endif; // end check for comment type
	
} // end of function
endif; // end of check for function's existence