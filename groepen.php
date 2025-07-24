<?php
/*
Template Name: Groepenpagina
*/

if (!isset($activePage)) {
    $activePage = 'groepen';
}

// Header ophalen via WP of lokaal
if (function_exists('get_header')) {
    get_header();
} else {
    include 'header.php';
}
?>

<header>
    <h1>Groepen</h1>
</header>

<!-- 📦 Container voor groepen -->
<div id="groepenContainer" class="groepen-grid"></div>

<!-- 🪟 Modal voor groepsinfo -->
<div id="groepModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" style="display: none;">
    <div class="modal-content">
        <button class="close-modal" aria-label="Sluit">&times;</button>
        <h2 id="modalTitle"></h2>
        <div class="modal-content-body"></div>
    </div>
</div>

<?php
// Footer ophalen via WP of lokaal
if (function_exists('get_footer')) {
    get_footer();
} else {
    include 'footer.php';
}
?>