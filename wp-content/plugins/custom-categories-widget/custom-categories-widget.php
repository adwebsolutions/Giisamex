<?php
/**
 * Custom Categories Widget
 *
 * @package Custom_Categories_Widget
 *
 * @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @version     1.2
 * Plugin Name: Custom Categories Widget
 * Description: A custom post categories widget.
 * Version:     1.0
 * Author:      Yailet
 * Text Domain: custom-categories-widget
 * Domain Path: /lang
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


define( 'CUSTOM_CATS_WIDGET_FILE', __FILE__ );

class custom_cat_widget extends WP_Widget {

	// constructor
	function custom_cat_widget() {
		parent::WP_Widget(false, $name = __('Custom Post Categories Widget', 'wp_widget_plugin') );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
	}

	// widget form creation
	function form($instance) {
		if( $instance) {
			$title = esc_attr($instance['title']);
			$text = esc_attr($instance['text']);
			$textarea = esc_textarea($instance['textarea']);
		} else {
			$title = '';
			$text = '';
			$textarea = '';
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'wp_widget_plugin'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
		</p>
	<?php }

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['textarea'] = strip_tags($new_instance['textarea']);
		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title']);
		$text = $instance['text'];
		$textarea = $instance['textarea'];

		echo $before_widget;


		echo '<div class="widget-text wp_widget_plugin_box">';

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$parents_cat_list = get_terms('product-cat', array( 'parent' => 0 ) );


		if ( $parents_cat_list && !is_wp_error( $parents_cat_list ) ) {

			echo '<ul class="custom-cat-list">';
			foreach( $parents_cat_list as $parent_cat ):
				$term_id = $parent_cat->term_id;
				echo '<li class="custom-cat-item">';
				echo '<a href="' . get_term_link( $parent_cat ) . '">';
				echo '<span class="custom-cat-title-item">' . $parent_cat->name . '</span>';
				echo '</a><span class="custom-cat-btn"></span>';
				if ($parent_cat->count > 0)
				{
					$child_list = get_term_children($term_id,'product-cat');
					echo '<ul class="custom-subcat-list">';
					foreach ($child_list as $child){
						$child_item = get_term($child);
						if($child_item)
						{
							echo '<li class="custom-subcat-item">';
							echo '<a href="' . get_term_link( $child_item->term_id ) . '">';
							echo '<span class="custom-subcat-title-item">' . $child_item->name . '</span>';
							echo '</a><span class="custom-subcat-btn"></span>';
							$arg_post = array (
								'posts_per_page' => -1,
								'post_type' => 'productc',
								'order' => 'ASC',
								'orderby' => 'ID',
								'tax_query' => [
									'relation' => 'AND',[
									'taxonomy' => 'product-cat',
									'terms' => $child_item->term_id,
									'field' => 'term_id',
									'include_children' => true,           //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
									'operator' => 'IN'
									]
								]);

							$wpbp = new WP_Query($arg_post );
							echo '<ul class="custom-post-list">';
							if ($wpbp->have_posts()) :  while ($wpbp->have_posts()) : $wpbp->the_post(); ?>
								<li>
									<div class="">
										<a href="<?php the_permalink(); ?>"><?php echo get_the_title();  ?></a>
									</div>
								</li>
							<?php endwhile; endif;
								echo '</ul>';?>
							<?php wp_reset_query();
							echo '</li>';
						}
					}
					echo '</ul>';
				}
				echo '</li> ';
			endforeach;
			echo'</ul>';
		}
		echo $after_widget;
	}

// Add Shortcode to show posts count inside a category
	function category_post_count( $cat ) {
		$term = get_term_by( 'slug', $cat, 'category');
		return ( isset( $term->count ) ) ? $term->count : 0;
	}
	function register_plugin_styles() {
		wp_register_style( 'custom-categories-widget', plugins_url( 'custom-categories-widget/inc/style.css' ) );
		wp_enqueue_style( 'custom-categories-widget' );
		wp_enqueue_style('font-awesome','https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_register_script( 'custom', plugins_url('custom-categories-widget/inc/custom.js'), array(), '1.0.0', true );
		wp_enqueue_script( 'custom' );
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("custom_cat_widget");'));