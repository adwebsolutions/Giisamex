<?php
/*
 * Template Name: Custom-Product
 * @package porto-child
 */
get_header();
get_template_part('includes/title-breadcrumb' ) ?>
<div class="fluid-container">
    <div class="row">
        <div id="content" class="main-content-inner col-md-12">
            <ul class="filterable-grid clearfix">
                <?php
                $parents_cat_list = get_terms('custom-product-category', array( 'parent' => 0 ) ); // event is taxonomy here
                print_r($parents_cat_list);
                foreach( $parents_cat_list as $parent_cats ):
                    echo '<a href="' . get_term_link( $parent_cats ) . '">' . $parent_cats->name . '</a>: ';
                endforeach;
                ?>
                <?php $wpbp = new WP_Query(array(  'post_type' => 'custom-product', 'posts_per_page' =>'-1' ) ); ?>
                <?php if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
                    <?php $terms = get_the_terms(  get_the_ID(), 'filter' ); ?>
                    <li data-id="id-<?php echo  $count; ?>" data-type="<?php foreach ($terms as $term) { echo  strtolower(preg_replace('/\s+/', '-', $term->name)). ' '; } ?>">
                        <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) :  ?>
                            <?php  the_post_thumbnail(); ?>
                        <?php endif; ?>
                        <div class="image-over">
                            <h4><?php echo get_the_title();  ?></h4>
                            <a href="<?php the_permalink(); ?>"><?php _e('More Info','porto-child'); ?><i class="fa fa-angle-right"></i></a>
                        </div>
                    </li>
                    <?php $count++; ?>
                <?php endwhile; endif; ?>
                <?php wp_reset_query(); ?>
            </ul>
        </div><!-- #content  END -->
<?php  get_footer(); ?>