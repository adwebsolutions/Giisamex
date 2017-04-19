<?php
/*
 * Template Name: Custom-Product
 * @package porto-child
 */
get_header();

$parents_cat_list = get_terms('product-cat', array( 'parent' => 0 ) );

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
get_footer(); ?>