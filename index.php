<?php 
    include 'header.php'; 
?>

<header class="headerhome">
    <h1>Jeugd Rode Kruis Herckenrode</h1>
    <button class="primarybutton">
        Schrijf je in!
    </button>
</header>

<main>
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

    <section>
        <div class="introjrk">
            <div class="uitlegjrk">
                <div class="uitlegimg">
                    <img src="img/Groepsfotobewerkt.png" alt="Groepsfoto">
                </div>
                <div class="uitlegtxt">
                    <h3>Wat is JRK nu echt??</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo magni doloremque dolorum ipsa enim officiis ab...</p>
                </div>
            </div>

            <div class="uitlegjrk reverse">
                <div class="uitlegimg">
                    <img src="img/Groepsfotobewerkt.png" alt="Groepsfoto">
                </div>
                <div class="uitlegtxt">
                    <h3>Wat is JRK nu echt??</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo magni doloremque dolorum ipsa enim officiis ab...</p>
                </div>
            </div>
        </div>
    </section>

    <section id="speciale-activiteiten">
        <h3>Speciale activiteiten</h3>
        <div id="speciale-activiteiten-container"></div>
        <br>
        <div>
            <button class="primarybutton">
                <a href="kalender.php">Bekijk onze kalender</a>
            </button>
        </div>
    </section>

    <section class="contact">
        <h3>Contacteer onze hoofdleiding</h3>
        <div class="hoofdleiding" id="hoofdleidingContainer"></div>
    </section>
</main>

<script src="index.js"></script>

<?php include 'footer.php'; ?>