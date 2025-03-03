<?php

$projets = get_posts([
    'post_type'      => 'projet',
    'posts_per_page' => -1, // Récupère tous les posts
]);


ob_start();
?>

<div class="projets">
    <?php foreach ($projets as $projet) { ?>
        <article>
            <strong><?= get_the_title($projet); ?></strong>
            <figure>
                <img src="<?= get_the_post_thumbnail_url($projet, 'medium'); ?>" alt="<?= get_the_title($projet); ?>">
            </figure>
            <header>

                <?= get_post_content($projet); ?>

                <small><?= get_field('credits', $projet); ?></small>
            </header>
        </article>
    <?php } ?>
</div>
<?php
$content = ob_get_clean();
set_extra_content($content);



require __DIR__ . '/page.php';
