<?php get_header(); ?>
<div class="content-1">
	<div class="container">
		<div class="row">
			<div class="col-12">
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<img src="<?php bloginfo('template_directory') ?>/img/404.jpg" class="img-fluid mb-2 mb-md-0" alt="Arnie in Predator" loading="lazy" />
			</div>
			<div class="col-md-6">
				<h1>Oops! Something Went Wrong</h1>
				<h2>"Get to the choppa!"</h2>
				<p>The page you are looking for cannot be found. Arnie is going to stay back and deal with the problem.</p>
				<p>In the meantime, on your way back to the choppa, why not check out one of the posts below.</p>
			</div>
		</div>
	</div>
</div>
<div class="content-2">
	<div class="container">
		<div class="row">
			<div class="col">
				<h2>While You're Here</h2>
				<hr />
			</div>
		</div>
		<div class="row">
			<?php
				$latest_args = array(
					'posts_per_page' => 3,
					'orderby' => 'rand'
				);
				$latest = new WP_Query( $latest_args );

				if ( $latest -> have_posts() ) {
					// Declare a variable to hold the count of the latest posts 
					$latest_count = 1;

					while ( $latest -> have_posts() && ( $latest_count < 4 ) ) {
						$latest -> the_post(); // Get the post

						// Check the post isn't already displayed
						//if ( in_array( get_the_ID(), $displayed_posts) == false ) {
							// Add the post to the displayed_posts array 
							$displayed_posts[] = get_the_ID();

							// Turn the post into a columns
							if ( $latest_count == 1 ) {
								echo "<div class=\"col-md-4 post-list\"><a href=\"", get_the_permalink(), "\">";
							}
							else {
								echo "<div class=\"col-md-4 mt-4 mt-md-0 post-list\"><a href=\"", get_the_permalink(), "\">";
							}
						
							// Check if there is a thumbnail image
							if ( has_post_thumbnail() ) {
								// Display the thumbnail
								echo "<img src=\"", get_the_post_thumbnail_url(), "\" class=\"img-fluid post-stacked\" alt=\"", get_the_title(), "\" loading=\"lazy\" />";
							}
							else {
								// No thumbnail image so lets display the default one from the template
								echo "<img src=\"", bloginfo('template_directory'), "/img/default-post-image.jpg\" class=\"img-fluid post-stacked\" alt=\"", get_the_title(), "\" loading=\"lazy\" />";
							}

							// Display the title
							echo "<h3>", get_the_title(), "</h3>";
							echo "<p class=\"post-datetime\">", get_post_time('d M Y H:i'), "</p>";

							// Display the excerpt
							echo "<p>", get_the_excerpt(), "</p></a>";

							echo "<ul class=\"postdetails\">";
							echo "<li><i class=\"fas fa-user-circle\"></i> ", get_the_author_meta('display_name'), " |&nbsp;</li>";
							echo "<li><i class=\"far fa-comments\"></i> ", get_comments_number(), " comments</li>";
							echo "</ul>";

							echo "</div>";

							// Increment the counter
							$latest_count++;
						//}
					}

					// Reset global post variable. After this point, we are back to the Main Query object.
					wp_reset_postdata();
				}
			?>
		</div>
		<div class="row">
			<div class="mt-4">
				<div class="advert-before">Advert</div>
				<div align="center">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- Fit Dad Square -->
						<ins class="adsbygoogle"
							style="display:block"
							data-ad-client="ca-pub-2933900882310913"
							data-ad-slot="9880151769"
							data-ad-format="auto"
							data-full-width-responsive="true"></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>
				<div class="advert-after"></div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>