<?php get_header(); ?>



<?php
$show_video = get_theme_mod('nos_tribus_show_intro_video', false);
$video_mp4_id  = get_theme_mod('nos_tribus_intro_video_mp4', '');
$video_webm_id = get_theme_mod('nos_tribus_intro_video_webm', '');

// Convertir l'ID en URL
$video_mp4_url  = !empty($video_mp4_id) ? wp_get_attachment_url($video_mp4_id) : '';
$video_webm_url = !empty($video_webm_id) ? wp_get_attachment_url($video_webm_id) : '';

if ($show_video && (!empty($video_mp4_url) || !empty($video_webm_url))) : ?>
    <div class="intro">
        <div>
            <div class="boutons">
                <a class="bouton" href="/">Passer la vidéo</a>
            </div>
        </div>
        <div class="video">
            <video autoplay muted playsinline>
                <?php if (!empty($video_mp4_url)) : ?>
                    <source src="<?php echo esc_url($video_mp4_url); ?>" type="video/mp4">
                <?php endif; ?>
                <?php if (!empty($video_webm_url)) : ?>
                    <source src="<?php echo esc_url($video_webm_url); ?>" type="video/webm">
                <?php endif; ?>
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>