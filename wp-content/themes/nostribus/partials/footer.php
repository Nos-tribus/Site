<?php

$home_page_id = get_option('page_on_front');
$home_page = get_post($home_page_id);

$menu_name = 'footer_menu';
$menu_items = wp_get_nav_menu_items(get_nav_menu_locations()[$menu_name]);

?>
<footer class="site-footer">
    <?= get_field('footer_du_site', $home_page); ?>

    <p>
        <?php foreach ($menu_items as $idx => $menu_item) {
            echo $idx ? ' - ' : ''; ?>
            <a href="<?= esc_url($menu_item->url); ?>"><?= esc_html($menu_item->title); ?></a>
        <?php } ?>
</footer>