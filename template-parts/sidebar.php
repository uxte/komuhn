<aside class="sidebar">
    <nav class="nav-next-post">
        <?php $next_post = get_next_post(); ?>
        <?php if ($next_post):
            $next_post_title = $next_post->post_title;
            $next_post_link = get_permalink( $next_post->ID );
            $next_post_cover_text = get_post_meta( $next_post->ID, 'cover_meta', 1 );
            if ( empty( $next_post_cover_text ) ) {
                $next_post_cover_text = get_the_excerpt( $next_post->ID );
            };
        ?>
        <a class="next-post" href="<?php echo $next_post_link; ?>">
            <span class="caption">Next project:</span>
            <span class="title">With <strong><?php print $next_post_title; ?></strong></span>
            <span class="cover-text"><?php print $next_post_cover_text; ?></span>
        </a>
        <?php endif; ?>
    </nav>
</aside>
