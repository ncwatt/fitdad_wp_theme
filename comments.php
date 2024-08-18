<?php 
	// Stop the file from being accessed directly
	if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) :
		die('You can not access this page directly!');
	endif;
?>

<?php
 	// If the current post is protected by a password and the visitor has not yet
 	// entered the password we will return early without loading the comments.
	if (post_password_required())
 		return;

	// Get the sort order for comments from site settings
	$comment_order = get_option('comment_order');

	$args = array(
		//'status' => 'approve',
		'post_id' => get_the_ID(),	// Post ID of the current post
		'order' => $comment_order	// Order to display comments
	);

	// Build the comments query
	$comments_query = new WP_Comment_Query();
	$comments = $comments_query->query($args);
?>

<h2>Comments</h2>
<?php 
	// Loops through $comments_query and displays the comments
	// When approved the actual comment is displayed and the where applicable the name is the website link
	// When not approved an awaiting moderation message is displayed
	if ($comments) :
		foreach ($comments as $comment) :
			if ($comment->comment_approved == '1') : ?>
				<div class="comment-header">
					<a name="comment-<?php echo $comment->comment_ID; ?>"></a>
					<?php echo get_avatar($comment->comment_author_email, $size = '60'); ?>
					<p>
						<?php if ($comment->comment_author_url != '') : ?>
							<a href="<?php echo $comment->comment_author_url ?>" target="_blank"><?php echo $comment->comment_author ?></a>
						<?php 
							else :
								echo $comment->comment_author;
							endif;
						?>
						<br />
						<?php echo date_format(new DateTime($comment->comment_date), 'd M Y H:i'); ?>
					</p>
				</div>
				<div class="comment-content">
					<?php echo str_replace(chr(13), "<br />", $comment->comment_content); ?>
				</div>
			<?php else : ?>
				<div class="comment-header">
					<a name="comment-<?php echo $comment->comment_ID; ?>"></a>
					<?php echo get_avatar($comment->comment_author_email, $size = '60'); ?>
					<p>
						<?php echo $comment->comment_author; ?>
						<br />
						<?php echo date_format(new DateTime($comment->comment_date), 'd M Y H:i'); ?>
					</p>
				</div>
				<div class="comment-content">
					</i>This comment is awaiting moderation</i>
				</div>
			<?php endif; ?>
			<hr />
		<?php endforeach; ?>
	<?php else : ?>
		<p>There are currently no comments. Why not be the first by using the form below.</p>
<?php endif; ?>

<h3>Leave a comment</h3>
<?php 
	// If comments are open display the new comment form otherwise comments are closed message is displayed
	if(comments_open()) :
		if(get_option('comment_registration') && !$user_ID) : ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>
			<form action="<?php get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				<?php if(is_user_logged_in()) : ?>
					<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>
				<?php else : ?>
					<div class="form-group mb-3">
                    	<label for="author" class="form-label">Name <?php if($req) : ?><span class="text-danger">*</span><?php endif; ?></label>
                    	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" aria-describedby="authorHelp" placeholder="Enter your name" class="form-control">
                    	<small id="authorHelp" class="form-text text-muted">You must provide your name</small>
                	</div>
					<div class="form-group mb-3">
                    	<label for="email" class="form-label">Email address <?php if($req) : ?><span class="text-danger">*</span><?php endif; ?></label>
                    	<input type="email" name="email" id="email" value="<?php echo $comment_author_email; ?>" aria-describedby="emailAddressHelp" placeholder="Enter your email address" class="form-control">
                    	<small id="emailAddressHelp" class="form-text text-muted">You must provide your email address (it will not be published)</small>
                	</div>
						<div class="form-group mb-3">
                    	<label for="url" class="form-label">Website</label>
                    	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" aria-describedby="urlAddressHelp" placeholder="Website URL" class="form-control">
                    	<small id="urlAddressHelp" class="form-text text-muted">Please provide your website URL</small>
                	</div>
				<?php endif; ?>
				<div class="form-group mb-3">
                	<label for="comment" class="form-label">Comment <span class="text-danger">*</span></label>
                	<textarea rows="5" name="comment" id="comment" placeholder="Enter your comment" class="form-control" aria-describedby="commentHelp"></textarea>
                	<small id="commentHelp" class="form-text text-muted">Enter the comment you want to submit</small>
            	</div>
				<p>
					<div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITEKEY; ?>" data-callback="callbackCommentSubmit"></div>
					<script type="text/javascript">
						function callbackCommentSubmit() {
							document.getElementById("submit-comment").removeAttribute("disabled");
						}
					</script>
				</p>
				<p>
					<input name="submit" type="submit" id="submit-comment" class="submit" value="Post Comment" disabled />
            		<?php comment_id_fields(); ?>
				</p>
				<?php do_action('comment_form', $post->ID); ?>
			</form>
		<?php endif; ?>
	<?php else : ?>
		<p>The comments are closed.</p>
<?php endif; ?>