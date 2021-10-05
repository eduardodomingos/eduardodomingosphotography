<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eduardo_Domingos_Photography
 */

?>

<article <?php post_class(); ?>>
	<header class="post__header">
		<?php edp_post_thumbnail(); ?>
		<?php edp_post_bottom_category()?>
		<?php the_title( '<h1 class="post__title">', '</h1>' ); ?>
		<?php if(get_field('lead')): ?>
			<p class="post__lead"><?php the_field('lead'); ?></p>
		<?php endif; ?>
		<div class="post__meta">
			<?php 
				edp_posted_by();
				edp_posted_on();
			?>
		</div>
	</header>
	<div class="post__content">
		<?php the_content();?>
	</div>

	<footer class="post__footer">
		<?php edp_post_tags(); ?>
		<?php edp_share_this(); ?>
	</footer>
</article>
