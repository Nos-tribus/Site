<?php


$plugin_dir = __DIR__ . '/plugins';

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($plugin_dir));
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        require_once $file->getPathname();
    }
}


add_action('customize_controls_enqueue_scripts', function () {
    // Récupérer les URLs des pages
    $intro_page_url = get_permalink(get_page_by_path('intro'));
    $home_page_url  = home_url('/'); // URL de la page d'accueil

    // Enqueue le script
    wp_enqueue_script(
        'nos-tribus-customizer-redirect',
        get_template_directory_uri() . '/customizer-redirect.js',
        ['jquery', 'customize-controls'],
        false,
        true
    );

    // Localiser les variables PHP pour JS
    wp_localize_script('nos-tribus-customizer-redirect', 'nosTribusCustomizer', [
        'introPageUrl' => esc_url($intro_page_url),
        'homePageUrl'  => esc_url($home_page_url),
    ]);
});

add_action('customize_register', function($wp_customize) {

    // Section "Vidéo d'intro"
    $wp_customize->add_section('nos_tribus_intro_video', [
        'title'       => __('Vidéo d\'intro', 'nos-tribus'),
        'priority'    => 30,
        'description' => __('Paramètres pour la vidéo d\'introduction.', 'nos-tribus'),
    ]);

    // Case à cocher pour activer la vidéo
    $wp_customize->add_setting('nos_tribus_show_intro_video', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('nos_tribus_show_intro_video', [
        'type'     => 'checkbox',
        'label'    => __('Afficher une vidéo d\'intro', 'nos-tribus'),
        'section'  => 'nos_tribus_intro_video',
        'settings' => 'nos_tribus_show_intro_video',
    ]);

    // Champ pour la vidéo MP4 (Stocke l'ID seulement)
    $wp_customize->add_setting('nos_tribus_intro_video_mp4', [
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control(
        $wp_customize,
        'nos_tribus_intro_video_mp4',
        [
            'label'    => __('Fichier vidéo (MP4)', 'nos-tribus'),
            'section'  => 'nos_tribus_intro_video',
            'settings' => 'nos_tribus_intro_video_mp4',
            'mime_type' => 'video/mp4',
        ]
    ));

    // Champ pour la vidéo WEBM (Stocke l'ID seulement)
    $wp_customize->add_setting('nos_tribus_intro_video_webm', [
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control(
        $wp_customize,
        'nos_tribus_intro_video_webm',
        [
            'label'    => __('Fichier vidéo (WEBM)', 'nos-tribus'),
            'section'  => 'nos_tribus_intro_video',
            'settings' => 'nos_tribus_intro_video_webm',
            'mime_type' => 'video/webm',
        ]
    ));

    // Champ de sélection de couleur
    $wp_customize->add_setting('nos_tribus_intro_color', [
        'default'           => '#ffffff', // Valeur par défaut (blanc)
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'nos_tribus_intro_color',
        [
            'label'    => __('Couleur d\'introduction', 'nos-tribus'),
            'section'  => 'nos_tribus_intro_video',
            'settings' => 'nos_tribus_intro_color',
        ]
    ));

});


function get_text_color($hex) {
    // Remove # if present
    $hex = ltrim($hex, '#');

    // Convert HEX to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Calculate luminance using the relative luminance formula
    $luminance = ($r * 0.299) + ($g * 0.587) + ($b * 0.114);

    // Return white for dark colors, black for light colors
    return ($luminance < 128) ? 'white' : 'black';
}
