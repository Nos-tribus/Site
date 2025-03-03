<?php

$productions = get_posts([
    'post_type'      => 'production',
    'posts_per_page' => -1, // Récupère tous les posts
]);


ob_start();
?>
<div class="deux-colonnes">
    <div>
        <div class="boutons">
            <a class="bouton" href="/contact">Contactez-nous</a>
        </div>
    </div>
    <div>
    </div>
</div>

<div class="deux-colonnes">
    <div>
        <div class="video">
            <video autoplay="" controls="">
                <source src="<?= get_field('video_format_mp4'); ?>" type="video/mp4">
                <source src="<?= get_field('video_format_webm'); ?>" type="video/webm">
            </video>
        </div>
        <ul class="partners">
            <?php foreach (get_field('partenaires') as $partenaire) { ?>
                <li><a><img loading="lazy" src="<?=$partenaire['sizes']['medium'];?>" alt="<?=$partenaire['title'];?>"></a></li>
            <?php } ?>
        </ul>

    </div>
    <div>
        <div class="content">
            <?= get_field("contenu_en_colonne_de_droite"); ?>

            
            <a class="brochure" target="_blank" href="<?= get_field("brochure_pdf"); ?>"><span class="bouton">Téléchargement<br>brochure</span>
            <img loading="lazy" src="<?= get_field("couverture_de_la_brochure"); ?>" alt="<?= basename(get_field("couverture_de_la_brochure")); ?>"></a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
set_extra_content($content);



require __DIR__ . '/page.php';
