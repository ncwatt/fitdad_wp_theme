	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-3 text-center text-md-start order-1">
					<h9>Follow</h9>
					<ul class="follow-icons">
						<!--<li><a href="#" class="fab fa-facebook-f"></a>&nbsp;</li>-->
						<li><a href="https://twitter.com/ukfitdad" target="_blank" class="fab fa-twitter"></a>&nbsp;</li>
						<li><a href="https://www.instagram.com/ukfitdad/" target="_blank"><i class="fab fa-instagram"></i></a>&nbsp;</li>
						<li><a href="https://www.strava.com/athletes/23491399" target="_blank"><i class="fab fa-strava"></i></a>&nbsp;</li>
						<li><a href="https://www.thepowerof10.info/athletes/profile.aspx?ukaurn=3947341" target="_blank"><img src="<?php bloginfo('template_directory');?>/assets/img/power-of-10.png" class="power-of-10" /></a>&nbsp;</li>
					</ul>
				</div>
				<div class="col-md-6 mt-3 mt-md-0 text-center order-3 order-md-2">
					<p class="copyright">&copy; Copyright 2023. All Rights Reserved by <a href="/">fitdad.co.uk</a></p>
					<p class="admin-login">Powered by <a href="https://wordpress.org/" target="_blank">WordPress</a> | Theme by <a href="https://gtctek.co.uk" target="_blank">Gtctek</a> | Admin <a href="/wp-admin">Login</a></p>
				</div>
				<div class="col-md-3 mt-3 mt-md-0 text-center text-md-end order-2 order-md-3">
					<h9>Legal</h9>
					<p>
						<a href="#discModal" data-bs-toggle="modal" data-bs-target="#discModal">Disclaimer</a> | 
						<a href="#discModal" data-bs-toggle="modal" data-bs-target="#discModal">Terms of Use</a>
					</p>
					<!-- Disclaimer / Terms of Use Modal -->
					<div class="modal fade" id="discModal" tabindex="-1" aria-labelledby="discModalLabel" aria-hidden="true">
  						<div class="modal-dialog">
    						<div class="modal-content">
      							<div class="modal-header">
        							<h5 class="modal-title" id="discModalLabel">Disclaimer / Terms of Use</h5>
        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      							</div>
      							<div class="modal-body">
        							I'm still writing my disclaimer / terms of use. But in the meantime it's best to acknowledge that the only qualification that I hold is the
									Leadership in Running Fitness from England Athletics. So, before you follow any of the information contained within this site
									you should seek guidance from a fitness professional. <?php echo $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['HTTP_USER_AGENT'] ?>
      							</div>
      							<div class="modal-footer">
        							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      							</div>
    						</div>
  						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<?php wp_footer(); ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>