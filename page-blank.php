<?php get_header(); 
/*
Template Name: Blank Page
*/
?>
<div class="content-1">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
					if(have_posts()) : while(have_posts()) : the_post();
						the_content();
					endwhile; else : endif;
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>