<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/svg" href="<?php echo function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.'; ?>/img/Favicon.svg">

    <!-- Titel -->
    <title><?php echo function_exists('bloginfo') ? bloginfo('name') : 'Jeugd Rode Kruis Herckenrode'; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo function_exists('get_stylesheet_uri') ? get_stylesheet_uri() : 'style.css'; ?>">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ef4e3e0cf6.js" crossorigin="anonymous"></script>

    <?php if (function_exists('wp_head')) wp_head(); ?>
</head>

<body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("📌 DOM volledig geladen");

        const navbar = document.querySelector('.navbarjrk');
        const threshold = 50;

        if (navbar) {
            console.log("✅ Navbar gevonden");
            window.addEventListener('scroll', function () {
                if (window.scrollY > threshold) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        } else {
            console.warn("⚠️ Navbar niet gevonden");
        }

        const hamburger = document.getElementById("hamburger");
        const navMenu = document.querySelector(".navmenujrk");
        const icon = hamburger?.querySelector("i");

        if (hamburger && navMenu && icon) {
            console.log("✅ Hamburger en menu gevonden");

            hamburger.addEventListener("click", function () {
                navMenu.classList.toggle("show");

                const isOpen = navMenu.classList.contains("show");
                document.body.style.overflow = isOpen ? "hidden" : "auto";

                if (isOpen) {
                    icon.classList.remove("fa-bars");
                    icon.classList.add("fa-times");
                    document.body.classList.add("menu-open");
                    console.log("📂 Menu geopend");
                } else {
                    icon.classList.add("fa-bars");
                    icon.classList.remove("fa-times");
                    document.body.classList.remove("menu-open");
                    console.log("📁 Menu gesloten");
                }
            });

            document.querySelectorAll(".navmenujrk a").forEach(link => {
                link.addEventListener("click", () => {
                    navMenu.classList.remove("show");
                    icon.classList.remove("fa-times");
                    icon.classList.add("fa-bars");
                    document.body.style.overflow = "auto";
                    document.body.classList.remove("menu-open");
                    console.log("🔗 Menu gesloten via navigatielink");
                });
            });
        } else {
            console.warn("⚠️ Hamburger of menu niet gevonden");
        }
    });
</script>

<!-- ✅ NAVBAR -->
<nav class="navbarjrk">
    <div class="navcontainerjrk">
        <div class="navlogojrk">
            <a href="<?php echo function_exists('home_url') ? home_url('/') : 'index.php'; ?>">
                <img src="<?php echo function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.'; ?>/img/jrk_logo.svg" alt="JRK logo">
            </a>
        </div>

        <?php
        function get_custom_page_link($slug, $fallback) {
            $page = get_page_by_path($slug);
            return $page ? get_permalink($page) : $fallback;
        }

        $activePage = basename($_SERVER['PHP_SELF'], ".php");
        ?>

        <ul class="navmenujrk">
            <li> <a href="<?= get_custom_page_link('kalender', 'kalender.php'); ?>" class="<?= ($activePage === 'kalender') ? 'active' : '' ?>">Kalender</a> </li>
            <li> <a href="<?= get_custom_page_link('groepen', 'page-groepen.php'); ?>" class="<?= ($activePage === 'groepen') ? 'active' : '' ?>">Groepen</a> </li>
            <li> <a href="<?= get_custom_page_link('contact', 'contact.php'); ?>" class="<?= ($activePage === 'contact') ? 'active' : '' ?>">Contact</a> </li>
            <li> <a href="<?= get_custom_page_link('inschrijven', 'inschrijven.php'); ?>" class="<?= ($activePage === 'inschrijven') ? 'active' : '' ?>">Inschrijvingen</a> </li>
        </ul>

        <div class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</nav>
