<header class="header">
    <a href="/" class="logo">
        <img src="<?= get_theme_mod('site_logo'); ?>" alt="Logo Nos tribus">
    </a>
    <div class="burger"><button data-action="toggle-menu"><svg data-svg="burger" width="50" height="50" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <rect x="10" y="25" width="80" height="10" rx="5" fill="currentColor"></rect>
                <rect x="10" y="45" width="80" height="10" rx="5" fill="currentColor"></rect>
                <rect x="10" y="65" width="80" height="10" rx="5" fill="currentColor"></rect>
            </svg>
        </button></div>
    <?php get_template_part('partials/menu'); ?>
    <?php if (get_theme_mod('nos_tribus_show_intro_video', false)) { ?>
        <div class="ctas">
            <a class="bouton" href="/intro">Revoir la vidéo</a>
        </div>
    <?php } ?>
</header>