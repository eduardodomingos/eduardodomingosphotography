<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eduardo_Domingos_Photography
 */

?>
<?php
$cssClasses = array('teaser');
foreach((get_the_category()) as $category) {	
	array_push($cssClasses, 'category-'.$category->category_nicename);
}
?>

<article class="<?php echo join( ' ', $cssClasses ); ?>">
	<?php edp_post_thumbnail(array('teaser__thumbnail'), true); ?>

	<?php if(has_category(array(LESSON_CATEGORIES['lessons'], LESSON_CATEGORIES['workshops']))): ?>
		<?php edp_price_tag(array('teaser__price'), false)?>
	<?php endif; ?>

	<?php if(!has_category(array(LESSON_CATEGORIES['lessons'], LESSON_CATEGORIES['workshops']))): ?>
		<?php edp_post_bottom_category(array('teaser__category'))?>
	<?php endif; ?>
	
	<?php the_title( '<h3 class="teaser__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
	<?php if(get_field('summary')): ?>
		<p class="teaser__summary"><?php the_field('summary'); ?></p>
	<?php endif; ?>
	<?php
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'edp' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	?>
</article>