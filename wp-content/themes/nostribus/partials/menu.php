<nav>
    <button class="close" data-action="toggle-menu"><svg data-svg="close" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="-939 961 80 80">
            <path fill="currentColor" d="m-859 966.7-5.7-5.7-34.3 34.3-34.3-34.3-5.7 5.7 34.3 34.3-34.3 34.3 5.7 5.7 34.3-34.3 34.3 34.3 5.7-5.7-34.3-34.3z"></path>
        </svg>
    </button>
    <?php
    $menu_name = 'primary_menu';
    $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()[$menu_name]);
    $current_url = home_url(add_query_arg([], $_SERVER['REQUEST_URI']));
    ?>

    <ul>
        <li><img class="logo" src="<?= esc_url(get_theme_mod('site_logo')); ?>" alt="Logo Nos tribus"></li>

        <?php if ($menu_items): ?>
            <?php foreach ($menu_items as $item): ?>
                <?php $active_class = ($current_url === esc_url($item->url)) ? 'selected' : ''; ?>
                <li class="<?=$active_class; ?>">
                    <a href="<?= esc_url($item->url); ?>"><?= esc_html($item->title); ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</nav>
