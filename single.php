<?php get_header(); ?>

    <main>
        <section class="project">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            $post_color = get_post_meta( $post->ID, 'color_meta', 1) ;
            $post_style = 'style="background-color:' . $post_color . '"';
            ?>
            <header <?php echo $post_style; ?>>
                With <h1><?php the_title(); ?></h1>
            </header>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </section>
	</main>

<?php get_footer(); ?>
