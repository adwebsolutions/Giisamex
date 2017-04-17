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
    'pages' => array('custom-product-category'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),                             // list of meta fields (can be added by field arrays)
    'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => get_stylesheet_directory_uri() . '/Tax-meta-class'               //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);

$my_meta = new Tax_Meta_Class($config);
$my_meta->addImage('image_field_id',array('name'=> 'Imagen de la Categoría'));
$my_meta->Finish();
//file upload field

function arrr_custom_loop( $r_type = 'post', $r_post_num, $r_tax = 'category', $r_terms = 'featured' )  {
    $args = array(
        'showposts' => $r_post_num,
        'tax_query' => array(
            array(
                'post_type' => $r_type,
                'taxonomy' => $r_tax,
                'field' => 'slug',
                'terms' => array(
                    $r_terms
                ),
            )
        )
    );
    query_posts( $args );
    if (have_posts())
        while ( have_posts() ) : the_post();
            $more = 0;
            ?>
            <article>
                <header class="pagetitle">
                    <?php if ( is_singular() )  { ?>
                        <h1><?php the_title(); ?></h1>
                    <?php } else { ?>
                        <h2 class="entry"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php } ?>
                </header>
                <div class="content_wrapper">
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php if ( comments_open() && ! post_password_required() )  { ?>
                    <div class="comments_wrapper">
                        <div class="comments">
                            <?php comments_template(); ?>
                        </div>
                    </div>
                <?php } ?>
            </article>
        <?php endwhile;
    wp_reset_query();
}