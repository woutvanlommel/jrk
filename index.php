<?php
/*
Template Name: Homepagina
*/

get_header();
?>

<main>
  <?php
    get_template_part('components/homeheaderblok');
    get_template_part('components/wisselwoord');
    get_template_part('components/uitlegblok');
    get_template_part('components/specialeact');
    get_template_part('components/hoofdleiding');
  ?>
</main>

<?php
get_footer();
?>
