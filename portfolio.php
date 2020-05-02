<?php
    /* Template Name: Portfolio page */
    get_header();
?>
    <main class="wrap">
        <section class="portfolio">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php the_content(); endwhile; endif; ?>
        </section>
	</main>

<?php get_footer(); ?>
