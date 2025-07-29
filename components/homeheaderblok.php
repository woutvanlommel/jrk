<?php
$header_afbeelding = get_field('header_afbeelding');
$header_tekst = get_field('header_tekst');

// Bepaal de achtergrondstijl
if ($header_afbeelding) {
    $background_style = "background-image: url('" . esc_url($header_afbeelding['url']) . "'); background-size: cover; background-position: center;";
} else {
    $background_style = "background-color: rgb(255, 69, 69)";
}
?>

<header class="headerhome" style="<?php echo $background_style; ?>">
  <div class="header-content">
    <h1><?php echo esc_html($header_tekst); ?></h1>
  </div>
</header>