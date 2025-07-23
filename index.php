<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="img/Favicon.svg">
    <title>Jeugd Rode Kruis Herckenrode</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/ef4e3e0cf6.js" crossorigin="anonymous"></script>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const navbar = document.querySelector('.navbarjrk');
      const threshold = 50;
  
      window.addEventListener('scroll', function() {
        // let op: hier gebruik je scrollY (niet scrollly!)
        if (window.scrollY > threshold) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      });
    });
  </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const navMenu = document.querySelector(".navmenujrk");
    const icon = hamburger.querySelector("i");

    hamburger.addEventListener("click", function () {
        navMenu.classList.toggle("show");

        const isOpen = navMenu.classList.contains("show");
        document.body.style.overflow = isOpen ? "hidden" : "auto";

        if (isOpen) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-times");
        document.body.classList.add("menu-open"); // ➕ voeg class toe
        } else {
        icon.classList.add("fa-bars");
        icon.classList.remove("fa-times");
        document.body.classList.remove("menu-open"); // ➖ verwijder class
        }
    });

    document.querySelectorAll(".navmenujrk a").forEach(link => {
        link.addEventListener("click", () => {
        navMenu.classList.remove("show");
        icon.classList.remove("fa-times");
        icon.classList.add("fa-bars");
        document.body.style.overflow = "auto";
        document.body.classList.remove("menu-open"); // ➖ ook bij sluiten via link
        });
    });
    });
  </script>

<body>

    <nav class="navbarjrk">
        <div class="navcontainerjrk">
            <div class="navlogojrk">
                <a href="index.html">
                    <img src="img/jrk_logo.svg" alt="">
                </a>
            </div>

            <ul class="navmenujrk">
                <li><a href="kalender.html">Kalender</a></li>
                <li><a href="groepen.html">Groepen</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="inschrijven.html">Inschrijvingen</a></li>
            </ul>

            <div class="hamburger" id="hamburger">
                <i class="fas fa-bars"></i>
            </div>

        </div> 
    </nav>

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
                <h2>JEUGD RODE KRUIS IS SAMEN  <br><span class="wisselwoord">Plezier maken</span></h2>
            </div>

            <div class="jrkwisselwoordtxt">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum facere quis totam ipsam animi quas tempora nesciunt quasi? Corporis expedita nam non? Fuga maxime pariatur sapiente vel quas nesciunt enim.</p>
            </div>
        </div>
       

        <script src="index.js"></script>
        </section>


        <section>
        <div class="introjrk">

            <div class="uitlegjrk">
                <div class="uitlegimg">
                    <img src="img/Groepsfotobewerkt.png" alt="Groepsfoto">
                </div>
                <div class="uitlegtxt">
                    <h3>Wat is JRK nu echt??</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo magni doloremque dolorum ipsa enim officiis ab. Culpa deserunt mollitia quis assumenda veniam distinctio inventore tempora placeat impedit nihil, doloremque dolorem!</p>
                </div>
            </div>

            <div class="uitlegjrk reverse">
                <div class="uitlegimg">
                    <img src="img/Groepsfotobewerkt.png" alt="Groepsfoto">
                </div>
                <div class="uitlegtxt">
                    <h3>Wat is JRK nu echt??</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo magni doloremque dolorum ipsa enim officiis ab. Culpa deserunt mollitia quis assumenda veniam distinctio inventore tempora placeat impedit nihil, doloremque dolorem!</p>
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
                    <a href="kalender.html">Bekijk onze kalender</a>
                </button>
            </div>
        </section>
       

        <section class="contact">
            <h3>Contacteer onze hoofdleiding</h3>
            <div class="hoofdleiding" id="hoofdleidingContainer">
            </div>
        </section>

    
    </main>

    <footer>
        <div class="footer">
          <div class="footertop">
            <div class="footerlogo">
              <img src="img/jrk_logo.svg" alt="JRK Logo">
              <h3>Jeugd Rode Kruis Herckenrode</h3>
              <p><a href="mailto:jeugdrodekruis@herckenrode.be">jeugdrodekruis@herckenrode.be</a><br>Prinsenhofweg 3, 3511 Kuringen</p>
            </div>
      
            <div class="footersocial">
              <h3>Volg ons op</h3>
                <div class="icons">
                    <a href="https://www.facebook.com/jeugdrodekruiskuringen" target="_blank"><i class="fa-brands fa-facebook fa-2x"></i></a>
                    <a href="https://www.instagram.com/jeugd.rodekruis.herckenrode/" target="_blank"><i class="fa-brands fa-instagram fa-2x"></i></a>
                    <a href="https://www.tiktok.com/@jrk_herckenrode" target="_blank"><i class="fa-brands fa-tiktok fa-2x"></i></a>
                </div>
            </div>
          </div>
      
          <hr>
      
          <div class="footerbottom">
            <ul>
                <li><a href="">Gegevensbeleid</a></li>
                <li><a href="">Gebruikersvoorwaarden</a></li>
                <li><a href="">Wettelijke vermeldingen</a></li>
                <li><a href="">Cookiebeleid</a></li>
            </ul>
          </div>
        </div>
      </footer>
    
</body>
</html>