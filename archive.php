<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eduardo_Domingos_Photography
 */

get_header();

$has_post_listing = false;
?>
<div class="site-content">
	<main id="primary" class="site-main">
		<?php if ( have_posts() ) : ?>
			
			<header class="page__header">
				<div class="container">
					<?php
					the_archive_title( '<h1 class="page__title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</div>
			</header>
	
			<?php
			$archive_cat_ID = get_query_var('cat');
			$category_slug = get_category($archive_cat_ID)->slug;
			$query = new WP_Query(array(
				'posts_per_page'	=> -1,
				'post_type'			=> 'archive_landing'
			));
			while ( $query->have_posts() ) {
				$query->the_post();
				if(get_field('category') && get_field('category') == $archive_cat_ID ) {
					$has_post_listing = edp_has_module('post_listing');
					edp_modules();					
				}
			}
			?>
			<div class="container">
				<section class="section post-listing">
					<?php if($has_post_listing): ?>
					<header class="section__header">
						<div>
						<h2 class="section__title <?php echo $category_slug ? ' section__title--'.$category_slug : '';?>">+ <?php echo get_cat_name($archive_cat_ID); ?></h2>
						</div>
					</header>
					<?php endif; ?>
					<ul class="post-listing__list post-listing__list--4up">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						echo '<li class="post-listing__item">';
						get_template_part( 'template-parts/content', 'teaser' );
						echo '</li>';
					endwhile;
					?>
					</ul>
				</section>
				<?php the_posts_navigation(); ?>
			</div>

		<?php endif; ?>
	</main>
</div>
<?php
get_footer();
