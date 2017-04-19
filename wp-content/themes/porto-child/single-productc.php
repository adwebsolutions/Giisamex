<?php
/**
 * @package porto-child
 */
get_header() ?>
<?php
wp_reset_postdata();
global $porto_settings, $porto_layout;
$options = array();
$options['themeConfig'] = true;
$options['lg'] = $porto_settings['post-related-cols'];
if ($porto_layout == 'wide-left-sidebar' || $porto_layout == 'wide-right-sidebar' || $porto_layout == 'left-sidebar' || $porto_layout == 'right-sidebar')
    $options['lg']--;
if ($options['lg'] < 1)
    $options['lg'] = 1;
$options['md'] = $porto_settings['post-related-cols'] - 1;
if ($options['md'] < 1)
    $options['md'] = 1;
$options['sm'] = $porto_settings['post-related-cols'] - 2;
if ($options['sm'] < 1)
    $options['sm'] = 1;
$options = json_encode($options);
echo $post_layout;
?>

    <div id="content" role="main" class="<?php if ($porto_layout === 'widewidth' || $porto_layout === 'wide-left-sidebar' || $porto_layout === 'wide-right-sidebar') { echo 'm-t-lg m-b-xl'; if (porto_get_wrapper_type() !=='boxed') echo ' m-r-md m-l-md'; } ?>">
        <?php if (have_posts()) : the_post();
            $post_layout = get_post_meta($post->ID, 'post_layout', true);
            $post_layout = ($post_layout == 'default' || !$post_layout) ? $porto_settings['post-content-layout'] : $post_layout;
            if ($post->post_type == 'productc') :
                if ($porto_settings['post-backto-blog']) : ?><a class="inline-block m-b-md" href="<?php echo get_post_type_archive_link('post') ?>"><i class="fa fa-long-arrow-<?php echo (is_rtl() ? 'right p-r-xs' : 'left p-l-xs') ?>"></i> <?php echo sprintf( __( 'Back to %s', 'porto' ), porto_title_archive_name('post') ); ?></a><?php endif; ?>
                <?php get_template_part( 'content', 'single-custom-product' ); ?>
                <?php
                if ($porto_settings['post-backto-blog']) : ?><a class="inline-block m-t-md m-b-md" href="<?php echo get_post_type_archive_link('post') ?>"><i class="fa fa-long-arrow-<?php echo (is_rtl() ? 'right p-r-xs' : 'left p-l-xs') ?>"></i> <?php echo sprintf( __( 'Back to %s', 'porto' ), porto_title_archive_name('post') );  ?></a><?php endif;
                if ($porto_settings['post-related']) :
                    $related_posts = get_related_products($post->ID);
                    $related_cats = get_the_terms($post->ID, 'product-cat');
                    if ($related_posts->have_posts()) : ?>
                        <hr class="tall"/>
                        <div class="related-posts">
                            <h4 class="sub-title"><?php echo __('Related Products', 'porto-child'); ?></h4>
                            <h5>Categorías: <span>
                                    <?php
                                    $first = true;
                                    foreach($related_cats as $related_cat):
                                        //var_dump($related_cat);
                                        if($related_cat->count > 1):
                                            echo ($first == false)? ' | ':"";
                                            echo '<a href="'.get_term_link( $related_cat ).'">';
                                            echo $related_cat->name;
                                            echo '</a>';
                                            $first = false;
                                        endif;
                                    endforeach; ?>
                                </span></h5>
                            <div class="row">
                                <div class="post-carousel porto-carousel owl-carousel show-nav-title" data-plugin-options="<?php echo esc_attr($options) ?>">
                                    <?php
                                    while ($related_posts->have_posts()) {
                                        $related_posts->the_post();
                                        get_template_part('content', 'productc-item');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif;
                endif;
            else : ?>
                <?php get_template_part('content'); ?>
            <?php endif;
        endif; ?>
    </div>
<?php get_footer() ?>