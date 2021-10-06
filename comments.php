<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eduardo_Domingos_Photography
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<section class="comments section section--bordered">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="screen-reader-text">Comentários</h2>
		<p class="comments__counter">
			<?php
			$edp_comment_count = get_comments_number();
			if($edp_comment_count === '1') {
				echo number_format_i18n( $edp_comment_count ) . ' comentário';
			}
			else {
				echo number_format_i18n( $edp_comment_count ) . ' comentários';
			}
			?>
		</p>

		<?php the_comments_navigation(); ?>

		<ol class="comments__list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'walker' =>  new Custom_Walker_Comment()
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'edp' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	$args = array(
		'title_reply_before'   => '<p class="comment-respond__title">',
		'title_reply_after'    => '</p>',
		'title_reply' => 'Deixe um comentário',
		'label_submit' => 'Enviar comentário',
		'class_form' => 'comment-respond__form'
	);
	comment_form($args);
	?>

</section>
