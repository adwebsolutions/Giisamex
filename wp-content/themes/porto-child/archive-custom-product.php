<?php
/**
 * @package porto-child
 */

if (is_post_type_archive('custom-product')){
	require_once dirname( __FILE__ ) . '/custom-product.php';
} else {
get_header(); ?>
<?php get_template_part('includes/title-breadcrumb' );
	  ?>
<div class="container">
	<div class="row">
		<div id="content" class="main-content-inner col-md-12">
			<div class="content-padder">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'custom-product' ); ?>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'no-results', 'archive' ); ?>
				<?php endif; ?>
			</div>
		</div>
<?php }
	get_footer(); ?>
