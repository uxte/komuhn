<?php get_header(); ?>

    <main>
        <section class="project">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            $post_cover_text = get_post_meta( $post->ID, 'cover_meta', 1);
            if ( empty($post_cover_text) ) {
                $post_cover_text = get_the_excerpt();
            };
            $post_color = get_post_meta( $post->ID, 'color_meta', 1);
            $post_style = 'style="background-color:' . $post_color . '"';
            ?>
            <header <?php print $post_style; ?>>
                <span class="wrapper">With <h1><?php the_title(); ?></h1></span>
                <h2><?php print $post_cover_text; ?></h2>
            </header>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </section>
	</main>

<?php get_footer(); ?>
