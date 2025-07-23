<?php
// CSS en JS toevoegen
function jrk_enqueue_scripts() {
    // Basis stylesheet (verplicht voor WP)
    wp_enqueue_style('jrk-style', get_stylesheet_uri());

    // Jouw echte stylesheet
    $custom_style_path = get_template_directory() . '/styles.css';
    if (file_exists($custom_style_path)) {
        wp_enqueue_style('jrk-custom-style', get_template_directory_uri() . '/styles.css');
    }

    // JavaScript-bestanden toevoegen
    $scripts = ['index.js', 'groepen.js', 'kalender.js'];
    foreach ($scripts as $script) {
        $path = get_template_directory() . '/' . $script;
        if (file_exists($path)) {
            $handle = 'jrk-' . basename($script, '.js');
            wp_enqueue_script($handle, get_template_directory_uri() . '/' . $script, [], null, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'jrk_enqueue_scripts');
