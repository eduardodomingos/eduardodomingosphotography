<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Eduardo_Domingos_Photography
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function edp_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( is_single() && is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'content-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'edp_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function edp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'edp_pingback_header' );

/**
 * Get template part with passed arguments.
 * @return file
 */
function edp_get_template_part( $slug, $name = null, $data = array() ) {
    extract( $data );
    if ( $name )
        $file = "{$slug}-{$name}.php";
    else
        $file = "{$slug}.php";
    include locate_template( $file );
}

/**
 * Unset comment form fields.
 */
function edp_unset_comment_form_fields($fields){
	if(isset($fields['cookies'])) {
       unset($fields['cookies']);
	}
    if(isset($fields['url'])) {
       unset($fields['url']);
	}
   return $fields;
}
add_filter('comment_form_default_fields', 'edp_unset_comment_form_fields');

/*
 * Prefix tags with an # symbol
*/
add_filter( 'term_links-post_tag', function ( $links )
{

    // Return if $links are empty
    if ( empty( $links ) )
        return $links;

    // Reset $links to an empty array
    unset ( $links );
    $links = [];

    // Get the current post ID
    $id = get_the_ID();
    // Get all the tags attached to the post
    $taxonomy = 'post_tag';
	$terms = get_the_terms( $id, $taxonomy );
	

    // Make double sure we have tags
    if ( !$terms )
        return $links; 

    // Loop through the tags and build the links
    foreach ( $terms as $term ) {
        $link = get_term_link( $term, $taxonomy );

        // Here we add our hastag, so we get #Tag Name with link
        $links[] = '<a href="' . esc_url( $link ) . '" rel="tag">#' . $term->name . '</a>';
    }

    return $links;
});