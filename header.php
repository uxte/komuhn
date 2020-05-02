<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">

  <?php wp_head(); ?>
  <meta name="description" content="<?php bloginfo( 'description' ); ?>">
  <meta name="author" content="Komuhn">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css">
  <link rel="stylesheet" media="screen and (min-width: 1025px)" href="<?php echo get_stylesheet_directory_uri(); ?>/css/full.css">

</head>

<body <?php body_class(); ?>>
	<!--[if IE]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->

	<header class="main-header wrap">
        <div class="identity">
            <h1 class="logo">
                <a class="logo" href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" alt="Logo">
                    <span><?php bloginfo('name'); ?></span>
        			<img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="<?php bloginfo('name'); ?>" />
        		</a>
            </h1>
            <h2 class="title">
                <span><?php single_post_title(); ?></span>
            </h2>
        </div>

        <nav class="main-nav" id="main-nav">
            <?php
            wp_nav_menu( array(
                'menu'            => 'top-menu',
                'container'       => ''
            ));
            ?>
        </nav>

	</header>
