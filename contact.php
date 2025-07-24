<?php
/*
Template Name: Contactpagina
*/

// Zorg dat $activePage bestaat voor navigatie
if (!isset($activePage)) {
    $activePage = 'contact';
}

// Laad header afhankelijk van omgeving
if (function_exists('get_header')) {
    get_header();
} else {
    include 'header.php';
}
?>

<header>
    <h1>Contact</h1>
</header>

<main>
    <section class="contactgegevens">
        <p>Heb je vragen of opmerkingen? Neem gerust contact met ons op via onderstaand e-mailadres of spreek iemand van de hoofdleiding aan.</p>

        <ul>
            <li><strong>Email:</strong> <a href="mailto:info@jrkherckenrode.be">info@jrkherckenrode.be</a></li>
            <li><strong>Locatie:</strong> Prinsenhofweg 3, 3511 Kuringen</li>
        </ul>

        <!-- Als je later een formulier of kaart wilt toevoegen, kan het hier -->
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