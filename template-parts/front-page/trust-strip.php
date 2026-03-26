<?php
$guideCount = wp_count_posts('poradnik');
$rankingCount = wp_count_posts('ranking');
$specialistCount = wp_count_posts('specjalista');
?>
<section class="section trust-strip">
  <div class="container trust-strip__grid">
    <div class="trust-item">
      <strong><?php echo esc_html((string) ($guideCount->publish ?? 0)); ?>+</strong>
      <span><?php esc_html_e('poradników eksperckich', 'generatepress-child-poradnik'); ?></span>
    </div>
    <div class="trust-item">
      <strong><?php echo esc_html((string) ($rankingCount->publish ?? 0)); ?>+</strong>
      <span><?php esc_html_e('rankingów i porównań', 'generatepress-child-poradnik'); ?></span>
    </div>
    <div class="trust-item">
      <strong><?php echo esc_html((string) ($specialistCount->publish ?? 0)); ?>+</strong>
      <span><?php esc_html_e('zweryfikowanych specjalistów', 'generatepress-child-poradnik'); ?></span>
    </div>
    <div class="trust-item trust-item--cta">
      <a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>"><?php esc_html_e('Znajdź specjalistę', 'generatepress-child-poradnik'); ?></a>
    </div>
  </div>
</section>
