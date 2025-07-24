<?php
function jrk_enqueue_scripts() {
    // Basis stylesheet van het thema
    wp_enqueue_style('jrk-style', get_stylesheet_uri());

    // Extra custom CSS indien aanwezig
    if (file_exists(get_template_directory() . '/custom.css')) {
        wp_enqueue_style('jrk-custom-style', get_template_directory_uri() . '/custom.css');
    }

    // JavaScript-bestanden in juiste volgorde
    // 1. config.js (moet eerst!)
    if (file_exists(get_template_directory() . '/config.js')) {
        wp_enqueue_script('jrk-config', get_template_directory_uri() . '/config.js', [], null, true);
    }

    // 2. index.js
    if (file_exists(get_template_directory() . '/index.js')) {
        wp_enqueue_script('jrk-index', get_template_directory_uri() . '/index.js', ['jrk-config'], null, true);
    }

    // 3. kalender.js
    if (file_exists(get_template_directory() . '/kalender.js')) {
        wp_enqueue_script('jrk-kalender', get_template_directory_uri() . '/kalender.js', ['jrk-config'], null, true);
    }

    // 4. groepen.js
    if (file_exists(get_template_directory() . '/groepen.js')) {
        wp_enqueue_script('jrk-groepen', get_template_directory_uri() . '/groepen.js', ['jrk-config'], null, true);
    }

    // Globale data beschikbaar maken in JS
    wp_localize_script('jrk-config', 'jrkData', array(
        'themeUrl' => get_template_directory_uri(),
        'siteUrl' => get_site_url()
    ));
}
add_action('wp_enqueue_scripts', 'jrk_enqueue_scripts');