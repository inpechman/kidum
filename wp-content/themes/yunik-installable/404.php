<?php get_header(); des_yunik_print_menu(); ?>

		<div class="container">
			<div class="entry-header">
				<div class="error-c">
					<img src="<?php echo get_template_directory_uri() . "/img/error.png";?>" title=""/>						
					<p class="text-error"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching one of the links in the right sidebar or in the top menu, can help.', 'yunik' ); ?></p>
				</div>
				
			</div>
		</div>
		
<?php get_footer(); ?>