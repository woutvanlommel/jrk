<?php
/*
Template Name: Inschrijvenpagina
*/

// Zorg dat $activePage bestaat voor navigatie
if (!isset($activePage)) {
    $activePage = 'inschrijven';
}

// Laad header afhankelijk van omgeving
if (function_exists('get_header')) {
    get_header();
} else {
    include 'header.php';
}
?>

<header>
  <h1>Inschrijvingen</h1>
</header>

<main>
  <section class="inschrijfinfo">
    <p>Wil je graag deel uitmaken van Jeugd Rode Kruis Herckenrode? Schrijf je dan eenvoudig in via onderstaand formulier of neem contact met ons op voor meer informatie.</p>

    <ul>
      <li><strong>Startdatum activiteiten:</strong> Vanaf september</li>
      <li><strong>Leeftijdscategorieën:</strong> Vanaf 6 jaar tot 16 jaar</li>
      <li><strong>Locatie:</strong> Prinsenhofweg 3, 3511 Kuringen</li>
    </ul>

    <!-- Inschrijfformulier placeholder -->
    <!-- Je kan hier bv. een Gravity Form of Contact Form 7 shortcode plaatsen -->
    <!-- [contact-form-7 id="1234" title="Inschrijvingsformulier"] -->
  </section>
</main>

<?php
// Laad footer afhankelijk van omgeving
if (function_exists('get_footer')) {
    get_footer();
} else {
    include 'footer.php';
}
?>
