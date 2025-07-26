<?php
$header_afbeelding = get_field('header_afbeelding');
$header_tekst = get_field('header_tekst');
?>

<header class="home-header" style="
  <?php if ($header_afbeelding): ?>
    background-image: url('<?php echo esc_url($header_afbeelding['url']); ?>');
    background-size: cover;
    background-position: center;
  <?php else: ?>
    background-color: #e6007d;
  <?php endif; ?>
">
  <div class="header-content">
    <h1><?php echo esc_html($header_tekst); ?></h1>
  </div>
</header>