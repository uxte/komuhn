<?php
    /* Template Name: Portfolio page */
    get_header();
?>
    <main>
        <section class="portfolio">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php the_content(); endwhile; endif; ?>
        </section>
	</main>

	<footer>

	</footer>

</body>

</html>
