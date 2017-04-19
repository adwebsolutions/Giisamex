<?php

add_action('wp_enqueue_scripts', 'porto_child_css', 1001);
 
// Load CSS
function porto_child_css() {
    // porto child theme styles
    wp_deregister_style( 'styles-child' );
    wp_register_style( 'styles-child', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'styles-child' );

    if (is_rtl()) {
        wp_deregister_style( 'styles-child-rtl' );
        wp_register_style( 'styles-child-rtl', get_stylesheet_directory_uri() . '/style_rtl.css' );
        wp_enqueue_style( 'styles-child-rtl' );
    }
}
include dirname( __FILE__ ) . '/product-post-types.php';
require_once (dirname( __FILE__ ) . "/Tax-meta-class/Tax-meta-class.php");
$config = array(
    'id' => 'demo_meta_box',                         // meta box id, unique per meta box
    'title' => 'Demo Meta Box',                      // meta box title
    'pages' => array('product-cat'),                 // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),                             // list of meta fields (can be added by field arrays)
    'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => get_stylesheet_directory_uri() . '/Tax-meta-class'               //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);

$my_meta = new Tax_Meta_Class($config);
$my_meta->addImage('image_field_id',array('name'=> __('Category Image','porto-child')));
$my_meta->Finish();
//file upload field
function porto_child_meta_layout() {
    global $wp_query, $porto_settings;
    $value = isset($porto_settings['layout']) ? $porto_settings['layout'] : $porto_settings['layout'];
    $default = porto_meta_use_default();
    if ((class_exists('bbPress') && is_bbpress()) || (class_exists('BuddyPress') && is_buddypress())) {
        $value = $porto_settings['bb-layout'];
    } else if (is_404()) {
        $value = 'fullwidth';
    } else if (is_category()) {
        $cat = $wp_query->get_queried_object();
        if ($default)
            $value = $porto_settings['post-archive-layout'];
        else
            if ($cat) $value = get_metadata('category', $cat->term_id, 'layout', true);
    } else if (is_archive()) {
        if (function_exists('is_shop') && is_shop())  {
            if ($default)
                $value = $porto_settings['product-archive-layout'];
            else
                $value = get_post_meta(wc_get_page_id( 'shop' ), 'layout', true);
        } else if (function_exists('is_porto_portfolios_page') && is_porto_portfolios_page() && ($archive_page = porto_portfolios_page_id())) {
            if ($default)
                $value = $porto_settings['portfolio-archive-layout'];
            else
                $value = get_post_meta($archive_page, 'layout', true);
        } else if (function_exists('is_porto_members_page') && is_porto_members_page() && ($archive_page = porto_members_page_id())) {
            if ($default)
                $value = $porto_settings['member-archive-layout'];
            else
                $value = get_post_meta($archive_page, 'layout', true);
        } else if (function_exists('is_porto_faqs_page') && is_porto_faqs_page() && ($archive_page = porto_faqs_page_id())) {
            if ($default)
                $value = $porto_settings['faq-archive-layout'];
            else
                $value = get_post_meta($archive_page, 'layout', true);
        } else if (function_exists('is_porto_events_page') && is_porto_events_page() && ($archive_page = is_porto_events_page())) {
            if ($default)
                $value = $porto_settings['event-archive-layout'];
            else
                $value = get_post_meta($archive_page, 'layout', true);
        } else {
            if (is_post_type_archive('portfolio')) {
                $value = $porto_settings['portfolio-archive-layout'];
            } else if (is_post_type_archive('member')) {
                $value = $porto_settings['member-archive-layout'];
            } else if (is_post_type_archive('faq')) {
                $value = $porto_settings['faq-archive-layout'];
            } else if (is_post_type_archive('event')) {
                $value = $porto_settings['event-archive-layout'];
            } else {
                $term = get_queried_object();
                if ($term && isset($term->taxonomy) && isset($term->term_id)) {
                    if ($default) {
                        switch ($term->taxonomy) {
                            case in_array($term->taxonomy, porto_get_taxonomies('portfolio')):
                                $value = $porto_settings['portfolio-archive-layout'];
                                break;
                            case in_array($term->taxonomy, porto_get_taxonomies('product')):
                                $value = $porto_settings['product-archive-layout'];
                                break;
                            case 'product_cat':
                                $value = $porto_settings['product-archive-layout'];
                                break;
                            case in_array($term->taxonomy, porto_get_taxonomies('member')):
                                $value = $porto_settings['member-archive-layout'];
                                break;
                            case in_array($term->taxonomy, porto_get_taxonomies('faq')):
                                $value = $porto_settings['faq-archive-layout'];
                                break;
                            case in_array($term->taxonomy, porto_get_taxonomies('post')):
                                $value = $porto_settings['post-archive-layout'];
                                break;
                            default:
                                $value = $porto_settings['layout'];
                        }
                    } else {
                        $value = get_metadata($term->taxonomy, $term->term_id, 'layout', true);
                    }
                } else if (is_tag()) {
                    $value = $porto_settings['post-archive-layout'];
                }
            }
        }
    } else {
        if (is_singular()) {
            if ($default) {
                switch (get_post_type()) {
                    case 'productc':
                        $value = $porto_settings['post-single-layout'];
                        break;
                    case 'product':
                        $value = $porto_settings['product-single-layout'];
                        break;
                    case 'portfolio':
                        $value = $porto_settings['portfolio-single-layout'];
                        break;
                    case 'member':
                        $value = $porto_settings['member-single-layout'];
                        break;
                    case 'post':
                        $value = $porto_settings['post-single-layout'];
                        break;
                    default:
                        $value = $porto_settings['layout'];
                }
            } else {
                $value = get_post_meta(get_the_id(), 'layout', true);
            }
        } else {
            if (!is_home() && is_front_page()) {
                $value = $porto_settings['layout'];
            } else if (is_home() && !is_front_page()) {
                $value = $porto_settings['post-archive-layout'];
            } else if (is_home() || is_front_page()) {
                $value = $porto_settings['layout'];
            }
        }
    }
    return apply_filters('porto_meta_layout', $value);
}

function get_related_products($post_id) {
    global $porto_settings;
    $args = '';

    $item_cats = get_the_terms($post_id, 'product-cat');
    $item_array = array();
    if ($item_cats) :
        foreach($item_cats as $item_cat) {
            $item_array[] = $item_cat->term_id;
        }
    endif;



    $args = wp_parse_args($args, array(
        'showposts' => $porto_settings['post-related-count'],
        'post__not_in' => array($post_id),
        'ignore_sticky_posts' => 0,
        'post_type' => 'productc',
        'tax_query' => array(
            array(
                'taxonomy' => 'product-cat',
                'field' => 'id',
                'terms' => $item_array
            )
        ),
        'orderby' => $porto_settings['post-related-orderby']

    ));
    $query = new WP_Query($args);
    return $query;
}


function porto_child_breadcrumbs() {

    // use yoast breadcrumbs if enabled
    if ( function_exists( 'yoast_breadcrumb' ) ) {
        $yoast_breadcrumbs = yoast_breadcrumb('', '', false);
        if ($yoast_breadcrumbs) {
            return $yoast_breadcrumbs;
        }
    }

    global $porto_settings;

    $post = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
    $output = '';

    //NA add breadcrumbs prefix
    if ( ! is_front_page() ) {
        if ( isset($porto_settings['breadcrumbs-prefix']) && $porto_settings['breadcrumbs-prefix'] ) {
            $output .= '<span class="breadcrumbs-prefix">' . $porto_settings['breadcrumbs-prefix'] . '</span>';
        }
    }

    // breadcrumbs start wrap
    $output .= '<ul class="breadcrumb">';

    //** add home link
    if ( ! is_front_page() ) {
        $output .= porto_breadcrumbs_link( __('Home', 'porto-child'), apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
    } elseif ( is_home() ) {
        $output .= porto_breadcrumbs_link( $porto_settings['blog-title'] );
    }

    //NA add woocommerce shop page link
    if ( class_exists( 'WooCommerce' ) && ( ( is_woocommerce() && is_archive() && ! is_shop() ) || is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
        $output .= porto_breadcrumbs_shop_link();
    }

    //NA add bbpress forums link
    if ( class_exists( 'bbPress' ) && is_bbpress() && ( bbp_is_topic_archive() || bbp_is_single_user() || bbp_is_search() || bbp_is_topic_tag()  || bbp_is_edit() ) ) {
        $output .= porto_breadcrumbs_link( bbp_get_forum_archive_title(), get_post_type_archive_link( 'forum' ) );
    }

    //**
    if ( is_singular() ) {
        if ( isset( $post->post_type ) && $post->post_type !== 'product' && get_post_type_archive_link( $post->post_type ) && (isset($porto_settings['breadcrumbs-archives-link']) && $porto_settings['breadcrumbs-archives-link']) ) {
            $output .= porto_breadcrumbs_archive_link();
        } elseif ( isset( $post->post_type ) && $post->post_type == 'post' && get_option( 'show_on_front' ) == 'page' && (isset($porto_settings['breadcrumbs-blog-link']) && $porto_settings['breadcrumbs-blog-link']) ) {
            $output .= porto_breadcrumbs_link( get_the_title( get_option('page_for_posts', true) ), get_permalink( get_option('page_for_posts' ) ) );
        }

        if ( isset( $post->post_parent ) && $post->post_parent == 0 ) {
            $output .= porto_breadcrumbs_terms_link();
        } else {
            $output .= porto_breadcrumbs_ancestors_link();
        }
        $output .= porto_breadcrumb_leaf();
    } else {
        if ( is_post_type_archive() ) {
            if ( is_search() ) {
                $output .= porto_breadcrumbs_archive_link();
                $output .= porto_breadcrumb_leaf( 'search' );
            } else {
                $output .= porto_breadcrumbs_archive_link( false );
            }
        } elseif ( is_tax() || is_tag() || is_category() ) {
            $html = porto_breadcrumbs_taxonomies_link();
            $html .= porto_breadcrumb_leaf( 'term' );



            if ( is_tag() ) {
                if ( get_option( 'show_on_front' ) == 'page' && (isset($porto_settings['breadcrumbs-blog-link']) && $porto_settings['breadcrumbs-blog-link']) ) {
                    $output .= porto_breadcrumbs_link( get_the_title( get_option('page_for_posts', true) ), get_permalink( get_option('page_for_posts' ) ) );
                }
                $output .= sprintf( __( 'Tag - %s', 'porto' ), $html );
            } elseif ( is_tax('product_tag') ) {
                $output .= sprintf( __( 'Product Tag - %s', 'porto' ), $html );
            } else {
                if ( is_category() && get_option( 'show_on_front' ) == 'page' && (isset($porto_settings['breadcrumbs-blog-link']) && $porto_settings['breadcrumbs-blog-link']) ) {
                    $output .= porto_breadcrumbs_link( get_the_title( get_option('page_for_posts', true) ), get_permalink( get_option('page_for_posts' ) ) );
                }
//Added
                if ( is_tax('product-cat') ) {
                    $output .= porto_breadcrumbs_link( porto_breadcrumbs_archive_name('productc'), get_post_type_archive_link( 'productc' ) );
                }

                if ( is_tax('portfolio_cat') || is_tax('portfolio_skills') ) {
                    $output .= porto_breadcrumbs_link( porto_breadcrumbs_archive_name('portfolio'), get_post_type_archive_link( 'portfolio' ) );
                }

                if ( is_tax('member_cat') ) {
                    $output .= porto_breadcrumbs_link( porto_breadcrumbs_archive_name('member'), get_post_type_archive_link( 'member' ) );
                }

                if ( is_tax('faq_cat') ) {
                    $output .= porto_breadcrumbs_link( porto_breadcrumbs_archive_name('faq'), get_post_type_archive_link( 'faq' ) );
                }
                $output .= $html;
            }
        } elseif ( is_date() ) {
            global $wp_locale;

            if ( get_option( 'show_on_front' ) == 'page' && (isset($porto_settings['breadcrumbs-blog-link']) && $porto_settings['breadcrumbs-blog-link']) ) {
                $output .= porto_breadcrumbs_link( get_the_title( get_option('page_for_posts', true) ), get_permalink( get_option('page_for_posts' ) ) );
            }

            $year = esc_html( get_query_var( 'year' ) );

            if ( is_month() || is_day() ) {
                $month = get_query_var( 'monthnum' );
                $month_name = $wp_locale->get_month( $month );
            }

            if ( is_year() ) {
                $output .= porto_breadcrumb_leaf( 'year' );
            } elseif ( is_month() ) {
                $output .= porto_breadcrumbs_link( $year, get_year_link( $year ) );
                $output .= porto_breadcrumb_leaf( 'month' );
            } elseif ( is_day() ) {
                $output .= porto_breadcrumbs_link( $year, get_year_link( $year ) );
                $output .= porto_breadcrumbs_link( $month_name, get_month_link( $year, $month ) );
                $output .= porto_breadcrumb_leaf( 'day' );
            }
        } elseif ( is_author() ) {
            $output .= porto_breadcrumb_leaf( 'author' );
        } elseif ( is_search() ) {
            $output .= porto_breadcrumb_leaf( 'search' );
        } elseif ( is_404() ) {
            $output .= porto_breadcrumb_leaf( '404' );
        } elseif ( class_exists( 'bbPress' ) && is_bbpress() ) {
            if ( bbp_is_search() ) {
                $output .= porto_breadcrumb_leaf( 'bbpress_search' );
            } elseif ( bbp_is_single_user() ) {
                $output .= porto_breadcrumb_leaf( 'bbpress_user' );
            } else {
                $output .= porto_breadcrumb_leaf();
            }
        } else {
            if ( is_home() && !is_front_page() ) {
                if ( get_option( 'show_on_front' ) == 'page' ) {
                    $output .= porto_breadcrumbs_link( get_the_title( get_option('page_for_posts', true) ) );
                } else {
                    $output .= porto_breadcrumbs_link( $porto_settings['blog-title'] );
                }
            }
        }
    }
    // breadcrumbs end wrap
    $output .= '</ul>';
    return apply_filters('porto_breadcrumbs', $output);

}