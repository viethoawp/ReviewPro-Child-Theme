<?php
if ( ! function_exists( 'reviewpro_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since  1.0.0
 */
function reviewpro_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>" <?php hybrid_attr( 'comment' ); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="comment-container">
			<p <?php hybrid_attr( 'comment-content' ); ?>><?php esc_html_e( 'Pingback:', 'reviewpro' ); ?> <span <?php hybrid_attr( 'comment-author' ); ?>><span itemprop="name"><?php comment_author_link(); ?></span></span> <?php edit_comment_link( esc_html__( '(Edit)', 'reviewpro' ), '<span class="edit-link">', '</span>' ); ?></p>
		</article>
	<?php
			break;
		default :
		// Proceed with normal comments.
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>" <?php hybrid_attr( 'comment' ); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="comment-container">

			<div class="comment-avatar">
				<?php echo get_avatar( $comment, apply_filters( 'reviewpro_comment_avatar_size', 80 ) ); ?>
				<span class="name" <?php hybrid_attr( 'comment-author' ); ?>><span itemprop="name"><?php echo get_comment_author_link(); ?></span></span>
				<?php echo reviewpro_comment_author_badge(); ?>
			</div>

			<div class="comment-body">
				<div class="comment-wrapper">

					<div class="comment-head">
						<?php
							$edit_comment_link = '';
							if ( get_edit_comment_link() )
								$edit_comment_link = sprintf( esc_html__( '&middot; %1$sEdit%2$s', 'reviewpro' ), '<a href="' . get_edit_comment_link() . '" title="' . esc_attr__( 'Edit Comment', 'reviewpro' ) . '">', '</a>' );

							printf( '<span class="date"><a href="%1$s" ' . hybrid_get_attr( 'comment-permalink' ) . '><time datetime="%2$s" ' . hybrid_get_attr( 'comment-published' ) . '>%3$s</time></a> %4$s</span>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( esc_html__( '%1$s at %2$s', 'reviewpro' ), get_comment_date(), get_comment_time() ),								
								$edit_comment_link
							);
						?><?php vhwp_comment_count(); ?>
					</div><!-- comment-head -->

					<div class="comment-content comment-entry" <?php hybrid_attr( 'comment-content' ); ?>>
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'reviewpro' ); ?></p>
						<?php endif; ?>
						<?php comment_text(); ?>
						<span class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply"></i> Reply', 'reviewpro' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</span><!-- .reply -->
					</div><!-- .comment-content -->

				</div>
			</div>

		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;