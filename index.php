<?php
/*
Template Name: Homepagina
*/

get_header();
?>

<?php
    get_template_part('components/homeheaderblok');
?>

<main>
  <div class="maincontainer">
    <?php get_template_part('components/wisselwoord'); ?>
    <?php get_template_part('components/uitlegblok'); ?>
    <?php get_template_part('components/specialeact'); ?>
    <?php get_template_part('components/hoofdleiding'); ?>
  </div>
</main>

<?php
get_footer();
?>
