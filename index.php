<?php get_header(); ?>

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
		<?php
			$args = array (
				'post_type' => 'portfolio',
			);
			$queryPortfolio = new WP_Query( $args );

			if ( $queryPortfolio->have_posts() ):
		?>
				<section class="portfolio">
							<?php
								while ( $queryPortfolio->have_posts() ) : $queryPortfolio->the_post();
									if ( has_post_thumbnail( get_the_ID() ) ){
											$image_id 		= get_post_thumbnail_id( get_the_ID() );
											$featured_image = wp_get_attachment_url( $image_id );
									}
									$subtitle = get_post_meta(get_the_ID(),'subtitle_meta', 1);
									$display = get_post_meta(get_the_ID(),'display_meta', 1);
									if($display == true) {
										$itemClass = 'display-half';
									} else {
										$itemClass = '';
									}
							?>
										<article class="item-project <?php echo $itemClass; ?>">
												<img class="item-image" src="<?php echo $featured_image; ?>" alt="<?php echo get_the_title(); ?>"/>
												<div class="item-content">
														<h1 class="item-title"><?php echo $subtitle; ?></h1>
														<a href="<?php echo get_the_permalink(); ?>" class="btn-white">Learn more</a>
												</div>
										</article>
							<?php
								endwhile;
							?>
				</section>
		<?php
			endif;
		?>
	</main>

	<footer>
			FOOTER
	</footer>

</body>

</html>
