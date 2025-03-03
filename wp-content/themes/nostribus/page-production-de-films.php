<?php

$productions = get_posts([
    'post_type'      => 'production',
    'posts_per_page' => -1, // Récupère tous les posts
]);


ob_start();
?>
<div class="deux-colonnes" data-type="component">
    <div>

        <div class="affiches">
            <h3>Nos productions</h3>

            <p>Cliquez sur l'affiche pour plus d'informations.</p>
            <ul>
                <?php foreach ($productions as $production) { ?>
                    <li>
                        <button data-film-id="<?= $production->ID; ?>">
                            <img src="<?= get_the_post_thumbnail_url($production, 'medium'); ?>" alt="<?= get_the_title($production); ?>">
                        </button>
                    </li>
                    <dialog class="popin" data-film-id="<?= $production->ID; ?>">
                        <div>
                            <figure>
                                <img src="<?= get_the_post_thumbnail_url($production, 'medium'); ?>" alt="<?= get_the_title($production); ?>">
                            </figure>
                            <div>

                                <strong>Fiche technique</strong>
                                <h3><?=get_the_title($production);?></h3>
                                <?=get_post_content($production->ID);?>
                                
                                <div class="boutons">
                                    <a class="bouton" href="<?=get_field('cta_lien', $production);?>"><?=get_field('cta_texte', $production);?></a>
                                </div>

                            </div>
                        </div>
                    </dialog>
                <?php } ?>
            </ul>

        </div>
    </div>
    <div>
        <div class="content">
            <?= get_field("contenu_en_colonne_de_droite"); ?>

            <div class="boutons">
                <a class="bouton" href="/contact">Contactez-nous</a>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
set_extra_content($content);



require __DIR__ . '/page.php';
