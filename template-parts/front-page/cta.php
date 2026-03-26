<section class="section">
  <div class="container">
    <?php poradnik_section_title('Masz problem'); ?>
    <p class="section-subtitle">Zapytaj specjalistę</p>
    <form class="cta-form" method="get" action="<?php echo esc_url(home_url('/specjalisci/')); ?>">
      <textarea class="full" name="problem" placeholder="Opisz problem (np. awaria instalacji elektrycznej)"></textarea>
      <select name="kategoria">
        <option value=""><?php esc_html_e('Kategoria', 'generatepress-child-poradnik'); ?></option>
        <option value="elektryka"><?php esc_html_e('Elektryka', 'generatepress-child-poradnik'); ?></option>
        <option value="hydraulika"><?php esc_html_e('Hydraulika', 'generatepress-child-poradnik'); ?></option>
        <option value="mechanika"><?php esc_html_e('Mechanika', 'generatepress-child-poradnik'); ?></option>
        <option value="prawo"><?php esc_html_e('Prawo', 'generatepress-child-poradnik'); ?></option>
      </select>
      <input type="text" name="miasto" placeholder="Miasto">
      <input class="full" type="email" name="email" placeholder="Email do kontaktu">
      <button class="btn btn-accent full" type="submit"><?php esc_html_e('Wyślij zapytanie', 'generatepress-child-poradnik'); ?></button>
    </form>
  </div>
</section>