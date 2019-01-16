<?php
/**
 * @package WordPress
 * @subpackage Yunik
 */
?>
<div id="secondary" class="widget-area four columns alpha">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Widgets')) : else : ?>

		<aside id="search" class="widget widget_search" role="complementary">
			<?php get_search_form(); ?>
		</aside>

		<aside id="archives" class="widget" role="complementary">
			<h2 class="widget-title"><?php _e( 'Archives', 'yunik' ); ?></h2>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>

		<aside id="meta" class="widget" role="complementary">
			<h2 class="widget-title"><?php _e( 'Meta', 'yunik' ); ?></h2>
			<ul>
				<?php wp_register(); ?>
				<aside role="complementary"><?php wp_loginout(); ?></aside>
				<?php wp_meta(); ?>
			</ul>
		</aside>

	<?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->