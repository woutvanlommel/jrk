<?php
// 🚀 Enqueue scripts & styles
function jrk_enqueue_scripts() {
    wp_enqueue_style('jrk-style', get_stylesheet_uri());

    if (file_exists(get_template_directory() . '/custom.css')) {
        wp_enqueue_style('jrk-custom-style', get_template_directory_uri() . '/custom.css');
    }

    // config.js (altijd eerst)
    if (file_exists(get_template_directory() . '/config.js')) {
        wp_enqueue_script('jrk-config', get_template_directory_uri() . '/config.js', [], null, true);
    }

    // Homepagina: index.js + wisselwoorden + hoofdleidingdata
    if (is_front_page()) {
        wp_register_script('jrk-index', get_template_directory_uri() . '/index.js', ['jrk-config'], null, true);

        // ➕ Haal alle leiding op voor JS
        $leiding = [];
        $leiding_posts = get_posts([
            'post_type' => 'leiding',
            'posts_per_page' => -1
        ]);

        foreach ($leiding_posts as $lid) {
            $leiding[] = [
                'naam' => get_the_title($lid->ID),
                'email' => get_field('email', $lid->ID),
                'telefoon' => get_field('telefoon', $lid->ID),
                'foto' => get_field('foto', $lid->ID),
                'rollen' => get_field('rollen', $lid->ID)
            ];
        }

        wp_localize_script('jrk-index', 'leidingData', ['leiding' => $leiding]);

        // Voeg wisselwoorden ook toe
        $wisselwoorden = get_field('wisselwoorden', get_option('page_on_front'));
        if ($wisselwoorden) {
            $woorden = array_map(fn($item) => $item['woord'], $wisselwoorden);
            wp_localize_script('jrk-index', 'wisselData', ['woorden' => $woorden]);
        }

        wp_enqueue_script('jrk-index');
    }

    // Kalenderpagina
    if (is_page('kalender') && file_exists(get_template_directory() . '/kalender.js')) {
        wp_enqueue_script('jrk-kalender', get_template_directory_uri() . '/kalender.js', ['jrk-config'], null, true);
    }

    // Groepenpagina
    if (is_page_template('groepen.php') && file_exists(get_template_directory() . '/groepen.js')) {
        wp_register_script('jrk-groepen', get_template_directory_uri() . '/groepen.js', ['jrk-config'], null, true);
    
        // ✅ ➕ Bouw data-array voor groepenpagina
        $groepenData = ['groepen' => []];
    
        $groepen_posts = get_posts([
            'post_type' => 'groepen',
            'posts_per_page' => -1
        ]);
    
        foreach ($groepen_posts as $groep) {
            $groep_naam = get_the_title($groep->ID);
            $groep_kleur = get_field('kleur', $groep->ID);
            $groep_afbeelding = get_field('afbeelding', $groep->ID);
    
            // ➕ Zoek bijhorende leiding
            $leidingleden = get_posts([
                'post_type' => 'leiding',
                'posts_per_page' => -1,
                'meta_query' => [[
                    'key' => 'groepen',
                    'value' => '"' . $groep_naam . '"',
                    'compare' => 'LIKE'
                ]]
            ]);
    
            $leiding_array = [];
            foreach ($leidingleden as $lid) {
                $leiding_array[] = [
                    'naam' => get_the_title($lid->ID),
                    'achternaam' => get_field('achternaam', $lid->ID),
                    'email' => get_field('email', $lid->ID),
                    'telefoon' => get_field('telefoon', $lid->ID),
                    'foto' => get_field('foto', $lid->ID),
                    'favorieteAct' => get_field('favorieteAct', $lid->ID),
                    'verjaardag' => get_field('verjaardag', $lid->ID)
                ];
            }
    
            $groepenData['groepen'][] = [
                'naam' => $groep_naam,
                'kleur' => $groep_kleur,
                'afbeelding' => $groep_afbeelding,
                'leiding' => $leiding_array
            ];
        }
    
        wp_localize_script('jrk-groepen', 'groepenData', $groepenData);
    
        wp_enqueue_script('jrk-groepen');
    }

    // Globale data voor elke JS
    wp_localize_script('jrk-config', 'jrkData', [
        'themeUrl' => get_template_directory_uri(),
        'siteUrl' => get_site_url()
    ]);
}
add_action('wp_enqueue_scripts', 'jrk_enqueue_scripts');


