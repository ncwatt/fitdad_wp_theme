<?php get_header(); ?>
<div class="content-1">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
					printf( esc_html( get_search_query() ) );

					printf(
						esc_html(
							/* translators: %d: The number of search results. */
							_n(
								'We found %d result for your search.',
								'We found %d results for your search.',
								(int) $wp_query->found_posts,
								'twentytwentyone'
							)
						),
						(int) $wp_query->found_posts
					);

					if(have_posts()) : while(have_posts()) : the_post();
						the_content();
					endwhile; else : endif;
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>