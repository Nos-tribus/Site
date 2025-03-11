<?php
?>
<?php get_header(); ?>
<?php get_template_part('partials/header'); ?>
<div class="contact">
    <div class="container" data-type="fragment">
        <div>
            <div class="deux-colonnes" data-type="component">
                <div>
                    <div class="surtitre">Contact</div>
                </div>
                <div class="totop">
                    <div class="socials">

                        <h4>Retrouvez-nous sur</h4>
                        <ul>
                            <li><a href="<?=get_field('liens')['page_facebook'];?>" target="_blank"><svg data-svg="facebook" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 310 310">
                                        <path fill="currentColor" d="M81.703 165.106h33.981V305a5 5 0 0 0 5 5H178.3a5 5 0 0 0 5-5V165.765h39.064a5 5 0 0 0 4.967-4.429l5.933-51.502a5 5 0 0 0-4.966-5.572h-44.996V71.978c0-9.732 5.24-14.667 15.576-14.667h29.42a5 5 0 0 0 5-5V5.037a5 5 0 0 0-5-5h-40.545A39.746 39.746 0 0 0 185.896 0c-7.035 0-31.488 1.381-50.804 19.151-21.402 19.692-18.427 43.27-17.716 47.358v37.752H81.703a5 5 0 0 0-5 5v50.844a5 5 0 0 0 5 5.001z"></path>
                                    </svg></a></li>
                            <li><a href="<?=get_field('liens')['page_instagram'];?>" target="_blank"><svg data-svg="instagram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"></path>
                                    </svg></a></li>
                            <li><a href="<?=get_field('liens')['page_vimeo'];?>" target="_blank"><svg data-svg="vimeo" xmlns="http://www.w3.org/2000/svg" baseProfile="tiny-ps" version="1.2" viewBox="0 0 1545 1339">
                                        <path fill="currentColor" d="M1544.13 310.25c-6.85 150.54-111.94 356.76-315.06 618.47-209.98 273.34-387.67 410.06-533.09 410.06-89.99 0-166.17-83.22-228.45-249.77-41.52-152.63-83.14-305.16-124.65-457.78-46.19-166.45-95.75-249.77-148.79-249.77-11.52 0-52.05 24.36-121.28 72.88L.2 360.58c76.18-67.02 151.37-134.13 225.37-201.35C327.28 71.33 403.56 25 454.52 20.32 574.71 8.79 648.7 91.12 676.51 267.21c30 190.11 50.76 308.34 62.38 354.57 34.66 157.7 72.81 236.45 114.42 236.45 32.38 0 80.95-51.21 145.71-153.42 64.66-102.32 99.33-180.17 103.99-233.57 9.24-88.3-25.43-132.54-103.99-132.54-37.05 0-75.19 8.45-114.32 25.36C960.59 115.08 1105.6-5.93 1319.75.93c158.72 4.67 233.52 107.78 224.38 309.33"></path>
                                    </svg>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="deux-colonnes" data-type="component">
                <div>
                    <figure>
                        <img src="<?= get_field('image_de_fond') ?? ''; ?>" _style="aspect-ratio:800/113" alt="Contact">
                    </figure>

                    <div class="contact-info">
                        <?= get_the_content(); ?>
                        <figure>
                            <img src="<?= get_field('illustration_dans_le_cadre')['sizes']['medium'] ?? ''; ?>" alt="Contact">
                        </figure>
                    </div>

                </div>
                <div class="tobottom" style="pointer-events: none";>
                    <figure>
                        <img src="<?= get_the_post_thumbnail_url(null, 'medium'); ?>" alt="<?= get_the_post_thumbnail_caption(); ?>">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_template_part('partials/footer'); ?>
<?php get_footer(); ?>