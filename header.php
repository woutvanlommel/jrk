<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                document.body.classList.add("menu-open");
            } else {
                icon.classList.add("fa-bars");
                icon.classList.remove("fa-times");
                document.body.classList.remove("menu-open");
            }
        });

        document.querySelectorAll(".navmenujrk a").forEach(link => {
            link.addEventListener("click", () => {
                navMenu.classList.remove("show");
                icon.classList.remove("fa-times");
                icon.classList.add("fa-bars");
                document.body.style.overflow = "auto";
                document.body.classList.remove("menu-open");
            });
        });
    });
</script>

<body>

<nav class="navbarjrk">
    <div class="navcontainerjrk">
        <div class="navlogojrk">
            <a href="index.php">
                <img src="img/jrk_logo.svg" alt="">
            </a>
        </div>

        <ul class="navmenujrk">
            <li><a href="kalender.php" class="<?= ($activePage === 'kalender') ? 'active' : '' ?>">Kalender</a></li>
            <li><a href="groepen.php" class="<?= ($activePage === 'groepen') ? 'active' : '' ?>">Groepen</a></li>
            <li><a href="contact.php" class="<?= ($activePage === 'contact') ? 'active' : '' ?>">Contact</a></li>
            <li><a href="inschrijven.php" class="<?= ($activePage === 'inschrijven') ? 'active' : '' ?>">Inschrijvingen</a></li>
        </ul>

        <div class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</nav>