<?php

add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary_menu'   => __('Menu Principal', 'mytheme'),
        'footer_menu' => __('Menu footer', 'mytheme'),
    ]);
});
