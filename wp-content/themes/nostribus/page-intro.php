<?php get_header(); ?>



<?php
$show_video = get_theme_mod('nos_tribus_show_intro_video', false);
$video_mp4_id  = get_theme_mod('nos_tribus_intro_video_mp4', '');
$video_webm_id = get_theme_mod('nos_tribus_intro_video_webm', '');
$nos_tribus_intro_color = get_theme_mod('nos_tribus_intro_color', '');
$dark_logo = get_theme_mod('dark_logo');
?>
<style>
    body:has(.intro) {
        background-color: <?= $nos_tribus_intro_color; ?>;
    }

    <?php if ($dark_logo && get_text_color($nos_tribus_intro_color) == 'white') : ?>.intro::after {
        background-image: url('<?= $dark_logo; ?>');
    }

    <?php endif; ?>
</style>
<?php
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
            <svg data-svg="play" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 75.2 94.9" width="16" height="16" fill="#ffffff">
                <path d="M71.8 41.1 12 1.3C6.9-2.1 0 1.6 0 7.7v79.5c0 6.2 6.9 9.8 12 6.4l59.8-39.8c4.5-2.9 4.5-9.7 0-12.7z"></path>
            </svg>
            <video>
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