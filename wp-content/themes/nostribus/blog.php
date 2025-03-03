<?php
/**
 * Template Name: Blog
 */ ?>

<?php get_header(); ?>

<main>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <h2><?php the_title(); ?></h2>
            <?php if (has_post_thumbnail()) : ?>
                <div><?php the_post_thumbnail(); ?></div>
            <?php endif; ?>
            <div><?php the_content(); ?></div>
        </article>
    <?php endwhile; else: ?>
        <p>Aucun contenu disponible.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
