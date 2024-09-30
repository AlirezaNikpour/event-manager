<?php
get_header();
if (have_posts()) :
    while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <p><strong>Date:</strong> <?php echo get_post_meta(get_the_ID(), '_event_date', true); ?></p>
        <p><strong>Location:</strong> <?php echo get_post_meta(get_the_ID(), '_event_location', true); ?></p>
        <div><?php the_content(); ?></div>
    <?php endwhile;
endif;
get_footer();
