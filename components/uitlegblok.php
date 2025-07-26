<section>
  <div class="introjrk">
    <?php if (have_rows('info_blokken')): ?>
      <?php while (have_rows('info_blokken')): the_row(); 
        $afbeelding = get_sub_field('afbeelding');
        $titel = get_sub_field('titel');
        $beschrijving = get_sub_field('beschrijving');
        $reverse = get_sub_field('reverse');
      ?>
        <div class="uitlegjrk <?php echo $reverse ? 'reverse' : ''; ?>">
          <div class="uitlegimg">
            <?php if ($afbeelding): ?>
              <img src="<?php echo esc_url($afbeelding['url']); ?>" alt="<?php echo esc_attr($afbeelding['alt']); ?>">
            <?php endif; ?>
          </div>
          <div class="uitlegtxt">
            <h3><?php echo esc_html($titel); ?></h3>
            <p><?php echo esc_html($beschrijving); ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>