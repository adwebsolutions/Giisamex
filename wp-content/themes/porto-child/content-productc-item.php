<?php
global $porto_settings, $porto_post_view, $porto_post_btn_style, $porto_post_btn_size, $porto_post_btn_color, $porto_post_image_size, $porto_post_author, $porto_post_excerpt_length;
$featured_images = porto_get_featured_images();
$attachment = $attachment_related = '';
if (count($featured_images)) {
    $attachment_id = $featured_images[0]['attachment_id'];
    if ($porto_post_image_size) {
        $attachment_related = porto_get_attachment($attachment_id, $porto_post_image_size, true);
    } else {
        $attachment_related = porto_get_attachment($attachment_id, 'full');
    }
    $attachment = porto_get_attachment($attachment_id);
    if (!$attachment_related)
        $attachment_related = $attachment;
}
$post_style = $porto_post_view ? $porto_post_view : $porto_settings['post-related-style'];
$post_thumb_bg = $porto_settings['post-related-thumb-bg'];
$post_thumb_image = $porto_settings['post-related-thumb-image'];
$post_thumb_borders = $porto_settings['post-related-thumb-borders'];
$post_author = $porto_post_author ? ($porto_post_author == 'show' ? true : false) : $porto_settings['post-related-author'];
$excerpt_length = $porto_settings['post-related-excerpt-length'];
if ($porto_post_excerpt_length)
    $excerpt_length = (int)$porto_post_excerpt_length;
$show_date = in_array('date', $porto_settings['post-metas']);

?>
<div class="post-item<?php echo ($porto_settings['post-title-style'] == 'without-icon') ? ' post-title-simple' : '' ?>">
    <?php if ($attachment && $attachment_related) : ?>
    <a href="<?php the_permalink(); ?>">
        <span class="post-image thumb-info<?php echo ($post_thumb_bg ? ' thumb-info-' . $post_thumb_bg : ''); echo ($post_thumb_image ? ' thumb-info-' . $post_thumb_image : ''); echo ($post_thumb_borders ? ' thumb-info-' . $post_thumb_borders : ''); ?> m-b-md">
            <span class="thumb-info-wrapper">
                <img class="img-responsive" width="<?php echo $attachment_related['width'] ?>" height="<?php echo $attachment_related['height'] ?>" src="<?php echo $attachment_related['src'] ?>" alt="<?php echo $attachment_related['alt'] ?>" />
        <?php if ($porto_settings['post-zoom']) : ?>
                <span class="zoom" data-src="<?php echo $attachment['src'] ?>" data-title="<?php echo $attachment['caption'] ?>"><i class="fa fa-search"></i></span>
        <?php endif; ?>
            </span>
        </span>
    </a>
    <?php else :?>
        <?php
        $imageid = 509;
        $attachment = porto_get_attachment($imageid);
        ?>
    <span class="post-image thumb-info<?php echo ($post_thumb_bg ? ' thumb-info-' . $post_thumb_bg : ''); echo ($post_thumb_image ? ' thumb-info-' . $post_thumb_image : ''); echo ($post_thumb_borders ? ' thumb-info-' . $post_thumb_borders : ''); ?> m-b-md">
        <span class="thumb-info-wrapper">
            <img class="owl-lazy img-responsive" width="<?php echo $attachment['width'] ?>" height="<?php echo $attachment['height'] ?>" data-src="<?php echo $attachment['src'] ?>" alt="<?php echo $attachment['alt'] ?>" />
        </span>
    </span>
    <?php endif;?>

    <h4><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
    <div class="clearfix box-btn">
        <a class="btn btn-xs btn-primary" href="<?php the_permalink(); ?>"><?php echo __('More Information','porto-child');?></a>
    </div>
</div>
