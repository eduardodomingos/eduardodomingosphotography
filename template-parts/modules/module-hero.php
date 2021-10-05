<?php
$title = $data['title'];
$text = $data['text'];
$link_type = $data['link']['link_type'];
$link_text = $data['link']['link_text'];
if($link_type === 'page') {
    $link_url = $data['link']['link_page'];
}
else {
    $link_url = get_category_link($data['link']['link_category']);
}
$image =  $data['background']['image'];
$opacity =  $data['background']['opacity']/100;
?>

<?php if($image): ?>
<div class="hero">
    <?php if($image): 
        $size = 'full';
        $image_src = wp_get_attachment_image_url( $image, $size );
        $image_srcset = wp_get_attachment_image_srcset( $image, $size );
        $image_sizes = wp_get_attachment_image_sizes($image, $size );
        $image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true) ?:'';
        ?>
        <img class="hero__image" src="<?php echo $image_src; ?>" srcset="<?php echo $image_srcset; ?>" sizes="<?php echo $image_sizes; ?>" alt="<?php echo $image_alt; ?>" style="opacity:<?php echo $opacity; ?>;" />
    <?php endif; ?>
    <div class="container">
        <?php if($title): ?>
        <p class="hero__title"><?php echo strip_tags($title); ?></p>
        <?php endif; ?>

        <?php if($text): ?>
        <p class="hero__text"><?php echo strip_tags($text); ?></p>
        <?php endif; ?>

        <?php if($link_text && $link_url): ?>
        <a href="<?php echo esc_url($link_url); ?>" class="hero__link button button--fat"><?php echo strip_tags($link_text); ?></a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
