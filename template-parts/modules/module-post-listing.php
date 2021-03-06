<?php
// echo '<pre>';
// print_r($data);
// echo '</pre>';

$title = $data['title'];
$bg_color = $data['bg_color'];
$description = $data['description'];
$list_type = $data['list_type'];
$limit_by_category = $data['limit_by_category'];
$featured_posts = $data['featured_posts'];
$layout = $data['layout'];
$posts_per_page = $data['posts_per_page'];

if($list_type === 'latest') {
    $query_args = array('posts_per_page' => $posts_per_page );

    if($limit_by_category) {
        $query_args['cat'] = $limit_by_category;
        $link_url = get_category_link($limit_by_category);
        $link_label = get_cat_name($limit_by_category);
        $category_slug = get_category($limit_by_category)->slug;
    } else {
        $onlineLessonsCatID = get_category_by_slug(LESSON_CATEGORIES['lessons'])->term_id;
        $workshopsCatID = get_category_by_slug(LESSON_CATEGORIES['workshops'])->term_id;
        $query_args['category__not_in'] = array($onlineLessonsCatID, $workshopsCatID);
        $link_url = get_permalink( get_option( 'page_for_posts' ) );
        $link_label = 'Artigos';
    }
    $query = new WP_Query($query_args);
} else {
    if($data['link']) {
        $link_url = get_category_link($data['link']);
        $link_label = get_cat_name($data['link']);
    }
}

$tag = 'div';
if ( $title ) {
    $tag = 'section';
}
?>
<<?php echo $tag; ?> class="section <?php echo 'section--'.$bg_color; ?> post-listing">
    <div class="container">
        <?php if($title): ?>
            <header class="section__header">
                <div>
                    <h2 class="section__title<?php echo $category_slug ? ' section__title--'.$category_slug : '';?>"><?php echo $title; ?></h2>
                    <?php if($link_label && $link_url): ?>
                        <a class="section__link button button--secondary" href="<?php echo esc_url($link_url); ?>">+ <?php echo $link_label; ?></a>
                    <?php endif; ?>
                </div>
                <?php if($description): ?>
                    <p class="section__description"><?php echo $description; ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>
        <?php  if( ($list_type === 'latest' && $query->have_posts()) || ($list_type === 'featured' && $featured_posts)) :?>
            <ul class="post-listing__list <?php echo 'post-listing__list--'.$layout.'up'; ?>">
            <?php
            if($list_type === 'latest') {
                while( $query->have_posts() ) {
                    $query->the_post();
                    echo '<li class="post-listing__item">';
                    edp_get_template_part('template-parts/content', 'teaser', array('layout'=> $layout));
                    echo '</li>';
                }
                wp_reset_postdata();
            } else {
                global $post;
                foreach ($featured_posts as $post) {
                    setup_postdata($post);
                    echo '<li class="post-listing__item">';
                    edp_get_template_part('template-parts/content', 'teaser', array('layout'=> $layout));
                    echo '</li>';
                }
            }
            ?>
            </ul>
        <?php endif;?>
    </div>
</<?php echo $tag; ?>>
