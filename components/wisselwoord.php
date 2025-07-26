<?php
$uitlegtekst = get_field('wisselwoord_tekst');
$wisselwoorden = get_field('wisselwoorden');
$eerste_woord = $wisselwoorden && count($wisselwoorden) > 0 ? $wisselwoorden[0]['woord'] : '...';
?>

<section>
  <div class="wisselwoordcontent">
    <div class="jrkwisselwoord">
      <h2>JEUGD RODE KRUIS IS SAMEN<br>
        <span class="wisselwoord"><?php echo esc_html($eerste_woord); ?></span>
      </h2>
    </div>

    <div class="jrkwisselwoordtxt">
      <p><?php echo esc_html($uitlegtekst); ?></p>
    </div>
  </div>
</section>

<?php
// Wisselwoorden doorgeven aan JS via wp_localize_script
if ($wisselwoorden) {
    $woorden_array = array_map(function ($item) {
        return $item['woord'];
    }, $wisselwoorden);

    wp_register_script('jrk-wisselwoord', get_template_directory_uri() . '/wisselwoord.js', [], null, true);
    wp_enqueue_script('jrk-wisselwoord');
    wp_localize_script('jrk-wisselwoord', 'wisselData', [
        'woorden' => $woorden_array
    ]);
}
?>