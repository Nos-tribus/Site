<?php
?>
<?php get_header(); ?>
<?php get_template_part('partials/header'); ?>

<div class="container">
    <div>
        <div class="deux-colonnes" data-type="component">
            <div>
                <div class="surtitre"><?= get_the_title(); ?></div>
                <h1>
                    <span><?= get_field('titre'); ?></span> <strong><?= get_field('afficher_amp') ? '&amp;' : ''; ?></strong>
                    <span><?= get_field('soustitre'); ?></span>
                </h1>
                <div class="content">
                    <?php the_content(); ?>

                </div>
            </div>
            <div>
                <figure>
                    <img src="<?= get_the_post_thumbnail_url(null,'medium'); ?>" alt="<?= get_the_post_thumbnail_caption(); ?>">
                </figure>
            </div>
        </div>

        <?php get_extra_content(); ?>
    </div>
</div>


<?php get_template_part('partials/footer'); ?>
<?php get_footer(); ?>