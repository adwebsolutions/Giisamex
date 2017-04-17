<?php
/**
 * @package porto-child
 */
get_header();
?>
    <div class="container">
        <div class="row">
            <div id="content" class="main-content-inner col-xs-12 col-sm-12 col-md-12">
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', 'single-productc' ); ?>

                <?php endwhile; // end of the loop. ?>
            </div>
        </div>
    </div><?php get_footer(); ?>