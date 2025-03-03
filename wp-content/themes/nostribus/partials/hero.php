<div class="hero">
    <figure class="soleil"></figure>
    <?php get_template_part('partials/header');?>
    <div class="hero-content">
        <div class="surtitre"><?= get_field('surtitre'); ?></div>
        <div class="titre">
            <header>
                <h1><?= get_the_title(); ?></h1>
                <h2><?= get_field('soustitre'); ?></h2>
            </header>
            <figure>
                <img src="<?= get_the_post_thumbnail_url(null,'large'); ?>" alt="<?= get_the_post_thumbnail_caption(); ?>">
            </figure>
        </div>
    </div>
</div>