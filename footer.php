<footer>
    <div class="footer">
        <div class="footertop">
            <div class="footerlogo">
                <img src="<?php echo function_exists('get_template_directory_uri') ? get_template_directory_uri() : '.'; ?>/img/jrk_logo.svg" alt="JRK Logo">
                <h3>Jeugd Rode Kruis Herckenrode</h3>
                <p>
                    <a href="mailto:jeugdrodekruis@herckenrode.be">jeugdrodekruis@herckenrode.be</a><br>
                    Prinsenhofweg 3, 3511 Kuringen
                </p>
            </div>

            <div class="footersocial">
                <h3>Volg ons op</h3>
                <div class="icons">
                    <a href="https://www.facebook.com/jeugdrodekruiskuringen" target="_blank" aria-label="Facebook"><i class="fa-brands fa-facebook fa-2x"></i></a>
                    <a href="https://www.instagram.com/jeugd.rodekruis.herckenrode/" target="_blank" aria-label="Instagram"><i class="fa-brands fa-instagram fa-2x"></i></a>
                    <a href="https://www.tiktok.com/@jrk_herckenrode" target="_blank" aria-label="TikTok"><i class="fa-brands fa-tiktok fa-2x"></i></a>
                </div>
            </div>
        </div>

        <hr>

        <div class="footerbottom">
            <ul>
                <li><a href="#">Gegevensbeleid</a></li>
                <li><a href="#">Gebruikersvoorwaarden</a></li>
                <li><a href="#">Wettelijke vermeldingen</a></li>
                <li><a href="#">Cookiebeleid</a></li>
            </ul>
        </div>
    </div>
</footer>

<?php
// WordPress sluit normaal <body> en <html> via wp_footer()
if (!function_exists('wp_footer')) {
    echo '</body></html>';
} else {
    wp_footer();
}
?>