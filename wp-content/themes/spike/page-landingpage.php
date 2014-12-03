<?php
/**
 * Template Name: Landingpage
 */
?>

<div id="page">
    <div class="content">
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <h1 class="title"><?php the_title(); ?></h1>
            <div class="post-content box mark-links">
                    <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>