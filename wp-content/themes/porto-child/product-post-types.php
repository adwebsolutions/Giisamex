<?php

// function: post_type BEGIN
register_activation_hook( __FILE__, function () {
    post_type();
    flush_rewrite_rules();
} );
register_deactivation_hook( __FILE__, function () {
    flush_rewrite_rules();
} );
add_action( 'init', 'post_type' );
function post_type() {
    $labels = array(
        'name'                  => _x( 'Products', 'porto-child' ),
        'singular_name'         => _x( 'Product', 'porto-child' ),
        'menu_name'             => _x( 'Products', 'admin menu', 'porto-child' ),
        'add_new'               => _x( 'Add New', 'productc','porto-child' ),
        'add_new_item'          => __( 'Add New Product', 'porto-child' ),
        'edit_item'             => __( 'Edit Products', 'porto-child' ),
        'new_item'              => __( 'New Products', 'porto-child' ),
        'view_item'             => __( 'View Products', 'porto-child' ),
        'all_items'             => __( 'All Products', 'porto-child' ),
        'search_items'          => __( 'Search Products', 'porto-child' ),
        'not_found'             => __( 'No Products Found', 'porto-child' ),
        'not_found_in_trash'    => __( 'No Products Found In Trash', 'porto-child' ),
        'parent_item_colon'     => '',
    );
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => __( 'productc' ) ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => null,
        'supports'              => array( 'title','editor', 'thumbnail', 'excerpt' )
    );
    register_post_type(__( 'productc' ), $args);
}



function product_messages($messages)
{
    $messages[__( 'productc' )] =
        array(
            0 => '',
            1 => sprintf(('Product Updated. <a href="%s">View Product</a>'), esc_url(get_permalink($post_ID))),
            2 => __('Custom Field Updated.', 'porto-child' ),
            3 => __('Custom Field Deleted.', 'porto-child' ),
            4 => __('Product Updated.', 'porto-child' ),
            5 => isset($_GET['revision']) ? sprintf( __('Product Restored To Revision From %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
            6 => sprintf(__('Product Published. <a href="%s">View Product</a>'), esc_url(get_permalink($post_ID))),
            7 => __('Products Saved.'),
            8 => sprintf(__('Product Submitted. <a target="_blank" href="%s">Preview Product</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf(__('Product Scheduled For: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf(__('Product Draft Updated. <a target="_blank" href="%s">Preview Product</a>'), esc_url( add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );
    return $messages;

} // function: product_messages END

// function: product_filter BEGIN
function product_filter()
{
    register_taxonomy(
        __( "product-cat" ),
        array(__( "productc" )),
        array(
            "hierarchical" => true,
            "label" => __( "Product Categories" ),
            "singular_label" => __( "Product Category" ),
            "query_var" => true,
            "rewrite" => array(
                'slug' => 'product-cat',
                'hierarchical' => true
            )
        )
    );
} // function: products_filter END

add_action( 'init', 'product_filter', 0 );
add_filter( 'post_updated_messages', 'product_messages' );

function taxonomy_slug_rewrite($wp_rewrite) {
    $rules = array();
    // get all custom taxonomies
    $taxonomies = get_taxonomies(array('_builtin' => false), 'objects');
    // get all custom post types
    $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');

    foreach ($post_types as $post_type) {
        foreach ($taxonomies as $taxonomy) {

            // go through all post types which this taxonomy is assigned to
            foreach ($taxonomy->object_type as $object_type) {

                // check if taxonomy is registered for this custom type
                if ($object_type == $post_type->rewrite['slug']) {

                    // get category objects
                    $terms = get_categories(array('type' => $object_type, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));

                    // make rules
                    foreach ($terms as $term) {
                        $rules[$object_type . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
                    }
                }
            }
        }
    }
    // merge with global rules
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', 'taxonomy_slug_rewrite');
