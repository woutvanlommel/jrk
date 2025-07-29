<?php
// 🚀 Enqueue scripts & styles
function jrk_enqueue_scripts() {
    wp_enqueue_style('jrk-style', get_stylesheet_uri());

    if (file_exists(get_template_directory() . '/custom.css')) {
        wp_enqueue_style('jrk-custom-style', get_template_directory_uri() . '/custom.css');
    }

// Homepagina: index.js + wisselwoorden + hoofdleidingdata
if (is_front_page()) {
    wp_register_script('jrk-index', get_template_directory_uri() . '/index.js', [], null, true);

    // ➕ Haal alle leiding op voor JS
    $leiding = [];
    $leiding_posts = get_posts([
        'post_type' => 'leiding',
        'posts_per_page' => -1
    ]);

    foreach ($leiding_posts as $lid) {
        $leiding[] = [
            'voornaam' => get_field('voornaam', $lid->ID),
            'achternaam' => get_field('achternaam', $lid->ID),
            'email' => get_field('email', $lid->ID),
            'telefoon' => get_field('telefoon', $lid->ID),
            'foto' => get_field('foto', $lid->ID),
            'rollen' => get_field('rollen', $lid->ID),
            'groepen' => get_field('groepen', $lid->ID)
        ];
    }

    wp_localize_script('jrk-index', 'leidingData', ['leiding' => $leiding]);

    // Voeg wisselwoorden toe
    $wisselwoorden = get_field('wisselwoorden', get_option('page_on_front'));
    if ($wisselwoorden) {
        $woorden = array_map(fn($item) => $item['woord'], $wisselwoorden);
        wp_localize_script('jrk-index', 'wisselData', ['woorden' => $woorden]);
    }

    // 🔑 Voeg REST endpoint toe voor speciale activiteiten
    wp_localize_script('jrk-index', 'jrkCalendar', [
        'restUrl' => esc_url(rest_url('jrk/v1/calendar'))
    ]);

    wp_enqueue_script('jrk-index');
}

    // Kalenderpagina
    if (is_page('kalender') && file_exists(get_template_directory() . '/kalender.js')) {
        wp_enqueue_script('jrk-kalender', get_template_directory_uri() . '/kalender.js', [], null, true);

        // API Key + REST endpoint naar JS sturen
        wp_localize_script('jrk-kalender', 'jrkCalendar', [
            'apiKey' => JRK_GOOGLE_CALENDAR_KEY,
            'restUrl' => esc_url(rest_url('jrk/v1/calendar'))
        ]);
    }

    // Groepenpagina
    if (is_page_template('groepen.php') && file_exists(get_template_directory() . '/groepen.js')) {
        wp_register_script('jrk-groepen', get_template_directory_uri() . '/groepen.js', [], null, true);
    
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
                    'voornaam' => get_field('voornaam', $lid->ID),
                    'achternaam' => get_field('achternaam', $lid->ID),
                    'email' => get_field('email', $lid->ID),
                    'telefoon' => get_field('telefoon', $lid->ID),
                    'foto' => get_field('foto', $lid->ID),
                    'favorieteAct' => get_field('favorieteAct', $lid->ID),
                    'verjaardag' => get_field('verjaardag', $lid->ID),
                    'rollen' => get_field('rollen', $lid->ID)
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

    // Dynamisch alle groepen ophalen voor select veld
    $groepen_choices = [];
    $groepen_posts = get_posts(['post_type' => 'groepen', 'posts_per_page' => -1]);
    foreach ($groepen_posts as $groep) {
        $groepen_choices[$groep->post_title] = $groep->post_title;
    }

    // Leiding
    acf_add_local_field_group([
        'key' => 'leiding_velden',
        'title' => 'Leidinggegevens',
        'fields' => [
            ['key' => 'leiding_voornaam', 'label' => 'Voornaam', 'name' => 'voornaam', 'type' => 'text'],
            ['key' => 'leiding_achternaam', 'label' => 'Achternaam', 'name' => 'achternaam', 'type' => 'text'],
            ['key' => 'leiding_email', 'label' => 'E-mail', 'name' => 'email', 'type' => 'email'],
            ['key' => 'leiding_telefoon', 'label' => 'Telefoonnummer', 'name' => 'telefoon', 'type' => 'text'],
            ['key' => 'leiding_favoriete_act', 'label' => 'Favoriete activiteit', 'name' => 'favorieteAct', 'type' => 'text'],
            ['key' => 'leiding_verjaardag', 'label' => 'Verjaardag', 'name' => 'verjaardag', 'type' => 'text'],
            ['key' => 'leiding_foto', 'label' => 'Foto', 'name' => 'foto', 'type' => 'image', 'return_format' => 'url'],

            // Dynamische groepen-selectie
            [
                'key' => 'leiding_groepen',
                'label' => 'Groepen',
                'name' => 'groepen',
                'type' => 'select',
                'choices' => $groepen_choices,
                'multiple' => 1,
                'ui' => 1,
                'return_format' => 'value',
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


// 🔑 REST endpoint voor Google Calendar events
add_action('rest_api_init', function () {
    register_rest_route('jrk/v1', '/calendar', [
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) {
            $calendarIds = [
                '9f8aecf23be1e8387aa31872f5df2a5308dde848a01f854f9db282cad285b683@group.calendar.google.com',
                '0baaf1cea005548f41707e9942f8fe0733e31efe6b654b71f90ac65196da9fcf@group.calendar.google.com',
                'b940058507355683160f31fa21ce080c434a4b3344447e355e402a7a4bfa7d84@group.calendar.google.com',
                '7b5c3807b7714e41c9260b40a1ae2ecde3042aa4c1f6dc23715c8b5d951b303c@group.calendar.google.com',
                '5578d000dbaac65888adf7dbd787d7c7187386ae40ca78e20f3859e5487ffa9e@group.calendar.google.com'
            ];

            $timeMin = $request->get_param('timeMin') ?: gmdate('c');
            $timeMax = $request->get_param('timeMax');

            $events = [];
            foreach ($calendarIds as $id) {
                $url = add_query_arg([
                    'key' => JRK_GOOGLE_CALENDAR_KEY,
                    'singleEvents' => 'true',
                    'orderBy' => 'startTime'
                ], "https://www.googleapis.com/calendar/v3/calendars/" . urlencode($id) . "/events");

                $response = wp_remote_get($url);
                if (!is_wp_error($response)) {
                    $data = json_decode(wp_remote_retrieve_body($response), true);
                    if (!empty($data['items'])) {
                        foreach ($data['items'] as &$item) {
                            $item['calendarId'] = $id;
                        }
                        $events = array_merge($events, $data['items']);
                    }
                }
            }

            return $events;
        },
        'permission_callback' => '__return_true'
    ]);
});

add_action('init', function(){
    $test_url = "https://www.googleapis.com/calendar/v3/calendars/0baaf1cea005548f41707e9942f8fe0733e31efe6b654b71f90ac65196da9fcf@group.calendar.google.com/events?key=" . JRK_GOOGLE_CALENDAR_KEY;
    $res = wp_remote_get($test_url);
    error_log("📡 Test API response: " . print_r($res, true));
});