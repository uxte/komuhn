<?php
    /* Template Name: Portfolio page */
    get_header();
?>

<body <?php body_class(); ?>>
	<!--[if IE]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->

	<header class="main-header">
		<a class="logo" href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="<?php bloginfo('name'); ?>" />
		</a>
	</header>

	<main>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php the_content(); endwhile; endif; ?>
	</main>

	<footer>
			
	</footer>

</body>

</html>
