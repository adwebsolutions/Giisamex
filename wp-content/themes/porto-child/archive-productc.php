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
    <?php if ( have_posts() ) : ?>


        <?php $parents_cat_list = get_terms('product-cat', array( 'parent' => 0 ) );
		    //var_dump($parents_cat_list);

			if ( $parents_cat_list && !is_wp_error( $parents_cat_list ) ) {
				echo '<ul class="custom-archive-list">';
				foreach( $parents_cat_list as $parent_cats ):
					$term_id = $parent_cats->term_id;
					$custom_data = get_term_meta($term_id,'image_field_id');
                    $child_list = get_term_children($term_id,'product-cat');
					echo '<li class="custom-post">';
                    $post_link = get_term_link( $parent_cats );
                    if (($parent_cats->count == 1)&&(count($child_list)==0)) :
                        $arg_post = array (
                            'posts_per_page' => -1,
                            'post_type' => 'productc',
                            'order' => 'ASC',
                            'orderby' => 'ID',
                            'tax_query' => [
                                'relation' => 'AND',[
                                    'taxonomy' => 'product-cat',
                                    'terms' => $term_id,
                                    'field' => 'term_id',
                                    'operator' => 'IN'
                                ]
                            ]);
                        $wpbp = new WP_Query($arg_post );
                        if ($wpbp->post_count == 1){
                            $post_link = get_post_permalink($wpbp->posts[0]->ID);
                        }
                        wp_reset_query();
                    endif;
					echo '<a href="' . $post_link . '">';
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
<?php get_footer() ?>
