<?php
/**
 * @package porto-child
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<div class="row">
			<div class="col-md-12">
				<?php the_content();?>
			</div>

			<div class="clear"></div>
		</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->