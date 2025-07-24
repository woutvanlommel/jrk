<?php 
if (function_exists('get_header')) {
    get_header();
} else {
    include 'header.php';
}
?>

<header class="headerhome">
    <h1>Jeugd Rode Kruis Herckenrode</h1>
    <a class="primarybutton" href="<?php echo function_exists('site_url') ? site_url('/inschrijven') : 'inschrijven.php'; ?>">Schrijf je in!</a>
</header>

<main>
    <!-- 🎈 WISSELWOORD -->
    <section>
        <div class="wisselwoordcontent">
            <div class="jrkwisselwoord">
                <h2>JEUGD RODE KRUIS IS SAMEN<br><span class="wisselwoord">Plezier maken</span></h2>
            </div>

            <div class="jrkwisselwoordtxt">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum facere quis totam ipsam animi quas tempora nesciunt quasi? Corporis expedita nam non? Fuga maxime pariatur sapiente vel quas nesciunt enim.</p>
            </div>
        </div>
    </section>

    <!-- 👋 UITLEG -->
    <section>
        <div class="introjrk">
            <div class="uitlegjrk">
                <div class="uitlegimg">
                    <img src="<?php echo function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.'; ?>/img/Groepsfotobewerkt.png" alt="Groepsfoto JRK">
                </div>
                <div class="uitlegtxt">
                    <h3>Wat is JRK nu echt?</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo magni doloremque dolorum ipsa enim officiis ab...</p>
                </div>
            </div>

            <div class="uitlegjrk reverse">
                <div class="uitlegimg">
                    <img src="<?php echo function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.'; ?>/img/Groepsfotobewerkt.png" alt="Groepsfoto JRK">
                </div>
                <div class="uitlegtxt">
                    <h3>Wat is JRK nu echt?</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo magni doloremque dolorum ipsa enim officiis ab...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ⭐ SPECIALE ACTIVITEITEN -->
    <section id="speciale-activiteiten">
        <h3>Speciale activiteiten</h3>
        <div id="speciale-activiteiten-container"></div>
        <br>
        <div>
            <a class="primarybutton" href="<?php echo function_exists('site_url') ? site_url('/kalender') : 'kalender.php'; ?>">
                Bekijk onze kalender
            </a>
        </div>
    </section>

    <!-- 📞 HOOFDLEIDING -->
    <section class="contactleiding">
        <h3>Contacteer onze hoofdleiding</h3>
        <div class="hoofdleiding" id="hoofdleidingContainer"></div>
    </section>
</main>

<?php 
if (function_exists('get_footer')) {
    get_footer();
} else {
    include 'footer.php';
}
?>