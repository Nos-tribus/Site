<?php
$GLOBALS['extra_content'] = [];
function set_extra_content($content)
{
    $GLOBALS['extra_content'][] = $content;
}
function get_extra_content()
{
    foreach ($GLOBALS['extra_content'] as $content) {
        echo $content;
    }
}


/**
 * Récupère et affiche le contenu d'un article WordPress
 *
 * @param int $post_id L'ID de l'article à récupérer.
 */
function get_post_content($post_id) {
    $post = get_post($post_id);

    if ($post && !is_wp_error($post)) {
        return apply_filters('the_content', $post->post_content);
    }
}
