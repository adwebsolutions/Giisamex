<?php
/**
 * @package porto-child
 */
?>

<?php get_header() ?>
<?php
global $porto_settings, $porto_layout;
$post_layout = $porto_settings['post-layout'];
$post_infinite = $porto_settings['blog-infinite'];
if ( is_category() ) {
    global $wp_query;
    $term = $wp_query->queried_object;
    $term_id = $term->term_id;
    $post_options = get_metadata($term->taxonomy, $term->term_id, 'post_options', true) == 'post_options' ? true : false;
    $post_layout = $post_options ? get_metadata($term->taxonomy, $term->term_id, 'post_layout', true) : $post_layout;
    $post_infinite = $post_options ? (get_metadata($term->taxonomy, $term->term_id, 'post_infinite', true) != 'post_infinite' ? true : false ) : $post_infinite;
}

if ($post_infinite) {
    global $wp_rewrite, $wp_query;
    $page_num = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $page_link = get_pagenum_link();
    $page_max_num = $wp_query->max_num_pages;
    if ( !$wp_rewrite->using_permalinks() || is_admin() || strpos($page_link, '?') ) {
        if (strpos($page_link, '?') !== false)
        $page_path = apply_filters( 'get_pagenum_link', $page_link . '&amp;paged=');
        else
            $page_path = apply_filters( 'get_pagenum_link', $page_link . '?paged=');
    } else {
        $page_path = apply_filters( 'get_pagenum_link', $page_link . user_trailingslashit( $wp_rewrite->pagination_base . "/" ));
    }
}
?>

<div id="content" role="main" class="<?php if ($porto_layout === 'widewidth' || $porto_layout === 'wide-left-sidebar' || $porto_layout === 'wide-right-sidebar') { echo 'm-t-lg m-b-xl'; if (porto_get_wrapper_type() !=='boxed') echo ' m-r-md m-l-md'; } ?>">
    <?php if ( have_posts() ) : ?>
        <?php if (category_description()) : ?>
            <div class="page-content">
                <?php echo category_description() ?>
            </div>
        <?php endif; ?>
		<?php if ($post_layout == 'timeline') {
            global $prev_post_year, $prev_post_month, $first_timeline_loop, $post_count;
            $prev_post_year = null;
            $prev_post_month = null;
            $first_timeline_loop = false;
            $post_count = 1;
            ?>
        <div class="blog-posts posts-<?php echo $post_layout ?><?php if ($post_infinite) echo ' infinite-container' ?><?php if ($porto_settings['post-style'] == 'related') : ?> blog-posts-related<?php endif; ?>">
            <section class="timeline">
                <div class="timeline-body<?php if ($post_infinite) echo ' posts-infinite' ?>"<?php if ($post_infinite) : ?> data-pagenum="<?php echo esc_attr($page_num) ?>" data-pagemaxnum="<?php echo esc_attr($page_max_num) ?>" data-path="<?php echo esc_url($page_path) ?>"<?php endif; ?>>
        <?php } else if ($post_layout == 'grid') { ?>
        <div class="blog-posts posts-<?php echo $post_layout ?><?php if ($post_infinite) echo ' infinite-container' ?><?php if ($porto_settings['post-style'] == 'related') : ?> blog-posts-related<?php endif; ?>">

            <div class="grid row<?php if ($post_infinite) echo ' posts-infinite' ?>"<?php if ($post_infinite) : ?> data-pagenum="<?php echo esc_attr($page_num) ?>" data-pagemaxnum="<?php echo esc_attr($page_max_num) ?>" data-path="<?php echo esc_url($page_path) ?>"<?php endif; ?>>
        <?php } else { ?>
        <div class="blog-posts posts-<?php echo $post_layout ?><?php if ($post_infinite) echo ' infinite-container posts-infinite' ?>"<?php if ($post_infinite) : ?> data-pagenum="<?php echo esc_attr($page_num) ?>" data-pagemaxnum="<?php echo esc_attr($page_max_num) ?>" data-path="<?php echo esc_url($page_path) ?>"<?php endif; ?>>
        <?php } ?>

        <?php $parents_cat_list = get_terms('product-cat', array( 'parent' => 0 ) );
		    //var_dump($parents_cat_list);

			if ( $parents_cat_list && !is_wp_error( $parents_cat_list ) ) {
				echo '<ul class="custom-archive-list">';
				foreach( $parents_cat_list as $parent_cats ):
					$term_id = $parent_cats->term_id;
					$custom_data = get_term_meta($term_id,'image_field_id');
					echo '<li class="custom-post">';
					echo '<a href="' . get_term_link( $parent_cats ) . '">';
					echo '<img src="'.$custom_data[0]['url'].'">';
					echo '<span class="custom-cat-title">' . $parent_cats->name . '</span>';
					echo '<span class="cat-prod-count">';
					if ($parent_cats->count==1) :
						echo $parent_cats->count.'&nbsp;Producto';
					else :
						echo $parent_cats->count.'&nbsp;Productos';
					endif;
					echo '</span>';
					echo '</a></li> ';
				endforeach;
				echo'</ul>';
			}
        ?>
        <?php if ($post_layout == 'timeline') { ?>
                </div>
            </section>
        <?php } else if ($post_layout == 'grid') { ?>
            </div>
        <?php } else { ?>
        <?php } ?>

        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <h2 class="entry-title"><?php _e( 'Nothing Found', 'porto' ); ?></h2>
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
            <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'porto' ), admin_url( 'post-new.php' ) ); ?></p>
        <?php elseif ( is_search() ) : ?>

            <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'porto' ); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'porto' ); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php get_footer() ?>
