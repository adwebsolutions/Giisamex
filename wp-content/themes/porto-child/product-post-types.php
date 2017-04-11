<?php

// function: post_type BEGIN
function post_type() {
    $labels = array(
        'name'                  => _x( 'Products', 'porto-child' ),
        'singular_name'         => _x( 'Product', 'porto-child' ),
        'menu_name'             => _x( 'Products', 'admin menu', 'porto-child' ),
        'add_new'               => _x( 'Add New', 'product','porto-child' ),
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
        'rewrite'               => array( 'slug' => __( 'product' ) ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => null,
        'supports'              => array( 'title','editor', 'thumbnail', 'excerpt' )
    );
    register_post_type(__( 'product' ), $args);
}
function product_messages($messages)
{
    $messages[__( 'product' )] =
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
        __( "product_category" ),
        array(__( "product" )),
        array(
            "hierarchical" => true,
            "label" => __( "Categories" ),
            "singular_label" => __( "Category" ),
            "rewrite" => array(
                'slug' => 'product_category',
                'hierarchical' => true
            )
        )
    );
} // function: products_filter END

add_action( 'init', 'post_type' );
add_action( 'init', 'product_filter', 0 );
add_filter( 'post_updated_messages', 'product_messages' );