// 🧱 Custom Post Types: Leiding & Groepen
function jrk_register_custom_post_types() {
    // Leiding
    register_post_type('leiding', [
        'labels' => [
            'name' => 'Leiding',
            'singular_name' => 'Leidinglid',
            'add_new_item' => 'Voeg nieuw leidinglid toe',
            'edit_item' => 'Bewerk leidinglid',
            'new_item' => 'Nieuw leidinglid',
            'view_item' => 'Bekijk leidinglid',
            'search_items' => 'Zoek in leiding',
            'not_found' => 'Geen leiding gevonden'
        ],
        'public' => true,
        'menu_position' => 4,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'thumbnail', 'custom-fields'],
        'has_archive' => false,
        'show_in_rest' => true
    ]);

    // Groepen
    register_post_type('groepen', [
        'labels' => [
            'name' => 'Groepen',
            'singular_name' => 'Groep',
            'add_new_item' => 'Voeg nieuwe groep toe',
            'edit_item' => 'Bewerk groep',
            'new_item' => 'Nieuwe groep',
            'view_item' => 'Bekijk groep',
            'search_items' => 'Zoek in groepen',
            'not_found' => 'Geen groepen gevonden'
        ],
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-networking',
        'supports' => ['title', 'custom-fields', 'thumbnail'],
        'has_archive' => false,
        'show_in_rest' => true
    ]);
}
add_action('init', 'jrk_register_custom_post_types');


// 🔤 ACF-velden registreren
if (function_exists('acf_add_local_field_group')) {

    // Leiding
    acf_add_local_field_group([
        'key' => 'leiding_velden',
        'title' => 'Leidinggegevens',
        'fields' => [
            ['key' => 'leiding_achternaam', 'label' => 'Achternaam', 'name' => 'achternaam', 'type' => 'text'],
            ['key' => 'leiding_email', 'label' => 'E-mail', 'name' => 'email', 'type' => 'email'],
            ['key' => 'leiding_telefoon', 'label' => 'Telefoonnummer', 'name' => 'telefoon', 'type' => 'text'],
            ['key' => 'leiding_favoriete_act', 'label' => 'Favoriete activiteit', 'name' => 'favorieteAct', 'type' => 'text'],
            ['key' => 'leiding_verjaardag', 'label' => 'Verjaardag', 'name' => 'verjaardag', 'type' => 'text'],
            ['key' => 'leiding_foto', 'label' => 'Foto', 'name' => 'foto', 'type' => 'image', 'return_format' => 'url'],
            [
                'key' => 'leiding_groepen',
                'label' => 'Groepen',
                'name' => 'groepen',
                'type' => 'checkbox',
                'choices' => [],
                'allow_custom' => 1,
                'layout' => 'vertical'
            ],
            [
                'key' => 'leiding_rollen',
                'label' => 'Rollen',
                'name' => 'rollen',
                'type' => 'checkbox',
                'choices' => [
                    'leiding' => 'Leiding',
                    'hoofdleiding' => 'Hoofdleiding',
                    'oudleiding' => 'Oudleiding',
                    'kookouder' => 'Kookouder'
                ],
                'allow_custom' => 1,
                'layout' => 'vertical'
            ]
        ],
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'leiding']]]
    ]);

    // Groepen
    acf_add_local_field_group([
        'key' => 'groep_velden',
        'title' => 'Groepgegevens',
        'fields' => [
            ['key' => 'groep_kleur', 'label' => 'Achtergrondkleur', 'name' => 'kleur', 'type' => 'color_picker'],
            ['key' => 'groep_afbeelding', 'label' => 'Achtergrondafbeelding', 'name' => 'afbeelding', 'type' => 'image', 'return_format' => 'url']
        ],
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'groepen']]]
    ]);
}
