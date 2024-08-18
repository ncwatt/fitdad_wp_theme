<?php get_header(); ?>
<div class="content-1">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-9 post-single">
				<div class="row">
					<div class="col-12">
						<?php
							// Check if there is a featured image
							if ( has_post_thumbnail() ) {
								// Display the thumbnail
								echo "<img src=\"", get_the_post_thumbnail_url(), "\" class=\"featured-image\" alt=\"", get_the_title(), "\" />";
							}
							else {
								// No thumbnail image so lets display the default one from the template
								echo "<img src=\"", bloginfo('template_directory'), "/img/default-post-image.jpg\" class=\"featured-image\" alt=\"", get_the_title(), "\" />";
							}

							// Display the title
							echo "<h1>", get_the_title(), "</h1>";
							echo "<p class=\"post-datetime\">Posted: ", get_post_time('d M Y H:i'), "</p>";
							echo the_content();
							echo the_tags();
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-12 comments">
						<?php
							// If comments are open or there is at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						?>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-3">
				<div class="row">
					<div class="col-12">
						<?php
							$postcat = get_the_category( $post->ID );
							if ( ! empty( $postcat ) ) {
								$category = get_top_level_category( $postcat[0]->cat_ID );
						
								$sublist = get_category_subcat_list( $category );

								$catcount = 0;

								foreach ( $sublist as $cat ) {
									if ( $catcount == 0 ) {
										echo "<h2>" . $cat["category_name"] . "</h2><hr />" ;
										$catcount++;
									}
									else {
										if ( $catcount == 1 ) {
											echo "<ul class=\"category_list\">";
										}

										echo "<li><a href=\"" . $cat["category_url"] . "\">" .  $cat["category_name"] . " (" .  $cat["category_count"] . ")" . "</a></li>" ;
										$catcount++;
									}
								}

								if ( $catcount > 1 ) {
									echo "</ul>";
								}
							}
						?>				
					</div>
					<div class="col-12">
						<div class="advert-before">Advert</div>
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
						<div class="advert-after"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>