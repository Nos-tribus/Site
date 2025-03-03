<?php
/**
 * Template Name: Home
 */ ?>
<?php get_header(); ?>

<div class="page-index">
    <?php get_template_part('partials/hero'); ?>

    <div class="container">
        <div>
            <div class="content">

                <?php the_content(); ?>

                <div class="boutons">
                    <a class="bouton" href="/contact">Contactez-nous</a>
                </div>
            </div>
        </div>
    </div>

</div>

<?php get_template_part('partials/footer'); ?>
<?php get_footer(); ?>