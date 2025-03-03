<?php

// Activation des images mises en avant
add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
});

add_action('after_setup_theme', function () {
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
});

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_setting('site_logo');

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', array(
        'label'    => __('Logo du site', 'mytheme'),
        'section'  => 'title_tagline',
        'settings' => 'site_logo',
    )));
});

add_action('wp_enqueue_scripts', function () {
    $updateCache = isset($_GET['refresh']);
    $upload_dir = wp_upload_dir();
    $upload_base = $upload_dir['basedir'] . '/nos-tribus/';
    $upload_url = $upload_dir['baseurl'] . '/nos-tribus/';

    $font_folder = 'fonts/';
    $image_folder = 'images/';

    $upload_fonts_path = $upload_base . $font_folder;
    $upload_images_path = $upload_base . $image_folder;
    $upload_fonts_url = $upload_url . $font_folder;
    $upload_images_url = $upload_url . $image_folder;

    // Vérifier et créer les dossiers si nécessaire
    if (!file_exists($upload_base)) {
        wp_mkdir_p($upload_base);
    }
    if (!file_exists($upload_fonts_path)) {
        wp_mkdir_p($upload_fonts_path);
    }
    if (!file_exists($upload_images_path)) {
        wp_mkdir_p($upload_images_path);
    }

    // URLs des fichiers distants
    $remote_files = [
        'style.css' => THEME_URL.'style.css',
        'scripts.js' => THEME_URL.'scripts.js'
    ];

    $versions = [];

    foreach ($remote_files as $filename => $url) {
        $local_file = $upload_base . $filename;
        $hash = '';

        // Vérifier si le fichier existe déjà
        if (!$updateCache && file_exists($local_file)) {
            $hash = md5_file($local_file);
        } else {
            // Télécharger le fichier
            $response = wp_remote_get($url);

            if (!is_wp_error($response) && isset($response['body'])) {
                if ($filename == 'style.css') {
                    $css_content = $response['body'];

                    // Téléchargement et remplacement des polices
                    preg_match_all('/url\(["\']?(\/fonts\/[^"\')]+)["\']?\)/i', $css_content, $matches);
                    if (!empty($matches[1])) {
                        foreach ($matches[1] as $font_path) {
                            $font_url = 'https://nos-tribus.netlify.app' . $font_path;
                            $font_filename = basename($font_path);
                            $local_font_path = $upload_fonts_path . $font_filename;
                            $local_font_url = $upload_fonts_url . $font_filename;

                            // Télécharger la police si elle n'existe pas
                            if (!file_exists($local_font_path)) {
                                $font_response = wp_remote_get($font_url);
                                if (!is_wp_error($font_response) && isset($font_response['body'])) {
                                    file_put_contents($local_font_path, $font_response['body']);
                                }
                            }

                            // Remplacer l'URL distante par l'URL locale dans le CSS
                            $css_content = str_replace('"' . $font_path, '"' . $local_font_url, $css_content);
                        }
                    }

                    // Téléchargement et remplacement des images
                    preg_match_all('/url\(["\']?(\/images\/[^"\')]+)["\']?\)/i', $css_content, $matches);
                    if (!empty($matches[1])) {
                        foreach ($matches[1] as $image_path) {
                            $image_url = 'https://nos-tribus.netlify.app' . $image_path;
                            $image_filename = basename($image_path);
                            $local_image_path = $upload_images_path . $image_filename;
                            $local_image_url = $upload_images_url . $image_filename;

                            // Télécharger l'image si elle n'existe pas
                            if (!file_exists($local_image_path)) {
                                $image_response = wp_remote_get($image_url);
                                if (!is_wp_error($image_response) && isset($image_response['body'])) {
                                    file_put_contents($local_image_path, $image_response['body']);
                                }
                            }

                            // Remplacer l'URL distante par l'URL locale dans le CSS
                            $css_content = str_replace('(' . $image_path, '(' . $local_image_url, $css_content);
                        }
                    }

                    $response['body'] = $css_content;
                }

                file_put_contents($local_file, $response['body']);
                $hash = md5($response['body']);
            }
        }

        if ($hash) {
            $versions[$filename] = $hash;
        }
    }

    // Enqueue les fichiers avec leur version basée sur leur hash
    wp_enqueue_style('nos-tribus-style', $upload_url . 'style.css', [], $versions['style.css'] ?? null);
    wp_enqueue_script('nos-tribus-script', $upload_url . 'scripts.js', [], $versions['scripts.js'] ?? null, true);
});



function customizer_add_dark_logo( $wp_customize ) {
    $wp_customize->add_section( 'custom_logo_section', array(
        'title'    => __( 'Logo alternatif', 'textdomain' ),
        'priority' => 30,
    ));

    $wp_customize->add_setting( 'dark_logo', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'dark_logo', array(
        'label'    => __( 'Logo pour fond noir', 'textdomain' ),
        'section'  => 'custom_logo_section',
        'settings' => 'dark_logo',
    )));
}
add_action( 'customize_register', 'customizer_add_dark_logo' );
