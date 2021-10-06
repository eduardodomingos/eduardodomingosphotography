<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Eduardo_Domingos_Photography
 */

if ( ! function_exists( 'edp_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function edp_posted_on($classes = array()) {
		$classes[] = 'post__date';
		$time_string = '<time class="published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			'há ' .human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			'há ' . human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) )
		);

		echo ' <span class="'.join( ' ', $classes ).'">'. $time_string . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'edp_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function edp_posted_by() {
		$byline = sprintf(
			esc_html_x( '%1$sPublicado por%2$s %3$s', 'post author', 'edp' ),
			'<span class="screen-reader-text">',
			'</span>',
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		echo '<div class="post__author">';
		echo get_avatar( get_the_author_meta( 'ID' ), 32 );
		echo $byline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	
	}
endif;

if ( ! function_exists( 'edp_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function edp_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'edp' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'edp' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'edp' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'edp' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'edp' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

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
	}
endif;

if ( ! function_exists( 'edp_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function edp_post_thumbnail($cssClasses=array('post__thumbnail'), $show_link = false) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( !$show_link ) :
			?>

			<div class="<?php echo join( ' ', $cssClasses ); ?>">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="<?php echo join( ' ', $cssClasses ); ?>" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'edp_post_bottom_category' ) ) :
	/**
	 * Prints HTML with a link for the bottom post category.
	 */
	function edp_post_bottom_category($cssClasses = array('post__category')) {
		$terms = get_the_category();
		if ( ! is_array( $terms ) || empty( $terms ) ) {
			return false;
		}
		$filter = function($terms) use (&$filter) {
			$return_terms = array();
			$term_ids = array();
			foreach ($terms as $t){
				$term_ids[] = $t->term_id;
			}
			foreach ( $terms as $t ) {
				if( $t->parent == false || !in_array($t->parent,$term_ids) )  {
					//remove this term
				}
				else{
					$return_terms[] = $t;
				}
			}
	
			if( count($return_terms) ){
				return $filter($return_terms);  
			}
			else {
				return $terms;
			}
		};
		$bottom_category_obj = $filter($terms)[0];
		$bottom_category_obj_link = '<a href="' . esc_url(get_category_link( $bottom_category_obj->term_id )) . '">' . esc_html($bottom_category_obj->name) . '</a>';
		echo sprintf( '<p class="'.join( ' ', $cssClasses ).'">' . esc_html__( '%1$sPublicado em%2$s %3$s', 'edp' ) . '</p>', '<span class="screen-reader-text">', '</span>', $bottom_category_obj_link ); // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'edp_price_tag' ) ) :
	/**
	 * Prints HTML with a link for the bottom post category.
	 */
	function edp_price_tag($cssClasses = array(), $show_promo_info) {
		$price = get_field('price',false,false);
		$duration = get_field('duration');
		$promotion = get_field('promotion');
		$promotion_name = $promotion['promotion_name'];
		$promotion_value = $promotion['promotion_value'];
		$promotion_expiry_date = DateTime::createFromFormat('Ymd', $promotion['promotion_expiry_date']);

		if($price) {
			if($promotion_value && edp_discount_is_valid($promotion_expiry_date)) {
				$old_price = $price;
				$price = round($price - ($price * ($promotion_value/100)), 1);
			}
			$old_price.='€';
			$price.='€';
		}
		else {
			$price = 'Preço sob consulta';
		}
		?>
		<div class="<?php echo join( ' ', $cssClasses )?> price-tag">
			<div class="price-tag__price">
				<?php if($promotion_value && edp_discount_is_valid($promotion_expiry_date)): ?>
					<span class="price-tag__discount">- <?php echo $promotion_value; ?>%</span>
				<?php endif;?>
				<?php if($old_price): ?>
					<s><?php echo $old_price; ?></s>
				<?php endif;?>
				<span><?php echo $price; ?></span>
			</div>
			<?php if($duration): ?>
				<div class="price-tag__duration"><?php echo $duration; ?></div>
			<?php endif;?>
		</div>
		<?php
	}

	function edp_discount_is_valid($expiry_date) {
		$today = new DateTime();
		if( $expiry_date >= $today) {
		 	return true;
		}
		return false;
	}
endif;

if ( ! function_exists( 'edp_post_tags' ) ) :
	/**
	 * Prints HTML with meta information for the tags.
	 */
	function edp_post_tags() {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list('',' ');
		if ( $tags_list ) {
			?>
			<p class="post__tags"><span class="screen-reader-text">Etiquetas</span> <?php echo $tags_list?></p>
			<?php
		}
	}
endif;

if ( ! function_exists( 'edp_share_this' ) ) :
	/**
	 * Displays the share buttons.
	 */
	function edp_share_this() {
		$url = urlencode(get_the_permalink());
		$title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
		?>
		<div class="post__share">
			<p>Partilhe:</p>
			<ul class="social__list">
				<li class="social__item social__item--facebook">
					<a class="social__link" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" title="Partilhar no Facebook">
						<span class="screen-reader-text">Partilhar no Facebook</span>
					</a>
				</li>
				<li class="social__item social__item--twitter">
					<a class="social__link" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>&amp;via=amaedoandre" title="Partilhar no Twitter">
						<span class="screen-reader-text">Partilhar no Twitter</span>
					</a>
				</li>
				<li class="social__item social__item--email">
					<a class="social__link" href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&amp;body=Acabei de ler este artigo no blog A Mãe do André: <?php echo $url; ?>" title="Enviar por email">
						<span class="screen-reader-text">Enviar por email</span>
					</a>
				</li>
			</ul>
			
		</div>
	<?php
	}
endif;


if ( ! function_exists( 'edp_get_latest_posts' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function edp_get_latest_posts_from_category($number_of_posts = 3) {
		$cats = get_the_category();
		$top_cat_obj = array();

		foreach($cats as $cat) {
			if ($cat->parent == 0) {
				$top_cat_obj[] = $cat;  
			}
		}
		$top_cat_obj = $top_cat_obj[0];
		$catName = $top_cat_obj -> name;
		$catID = $top_cat_obj -> cat_ID;

		// $title = $data['title'];
		// $description = $data['description'];
		// $list_type = $data['list_type'];
		// $limit_by_category = $data['limit_by_category'];
		// $featured_posts = $data['featured_posts'];
		// $layout = $data['layout'];
		// $posts_per_page = $data['posts_per_page'];

		$data = array(
			'title' => '+ ' . $catName,
			'description' => 'Artigos mais recentes na categoria ' . $catName,
			'list_type' => 'latest',
			'limit_by_category' => $catID,
			'layout' => 3,
			'posts_per_page' => $number_of_posts
		);


		// echo '<section class="section post-listing">';
		edp_get_template_part('template-parts/modules/module', 'post-listing', array('data' => $data));
		// echo '</section>';
	}
endif;
