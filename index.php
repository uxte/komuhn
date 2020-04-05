<?php get_header(); ?>

<body <?php body_class(); ?>>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <header class="main-header">
      <img class="logo" src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Komuhn"/>
  </header>

  <main>

    <?php
        $args = array (
            'post_type'              => 'portfolio',
        );
        $queryPortfolio = new WP_Query( $args );

        if ( $queryPortfolio->have_posts() ):
    ?>
      <section class="portfolio">
            <?php
                while ( $queryPortfolio->have_posts() ) : $queryPortfolio->the_post();
            ?>
                <article class="item-project">
                    <img class="item-image" src="<?php echo get_template_directory_uri(); ?>/img/inecc.svg" alt="Inecc"/>
                    <div class="item-content">
                        <h2 class="item-title"><?php echo the_title(); ?></h2>
                        <a href="#" class="btn-white">Learn more</a>
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
