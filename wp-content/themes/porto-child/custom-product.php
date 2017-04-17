<?php
/*
 * Template Name: Custom-Product
 * @package porto-child
 */
get_header();

$parents_cat_list = get_terms('product-cat', array( 'parent' => 0 ) );
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
get_footer(); ?>