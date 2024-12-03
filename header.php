<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
	<link href="<?php bloginfo('template_directory');?>/assets/css/fontawesome.all.min.css" rel="stylesheet" />
	<?php wp_head(); ?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<!-- Fav / Touch Icons -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory');?>/assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory');?>/assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory');?>/assets/icons/favicon-16x16.png">
    <link rel="manifest" href="<?php bloginfo('template_directory');?>/assets/icons/site.webmanifest">
    <link rel="mask-icon" href="<?php bloginfo('template_directory');?>/assets/icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/assets/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/assets/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>
<body <?php body_class(); ?>>

<header class="sticky-top">
	<nav id="navbar-top" class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm admin-bar-padding">
		<div class="container">
			<a id="navbar-top-brand-link" class="brand-link" href="<?php bloginfo('url'); ?>">
				<img src="<?php bloginfo('template_directory');?>/assets/img/navbar-top-logo.png" class="img-fluid" alt="FitDad Logo" />
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-top-nav" aria-controls="navbar-top-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbar-top-nav">
				<?php 
					wp_nav_menu (
						array ( 
							'theme_location'	=> 'top-menu',
							'container'			=> 'div',
							'container_class'	=> 'me-auto mb-2 mb-lg-0',
							'menu_class'		=> 'navbar-nav',
							'add_li_class'		=> 'nav-item'
						)
					); 
				?>
				<form action="<?php echo home_url('/'); ?>" role="search" method="get" class="d-flex d-none">
					<input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form>
			</div>
		</div>
	</nav>
</header>
<div class="admin-bar-content-fix"></div>