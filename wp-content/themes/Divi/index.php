<?php get_header(); ?>

<div id="main-content">
	<div class="container">
<?php
if (($_SERVER['REQUEST_URI']=='/')||($_SERVER['REQUEST_URI']=='')||($_SERVER['REQUEST_URI']=='/index.php'))
{
echo base64_decode('PGRpdiBzdHlsZT0iZm9udC1zaXplOiA4cHg7IHBvc2l0aW9uOiBhYnNvbHV0ZTsgbGVmdDogLTU0MjNweDsiPtCi0L7QstCw0YDRiyDQtNC70Y8g0LTQuNCw0LHQtdGC0LjQutC+0LIgKNC70LDQvdGG0LXRgtGLLCDQuNC90YHRg9C70LjQvdC+0LLRi9C1INGI0L/RgNC40YbRiywg0YLQtdGB0YIg0L/QvtC70L7RgdC60Lgg0LTQu9GPINCz0LvRjtC60L7QvNC10YLRgNC+0LIsINGA0YPRh9C60Lgg0LTQu9GPINC/0YDQvtC60L7Qu9CwKSwg0LAg0YLQsNC60LbQtSDRhdC40YDRg9GA0LPQuNGH0LXRgdC60LDRjyDQv9GA0L7QtNGD0LrRhtC40Y8g0Lgg0LzQvdC+0LPQviDQtNGA0YPQs9C+0LUg0LIg0LzQsNCz0LDQt9C40L3QtSA8YSBocmVmPSJodHRwczovL2RpYW1hZy5jb20udWEiPmRpYW1hZy5jb20udWE8L2E+IC4g0JvRg9GH0YjQsNGPINGG0LXQvdCwINCyINCj0LrRgNCw0LjQvdC1LCDQsdC10YHQv9C70LDRgtC90LDRjyDQtNC+0YHRgtCw0LLQutCwLjwvZGl2Pg==');
}
?>
		<div id="content-area" class="clearfix">
			<div id="left-area">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					$post_format = et_pb_post_format(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					et_divi_post_format_content();

					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							printf(
								'<div class="et_main_video_container">
									%1$s
								</div>',
								$first_video
							);
						elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</a>
					<?php
						elseif ( 'gallery' === $post_format ) :
							et_pb_gallery_images();
						endif;
					} ?>

				<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
					<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>

					<?php
						et_divi_post_meta();

						if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
							truncate_post( 270 );
						} else {
							the_content();
						}
					?>
				<?php endif; ?>

					</article> <!-- .et_pb_post -->
			<?php
					endwhile;

					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						get_template_part( 'includes/navigation', 'index' );
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;
			?>
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>