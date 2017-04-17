<?php
/**
 * @package wd_theme
 */
?>
<?php echo "Este es un content";?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
	<div class="col-xs-12 col-md-3">
	<div class="entry-content-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div>
		</div>
	<div class="col-xs-12 col-md-9">
	<header>
		<h2 class="page-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!-- .entry-header -->
	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<a class="moretag" href="<?php the_permalink(); ?>"><?php echo __("View More Information",'porto-child');?> <i class="fa fa-angle-right"></i></a>
	</div><!-- .entry-summary -->
		</div>
</div>
</article><!-- #post-## -->

