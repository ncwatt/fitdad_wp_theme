<?php get_header(); ?>
<div class="content-1">
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
				<div class="row">
				<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
				?>
					<div class="col-md-6 mb-4 post-list">
						<a href="<?php echo get_the_permalink(); ?>">
							<img class="img-fluid post-stacked" alt="<?php echo get_the_title(); ?>" src="<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : bloginfo('template_directory') . "/img/default-post-image.jpg"; ?>" />
							<h3><?php echo get_the_title() ?></h3>
							<p class="post-datetime"><?php echo get_post_time('d M Y H:i'); ?></p>
							<p><?php echo get_the_excerpt() ?></p>
						</a>
						<ul class="postdetails">
							<li><i class="fas fa-user-circle"></i> <?php echo get_the_author_meta('display_name'); ?> |&nbsp;</li>
							<li><i class="far fa-comments"></i> <?php echo get_comments_number(); ?> comments</li>
						</ul>
					</div>
				<?php
						endwhile;
					endif;
				?>
				</div>
				<div class="row">
					<?php
						//Get the paginated links
    					$lists = paginate_links(
							array(
								'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
								'format'       => '?paged=%#%',
								'current'      => max( 1, get_query_var( 'paged' ) ),
								'total'        => $wp_query->max_num_pages,
								'type'         => 'array',
								'show_all'     => false,
								'end_size'     => 2,
								'mid_size'     => 1,
								'prev_text'    => __( '« Prev' ),
								'next_text'    => __( 'Next »' ),
								'add_fragment' => '',
							)
						);

						if ( is_array( $lists ) ) {
         
							$html = '<nav><ul class="pagination justify-content-center">';
					 
							foreach ( $lists as $list ) {
								$html .= '<li class="page-item' . (strpos($list, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link text-dark', $list) . '</li>';
							}
					 
							$html .= '</ul></nav>';
					 
							//if ( $echo ) {
								echo $html;
							//} else {
								//return $html;
							//}
						}
					?>

					<?php the_posts_pagination(); ?>
				</div>
				<div class="row">
					<?php
						global $wp_query;
						
						$big = 999999999; // need an unlikely integer
						
						$pagelinks = get_paginate_links_as_array(
							paginate_links(
								array(
									'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format' => '?paged=%#%',
									'current' => max( 1, get_query_var('paged') ),
									'total' => $wp_query->max_num_pages,
									'type' => 'list',
									'prev_text' => 'Previous',
									'next_text' => 'Next'
								)
							), 'Next', 'Previous'
						);
						
						// Declare a variable to hold the pagination buttons section
						$pagesect = 'first';
						$pagecount = 1;

						// Loop thorugh the returned array and create the pagination links
						foreach ( $pagelinks as $pagelink ) {
							if ( $pagelink['sect'] == 'first' ) {

								// Add the links for the first section (these would normally be the
								// the link to previous pages)
								echo "<div class=\"col-6 col-md-4 pagination-links\">";
								echo "<a href=\"", $pagelink['href'], "\"><i class=\"fas fa-arrow-left\"></i> Older Posts</a>";
								echo "</div>";

								$pagesect = 'mid-start';
							} 
							
							if ( $pagelink['sect'] == 'mid' ) {

								if ( $pagesect == 'mid' ) {
									echo "&nbsp;";
								}

								if ( $pagesect == 'first' ) {
									echo "<div class=\"col-6 col-md-4 pagination-links\"></div>";
									$pagesect = 'mid-start';
								} 
								
								if ( $pagesect == 'mid-start' ) {
									echo "<div class=\"d-none d-md-block col-md-4 text-center pagination-links\">";
									$pagesect = 'mid';
								}
								
								if ( $pagelink['type'] == 'a' ) {
									echo "<a href=\"", $pagelink['href'], "\">", $pagelink['text'], "</a>";
								} elseif ( $pagelink['type'] == 'span' ) {
									echo "<span>", $pagelink['text'], "</span>";
								}
								
								if ( $pagecount == count( $pagelinks ) ) {
									echo "</div>";
									echo "<div class=\"col-6 col-md-4\"></div>";
								}
							}

							if ( $pagelink['sect'] == 'last' ) {

								if ( $pagesect == 'first' ) {
									echo "<div class=\"col-6 col-md-4 pagination-links\"></div>";
									echo "<div class=\"d-none d-md-block col-md-4 text-center pagination-links\"></div>";
								}

								if ( $pagesect == 'mid' ) {
									echo "</div>";
								}

								echo "<div class=\"col-6 col-md-4 text-end pagination-links\">";
								echo "<a href=\"", $pagelink['href'], "\">Newer Posts <i class=\"fas fa-arrow-right\"></i></a>";
								echo "</div>";
							}

							// Increment the counter
							$pagecount++;
						}
					?>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="row">
					<div class="col-12">
						<?php
							$queried_object = get_queried_object();

							$category = get_top_level_category( $queried_object -> term_id );	

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
					
							//include get_template_directory() . "/inc/strava_widget_small.php";
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